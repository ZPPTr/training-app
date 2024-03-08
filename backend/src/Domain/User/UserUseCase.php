<?php declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Common\Flusher;
use App\Domain\Common\ValueObjects\Email;
use App\Domain\Common\ValueObjects\UuId;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;

readonly class UserUseCase {
    public function __construct(
        private Flusher $flusher,
        private UserRepository $repository,
    ) {}

    public function create(string $email, string $role): void {
        $user = User::create(UuId::next(), new Email($email), RolesEnum::from($role));
        $this->repository->add($user);

        $this->flusher->flush();

    }

}