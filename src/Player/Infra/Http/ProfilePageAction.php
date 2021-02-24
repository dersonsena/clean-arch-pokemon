<?php

declare(strict_types=1);

namespace App\Player\Infra\Http;

use App\Shared\Infra\Http\TemplateAction;

class ProfilePageAction extends TemplateAction
{
    protected function handle(): string
    {
        return $this->presenter->render('profile.html.twig', [
            'name' => 'Kildim',
            'lastName' => 'Sena'
        ]);
    }
}