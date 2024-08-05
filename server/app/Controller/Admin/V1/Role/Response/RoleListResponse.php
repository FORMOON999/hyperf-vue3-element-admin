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

namespace App\Controller\Admin\V1\Role\Response;

use App\Common\Core\Annotation\ArrayType;
use App\Common\Core\Entity\BaseListResponse;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class RoleListResponse extends BaseListResponse
{
    #[ApiModelProperty('列表')]
    #[ArrayType(RoleDetailResponse::class)]
    public array $list;
}
