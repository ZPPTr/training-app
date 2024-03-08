<?php declare(strict_types=1);

namespace App\Domain\Common\Enums;
enum MeasurementEnum: string {
    case Count = 'count';
    case Distance = 'distance';
    case Period = 'period';
}
