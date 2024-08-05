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
