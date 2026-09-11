<?php

namespace App\Enums;

enum ProgramCategory: string
{
    case Advocacy = 'advocacy';
    case Education = 'education';
    case Community = 'community';
    case Media = 'media';

    public function label(): string
    {
        return match ($this) {
            self::Advocacy => 'Advocacy & Campaigns',
            self::Education => 'Education & Outreach',
            self::Community => 'Community Engagement',
            self::Media => 'Media & Digital',
        };
    }
}
