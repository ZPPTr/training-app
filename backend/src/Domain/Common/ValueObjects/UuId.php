<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObjects;

use App\Infrastructure\Exception\DomainException;
use Ramsey\Uuid\Uuid as UuidFactory;

readonly class UuId {
    public function __construct(public string $value) {
        if (empty($value)) {
            throw new DomainException('The value of UUid can not be empty');
        }
    }

    public static function next(): self {
        return new self(UuidFactory::uuid1()->toString());
    }

    public function isEqual(?self $other): bool {
        return $this->value === $other?->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
