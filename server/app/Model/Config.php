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
 * @property string $name 配置标题
 * @property string $description 配置项描述
 * @property string $key 配置项键
 * @property string $value 配置值
 */
class Config extends BaseModel
{
    /**
     * primaryKey.
     */
    protected string $primaryKey = 'id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'config';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'created_at', 'updated_at', 'deleted_at', 'name', 'description', 'key', 'value'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer'];

    public function newEntity(): BaseModelEntity
    {
        return new ConfigEntity($this->toArray());
    }
}
