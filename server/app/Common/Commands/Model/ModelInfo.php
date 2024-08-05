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

namespace App\Common\Commands\Model;

class ModelInfo extends ClassInfo
{
    // 字段
    public array $columns;

    // 模块
    public string $module;

    // 主键
    public string $pk;

    // 表的备注
    public string $comment;

    // 是否存在
    public bool $exist;
}
