<?php declare(strict_types=1);

namespace App\Infrastructure\Event\Listener;

use App\Infrastructure\Exception\DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionListener {
    private LoggerInterface $logger;
    private Throwable $exception;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void {
        $this->exception = $event->getThrowable();

       if ($this->isDomainException()) {
           $this->writeLog();
           /** @psalm-suppress NoInterfaceProperties */
           $response = $this->exception->asString ? $this->createStringResponse(Response::HTTP_BAD_REQUEST) : $this->createErrorResponseObject();
           $event->setResponse($response);
       } elseif ($this->exception instanceof NotFoundHttpException) {
           $response = $this->createObjectResponseNotFound();
           $event->setResponse($response);
       } elseif ($this->exception instanceof AccessDeniedHttpException) {
           $response = $this->createForbiddenResponse();
           $event->setResponse($response);
       } elseif ($this->isProduction()) {
           $this->writeLog();
           $response = $this->createStringResponse();
           $event->setResponse($response);
       }
    }

    private function createErrorResponseObject(): JsonResponse {
        $errorObject = [
            'type' => $this->exception->getType(),
            'message' => $this->exception->getMessage(),
            'data' => $this->exception->getData(),
        ];
        return new JsonResponse($errorObject, (int) $this->exception->getCode());
    }

    private function createForbiddenResponse(): JsonResponse {
        return new JsonResponse([
            'type' => 'Forbidden',
            'message' => $this->exception->getMessage(),
            'data' => []
        ], Response::HTTP_FORBIDDEN);
    }

    private function createStringResponse(?int $statusCode = null): JsonResponse {
        return new JsonResponse($this->exception->getMessage(), $statusCode ?: $this->getStatusCode());
    }

    private function createObjectResponse(): JsonResponse {
        return new JsonResponse(json_decode($this->exception->getMessage()), $this->getStatusCode());
    }

    private function createObjectResponseNotFound(): JsonResponse {
        return new JsonResponse(json_decode($this->exception->getMessage()), Response::HTTP_NOT_FOUND);
    }

    private function getStatusCode(): int {
        if ($this->exception->getCode() <= 500) {
            return Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (int) ($this->exception->getCode() ?: Response::HTTP_BAD_REQUEST);
    }

    private function isProduction(): bool {
        return !$_ENV['APP_DEBUG'];
    }

    private function writeLog(): void {
        $extraData = $this->exception instanceof DomainException ? $this->exception->getIndexedData() : [];
        $this->logger->critical($this->exception->getMessage(), array_merge($extraData, $this->exception->getTrace()));
    }

    private function isDomainException(): bool {
        return $this->exception instanceof DomainException;
    }
}
