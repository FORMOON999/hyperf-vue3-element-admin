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

namespace App\Controller\Admin\V1\Config;

use App\Common\Core\BaseController;
use App\Common\Core\Entity\BaseSuccessResponse;
use App\Common\Exceptions\BusinessException;
use App\Common\Middleware\AdminMiddleware;
use App\Constants\Errors\ConfigError;
use App\Controller\Admin\V1\Config\Request\ConfigCreateRequest;
use App\Controller\Admin\V1\Config\Request\ConfigListRequest;
use App\Controller\Admin\V1\Config\Request\ConfigModifyRequest;
use App\Controller\Admin\V1\Config\Response\ConfigDetailResponse;
use App\Controller\Admin\V1\Config\Response\ConfigListResponse;
use App\Infrastructure\ConfigInterface;
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

#[Controller(prefix: 'api/v1/admin/config')]
#[Api(tags: 'Admin/配置管理')]
#[Middleware(AdminMiddleware::class)]
#[ApiHeader(name: 'Authorization')]
class ConfigController extends BaseController
{
    #[Inject()]
    protected ConfigInterface $config;

    #[GetMapping(path: '')]
    #[ApiOperation('获取配置列表')]
    public function getList(#[Valid] #[RequestQuery] ConfigListRequest $request): ConfigListResponse
    {
        $result = $this->config->getList(
            $request->getSearchParams(),
            [
                'id',
                'created_at',
                'name',
                'description',
                'key',
                'value',
            ],
            [],
            $request->getSort(),
            $request->getPage(),
        );
        return new ConfigListResponse($result);
    }

    #[PostMapping(path: '')]
    #[ApiOperation('创建配置')]
    public function create(#[Valid] #[RequestFormData] ConfigCreateRequest $request): BaseSuccessResponse
    {
        $result = $this->config->create($request->setUnderlineName()->toArray());
        if (!$result) {
            throw new BusinessException(ConfigError::CREATE_ERROR);
        }
        return new BaseSuccessResponse($result);
    }

    #[PutMapping(path: '{id}')]
    #[ApiOperation('更新配置')]
    public function modify(string $id, #[Valid] #[RequestFormData] ConfigModifyRequest $request): BaseSuccessResponse
    {
        $result = $this->config->modify(
            ['id' => $id],
            $request->setUnderlineName()->toArray()
        );
        if (!$result) {
            throw new BusinessException(ConfigError::UPDATE_ERROR);
        }
        return new BaseSuccessResponse($result);
    }

    #[DeleteMapping(path: '{ids}')]
    #[ApiOperation('删除配置')]
    public function remove(string $ids): BaseSuccessResponse
    {
        $result = $this->config->remove(['id' => explode(',', $ids)]);
        if (!$result) {
            throw new BusinessException(ConfigError::DELETE_ERROR);
        }
        return new BaseSuccessResponse($result);
    }

    #[GetMapping(path: '{id}')]
    #[ApiOperation('获取配置详情')]
    public function detail(string $id): ConfigDetailResponse
    {
        $result = $this->config->detail(
            ['id' => $id],
            [
                'id',
                'created_at',
                'name',
                'description',
                'key',
                'value',
            ],
        );
        if (!$result) {
            throw new BusinessException(ConfigError::NOT_FOUND);
        }
        return new ConfigDetailResponse($result);
    }
}
