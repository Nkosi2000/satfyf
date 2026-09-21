<?php

namespace App\Enums;

enum PartnerType: string
{
    case Partner = 'partner';
    case Collaborator = 'collaborator';
    case AdvisoryCouncil = 'advisory_council';

    public function label(): string
    {
        return match ($this) {
            self::Partner => __('Partner'),
            self::Collaborator => __('Collaborator'),
            self::AdvisoryCouncil => __('Advisory Council'),
        };
    }
}
