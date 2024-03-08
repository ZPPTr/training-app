<?php declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Training\UseCase\CategoryUseCase;
use App\Domain\Training\UseCase\Dto\CategoryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('category')]
class CategoryController extends AbstractController {
    #[Route('', methods: 'GET')]
    public function index(): Response {
        return new Response(json_encode([22]));
    }

    #[Route('', methods: 'POST')]
    public function create(CategoryUseCase $useCase, CategoryDto $dto): Response {
        $useCase->create($dto);

        return new Response(json_encode(['OK']));
    }

    #[Route('/{id<\d+>}', methods: 'PUT')]
    public function update(): Response {

        return new Response(json_encode([22]));
    }
}
