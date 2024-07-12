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
use App\Infrastructure\MenuInterface;
use App\Model\Menu;
use App\Model\MenuEntity;

class MenuService implements MenuInterface
{
    use ServiceTrait;

    public function __construct(protected Menu $menu) {}

    public function getList(array $search): array
    {
        $result = $this->getChildrenList($search);
        $data = [];
        foreach ($result->list as $item) {
            $search['parent_id'] = $item->id;
            $item->routeName = $item->name;
            $item->children = $this->getList($search);
            $data[] = $item->toArray();
        }
        return $data;
    }

    public function create(array $data): int|string
    {
        $model = clone $this->menu;
        $data = $this->check($data);
        $model->fill($data);
        $ret = $model->save();
        return $ret ? $model->getKey() : 0;
    }

    public function modify(array $search, array $data): int
    {
        $data = $this->check($data, $search);
        return (int) $this->menu->buildQuery($search)->first()?->update($data);
    }

    public function remove(array $search): ?bool
    {
        return $this->menu->buildQuery($search)->first()?->delete();
    }

    public function detail(array $search, array $field = ['*'], array $withs = [], array $sort = []): ?MenuEntity
    {
        $query = $this->menu->buildQuery($search, $sort)->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $query->first()?->newEntity();
    }

    public function getCacheById(string $id): ?MenuEntity
    {
        return $this->menu->findFromCacheByCustom($id, function ($id) {
            return $this->menu->buildQuery(['id' => $id])->first();
        })?->newEntity();
    }

    public function getCacheByIds(array $ids): Output
    {
        $result = $this->menu->findManyFromCacheByCustom($ids, function ($ids) {
            return $this->menu->buildQuery(['id' => $ids])->get();
        });
        return $this->outputForCollection($result);
    }

    public function routes(array $roleIds): array
    {
        $response = [];
        $tops = $this->getListByPid(0, $roleIds);
        /**
         * @var MenuEntity $top
         */
        foreach ($tops->list as $top) {
            $meta = [
                'title' => $top->name,
                'icon' => $top->icon,
                'hidden' => ! $top->visible->getValue(),
                'alwaysShow' => (bool) $top->alwaysShow,
                'params' => $top->params,
            ];
            $item = [
                'path' => $top->path,
                'name' => $top->path,
                'component' => $top->component,
                'redirect' => $top->redirect,
                'meta' => $meta,
                'children' => $this->getChildren($top->id, $roleIds),
            ];
            $response[] = $item;
        }
        return $response;
    }

    public function options(): array
    {
        $response = [];
        $tops = $this->getListByPid(0);
        foreach ($tops->list as $top) {
            $item = [
                'label' => $top->name,
                'value' => $top->id,
                'children' => $this->getChildrenOption($top->id),
            ];
            $response[] = $item;
        }
        return $response;
    }

    protected function getChildrenList(array $search): Output
    {
        $query = $this->menu->newQuery();
        if (empty($search['parent_id'])) {
            $search['parent_id'] = 0;
            unset($search['name']);
        } else {
            $query->whereLike('name', $search);
        }
        $query->whereSearch($search)
            ->select([
                'id',
                'parent_id',
                'name',
                'type',
                'path',
                'component',
                'perm',
                'sort',
                'visible',
                'icon',
                'redirect',
            ]);
        return $this->menu->output($query);
    }

    protected function getChildrenOption(int $pid): array
    {
        $result = [];
        $menu = $this->getListByPid($pid);
        foreach ($menu->list as $data) {
            $item = [
                'label' => $data->name,
                'value' => $data->id,
                'children' => $this->getChildrenOption($data->id),
            ];
            $result[] = $item;
        }
        return $result;
    }

    protected function getListByPid(int $pid, array $roleIds = []): Output
    {
        $query = $this->menu->buildQuery([
            'menu.parent_id' => $pid,
        ], ['menu.sort' => 'asc'])->select([
            'menu.*',
        ]);
        if (! empty($roleIds)) {
            $query->join('role_menu', 'role_menu.menu_id', '=', 'menu.id')
                ->whereIn('role_menu.role_id', $roleIds)
                ->groupBy(['menu.id']);
        }
        return $this->menu->output($query);
    }

    protected function getChildren(int $pid, array $roleIds): array
    {
        $result = [];
        $menu = $this->getListByPid($pid, $roleIds);
        /**
         * @var MenuEntity $data
         */
        foreach ($menu->list as $data) {
            $meta = [
                'title' => $data->name,
                'icon' => $data->icon,
                'hidden' => ! $data->visible->getValue(),
                'keepAlive' => (bool) $data->keepAlive,
                'alwaysShow' => (bool) $data->alwaysShow,
                'params' => $data->params,
            ];
            $item = [
                'path' => $data->path,
                'name' => ucfirst($data->path),
                'component' => $data->component,
                'meta' => $meta,
            ];
            $result[] = $item;
        }
        return $result;
    }

    protected function check(array $data, array $search = []): array
    {
        return $data;
    }
}
