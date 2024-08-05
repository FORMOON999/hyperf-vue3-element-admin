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

namespace App\Common\Traits;

use Hyperf\Database\Schema\Blueprint;

trait MigrateFiledTrait
{
    public function commonFields(Blueprint $table): void
    {
        $table->increments('id');
        $table->dateTime('created_at')->comment('创建时间');
        $table->dateTime('updated_at')->comment('更新时间');
        $table->dateTime('deleted_at')->nullable()->comment('删除时间');
    }
}
