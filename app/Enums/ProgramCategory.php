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
            self::Advocacy => __('Advocacy & Campaigns'),
            self::Education => __('Education & Outreach'),
            self::Community => __('Community Engagement'),
            self::Media => __('Media & Digital'),
        };
    }
}
