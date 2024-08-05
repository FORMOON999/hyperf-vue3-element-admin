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

use App\Common\Core\Entity\BaseModelEntity;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class RoleMenuEntity.
 */
class RoleMenuEntity extends BaseModelEntity
{
    #[ApiModelProperty(value: '角色ID')]
    public int $roleId;

    #[ApiModelProperty(value: '菜单ID')]
    public int $menuId;
}
