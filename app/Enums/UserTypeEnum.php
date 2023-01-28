<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static TOUR_GUIDE()
 * @method static static TOURIST()
 */
final class UserTypeEnum extends Enum
{
    const ADMIN = "admin";
    const TOUR_GUIDE = "tour_guide";
    const TOURIST = "tourist";
}
