<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation;

interface TemplatePresenter
{
    public function render(string $templateName, array $data = []): string;
}