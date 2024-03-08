<?php declare(strict_types=1);

namespace App\Domain\Training\Repository;

use App\Domain\Training\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class CategoryRepository {
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em,
    ) {
        $this->repository = $em->getRepository(Category::class);
    }

    public function add(Category $category): void {
        $this->em->persist($category);
    }

    public function getByIds(int ...$ids): array {
        return $this->repository->findBy(['id' => $ids]);
    }
}