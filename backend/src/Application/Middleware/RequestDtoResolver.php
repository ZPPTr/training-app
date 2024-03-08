<?php declare(strict_types=1);

namespace App\Application\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

readonly class RequestDtoResolver implements ValueResolverInterface {
    public function __construct(
        private RequestDtoParser $requestDtoParser,
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator {
        if (strripos($argument->getName(), 'dto') === false) {
            return [];
        }

        $reflection = new \ReflectionClass($argument->getType());
        if (!$reflection->implementsInterface(RequestDtoInterface::class)) {
            return [];
        }

        $dto = $this->requestDtoParser->parseRequestToDto($request, $argument->getType());
        $this->requestDtoParser->validate($dto);

        yield $dto;
    }
}
