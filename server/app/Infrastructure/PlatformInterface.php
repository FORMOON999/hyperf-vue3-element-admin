<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Model\PlatformEntity;
use App\Common\Core\Entity\Output;

interface PlatformInterface
{
    public function getList(array $search, array $field = ['*'], array $withs = [], array $sort = [], array $page = []): Output;

    public function create(array $data): int|string;

    public function modify(array $search, array $data): int;

    public function remove(array $search): int;

    public function detail(array $search, array $field = ['*'], array $withs = [], array $sort = []): ?PlatformEntity;

    public function getCacheById(string $id): ?PlatformEntity;

    public function getCacheByIds(array $ids): Output;

    public function login(string $username, string $password): PlatformEntity;
}
