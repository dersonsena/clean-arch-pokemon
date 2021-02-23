<?php

declare(strict_types=1);

namespace App\Shared\Infra\Http;

use App\Shared\Infra\Presentation\Presenter;
use App\Shared\Infra\Presentation\PresenterFactory;
use App\Shared\Infra\Presentation\TemplatePresenter;
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

    abstract protected function handle(): string;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $this->request = $request;
            $this->response = $response;
            $this->args = $args;
            $this->body = $this->parseBody();
            $this->presenter = PresenterFactory::createTemplate($request);

            $this->response->getBody()->write($this->handle());

            return $this->response
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(200);

        } catch (Throwable $e) {
            $this->response->getBody()->write("
                <h1>{$e->getMessage()}</h1>
                <h2>{$e->getFile()}: {$e->getLine()}</h2>
                <pre>{$e->getTraceAsString()}</pre>"
            );

            return $this->response
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(404);
        }
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