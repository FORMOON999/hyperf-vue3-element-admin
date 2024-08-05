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

use App\Common\Core\BaseModel;
use App\Common\Core\Entity\BaseModelEntity;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property int $parent_id 父级
 * @property string $name 菜单名称
 * @property string $type 菜单类型(CATALOG-菜单；MENU-目录；BUTTON-按钮；EXTLINK-外链)
 * @property string $path 路由路径
 * @property string $component 组件路径(vue页面完整路径，省略.vue后缀)
 * @property string $perm 权限标识
 * @property int $sort 排序
 * @property int $visible 显示状态
 * @property string $icon 菜单图标
 * @property string $redirect 跳转路径
 * @property int $always_show 始终显示
 * @property int $keep_alive 始终显示
 * @property string $params 路由参数
 */
class Menu extends BaseModel
{
    /**
     * primaryKey.
     */
    protected string $primaryKey = 'id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'menu';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'created_at', 'updated_at', 'deleted_at', 'parent_id', 'name', 'type', 'path', 'component', 'perm', 'sort', 'visible', 'icon', 'redirect', 'always_show', 'keep_alive', 'params'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'parent_id' => 'integer', 'sort' => 'integer', 'visible' => 'integer', 'always_show' => 'integer', 'keep_alive' => 'integer', 'params' => 'json'];

    public function newEntity(): BaseModelEntity
    {
        return new MenuEntity($this->toArray());
    }

    public function role(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_menu', 'menu_id', 'role_id', 'id');
    }
}
