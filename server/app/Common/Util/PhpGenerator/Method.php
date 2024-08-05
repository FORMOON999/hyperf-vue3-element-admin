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

class Method extends Base
{
    /**
     * @var bool
     */
    private $final = false;

    /**
     * @var bool
     */
    private $abstract = false;

    /**
     * @var Params[]
     */
    private $params = [];

    /**
     * @var mixed
     */
    private $return;

    /**
     * @var ?string
     */
    private $content;

    public function __toString(): string
    {
        return PrinterFactory::getInstance()->getPrinter($this->getVersion())->printMethod($this);
    }

    public function getFinal(): bool
    {
        return $this->final;
    }

    public function setFinal(bool $final = true): Method
    {
        $this->final = $final;
        return $this;
    }

    /**
     * @return Params[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param Params[] $params
     */
    public function setParams(array $params): Method
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param mixed $return
     */
    public function setReturn($return): Method
    {
        $this->return = $return;
        return $this;
    }

    /**
     * @return $this
     */
    public function addParams(Params $params): Method
    {
        $this->params[] = $params;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(?string $content): Method
    {
        $this->content = $content;
        return $this;
    }

    public function getAbstract(): bool
    {
        return $this->abstract;
    }

    public function setAbstract(bool $abstract = true): Method
    {
        $this->abstract = $abstract;
        return $this;
    }
}
