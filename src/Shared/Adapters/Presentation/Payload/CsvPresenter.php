<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Presentation\Payload;

use App\Shared\Adapters\Presentation\Contracts\PayloadPresenter;

final class CsvPresenter implements PayloadPresenter
{
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