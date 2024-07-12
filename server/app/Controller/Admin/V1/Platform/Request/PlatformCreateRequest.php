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

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;
use Hyperf\DTO\Annotation\Validation\Required;

/**
 * Class PlatformCreateRequest.
 */
class PlatformCreateRequest extends BaseObject
{
    #[ApiModelProperty(value: '账号', required: true), Required]
    public string $username;

    #[ApiModelProperty(value: '密码', required: true), Required]
    public string $password;

    #[ApiModelProperty(value: '角色', required: true), Required]
    public array $roleId;

    #[ApiModelProperty(value: '状态', required: true), Required]
    public int $status;
}
