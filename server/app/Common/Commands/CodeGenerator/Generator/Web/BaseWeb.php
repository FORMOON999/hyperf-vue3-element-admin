<?php

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