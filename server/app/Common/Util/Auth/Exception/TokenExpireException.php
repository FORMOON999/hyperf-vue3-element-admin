<?php
/**
 * Created by PhpStorm.
 * Date:  2022/4/15
 * Time:  5:41 PM.
 */

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Common\Util\Auth\Exception;

use Hyperf\Server\Exception\RuntimeException;

class TokenExpireException extends RuntimeException {}
