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

namespace App\Common\Commands\CodeGenerator\Generator\Web;

use App\Common\Commands\CodeGenerator\Generator\AbstractGenerator;
use Hyperf\Stringable\Str;

abstract class BaseWeb extends AbstractGenerator
{
    protected array $webConfig;

    public function getFilename(): string
    {
        return lcfirst($this->modelInfo->name);
    }

    protected function getUri(): string
    {
        $url = array_merge(
            explode('/', $this->config->url),
            [
                lcfirst($this->config->version),
                $this->webConfig['application'],
            ],
            explode('/', Str::snake($this->modelInfo->name, '/'))
        );
        return implode('/', array_filter($url));
    }
}
