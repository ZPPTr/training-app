<?php declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\Common\ValueObjects\Email;
use App\Domain\Common\ValueObjects\UuId;
use App\Domain\User\RolesEnum;
use App\Infrastructure\Services\Doctrine\Types\EmailType;
use App\Infrastructure\Services\Doctrine\Types\UuIdType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface {
    #[ORM\Column(name: 'id', type: UuIdType::NAME, unique: true)]
    #[ORM\Id]
    protected UuId $id;

    #[ORM\Column(name: 'email', type: EmailType::NAME, unique: true)]
    private Email $email;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 64, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(name: 'roles', type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(name: 'ban', type: Types::BOOLEAN)]
    private bool $ban = false;

    private function __construct() {}

    public static function create(UuId $id, Email $email, RolesEnum $role, string $name = null): self {
        $user = new self();
        $user->id = $id;
        $user->email = $email;
        $user->name = $name;
        $user->roles = [$role->value];

        return $user;
    }

    public function getId(): UuId {
        return $this->id;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    public function getRoles(): array {
        return $this->roles;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'roles'=> $this->roles,
        ];
    }

    public function eraseCredentials(): void {}
}
