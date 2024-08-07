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

namespace App\Common\Commands\CodeGenerator\Generator;

use App\Common\Commands\Model\ClassInfo;
use Symfony\Component\Finder\Finder;

class ErrorGenerator extends AbstractGenerator
{
    protected int $moduleIndex;

    public function getPath(string $module = ''): string
    {
        return parent::getPath('/Constants/Errors');
    }

    public function getFilename(): string
    {
        return $this->modelInfo->name . 'Error';
    }

    public function buildClass(ClassInfo $class, array $results = []): string
    {
        $business = $this->getSerialNumber($class);
        $stub = file_get_contents(dirname(__DIR__) . '/stubs/Error.stub');
        $this->replaceNamespace($stub, $class->namespace)
            ->replaceClass($stub, $class->name)
            ->replace($stub, '%MESSAGE%', $this->modelInfo->comment)
            ->replace($stub, '%MODULE%', (string) $this->moduleIndex)
            ->replace($stub, '%BUSINESS%', $business);
        return $stub;
    }

    protected function getSerialNumber(ClassInfo $class): string
    {
        if (! file_exists($class->file)) {
            $this->mkdir($class->file);
        }
        $fileCount = Finder::create()->files()->in(dirname($class->file))->count();
        ++$fileCount;
        return sprintf('%03d', $fileCount);
    }
}
