<?php declare(strict_types=1);

namespace App\Infrastructure\Services\Doctrine\Types;

use App\Domain\Common\ValueObjects\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType {
    public const NAME = 'email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed {
        return $value instanceof Email ? (string) $value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email {
        return !empty($value) ? new Email($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool {
        return true;
    }
}
