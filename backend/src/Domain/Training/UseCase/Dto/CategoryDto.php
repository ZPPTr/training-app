<?php declare(strict_types=1);

namespace App\Domain\Training\UseCase\Dto;

use App\Application\Middleware\RequestDtoInterface;

class CategoryDto implements RequestDtoInterface {
       public string $name;
       public string $description;
}
