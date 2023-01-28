<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CARD()
 * @method static static PASSPORT()
 */
final class IdentityTypeEnum extends Enum
{
    const CARD = "card";
    const PASSPORT = "passport";
}
