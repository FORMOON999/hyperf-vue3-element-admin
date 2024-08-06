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
use App\Common\Util\IPC\Config\ConfigIPC;
use App\Common\Util\IPC\Config\PipeConfig;
use App\Common\Util\IPC\Helper\SysConfigHelper;
use App\Infrastructure\ConfigInterface;
use App\Model\Config;
use App\Model\ConfigEntity;

class ConfigService implements ConfigInterface
{
    use ServiceTrait;

    public function __construct(protected Config $config, protected SysConfigHelper $sysConfig, protected ConfigIPC $ipc) {}

    public function getList(array $search, array $field = ['*'], array $withs = [], array $sort = [], array $page = []): Output
    {
        $query = $this->config->buildQuery()
            ->betweenTime('created_at', $search)
            ->whereSearch($search)
            ->sorts($sort)
            ->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $this->config->output($query, $page);
    }

    public function create(array $data): int|string
    {
        $model = clone $this->config;
        $data = $this->check($data);
        $model->fill($data);
        $ret = $model->save();
        if ($ret) {
            $this->updateConfig($model->key, $model->value);
            return $model->getKey();
        }
        return 0;
    }

    public function modify(array $search, array $data): int
    {
        $data = $this->check($data, $search);
        $model = $this->config->buildQuery($search)->first();
        if (is_null($model)) {
            return 0;
        }
        $status = $model->update($data);
        if ($status) {
            $this->updateConfig($model->key, $model->value);
        }
        return (int)$status;
    }

    public function remove(array $search): int
    {
        $list = $this->config->buildQuery($search)->get(['key']);
        if (empty($list)) {
            return 0;
        }
        $status = $this->config->buildQuery($search)->delete();
        if ($status) {
            foreach ($list as $item) {
                $this->updateConfig($item->key);
            }
        }
        return $status;
    }

    public function detail(array $search, array $field = ['*'], array $withs = [], array $sort = []): ?ConfigEntity
    {
        $query = $this->config->buildQuery($search, $sort)->select($field);
        if (! empty($withs)) {
            $query->with(...$withs);
        }
        return $query->first()?->newEntity();
    }

    public function getCacheById(string $id): ?ConfigEntity
    {
        return $this->config->findFromCacheByCustom($id, function ($id) {
            return $this->config->buildQuery(['id' => $id])->first();
        })?->newEntity();
    }

    public function getCacheByIds(array $ids): Output
    {
        $result = $this->config->findManyFromCacheByCustom($ids, function ($ids) {
            return $this->config->buildQuery(['id' => $ids])->get();
        });
        return $this->outputForCollection($result);
    }

    protected function check(array $data, array $search = []): array
    {
        return $data;
    }

    protected function updateConfig(string $key, ?string $value = null): void
    {
        $data = $this->sysConfig->getAll();
        $data[$key] = $value;
        $this->ipc->synConfig(new PipeConfig([$this->sysConfig->key() => $data]));
    }
}
