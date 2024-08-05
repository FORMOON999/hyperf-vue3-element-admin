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
use App\Common\Util\PhpGenerator\Printer\PrinterFactory;

class GenerateClass extends BaseObject
{
    /**
     * @var int
     */
    private $version = PrinterFactory::VERSION_PHP72;

    /**
     * @var bool
     */
    private $strictTypes = false;

    /**
     * @var bool
     */
    private $final = false;

    /**
     * @var bool
     */
    private $abstract = false;

    /**
     * @var bool
     */
    private $interface = false;

    /**
     * @var ?string
     */
    private $namespace;

    /**
     * @var array
     */
    private $uses = [];

    /**
     * @var string
     */
    private $classname;

    /**
     * @var ?string
     */
    private $inheritance;

    /**
     * @var array
     */
    private $comments = [];

    /**
     * @var array
     */
    private $implements = [];

    /**
     * @var Constant[]
     */
    private $constants = [];

    /**
     * @var Method[]
     */
    private $methods = [];

    /**
     * @var Property[]
     */
    private $properties = [];

    /**
     * @var array
     */
    private $traits = [];

    public function __toString(): string
    {
        return PrinterFactory::getInstance()->getPrinter($this->getVersion())->printClass($this);
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): GenerateClass
    {
        $this->version = $version;
        return $this;
    }

    public function getStrictTypes(): bool
    {
        return $this->strictTypes;
    }

    public function setStrictTypes(bool $strictTypes = true): GenerateClass
    {
        $this->strictTypes = $strictTypes;
        return $this;
    }

    public function getFinal(): bool
    {
        return $this->final;
    }

    public function setFinal(bool $final): GenerateClass
    {
        $this->final = $final;
        return $this;
    }

    public function getAbstract(): bool
    {
        return $this->abstract;
    }

    public function setAbstract(bool $abstract): GenerateClass
    {
        $this->abstract = $abstract;
        return $this;
    }

    public function getInterface(): bool
    {
        return $this->interface;
    }

    public function setInterface(bool $interface): GenerateClass
    {
        $this->interface = $interface;
        return $this;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function setNamespace(?string $namespace): GenerateClass
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function getUses(): array
    {
        return $this->uses;
    }

    public function setUses(array $uses): GenerateClass
    {
        $this->uses = $uses;
        return $this;
    }

    public function getClassname(): string
    {
        return $this->classname;
    }

    public function setClassname(string $classname): GenerateClass
    {
        $this->classname = $classname;
        return $this;
    }

    public function getInheritance(): ?string
    {
        return $this->inheritance;
    }

    public function setInheritance(?string $inheritance): GenerateClass
    {
        $this->inheritance = $inheritance;
        return $this;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): GenerateClass
    {
        $this->comments = $comments;
        return $this;
    }

    public function getImplements(): array
    {
        return $this->implements;
    }

    public function setImplements(array $implements): GenerateClass
    {
        $this->implements = $implements;
        return $this;
    }

    /**
     * @return Constant[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param Constant[] $constants
     */
    public function setConstants(array $constants): GenerateClass
    {
        $this->constants = $constants;
        return $this;
    }

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param Method[] $methods
     */
    public function setMethods(array $methods): GenerateClass
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param Property[] $properties
     */
    public function setProperties(array $properties): GenerateClass
    {
        $this->properties = $properties;
        return $this;
    }

    public function addUse(string $use): GenerateClass
    {
        if (! in_array($use, $this->uses)) {
            $this->uses[] = $use;
        }
        return $this;
    }

    public function addComment(string $comment): GenerateClass
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function addImplement(string $implement): GenerateClass
    {
        $this->implements[] = $implement;
        return $this;
    }

    public function addCont(Constant $constant): GenerateClass
    {
        $this->constants[] = $constant;
        return $this;
    }

    public function addProperty(Property $property): GenerateClass
    {
        $this->properties[] = $property;
        return $this;
    }

    public function addMethod(Method $method): GenerateClass
    {
        $this->methods[] = $method;
        return $this;
    }

    public function getTraits(): array
    {
        return $this->traits;
    }

    public function setTraits(array $traits): GenerateClass
    {
        $this->traits = $traits;
        return $this;
    }

    /**
     * @return $this
     */
    public function addTrait(string $trait): GenerateClass
    {
        $this->traits[] = $trait;
        return $this;
    }
}
