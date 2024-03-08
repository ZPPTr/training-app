<?php declare(strict_types=1);

namespace App\Domain\Common\Dto\Query;

use App\Application\Middleware\RequestDtoInterface;

class SortDto implements RequestDtoInterface {
    public ?string $orderBy;
    public ?string $sortBy;
}
