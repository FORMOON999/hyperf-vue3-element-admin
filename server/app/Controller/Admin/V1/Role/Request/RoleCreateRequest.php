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
use Hyperf\DTO\Annotation\Validation\Required;

/**
 * Class RoleCreateRequest.
 */
class RoleCreateRequest extends BaseObject
{
    #[ApiModelProperty(value: '角色名称', required: true), Required]
    public string $name;

    #[ApiModelProperty(value: '角色编码', required: true), Required]
    public string $code;

    #[ApiModelProperty(value: '排序', required: true), Required]
    public int $sort;

    #[ApiModelProperty(value: '状态', required: true), Required]
    public int $status;
}
