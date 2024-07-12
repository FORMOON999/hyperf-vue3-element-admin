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

use App\Common\Core\Entity\Output;
use App\Common\Core\ServiceTrait;
use App\Infrastructure\RoleMenuInterface;
use App\Model\RoleMenu;
use App\Model\RoleMenuEntity;
use Hyperf\DbConnection\Db;

class RoleMenuService implements RoleMenuInterface
{
    use ServiceTrait;

    public function __construct(protected RoleMenu $roleMenu) {}

    public function getList(array $search, array $field = ['*'], array $withs = [], array $sort = [], array $page = []): Output
    {
        $query = $this->roleMenu->buildQuery($search, $sort)->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $this->roleMenu->output($query, $page);
    }

    public function create(string $roleId, array $data): int|string
    {
        $insert = [];
        foreach ($data as $menuId) {
            $insert[] = [
                'role_id' => $roleId,
                'menu_id' => $menuId,
            ];
        }
        return Db::transaction(function () use ($roleId, $insert) {
            $this->remove(['role_id' => $roleId]);
            if (! empty($insert)) {
                return $this->roleMenu->batchInsert($insert);
            }
            return 1;
        });
    }

    public function modify(array $search, array $data): int
    {
        $data = $this->check($data, $search);
        return $this->roleMenu->buildQuery($search)->update($data);
    }

    public function remove(array $search): ?bool
    {
        return (bool) $this->roleMenu->buildQuery($search)->forceDelete();
    }

    public function detail(array $search, array $field = ['*'], array $withs = [], array $sort = []): ?RoleMenuEntity
    {
        $query = $this->roleMenu->buildQuery($search, $sort)->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $query->first()?->newEntity();
    }

    public function getCacheById(string $id): ?RoleMenuEntity
    {
        return $this->roleMenu->findFromCacheByCustom($id, function ($id) {
            return $this->roleMenu->buildQuery(['id' => $id])->first();
        })?->newEntity();
    }

    public function getCacheByIds(array $ids): Output
    {
        $result = $this->roleMenu->findManyFromCacheByCustom($ids, function ($ids) {
            return $this->roleMenu->buildQuery(['id' => $ids])->get();
        });
        return $this->outputForCollection($result);
    }

    protected function check(array $data, array $search = []): array
    {
        return $data;
    }
}
