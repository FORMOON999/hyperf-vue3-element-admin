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

namespace App\Controller\Admin\V1\Platform\Request;

use App\Common\Core\Entity\Page;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class PlatformListRequest extends Page
{
    #[ApiModelProperty('状态')]
    public int $status;
    #[ApiModelProperty('开始时间')]
    public string $startTime;

    #[ApiModelProperty('结束时间')]
    public string $endTime;

    #[ApiModelProperty('用户名')]
    public string $username;
}
