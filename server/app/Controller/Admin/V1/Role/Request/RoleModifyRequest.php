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

namespace App\Controller\Admin\V1\Role\Request;

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class RoleModifyRequest.
 */
class RoleModifyRequest extends BaseObject
{
    #[ApiModelProperty(value: '角色名称')]
    public string $name;

    #[ApiModelProperty(value: '角色编码')]
    public string $code;

    #[ApiModelProperty(value: '排序')]
    public int $sort;

    #[ApiModelProperty(value: '状态')]
    public int $status;
}
