<?php

declare(strict_types=1);

namespace App\Shared\Infra\Http;

use App\Shared\Contracts\AppExceptionBase;
use App\Shared\Exceptions\AppValidationException;
use PDOException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

abstract class ActionBase
{
    protected Request $request;
    protected Response $response;
    protected array $args;
    protected array $body;
    protected array $meta = [];

    abstract protected function handle(): array;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        $this->parseBody();

        try {
            $data = $this->answerSuccess($this->handle(), $this->meta);

            $response->getBody()->write(json_encode($data));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (Throwable $e) {
            return $this->answerWithError($e);
        }
    }
    
    private function parseBody(): void
    {
        $contentType = $this->request->getHeaderLine('Content-Type');

        if (!strstr($contentType, 'application/json')) {
            return;
        }

        $contents = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return;
        }

        $request = $this->request->withParsedBody($contents);
        $this->body = (array)$request->getParsedBody();
    }

    public function answerSuccess(array $data, array $meta = null, int $code = 200): array
    {
        return [
            'status' => 'success',
            'data' => $data,
            'meta' => $meta,
        ];
    }

    private function answerWithError(Throwable $e): Response
    {
        $statusCode = 500;
        $data = ['status' => 'error', 'message' => $e->getMessage(), 'meta' => []];

        if ($e instanceof PDOException) {
            $data = [
                'status' => 'error',
                'message' => 'PDO Error: ' . $e->getMessage(),
                'meta' => ['error_info' => $e->errorInfo]
            ];
        }

        if ($e instanceof AppExceptionBase) {
            $data = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'meta' => ['details' => $e->getDetails()]
            ];
        }

        if ($e instanceof AppValidationException) {
            $statusCode = 400;
            $data = ['status' => 'fail', 'data' => $e->getDetails()];
        }

        if (APP_DEBUG_ENABLED) {
            $data['$debug'] = [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
                'stack' => $e->getTraceAsString(),
            ];
        }

        $this->response->getBody()->write(json_encode($data));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}