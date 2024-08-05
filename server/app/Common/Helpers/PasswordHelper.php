<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Common\Helpers;

class PasswordHelper
{
    /**
     * @param mixed $originPassword
     * @return null|false|string
     */
    public static function generatePassword($originPassword)
    {
        return password_hash($originPassword, PASSWORD_BCRYPT, [
            'cost' => 12,
        ]);
    }

    /**
     * @param mixed $originPassword
     * @param mixed $hashedPassword
     * @return bool
     */
    public static function verifyPassword($originPassword, $hashedPassword)
    {
        return password_verify($originPassword, $hashedPassword);
    }
}
