<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Enum;

use AnzuSystems\Contracts\Model\Enum\BaseEnumTrait;
use AnzuSystems\Contracts\Model\Enum\EnumInterface;

enum RenderContext: string implements EnumInterface
{
    use BaseEnumTrait;

    case DesktopWeb = 'desktop-web';
    case MobileWeb = 'mobile-web';
    case MobileAppIOS = 'mobile-app-ios';
    case MobileAppAndroid = 'mobile-app-android';
    case Mailer = 'mailer';

    public const self Default = self::DesktopWeb;

    public function isMobile(): bool
    {
        return $this->in([self::MobileWeb, self::MobileAppIOS, self::MobileAppAndroid]);
    }
}
