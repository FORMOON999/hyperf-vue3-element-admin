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

namespace App\Controller\Admin\V1\Platform;

use App\Common\Core\BaseController;
use App\Common\Core\Entity\BaseSuccessResponse;
use App\Common\Exceptions\BusinessException;
use App\Common\Middleware\AdminMiddleware;
use App\Constants\Errors\PlatformError;
use App\Controller\Admin\V1\Platform\Request\PlatformCreateRequest;
use App\Controller\Admin\V1\Platform\Request\PlatformListRequest;
use App\Controller\Admin\V1\Platform\Request\PlatformModifyRequest;
use App\Controller\Admin\V1\Platform\Response\MeResponse;
use App\Controller\Admin\V1\Platform\Response\PlatformDetailResponse;
use App\Controller\Admin\V1\Platform\Response\PlatformListResponse;
use App\Infrastructure\PlatformInterface;
use App\Infrastructure\RoleInterface;
use Hyperf\ApiDocs\Annotation\Api;
use Hyperf\ApiDocs\Annotation\ApiHeader;
use Hyperf\ApiDocs\Annotation\ApiOperation;
use Hyperf\Di\Annotation\Inject;
use Hyperf\DTO\Annotation\Contracts\RequestFormData;
use Hyperf\DTO\Annotation\Contracts\RequestQuery;
use Hyperf\DTO\Annotation\Contracts\Valid;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;

#[Controller(prefix: '/api/v1/admin/platform')]
#[Api(tags: 'Admin/管理员管理')]
#[Middleware(AdminMiddleware::class)]
#[ApiHeader(name: 'Authorization')]
class PlatformController extends BaseController
{
    #[Inject()]
    protected PlatformInterface $platform;

    #[Inject]
    protected RoleInterface $role;

    #[GetMapping(path: 'me')]
    #[ApiOperation('获取当前登录用户信息')]
    public function me(): MeResponse
    {
        $result = $this->platform->detail(
            ['id' => $this->request->getAttribute('id')],
            [
                'id',
                'username',
                'role_id',
                'avatar',
            ],
        );
        $response = new MeResponse();
        $response->id = $result->id;
        $response->username = $result->username;
        $response->avatar = $result->avatar;
        $response->roles = $this->role->getRoleCodesByIds($result->roleId);
        $response->perms = $this->role->getPermissionsByIds($result->roleId);
        return $response;
    }

    #[GetMapping(path: '')]
    #[ApiOperation('获取管理员列表')]
    public function getList(#[Valid] #[RequestQuery] PlatformListRequest $request): PlatformListResponse
    {
        $result = $this->platform->getList(
            $request->getSearchParams(),
            [
                'id',
                'created_at',
                'updated_at',
                'username',
                'avatar',
                'role_id',
                'status',
                'last_time',
            ],
            [],
            $request->getSort(),
            $request->getPage(),
        );

        $roleIds = [];
        foreach ($result->list as $item) {
            $roleIds = array_merge($roleIds, $item->roleId);
        }
        $roleNames = [];
        if (! empty($roleIds)) {
            $roles = $this->role->getCacheByIds($roleIds);
            foreach ($roles->list as $role) {
                $roleNames[$role->id] = $role->name;
            }
        }
        foreach ($result->list as $key => $item) {
            $roleName = [];
            foreach ($item->roleId as $rid) {
                if (isset($roleNames[$rid])) {
                    $roleName[] = $roleNames[$rid];
                }
            }
            $result->list[$key]->roleName = $roleName;
        }
        return new PlatformListResponse($result);
    }

    #[PostMapping(path: '')]
    #[ApiOperation('创建管理员')]
    public function create(#[Valid] #[RequestFormData] PlatformCreateRequest $request): BaseSuccessResponse
    {
        $result = $this->platform->create($request->setUnderlineName()->toArray());
        if (! $result) {
            throw new BusinessException(PlatformError::CREATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[PutMapping(path: '{id}')]
    #[ApiOperation('更新管理员')]
    public function modify(string $id, #[Valid] #[RequestFormData] PlatformModifyRequest $request): BaseSuccessResponse
    {
        $result = $this->platform->modify(
            ['id' => $id],
            $request->setUnderlineName()->toArray()
        );
        if (! $result) {
            throw new BusinessException(PlatformError::UPDATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[DeleteMapping(path: '{ids}')]
    #[ApiOperation('删除管理员')]
    public function remove(string $ids): BaseSuccessResponse
    {
        $result = $this->platform->remove(['id' => explode(',', $ids)]);
        if (! $result) {
            throw new BusinessException(PlatformError::DELETE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[GetMapping(path: '{id}')]
    #[ApiOperation('获取管理员详情')]
    public function detail(string $id): PlatformDetailResponse
    {
        $result = $this->platform->detail(
            ['id' => $id],
            [
                'id',
                'username',
                'role_id',
                'status',
            ],
        );
        if (! $result) {
            throw new BusinessException(PlatformError::NOT_FOUND());
        }
        return new PlatformDetailResponse($result);
    }
}
