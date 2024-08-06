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

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class ConfigModifyRequest.
 */
class ConfigModifyRequest extends BaseObject
{
    #[ApiModelProperty(value: '配置标题')]
    public string $name;

    #[ApiModelProperty(value: '配置项描述')]
    public string $description;

    #[ApiModelProperty(value: '配置项键')]
    public string $key;

    #[ApiModelProperty(value: '配置值')]
    public string $value;
}
