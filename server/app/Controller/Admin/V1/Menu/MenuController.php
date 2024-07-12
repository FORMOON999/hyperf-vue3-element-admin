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

namespace App\Controller\Admin\V1\Menu;

use App\Common\Core\BaseController;
use App\Common\Core\Entity\BaseSuccessResponse;
use App\Common\Exceptions\BusinessException;
use App\Common\Middleware\AdminMiddleware;
use App\Constants\Errors\MenuError;
use App\Controller\Admin\V1\Menu\Request\MenuCreateRequest;
use App\Controller\Admin\V1\Menu\Request\MenuListRequest;
use App\Controller\Admin\V1\Menu\Request\MenuModifyRequest;
use App\Controller\Admin\V1\Menu\Response\MenuDetailResponse;
use App\Infrastructure\MenuInterface;
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

#[Controller(prefix: 'api/v1/admin/menu')]
#[Api(tags: 'Admin/菜单管理管理')]
#[Middleware(AdminMiddleware::class)]
#[ApiHeader(name: 'Authorization')]
class MenuController extends BaseController
{
    #[Inject()]
    protected MenuInterface $menu;

    #[GetMapping(path: 'routes')]
    #[ApiOperation('路由列表')]
    public function routes(): PsrResponseInterface
    {
        $result = $this->menu->routes($this->request->getAttribute('roleId'));
        return $this->response->success($result);
    }

    #[GetMapping(path: 'options')]
    #[ApiOperation('角色下拉数据源')]
    public function options(): PsrResponseInterface
    {
        $result = $this->menu->options();
        return $this->response->success($result);
    }

    #[GetMapping(path: '')]
    #[ApiOperation('获取菜单管理列表')]
    public function getList(#[Valid] #[RequestQuery] MenuListRequest $request): PsrResponseInterface
    {
        $result = $this->menu->getList(
            $request->toArray(),
        );
        return $this->response->success($result);
    }

    #[PostMapping(path: '')]
    #[ApiOperation('创建菜单管理')]
    public function create(#[Valid] #[RequestFormData] MenuCreateRequest $request): BaseSuccessResponse
    {
        $result = $this->menu->create($request->setUnderlineName()->toArray());
        if (! $result) {
            throw new BusinessException(MenuError::CREATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[PutMapping(path: '{id}')]
    #[ApiOperation('更新菜单管理')]
    public function modify(string $id, #[Valid] #[RequestFormData] MenuModifyRequest $request): BaseSuccessResponse
    {
        $result = $this->menu->modify(
            ['id' => $id],
            $request->setUnderlineName()->toArray()
        );
        if (! $result) {
            throw new BusinessException(MenuError::UPDATE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[DeleteMapping(path: '{ids}')]
    #[ApiOperation('删除菜单管理')]
    public function remove(string $ids): BaseSuccessResponse
    {
        $result = $this->menu->remove(['id' => explode(',', $ids)]);
        if (! $result) {
            throw new BusinessException(MenuError::DELETE_ERROR());
        }
        return new BaseSuccessResponse($result);
    }

    #[GetMapping(path: '{id}')]
    #[ApiOperation('获取菜单管理详情')]
    public function detail(string $id): MenuDetailResponse
    {
        $result = $this->menu->detail(
            ['id' => $id],
            [
                'id',
                'created_at',
                'updated_at',
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
                'always_show',
                'keep_alive',
                'params',
            ],
        );
        if (! $result) {
            throw new BusinessException(MenuError::NOT_FOUND());
        }
        $response = new MenuDetailResponse($result);
        $response->routeName = ucfirst($response->path);
        return $response;
    }
}
