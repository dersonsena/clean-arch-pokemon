<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation;

interface Presenter
{
    public const TYPE_PAYLOAD = 'payload';
    public const TYPE_TEMPLATE = 'template';

    public function getType(): string;
}