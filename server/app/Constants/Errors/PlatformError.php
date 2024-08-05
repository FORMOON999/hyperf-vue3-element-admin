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

enum PlatformError: int implements MessageBackedEnum
{
    use EnumMessageTrait;

    #[EnumMessage(message: '创建管理员失败')]
    case CREATE_ERROR = 1002001;

    #[EnumMessage(message: '更新管理员失败')]
    case UPDATE_ERROR = 1002002;

    #[EnumMessage(message: '删除管理员失败')]
    case DELETE_ERROR = 1002003;

    #[EnumMessage(message: '管理员不存在，请重试')]
    case NOT_FOUND = 1002004;

    #[EnumMessage(message: ':name 已被占用')]
    case EXISTS = 1002005;

    #[EnumMessage(message: '验证码错误')]
    case CAPTCHA_ERROR = 1002006;

    #[EnumMessage(message: '账号或者密码错误')]
    case ACCOUNT_OR_PASSWORD_NOT_FOUND = 1002007;

    #[EnumMessage(message: '账号已冻结，请联系管理员')]
    case FROZEN = 1002008;
}
