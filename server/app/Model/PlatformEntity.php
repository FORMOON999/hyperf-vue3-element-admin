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

namespace App\Model;

use App\Common\Constants\BaseStatus;
use App\Common\Core\Entity\BaseModelEntity;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class PlatformEntity.
 */
class PlatformEntity extends BaseModelEntity
{
    #[ApiModelProperty(value: '账号')]
    public string $username;

    #[ApiModelProperty(value: '密码')]
    public string $password;

    #[ApiModelProperty(value: '头像')]
    public string $avatar;

    #[ApiModelProperty(value: '角色id')]
    public array $roleId;

    #[ApiModelProperty(value: '角色名称')]
    public array $roleName;

    #[ApiModelProperty(value: '状态')]
    public BaseStatus $status;

    #[ApiModelProperty(value: '上次登录时间')]
    public ?string $lastTime = '';
}