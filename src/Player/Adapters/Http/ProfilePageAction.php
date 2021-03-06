<?php

declare(strict_types=1);

namespace App\Player\Adapters\Http;

use App\Shared\Adapters\Http\TemplateAction;

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
