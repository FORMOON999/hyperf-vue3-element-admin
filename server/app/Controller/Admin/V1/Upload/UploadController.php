<?php

namespace App\Controller\Admin\V1\Upload;

use App\Common\Core\BaseController;
use App\Common\Middleware\AdminMiddleware;
use App\Common\Util\Upload\Enums\UploadType;
use App\Common\Util\Upload\Helper\ImageHelper;
use App\Common\Util\Upload\UploadFactory;
use App\Common\Util\Upload\UploadInterface;
use App\Controller\Admin\V1\Upload\Request\UploadRequest;
use App\Controller\Admin\V1\Upload\Response\UploadResponse;
use Hyperf\ApiDocs\Annotation\Api;
use Hyperf\ApiDocs\Annotation\ApiFormData;
use Hyperf\ApiDocs\Annotation\ApiHeader;
use Hyperf\ApiDocs\Annotation\ApiOperation;
use Hyperf\Di\Annotation\Inject;
use Hyperf\DTO\Annotation\Contracts\RequestFormData;
use Hyperf\DTO\Annotation\Contracts\Valid;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Container\ContainerInterface;

#[Controller(prefix: 'api/v1/admin/upload')]
#[Api(tags: 'Admin/上传管理')]
#[Middleware(AdminMiddleware::class)]
#[ApiHeader(name: 'Authorization')]
class UploadController extends BaseController
{
    #[Inject]
    protected ImageHelper $imageHelper;

    protected UploadInterface $upload;

    public function __construct(ContainerInterface $container, UploadFactory $uploadFactory)
    {
        parent::__construct($container);
        $this->upload = $uploadFactory->make(UploadType::Local);
    }


    #[PostMapping(path: 'local')]
    #[ApiOperation('本地上传')]
    #[ApiFormData(name: 'file', type: 'file')]
    public function local(#[Valid] #[RequestFormData] UploadRequest $request): UploadResponse
    {
        $file = $this->request->file('file');
        $path = implode(DIRECTORY_SEPARATOR, [
            date("Ymd"),
            md5($file->getClientFilename() . time()) . ".".$file->getExtension()
        ]);
        $data = $this->upload->uploadFile($path,  $file->getPathname());


        return new UploadResponse([
            'path' => $data['path'],
            'url' => $this->imageHelper->makePathBuyConfig($data['path'])
        ]);
    }
}