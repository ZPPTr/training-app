<?php declare(strict_types=1);

namespace App\Infrastructure\Services\Doctrine\Types;

use App\Domain\Common\ValueObjects\UuId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UuIdType extends GuidType {
    public const NAME = 'uuid';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed {
        return $value instanceof UuId ? (string) $value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuId {
        return !empty($value) ? new UuId($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool {
        return true;
    }
}
