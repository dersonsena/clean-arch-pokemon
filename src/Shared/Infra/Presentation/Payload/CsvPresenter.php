<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Payload;

use App\Shared\Infra\Presentation\PayloadPresenter;
use App\Shared\Infra\Presentation\Presenter;

final class CsvPresenter implements PayloadPresenter
{
    public function getType(): string
    {
        return Presenter::TYPE_PAYLOAD;
    }

    public function output(array $data, array $options = []): string
    {
        $f = fopen('php://memory', 'r+');

        $separator = $options['separator'] ?? ',';
        $enclosure = $options['enclosure'] ?? '"';
        $escape = $options['escape'] ?? "\\";

        foreach ($data['data'] as $item) {
            fputcsv($f, $item, $separator, $enclosure, $escape);
        }

        rewind($f);

        return stream_get_contents($f);
    }
}