<?php declare(strict_types=1);

namespace App\Domain\Training\UseCase;

use App\Domain\Common\Flusher;
use App\Domain\Training\Entity\Category;
use App\Domain\Training\Repository\CategoryRepository;
use App\Domain\Training\UseCase\Dto\CategoryDto;
use App\Infrastructure\Services\Doctrine\SequenceService;
use App\Infrastructure\Services\Doctrine\TableEnum;

readonly class CategoryUseCase {
    public function __construct(
        private CategoryRepository $repository,
        private Flusher $flusher,
        private SequenceService $sequence,
    ) {}

    public function create(CategoryDto $dto): void {
        $category = new Category($this->sequence->next(TableEnum::Category), $dto);

        $this->repository->add($category);

        $this->flusher->flush();
    }
}
