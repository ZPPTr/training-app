<?php declare(strict_types=1);

namespace App\Domain\Training\Entity;

use App\Domain\Training\UseCase\Dto\ExerciseDto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'exercise')]
class Exercise {
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    private readonly int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, unique: true)]
    private string $name;

    #[ORM\Column(name: 'description', type: Types::STRING)]
    private string $description;

    #[ORM\Column(name: 'measurement', type: Types::JSON)]
    private array $measurement;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'exercises', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'exercise_category')]
    private Collection $categories;

    #[ORM\Column(name: 'icon', type: Types::STRING, nullable: true)]
    private ?string $icon = null;

    public function __construct(int $id, ExerciseDto $dto, Category ...$categories) {
        $this->id = $id;
        $this->name = $dto->name;
        $this->description = $dto->description;
        $this->measurement = $dto->measurement;
        $this->icon = $dto->icon;

        $this->categories = new ArrayCollection();

        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
}
