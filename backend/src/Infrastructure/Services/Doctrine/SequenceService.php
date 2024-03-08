<?php declare(strict_types=1);

namespace App\Infrastructure\Services\Doctrine;

use Doctrine\DBAL\Connection;

class SequenceService {
    public function __construct(
        private Connection $dbal,
    ) {}

    public function next(TableEnum $table): int {
        return (int) $this->dbal->executeQuery(sprintf("SELECT nextval('%s')", $table->getSequenceTableName()))->fetchOne();
    }

    public function getPackedSequences(TableEnum $table, int $count): array {
        return $this->dbal->executeQuery(sprintf("SELECT nextval('%s') FROM generate_series(1, %d)", $table->getSequenceTableName(), $count))->fetchFirstColumn();
    }

    public function reset(): void {
        $tables = $this->dbal
            ->executeQuery('select table_name from information_schema."tables" where table_schema = \'public\'')
            ->fetchFirstColumn();

        $sequences = $this->dbal
            ->executeQuery('select sequence_name from information_schema.sequences')
            ->fetchFirstColumn();

        foreach ($tables as $table) {
            $sequenceName = $table . '_id_seq';

            if (in_array($sequenceName, $sequences)) {
                $seq = $this->dbal
                    ->executeQuery('select max(id)+1 from "' . $table . '"')
                    ->fetchOne();

                $seq = $seq ?: 1;
                $this->dbal->executeQuery('ALTER SEQUENCE "' . $sequenceName . '" RESTART WITH ' . $seq);
            }
        }
    }
}