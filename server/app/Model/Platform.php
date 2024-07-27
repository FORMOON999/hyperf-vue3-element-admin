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

use App\Common\Core\BaseModel;
use App\Common\Core\Entity\BaseModelEntity;

/**
 * @property int $id
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $username 账号
 * @property string $password 密码
 * @property string $avatar 头像
 * @property string $role_id 角色
 * @property int $status 状态
 * @property string $last_time 上次登录时间
 */
class Platform extends BaseModel
{
    /**
     * primaryKey
     *
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected ?string $table = 'platform';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = ['id', 'created_at', 'updated_at', 'deleted_at', 'username', 'password', 'avatar', 'role_id', 'status', 'last_time'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = ['id' => 'integer', 'status' => 'integer', 'role_id' => 'json'];

    public function newEntity(): BaseModelEntity
    {
        return new PlatformEntity($this->toArray());
    }
}
