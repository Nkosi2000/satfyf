<?php

namespace App\Enums;

enum PartnerType: string
{
    case Partner = 'partner';
    case Collaborator = 'collaborator';

    public function label(): string
    {
        return match ($this) {
            self::Partner => __('Partner'),
            self::Collaborator => __('Collaborator'),
        };
    }
}
