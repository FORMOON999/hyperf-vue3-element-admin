<?php
/**
 * Created by PhpStorm.
 * Date:  2021/9/2
 * Time:  2:36 下午.
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

namespace App\Common\Commands\Model;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\PropertyProperty;

class ModelUpdateVisitor extends \Hyperf\Database\Commands\Ast\ModelUpdateVisitor
{
    protected function formatDatabaseType(string $type): ?string
    {
        switch ($type) {
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
                return 'integer';
            case 'bigint':
            case 'decimal':
            case 'float':
            case 'double':
            case 'real':
                return 'string';
            case 'bool':
            case 'boolean':
                return 'boolean';
            default:
                return null;
        }
    }

    protected function rewriteCasts(PropertyProperty $node): PropertyProperty
    {
        $items = [];
        $keys = [];
        if ($node->default instanceof Array_) {
            $items = $node->default->items;
        }

        if ($this->option->isForceCasts()) {
            $items = [];
            $casts = $this->class->getCasts();
            foreach ($node->default->items as $item) {
                $caster = $casts[$item->key->value] ?? null;
                if ($caster && $this->isCaster($caster)) {
                    $items[] = $item;
                }
            }
        }

        foreach ($items as $item) {
            $keys[] = $item->key->value;
        }
        foreach ($this->columns as $column) {
            $name = $column['column_name'];
            $type = $column['cast'] ?? null;
            if ($type === 'version') {
                $type = 'string';
            }
            if (in_array($name, $keys)) {
                continue;
            }
            if ($type || $type = $this->formatDatabaseType($column['data_type'])) {
                $items[] = new Node\Expr\ArrayItem(
                    new String_($type),
                    new String_($name)
                );
            }
        }

        $node->default = new Array_($items, [
            'kind' => Array_::KIND_SHORT,
        ]);
        return $node;
    }
}
