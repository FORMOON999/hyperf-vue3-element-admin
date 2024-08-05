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

use App\Common\Core\BaseObject;

class Params extends BaseObject
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $type;

    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var mixed
     */
    private $default;

    /**
     * 是否 赋值
     * @var bool
     */
    private $assign = false;

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default): Params
    {
        $this->setAssign(true);
        $this->default = $default;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Params
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): Params
    {
        $this->type = $type;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): Params
    {
        $this->comment = $comment;
        return $this;
    }

    public function getAssign(): bool
    {
        return $this->assign;
    }

    protected function setAssign(bool $assign): Params
    {
        $this->assign = $assign;
        return $this;
    }
}
