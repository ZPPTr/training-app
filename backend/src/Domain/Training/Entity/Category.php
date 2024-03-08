<?php declare(strict_types=1);

namespace App\Domain\Training\Entity;

use App\Domain\Training\UseCase\Dto\CategoryDto;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category')]
class Category {
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    private readonly int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, unique: true)]
    private string $name;

    #[ORM\Column(name: 'description', type: Types::STRING)]
    private string $description;

    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'categories')]
    private Collection $exercises;

    public function __construct(int $id, CategoryDto $dto) {
        $this->id = $id;
        $this->name = $dto->name;
        $this->description = $dto->description;
    }
}
