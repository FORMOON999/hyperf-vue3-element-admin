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

namespace App\Common\Commands\CodeGenerator;

class GeneratorConfig
{
    // 路径
    public string $path;

    // 版本
    public string $version;

    // 路由
    public string $url;

    // 引用
    public array $applications;
}
