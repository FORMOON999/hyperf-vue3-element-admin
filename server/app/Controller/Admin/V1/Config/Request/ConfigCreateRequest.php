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
use Hyperf\DTO\Annotation\Validation\Required;

/**
 * Class ConfigCreateRequest.
 */
class ConfigCreateRequest extends BaseObject
{
    #[ApiModelProperty(value: '配置标题', required: true), Required]
    public string $name;

    #[ApiModelProperty(value: '配置项描述', required: true), Required]
    public string $description;

    #[ApiModelProperty(value: '配置项键', required: true), Required]
    public string $key;

    #[ApiModelProperty(value: '配置值', required: true), Required]
    public string $value;
}
