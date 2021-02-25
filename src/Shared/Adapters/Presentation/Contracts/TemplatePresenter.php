<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Presentation\Contracts;

interface TemplatePresenter
{
    public function render(string $templateName, array $data = []): string;
}