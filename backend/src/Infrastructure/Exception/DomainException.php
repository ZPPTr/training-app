<?php

namespace App\Infrastructure\Exception;

class DomainException extends \DomainException {
    const ERROR_TYPE = 'DEFAULT';
    const MESSAGE = '';
    const HTTP_CODE = 400;

    private array $data = [];
    public readonly bool $asString;

    public function __construct(?string $message = '', array $data = [], bool $asString = false) {
        $this->data = $data;
        $this->asString = $asString;

        parent::__construct($message ?: static::MESSAGE, static::HTTP_CODE);
    }

    public function getType(): string {
        return static::ERROR_TYPE;
    }

    public function getData(): array {
        return $this->data;
    }

    public function getIndexedData(): array {
        $result = [];
        foreach ($this->data as $key => $item) {
            if (is_array($item)) {
                $item['key'] = $key;
            }
            $result[] = $item;
        }

        return $result;
    }

    protected function extractEntityNameFromClassName(string $className): string {
        if (($pos = strrpos($className, '\\')) !== false) {
            $className = substr($className, $pos + 1);
        }

        return $className;
    }
}
