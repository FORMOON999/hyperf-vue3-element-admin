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

namespace App\Service;

use App\Common\Constants\BaseStatus;
use App\Common\Core\Entity\Output;
use App\Common\Core\ServiceTrait;
use App\Common\Exceptions\BusinessException;
use App\Common\Helpers\PasswordHelper;
use App\Constants\Errors\PlatformError;
use App\Infrastructure\PlatformInterface;
use App\Model\Platform;
use App\Model\PlatformEntity;

class PlatformService implements PlatformInterface
{
    use ServiceTrait;

    public function __construct(protected Platform $platform) {}

    public function getList(array $search, array $field = ['*'], array $withs = [], array $sort = [], array $page = []): Output
    {
        $query = $this->platform->newQuery()
            ->betweenTime('created_at', $search)
            ->whereLike('username', $search)
            ->whereCondition('status', $search)
            ->whereSearch($search)
            ->sorts($sort)
            ->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $this->platform->output($query, $page);
    }

    public function create(array $data): int|string
    {
        $model = clone $this->platform;
        $data = $this->check($data);
        $model->fill($data);
        $ret = $model->save();
        return $ret ? $model->getKey() : 0;
    }

    public function modify(array $search, array $data): int
    {
        $data = $this->check($data, $search);
        return (int) $this->platform->buildQuery($search)->first()?->update($data) ?? 0;
    }

    public function remove(array $search): int
    {
        return $this->platform->buildQuery($search)->delete();
    }

    public function detail(array $search, array $field = ['*'], array $withs = [], array $sort = []): ?PlatformEntity
    {
        $query = $this->platform->buildQuery($search, $sort)->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $query->first()?->newEntity();
    }

    public function login(string $username, string $password): PlatformEntity
    {
        $platform = $this->detail(['username' => $username], [
            'id',
            'password',
            'status',
        ]);
        if (empty($platform)) {
            throw new BusinessException(PlatformError::ACCOUNT_OR_PASSWORD_NOT_FOUND);
        }

        if (! PasswordHelper::verifyPassword($password, $platform->password)) {
            throw new BusinessException(PlatformError::ACCOUNT_OR_PASSWORD_NOT_FOUND);
        }

        // 状态
        if ($platform->status !== BaseStatus::NORMAL) {
            throw new BusinessException(PlatformError::FROZEN);
        }

        $this->modify(['id' => $platform->id], ['last_time' => date('Y-m-d H:i:s')]);
        return $platform;
    }

    public function getCacheById(string $id): ?PlatformEntity
    {
        return $this->platform->findFromCacheByCustom($id, function ($id) {
            return $this->platform->buildQuery(['id' => $id])->first();
        })?->newEntity();
    }

    public function getCacheByIds(array $ids): Output
    {
        $result = $this->platform->findManyFromCacheByCustom($ids, function ($ids) {
            return $this->platform->buildQuery(['id' => $ids])->get();
        });
        return $this->outputForCollection($result);
    }

    protected function check(array $data, array $search = []): array
    {
        if (! empty($data['password'])) {
            $data['password'] = PasswordHelper::generatePassword($data['password']);
        }
        return $data;
    }
}
