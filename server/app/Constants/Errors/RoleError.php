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

namespace App\Constants\Errors;

use App\Common\Core\Enum\Annotation\EnumMessage;
use App\Common\Core\Enum\EnumMessageTrait;
use App\Common\Core\Enum\MessageBackedEnum;

enum RoleError: int implements MessageBackedEnum
{
    use EnumMessageTrait;

    #[EnumMessage(message: '创建角色管理失败')]
    case CREATE_ERROR = 1003001;

    #[EnumMessage(message: '更新角色管理失败')]
    case UPDATE_ERROR = 1003002;

    #[EnumMessage(message: '删除角色管理失败')]
    case DELETE_ERROR = 1003003;

    #[EnumMessage(message: '角色管理不存在，请重试')]
    case NOT_FOUND = 1003004;

    #[EnumMessage(message: ':name 已被占用')]
    case EXISTS = 1003005;
}
