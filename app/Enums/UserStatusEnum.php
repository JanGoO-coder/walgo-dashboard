<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static VERIFIED()
 * @method static static REJECTED()
 */
final class UserStatusEnum extends Enum
{
    const PENDING = "pending";
    const VERIFIED = "verified";
    const REJECTED = "rejected";
}
