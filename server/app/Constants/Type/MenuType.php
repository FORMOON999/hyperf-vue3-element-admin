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

namespace App\Constants\Type;

use App\Common\Core\Enum\Annotation\EnumMessage;
use App\Common\Core\Enum\EnumMessageTrait;

enum MenuType: string
{
    use EnumMessageTrait;

    #[EnumMessage(message: '菜单')]
    case MENU = 'MENU';

    #[EnumMessage(message: '目录')]
    case CATALOG = 'CATALOG';

    #[EnumMessage(message: '外链')]
    case EXT_LINK = 'EXTLINK';

    #[EnumMessage(message: '按钮权限')]
    case BUTTON = 'BUTTON';
}
