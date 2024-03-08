<?php declare(strict_types=1);

namespace App\Domain\Common\Dto\Query;

use App\Application\Middleware\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PaginationDto implements RequestDtoInterface {
    #[Assert\GreaterThan(0)]
    public int $page = 1;

    #[Assert\GreaterThan(0)]
    public int $perPage = 50;
}
