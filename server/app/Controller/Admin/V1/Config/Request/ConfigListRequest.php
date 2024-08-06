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

namespace App\Controller\Admin\V1\Config\Request;

use App\Common\Core\Entity\Page;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class ConfigListRequest extends Page
{
    #[ApiModelProperty('开始时间')]
    public string $startTime;

    #[ApiModelProperty('结束时间')]
    public string $endTime;
}
