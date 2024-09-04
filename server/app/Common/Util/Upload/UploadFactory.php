<?php
/**
 * Created by PhpStorm.
 * Date:  2022/4/8
 * Time:  6:25 PM.
 */

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Common\Util\Upload;

use App\Common\Util\IPC\Helper\SysConfigHelper;
use App\Common\Util\Upload\Enums\UploadType;
use App\Common\Util\Upload\Type\UploadLocal;
use App\Common\Util\Upload\Type\UploadOss;
use Hyperf\Codec\Json;
use Hyperf\Di\Annotation\Inject;
use function Hyperf\Support\make;

class UploadFactory
{
    #[Inject]
    protected SysConfigHelper $config;

    public function make(UploadType $uploadType, ?array $config = null): UploadInterface
    {
        $className = match ($uploadType) {
            UploadType::Local => UploadLocal::class,
            UploadType::Ali => UploadOss::class,
        };
        $class = make($className);
        $config = $config ?? $this->config->get("{$uploadType->value}Oss", '');
        $uploadConfig = new UploadConfig(Json::decode($config));
        $class->loadConfig($uploadConfig);
        return $class;
    }
}
