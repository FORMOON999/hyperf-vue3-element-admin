<?php

declare(strict_types=1);

namespace App\Constants\Errors;

use App\Common\Core\Enum\Annotation\EnumMessage;
use App\Common\Core\Enum\EnumMessageTrait;
use App\Common\Core\Enum\MessageBackedEnum;

enum RoleMenuError: int implements MessageBackedEnum
{
    use EnumMessageTrait;

    #[EnumMessage(message: '创建角色菜单关联失败')]
    case CREATE_ERROR = 1004001;

    #[EnumMessage(message: '更新角色菜单关联失败')]
    case UPDATE_ERROR = 1004002;

    #[EnumMessage(message: '删除角色菜单关联失败')]
    case DELETE_ERROR = 1004003;

    #[EnumMessage(message: '角色菜单关联不存在，请重试')]
    case NOT_FOUND = 1004004;

    #[EnumMessage(message: ':name 已被占用')]
    case EXISTS = 1004005;
}
