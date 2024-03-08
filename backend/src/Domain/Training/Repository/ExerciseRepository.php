<?php declare(strict_types=1);

namespace App\Domain\Training\Repository;

use App\Domain\Training\Entity\Exercise;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class ExerciseRepository {
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em,
    ) {
        $this->repository = $em->getRepository(Exercise::class);
    }

    public function add(Exercise $category): void {
        $this->em->persist($category);
    }
}