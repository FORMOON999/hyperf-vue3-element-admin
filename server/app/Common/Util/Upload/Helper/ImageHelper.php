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

namespace App\Common\Util\Upload\Helper;

use App\Common\Helpers\FormatHelper;
use App\Common\Helpers\RegularHelper;
use App\Common\Util\IPC\Helper\SysConfigHelper;
use Hyperf\Di\Annotation\Inject;

class ImageHelper
{
    public const KEY = '864134';

    #[Inject]
    protected SysConfigHelper $config;

    public function makePath(string $key, string $host = ''): string
    {
        if (empty($key)) {
            return $key;
        }
        if (RegularHelper::checkUrl($key)) {
            return $key;
        }
        return rtrim($host, "\t\n\r\0\x0B/") . '/' . ltrim($key, '/');
    }

    public function makePathBuyConfig(string $path, string $key = 'imageDomain'): string
    {
        return $this->makePath($path, $this->config->get($key));
    }

    public function encrypt(string $file, bool $saveOld = false): bool
    {
        if (!is_file($file)) {
            return false;
        }
        $content = file_get_contents($file);
        if ($saveOld) {
            $oldFile = $this->getOldFile($file);
            @file_put_contents($oldFile, $content);
        }
        $content = FormatHelper::randNum(3) . $content;
        @file_put_contents($file, $content);
        return true;
    }

    public function getOldFile(string $file): string
    {
        $info = explode('.', $file);
        $info[0] .= '-old';
        return implode('.', $info);
    }
}
