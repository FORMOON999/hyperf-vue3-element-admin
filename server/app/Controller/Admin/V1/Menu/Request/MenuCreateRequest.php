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
use App\Constants\Type\MenuType;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;
use Hyperf\DTO\Annotation\Validation\Required;

/**
 * Class MenuCreateRequest.
 */
class MenuCreateRequest extends BaseObject
{
    #[ApiModelProperty(value: '父级', required: true), Required]
    public int $parentId;

    #[ApiModelProperty(value: '菜单名称', required: true), Required]
    public string $name;

    #[ApiModelProperty(value: '菜单类型(CATALOG-菜单；MENU-目录；BUTTON-按钮；EXTLINK-外链)', required: true), Required]
    public MenuType $type;

    #[ApiModelProperty(value: '路由路径')]
    public string $path = '';

    #[ApiModelProperty(value: '组件路径(vue页面完整路径，省略.vue后缀)')]
    public string $component = '';

    #[ApiModelProperty(value: '权限标识')]
    public string $perm = '';

    #[ApiModelProperty(value: '排序', required: true), Required]
    public int $sort;

    #[ApiModelProperty(value: '显示状态', required: true), Required]
    public int $visible;

    #[ApiModelProperty(value: '菜单图标')]
    public string $icon = '';

    #[ApiModelProperty(value: '跳转路径')]
    public string $redirect = '';

    #[ApiModelProperty(value: '始终显示', required: true), Required]
    public ?int $alwaysShow;

    #[ApiModelProperty(value: '始终显示', required: true), Required]
    public ?int $keepAlive;

    #[ApiModelProperty(value: '路由参数')]
    public ?array $params = [];

    public function setType($type): MenuType
    {
        $this->type = MenuType::from($type);
        if ($this->type == MenuType::CATALOG) {
            $this->component = 'Layout';
        }
        return $this->type;
    }
}
