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
use App\Common\Constants\BaseStatus;
use App\Common\Traits\MigrateFiledTrait;
use App\Constants\Type\MenuType;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

class Auth extends Migration
{
    use MigrateFiledTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $date = date('Y-m-d H:i:s');
        if (! Schema::hasTable('role')) {
            Schema::create('role', function (Blueprint $table) {
                $this->commonFields($table);
                $table->comment('角色管理');
                $table->string('name', 32)->comment('角色名称');
                $table->string('code', 32)->comment('角色编码');
                $table->integer('sort')->default(1)->comment('排序');
                $table->tinyInteger('status')->comment('状态');
            });

            Db::table('role')->insert([
                'id' => 1,
                'name' => '系统管理员',
                'code' => 'ADMIN',
                'sort' => 1,
                'status' => BaseStatus::NORMAL,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        if (! Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $this->commonFields($table);
                $table->comment('菜单管理');
                $table->integer('parent_id')->default(0)->comment('父级');
                $table->string('name', 32)->comment('菜单名称');
                $table->enum('type', ['CATALOG', 'MENU', 'BUTTON', 'EXTLINK'])->nullable()->comment('菜单类型(CATALOG-菜单；MENU-目录；BUTTON-按钮；EXTLINK-外链)');
                $table->string('path', 255)->comment('路由路径');
                $table->string('component', 255)->comment('组件路径(vue页面完整路径，省略.vue后缀)');
                $table->string('perm', 255)->nullable()->comment('权限标识');
                $table->integer('sort')->default(1)->comment('排序');
                $table->tinyInteger('visible')->comment('显示状态');
                $table->string('icon', 255)->comment('菜单图标');
                $table->string('redirect', 255)->comment('跳转路径');
                $table->tinyInteger('always_show')->default(0)->comment('始终显示');
                $table->tinyInteger('keep_alive')->default(1)->comment('始终显示');
                $table->json('params')->nullable()->comment('路由参数');
            });
            Db::table('menu')->insert([
                ['id' => 1, 'parent_id' => 0, 'name' => '系统管理', 'type' => MenuType::CATALOG, 'path' => '/system', 'component' => 'Layout', 'perm' => '', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => 'system', 'redirect' => '/system', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 2, 'parent_id' => 1, 'name' => '管理员管理', 'type' => MenuType::MENU, 'path' => 'system/platform', 'component' => 'system/platform/index', 'perm' => '', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => 'el-icon-User', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 3, 'parent_id' => 2, 'name' => '管理员新增', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:platform:add', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 4, 'parent_id' => 2, 'name' => '管理员编辑', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:platform:edit', 'sort' => 2, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 5, 'parent_id' => 2, 'name' => '管理员删除', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:platform:delete', 'sort' => 3, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 6, 'parent_id' => 1, 'name' => '角色管理', 'type' => MenuType::MENU, 'path' => 'system/role', 'component' => 'system/role/index', 'perm' => '', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => 'role', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 7, 'parent_id' => 6, 'name' => '角色新增', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:role:add', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 8, 'parent_id' => 6, 'name' => '角色编辑', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:role:edit', 'sort' => 2, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 9, 'parent_id' => 6, 'name' => '角色删除', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:role:delete', 'sort' => 3, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 10, 'parent_id' => 6, 'name' => '分配权限', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:role:permission', 'sort' => 4, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 11, 'parent_id' => 1, 'name' => '菜单管理', 'type' => MenuType::MENU, 'path' => 'system/menu', 'component' => 'system/menu/index', 'perm' => '', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => 'menu', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 12, 'parent_id' => 11, 'name' => '菜单新增', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:menu:add', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 13, 'parent_id' => 11, 'name' => '菜单编辑', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:menu:edit', 'sort' => 2, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['id' => 14, 'parent_id' => 11, 'name' => '菜单删除', 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => 'sys:menu:delete', 'sort' => 3, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
            ]);
        }

        if (! Schema::hasTable('role_menu')) {
            Schema::create('role_menu', function (Blueprint $table) {
                $this->commonFields($table);
                $table->comment('角色菜单关联');
                $table->integer('role_id')->default(0)->comment('角色ID');
                $table->integer('menu_id')->default(0)->comment('菜单ID');
            });
            $roleMenu = [];
            for ($i = 1; $i <= 14; ++$i) {
                $roleMenu[] = ['role_id' => 1, 'menu_id' => $i, 'created_at' => $date, 'updated_at' => $date];
            }
            Db::table('role_menu')->insert($roleMenu);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'role',
            'menu',
            'role_menu',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
}
