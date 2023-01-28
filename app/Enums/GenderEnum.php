<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MALE()
 * @method static static FEMALE()
 * @method static static OTHER()
 */
final class GenderEnum extends Enum
{
    const MALE = "male";
    const FEMALE = "female";
    const OTHER = "other";
}
