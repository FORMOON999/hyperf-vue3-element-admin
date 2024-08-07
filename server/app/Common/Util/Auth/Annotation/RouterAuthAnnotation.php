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

namespace App\Common\Util\Auth\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 路由权限注解
 * 定义 白名单.
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class RouterAuthAnnotation extends AbstractAnnotation
{
    // 是否为公共访问， 不走auth验证
    public bool $isPublic = false;

    // 是否为白名单， 走auth验证，如果不存在token不报错
    public bool $isWhite = false;

    // 是否忽略 过期
    public bool $ignoreExpired = false;

    public function __construct(bool $isPublic = false, bool $isWhite = false, bool $ignoreExpired = false)
    {
        $this->isPublic = $isPublic;
        $this->isWhite = $isWhite;
        $this->ignoreExpired = $ignoreExpired;
    }
}
