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

namespace App\Common\Constants;

use App\Common\Core\Enum\Annotation\EnumMessage;
use App\Common\Core\Enum\EnumMessageTrait;

/**
 * 终端.
 */
enum Terminal: string
{
    use EnumMessageTrait;

    #[EnumMessage(message: '安卓')]
    case ANDROID = 'android';

    #[EnumMessage(message: '苹果')]
    case IOS = 'ios';

    #[EnumMessage(message: '苹果书签')]
    case IOS_BOOKMARK = 'ios_bookmark';
}
