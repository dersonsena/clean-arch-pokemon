<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Payload;

use App\Shared\Adapters\Contracts\Presentation\PayloadPresenter;

final class JsonPresenter implements PayloadPresenter
{
    public function output(array $data, array $options = []): string
    {
        return json_encode($data);
    }
}
