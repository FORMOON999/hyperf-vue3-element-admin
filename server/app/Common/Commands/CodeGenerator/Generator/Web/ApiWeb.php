<?php

namespace App\Common\Commands\CodeGenerator\Generator\Web;

use App\Common\Commands\Model\ClassInfo;
use App\Common\Helpers\FormatHelper;

class ApiWeb extends BaseWeb
{
    protected function getClassInfo(string $application = ''): ClassInfo
    {
        $path = implode('/', [
            $this->webConfig['path'],
            'src',
            'api',
            $this->getFilename() . '.ts'
        ]);
        return new ClassInfo([
            'name' => $this->getFilename(),
            'namespace' => "",
            'file' => $path,
        ]);
    }

    protected function getType(string $type): string
    {
        switch ($type) {
            case 'double':
            case 'float':
            case 'int':
            case 'integer':
            case 'tinyint':
            case 'smallint':
            case 'decimal':
            case 'timestamp':
                return 'number';
            case 'bigint':
            case 'string':
            case 'varchar':
            case 'char':
            case 'text':
            case 'enum':
                return 'string';
            case 'bool':
                return 'boolean';
            case 'datetime':
            case 'date':
                return 'Date';
            case 'json':
                return 'string[]';
            default:
                return 'any';
        }
    }

    protected function ts(string $interfaceName, bool $exceptDate = false): string
    {
        $excepts = ['updated_at', 'deleted_at'];
        if ($excepts) {
            $excepts[] = 'created_at';
        }
        $tsInterface = "export interface $interfaceName {\n";
        foreach ($this->modelInfo->columns as $item) {
            if (in_array($item['column_name'], $excepts)) {
                continue;
            }
            $key = FormatHelper::camelize($item['column_name']);
            $type = $this->getType($item['data_type']);
            $comment = $item['column_comment'] ?: $key;
            $tsInterface .= "  /**\n";
            $tsInterface .= "   * {$comment}\n";
            $tsInterface .= "   */\n";
            $tsInterface .= "  $key?: $type;\n";
        }
        $tsInterface .= "}\n";
        return $tsInterface;
    }

    public function buildClass(ClassInfo $class, array $results = []): string
    {
        $stub = file_get_contents(dirname(dirname(__DIR__)) . '/stubs/Web/WebApi.stub');

        $name = ucfirst($this->modelInfo->name);
        $pageVO = $this->ts("{$name}PageVO");
        $form = $this->ts("{$name}Form");

        $this->replace($stub, '%NAME%', $name)
            ->replace($stub, '%COMMENT%', $this->modelInfo->comment)
            ->replace($stub, '%URI_NAME%', strtoupper($this->modelInfo->name) . '_BASE_URL')
            ->replace($stub, '%URI%', $this->getUri())
            ->replace($stub, '%PAGE_VO%', $pageVO)
            ->replace($stub, '%FORM%', $form);
        return $stub;
    }
}