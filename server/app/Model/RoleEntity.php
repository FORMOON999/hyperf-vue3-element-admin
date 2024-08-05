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
 * Class RoleEntity.
 */
class RoleEntity extends BaseModelEntity
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
