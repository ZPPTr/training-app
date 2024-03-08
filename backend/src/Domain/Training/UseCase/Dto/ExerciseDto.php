<?php declare(strict_types=1);

namespace App\Domain\Training\UseCase\Dto;

use App\Application\Middleware\RequestDtoInterface;
use App\Domain\Common\Enums\MeasurementEnum;

class ExerciseDto implements RequestDtoInterface {
    public string $name;
    public string $description;
    public ?string $icon = null;

    /* @var MeasurementEnum[] **/
    public array $measurement = [];

    public array $categories = [];
}
