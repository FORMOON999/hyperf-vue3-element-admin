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
use App\Common\Core\Enum\BaseEnum;

class MenuType extends BaseEnum
{
    #[EnumMessage(message: '菜单')]
    public const MENU = 'MENU';

    #[EnumMessage(message: '目录')]
    public const CATALOG = 'CATALOG';

    #[EnumMessage(message: '外链')]
    public const EXT_LINK = 'EXTLINK';

    #[EnumMessage(message: '按钮权限')]
    public const BUTTON = 'BUTTON';
}
