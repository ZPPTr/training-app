<?php declare(strict_types=1);

namespace App\Application\Middleware;

use App\Infrastructure\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class RequestDtoParser {
    public function __construct(private ValidatorInterface $validator) {}

    public function validate(RequestDtoInterface $dto): void {
        /** @var ConstraintViolationList $errors */
        $errors = $this->validator->validate($dto);
        if ($errors->count() > 0) {
            $messages = [];

            foreach ($errors->getIterator() as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new ValidationException('Invalid params of request', $messages);
        }
    }

    /** @psalm-suppress InternalMethod */
    public function parseRequestToDto(Request $request, string $type): RequestDtoInterface {
        $serializer = new Serializer($this->getNormalizers());

        $page = (int) $request->get('page', 1);
        $perPage = (int) ($request->get('perPage') ?? $request->get('per-page', 50));
        $perPage = $perPage > 500 ? 500 : $perPage;

        $request->request->set('page', $page);
        $request->request->set('perPage', $perPage);

        $dtoData = key_exists(RequestDtoSortInterface::class, class_implements($type))
            ? $request->get('sortBy', [])
            : array_merge($request->query->all(), $request->request->all());

        return $serializer->denormalize($dtoData, $type);
    }

    private function getNormalizers(): array {
        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();
        $propertyTypeExtractor = new PropertyInfoExtractor([$reflectionExtractor], [$phpDocExtractor, $reflectionExtractor], [$phpDocExtractor], [$reflectionExtractor], [$reflectionExtractor]);

        // it is important to keep the order of normalizers, $normalizer must be always last
        return [
            new BackedEnumNormalizer(),
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, $propertyTypeExtractor),
        ];
    }
}
