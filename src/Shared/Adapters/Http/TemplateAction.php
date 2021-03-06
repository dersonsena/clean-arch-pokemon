<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Http;

use App\Shared\Adapters\Contracts\Presentation\TemplatePresenter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

abstract class TemplateAction
{
    protected Request $request;
    protected Response $response;
    protected TemplatePresenter $presenter;
    protected array $args;
    protected array $body;
    private int $statusCode = 200;

    abstract protected function handle(): string;

    public function __construct(TemplatePresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->body = $this->parseBody();

        try {
            $this->response->getBody()->write($this->handle());
        } catch (Throwable $e) {
            $this->response->getBody()->write("
                <h1>{$e->getMessage()}</h1>
                <h2>{$e->getFile()}: {$e->getLine()}</h2>
                <pre>{$e->getTraceAsString()}</pre>"
            );

            return $this->response
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(500);
        }

        return $this->response
            ->withHeader('Content-Type', 'text/html')
            ->withStatus($this->statusCode);
    }

    protected function statusCode(int $code = 200)
    {
        $this->statusCode = $code;
    }

    private function parseBody(): array
    {
        $contentType = $this->request->getHeaderLine('Content-Type');

        if (!strstr($contentType, 'application/json')) {
            return [];
        }

        $contents = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        $request = $this->request->withParsedBody($contents);
        return (array)$request->getParsedBody();
    }
}
