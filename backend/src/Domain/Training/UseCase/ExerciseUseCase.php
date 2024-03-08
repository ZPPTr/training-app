<?php declare(strict_types=1);

namespace App\Domain\Training\UseCase;

use App\Domain\Common\Flusher;
use App\Domain\Training\Entity\Exercise;
use App\Domain\Training\Repository\CategoryRepository;
use App\Domain\Training\Repository\ExerciseRepository;
use App\Domain\Training\UseCase\Dto\ExerciseDto;
use App\Infrastructure\Services\Doctrine\SequenceService;
use App\Infrastructure\Services\Doctrine\TableEnum;

readonly class ExerciseUseCase {
    public function __construct(
        private ExerciseRepository $repository,
        private CategoryRepository $categoryRepository,
        private Flusher $flusher,
        private SequenceService $sequence,
    ) {}

    public function create(ExerciseDto $dto): void {
        $categories = $this->categoryRepository->getByIds(... $dto->categories);
        $exercise = new Exercise($this->sequence->next(TableEnum::Exercise), $dto, ...$categories);

        $this->repository->add($exercise);

        $this->flusher->flush();
    }
}
