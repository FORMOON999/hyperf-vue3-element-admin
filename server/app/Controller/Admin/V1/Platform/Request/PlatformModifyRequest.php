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

namespace App\Controller\Admin\V1\Platform\Request;

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class PlatformModifyRequest.
 */
class PlatformModifyRequest extends BaseObject
{
    #[ApiModelProperty(value: '账号')]
    public string $username;

    #[ApiModelProperty(value: '密码')]
    public string $password;

    #[ApiModelProperty(value: '角色')]
    public array $roleId;

    #[ApiModelProperty(value: '状态')]
    public int $status;
}
