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

namespace App\Common\Util\PhpGenerator\Printer;

use App\Common\Util\PhpGenerator\Constant;
use App\Common\Util\PhpGenerator\GenerateClass;
use App\Common\Util\PhpGenerator\Method;
use App\Common\Util\PhpGenerator\Property;

interface PrinterInterface
{
    /**
     * class.
     *
     * @return mixed
     */
    public function printClass(GenerateClass $generateClass): string;

    /**
     * constant.
     *
     * @return mixed
     */
    public function printConstant(Constant $constant): string;

    /**
     * property.
     *
     * @return mixed
     */
    public function printProperty(Property $property): string;

    /**
     * method.
     *
     * @return mixed
     */
    public function printMethod(Method $method): string;
}
