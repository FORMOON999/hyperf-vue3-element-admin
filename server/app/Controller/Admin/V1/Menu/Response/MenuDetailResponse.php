<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1\Menu\Response;

use App\Common\Core\Annotation\ArrayType;
use App\Model\MenuEntity;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class MenuDetailResponse extends MenuEntity
{
    #[ApiModelProperty(value: '路由名称')]
    public string $routeName;

    #[ApiModelProperty('下级')]
    #[ArrayType(MenuEntity::class)]
    public array $children;

}