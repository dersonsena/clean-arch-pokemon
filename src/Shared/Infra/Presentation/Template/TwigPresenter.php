<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Template;

use Twig\Environment;
use App\Shared\Infra\Presentation\TemplatePresenter;
use Twig\Loader\FilesystemLoader;

final class TwigPresenter implements TemplatePresenter
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../../../../views');

        $this->twig = new Environment($loader, [
            'cache' => $_ENV['APP_ENV'] === 'dev' ? false : __DIR__ . '/../../../../../runtime/cache'
        ]);
    }

    public function render(string $templateName, array $data = []): string
    {
        return$this->twig->render($templateName, $data);
    }
}