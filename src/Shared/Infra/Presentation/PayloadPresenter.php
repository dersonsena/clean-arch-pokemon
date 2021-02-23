<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation;

interface PayloadPresenter extends Presenter
{
    public function output(array $data, array $options = []): string;
}