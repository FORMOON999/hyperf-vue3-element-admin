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

namespace App\Model;

use App\Common\Core\Entity\BaseModelEntity;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

/**
 * Class ConfigEntity.
 */
class ConfigEntity extends BaseModelEntity
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
