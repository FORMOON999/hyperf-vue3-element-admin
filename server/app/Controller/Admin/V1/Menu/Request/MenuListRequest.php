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

namespace App\Controller\Admin\V1\Menu\Request;

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class MenuListRequest extends BaseObject
{
    #[ApiModelProperty('菜单名称')]
    public ?string $name = null;
}
