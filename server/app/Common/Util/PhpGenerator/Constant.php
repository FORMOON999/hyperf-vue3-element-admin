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

namespace App\Common\Util\PhpGenerator;

use App\Common\Util\PhpGenerator\Printer\PrinterFactory;

class Constant extends Base
{
    /**
     * @var mixed
     */
    private $default;

    public function __toString(): string
    {
        return PrinterFactory::getInstance()->getPrinter($this->getVersion())->printConstant($this);
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default): Constant
    {
        $this->default = $default;
        return $this;
    }
}
