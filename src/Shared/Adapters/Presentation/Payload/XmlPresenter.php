<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Presentation\Payload;

use App\Shared\Adapters\Presentation\Contracts\PayloadPresenter;

final class XmlPresenter implements PayloadPresenter
{
    public function output(array $data, array $options = []): string
    {
        $charset = $options['charset'] ?? 'UTF-8';

        return trim('
            <?xml version="1.0" charset="'. $charset .'" ?>
            <note>
              <to>Tove</to>
              <from>Jani</from>
              <heading>Reminder</heading>
              <body>Don\'t forget me this weekend!</body>
            </note>
        ');
    }
}