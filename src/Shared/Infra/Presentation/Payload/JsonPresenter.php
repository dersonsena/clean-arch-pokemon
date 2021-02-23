<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Payload;

use App\Shared\Infra\Presentation\PayloadPresenter;
use App\Shared\Infra\Presentation\Presenter;

final class JsonPresenter implements PayloadPresenter
{
    public function getType(): string
    {
        return Presenter::TYPE_PAYLOAD;
    }

    public function output(array $data, array $options = []): string
    {
        return json_encode($data);
    }
}