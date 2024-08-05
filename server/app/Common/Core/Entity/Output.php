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

namespace App\Common\Core\Entity;

use App\Common\Core\BaseObject;

class Output extends BaseObject
{
    public ?int $page = null;

    public ?int $pageSize = null;

    public ?int $total = null;

    public array $list = [];
}
