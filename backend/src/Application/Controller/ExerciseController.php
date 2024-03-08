<?php declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Training\UseCase\Dto\ExerciseDto;
use App\Domain\Training\UseCase\ExerciseUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('exercise')]
class ExerciseController extends AbstractController {
    #[Route('', methods: 'GET')]
    public function index(): Response {
        return new Response(json_encode([22]));
    }

    #[Route('', methods: 'POST')]
    public function create(ExerciseUseCase $useCase, ExerciseDto $dto): Response {
        $useCase->create($dto);

        return new Response(json_encode(['OK']));
    }

    #[Route('/{id<\d+>}', methods: 'PUT')]
    public function update(): Response {

        return new Response(json_encode([22]));
    }
}
