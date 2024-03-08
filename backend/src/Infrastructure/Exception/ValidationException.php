<?php declare(strict_types=1);

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends DomainException {
    const ERROR_TYPE = 'VALIDATION_ERROR';
    const HTTP_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;
    const MESSAGE = 'Validation error';
}
