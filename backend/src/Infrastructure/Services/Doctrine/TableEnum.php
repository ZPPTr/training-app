<?php declare(strict_types=1);

namespace App\Infrastructure\Services\Doctrine;

enum TableEnum: string {
    case Category = 'category';
    case Exercise = 'exercise';

    public function getSequenceTableName(): string {
        return $this->value . '_id_seq';
    }
}