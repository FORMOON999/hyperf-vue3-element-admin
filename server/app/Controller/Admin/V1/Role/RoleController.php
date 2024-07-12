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

namespace App\Controller\Admin\V1\Role;

use App\Common\Constants\BaseStatus;
use App\Common\Core\BaseController;
use App\Common\Core\Entity\BaseSuccessResponse;
use App\Common\Exceptions\BusinessException;
use App\Common\Helpers\Arrays\ArrayHelper;
use App\Common\Middleware\AdminMiddleware;
use App\Constants\Errors\RoleError;
use App\Controller\Admin\V1\Role\Request\RoleCreateRequest;
use App\Controller\Admin\V1\Role\Request\RoleListRequest;
use App\Controller\Admin\V1\Role\Request\RoleModifyRequest;
use App\Controller\Admin\V1\Role\Response\RoleDetailResponse;
use App\Controller\Admin\V1\Role\Response\RoleListResponse;
use App\Infrastructure\RoleInterface;
use App\Infrastructure\RoleMenuInterface;
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
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

#[Controller(prefix: 'api/v1/admin/role')]
#[Api(tags: 'Admin/角色管理管理')]
#[Middleware(AdminMiddleware::class)]
#[ApiHeader(name: 'Authorization')]
class RoleController extends BaseController
{
    #[Inject()]
    protected RoleInterface $role;

    #[Inject()]
    protected RoleMenuInterface $roleMenu;

    #[GetMapping(path: 'options')]
    #[ApiOperation('角色下拉数据源')]
    public function options(): PsrResponseInterface
    {
        $roles = $this->role->getList(['status' => BaseStatus::NORMAL], ['id', 'name'], [], ['sort' => 'asc']);
        $data = [];
        foreach ($roles->list as $item) {
            $data[] = [
                'label' => $item->name,
                'value' => $item->id,
            ];
        }
        return $this->response->success($data);
    }

    #[GetMapping(path: '')]
    #[ApiOperation('获取角色管理列表')]
    public function getList(#[Valid] #[RequestQuery] RoleListRequest $request): RoleListResponse
    {
        $result = $this->role->getList(
            $request->getSearchParams(),
            [
                'id',
                'created_at',
                'updated_at',
                'name',
                'code',
                'sort',
                'status',
            ],
            [],
            $request->getSort(),
            $request->getPage(),
        );
        return new RoleListResponse($result);
    }

    #[PostMapping(path: '')]
    #[ApiOperation('创建角色管理')]
    public function create(#[Valid] #[RequestFormData] RoleCreateRequest $request): BaseSuccessResponse
    {
        $result = $this->role->create($request->setUnderlineName()->toArray());
        if (! $result) {
            throw new BusinessException(RoleError::CREATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[PutMapping(path: '{id}')]
    #[ApiOperation('更新角色管理')]
    public function modify(string $id, #[Valid] #[RequestFormData] RoleModifyRequest $request): BaseSuccessResponse
    {
        $result = $this->role->modify(
            ['id' => $id],
            $request->setUnderlineName()->toArray()
        );
        if (! $result) {
            throw new BusinessException(RoleError::UPDATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[DeleteMapping(path: '{ids}')]
    #[ApiOperation('删除角色管理')]
    public function remove(string $ids): BaseSuccessResponse
    {
        $result = $this->role->remove(['id' => explode(',', $ids)]);
        if (! $result) {
            throw new BusinessException(RoleError::DELETE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[GetMapping(path: '{id}')]
    #[ApiOperation('获取角色管理详情')]
    public function detail(string $id): RoleDetailResponse
    {
        $result = $this->role->detail(
            ['id' => $id],
            [
                'id',
                'name',
                'code',
                'sort',
                'status',
            ],
        );
        if (! $result) {
            throw new BusinessException(RoleError::NOT_FOUND());
        }
        return new RoleDetailResponse($result);
    }

    #[GetMapping(path: 'menuId/{id}')]
    #[ApiOperation('获取角色菜单ids')]
    public function menuId(string $id): PsrResponseInterface
    {
        $result = $this->roleMenu->getList([
            'role_id' => $id,
        ], ['menu_id']);
        $data = [];
        foreach ($result->list as $item) {
            $data[] = $item->menuId;
        }
        return $this->response->success($data);
    }

    #[PutMapping(path: 'menu/{id}')]
    #[ApiOperation('更新角色菜单')]
    public function menu(string $id): BaseSuccessResponse
    {
        $menuIds = $this->request->post();
        $this->roleMenu->create($id, $menuIds);
        return new BaseSuccessResponse();
    }
}
