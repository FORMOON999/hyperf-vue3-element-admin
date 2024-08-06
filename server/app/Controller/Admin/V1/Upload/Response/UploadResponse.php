<?php

namespace App\Controller\Admin\V1\Upload\Response;

use App\Common\Core\BaseObject;
use Hyperf\ApiDocs\Annotation\ApiModelProperty;

class UploadResponse extends BaseObject
{
    #[ApiModelProperty("path")]
    public string $path;

    #[ApiModelProperty('url')]
    public string $url;
}
