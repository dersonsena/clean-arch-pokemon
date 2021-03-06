<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation;

use App\Shared\Exceptions\RuntimeException;
use App\Shared\Infra\Presentation\Contracts\PayloadPresenter;
use App\Shared\Infra\Presentation\Payload\CsvPresenter;
use App\Shared\Infra\Presentation\Payload\JsonPresenter;
use App\Shared\Infra\Presentation\Payload\XmlPresenter;
use Psr\Http\Message\ServerRequestInterface as Request;

final class PresenterFactory
{
    private function __construct()
    {}

    public static function createPayload(Request $request): PayloadPresenter
    {
        $accept = explode(',', $request->getHeaderLine('Accept'))[0];

        switch ($accept) {
            case '':
            case '*/*':
            case 'application/json':
            case 'text/json':
                return new JsonPresenter();

            case 'application/xml':
            case 'text/xml':
                return new XmlPresenter();

            case 'application/csv':
            case 'text/csv':
                return new CsvPresenter();

            default:
                throw new RuntimeException(['accept' => $accept], 'Invalid payload presenter to this request.');
        }
    }
}
