<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Template;

use App\Shared\Infra\Presentation\TemplatePresenter;
use Jenssegers\Blade\Blade;

final class BladePresenter implements TemplatePresenter
{
    private Blade $blade;

    public function __construct()
    {
        $this->blade = new Blade(
            __DIR__ . '/../../../../../views',
            __DIR__ . '/../../../../../runtime/cache'
        );
    }

    public function render(string $templateName, array $data = []): string
    {
        return $this->blade->make($templateName, $data)->render();
    }
}