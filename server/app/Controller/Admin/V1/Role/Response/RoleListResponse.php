<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1\Role\Response;

use App\Common\Core\Entity\BaseListResponse;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;
use App\Common\Core\Annotation\ArrayType;

class RoleListResponse extends BaseListResponse
{
    #[ApiModelProperty('列表')]
    #[ArrayType(RoleDetailResponse::class)]
    public array $list;
}