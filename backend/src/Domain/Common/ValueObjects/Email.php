<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObjects;

use App\Infrastructure\Exception\DomainException;

readonly class Email {
    public function __construct(public string $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException('Incorrect email '. $value);
        }
    }

    public function isEqual(self $other): bool {
        return $this->value === $other->value;
    }

    public function __toString(): string {
        return $this->value;
    }
}
