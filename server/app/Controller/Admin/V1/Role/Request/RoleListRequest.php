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

namespace App\Controller\Admin\V1\Role\Request;

use App\Common\Core\Entity\Page;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class RoleListRequest extends Page
{
    #[ApiModelProperty('名称')]
    public string $name;
}
