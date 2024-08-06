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
use App\Common\Helpers\PasswordHelper;
use App\Common\Traits\MigrateFiledTrait;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

class Platform extends Migration
{
    use MigrateFiledTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $date = date('Y-m-d H:i:s');

        if (!Schema::hasTable('platform')) {
            Schema::create('platform', function (Blueprint $table) {
                $this->commonFields($table);
                $table->comment('管理员');

                $table->string('username', 32)->comment('账号');
                $table->string('password', 64)->comment('密码');
                $table->string('avatar', 255)->default('https://oss.youlai.tech/youlai-boot/2023/05/16/811270ef31f548af9cffc026dfc3777b.gif')->comment('头像');
                $table->json('role_id')->comment('角色');
                $table->tinyInteger('status')->comment('状态');
                $table->dateTime('last_time')->nullable()->comment('上次登录时间');
            });

            Db::table('platform')->insert([
                'username' => 'admin',
                'role_id' => json_encode([1]),
                'password' => PasswordHelper::generatePassword('123456'),
                'status' => BaseStatus::NORMAL,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        if (!Schema::hasTable('config')) {
            Schema::create('config', function (Blueprint $table) {
                $this->commonFields($table);
                $table->comment('系统配置');

                $table->string('name', 32)->comment('配置名称');
                $table->string('description', 255)->comment('描述');
                $table->string('key', 64)->comment('配置键');
                $table->text('value')->comment('配置值');
            });

            Db::table('config')->insert([
                [
                    'name' => '本地上传',
                    'description' => '本地上传配置',
                    'key' => 'localOss',
                    'value' => '{"bucket": "public"}',
                    'created_at' => $date,
                    'updated_at' => $date,
                ],
                [
                    'name' => '图片域名',
                    'description' => '图片域名',
                    'key' => 'imageDomain',
                    'value' => 'http://127.0.0.1:9501',
                    'created_at' => $date,
                    'updated_at' => $date,
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'platform',
            'config'
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
}
