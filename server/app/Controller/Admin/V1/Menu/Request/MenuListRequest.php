<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1\Menu\Request;

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class MenuListRequest extends BaseObject
{
    #[ApiModelProperty('菜单名称')]
    public ?string $name = null;
}