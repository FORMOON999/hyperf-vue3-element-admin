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

namespace App\Controller\Admin\V1\Platform\Response;

use App\Common\Core\Annotation\ArrayType;
use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class MeResponse extends BaseObject
{
    #[ApiModelProperty(value: '用户id')]
    public int $id;

    #[ApiModelProperty(value: '账号')]
    public string $username;

    #[ApiModelProperty(value: '头像')]
    public string $avatar;

    #[ApiModelProperty(value: '角色'), ArrayType(type: 'string')]
    public array $roles;

    #[ApiModelProperty(value: '权限'), ArrayType(type: 'string')]
    public array $perms;
}
