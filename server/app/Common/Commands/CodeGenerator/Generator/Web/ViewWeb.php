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

use App\Common\Commands\Model\ClassInfo;
use App\Common\Constants\BaseStatus;
use App\Common\Helpers\FormatHelper;
use App\Constants\Type\MenuType;
use Hyperf\DbConnection\Db;

class ViewWeb extends BaseWeb
{
    protected array $webConfig;

    public function buildClass(ClassInfo $class, array $results = []): string
    {
        $stub = file_get_contents(dirname(dirname(__DIR__)) . '/stubs/Web/WebView.stub');
        $name = FormatHelper::camelize($this->modelInfo->name);

        $this->addMenu($this->modelInfo->comment, $name);

        $this->replace($stub, '%NAME%', $name)
            ->replace($stub, '%DEFINE%', ucfirst($name))
            ->replace($stub, '%COMMENT%', $this->modelInfo->comment)
            ->replace($stub, '%RULE%', $this->rule())
            ->replace($stub, '%ROW%', $this->row())
            ->replace($stub, '%FORM%', $this->form());
        return $stub;
    }

    protected function getClassInfo(string $application = ''): ClassInfo
    {
        $path = implode('/', [
            $this->webConfig['path'],
            'src',
            'views',
            $this->getFilename(),
            'index.vue',
        ]);
        return new ClassInfo([
            'name' => $this->getFilename(),
            'namespace' => '',
            'file' => $path,
        ]);
    }

    protected function rowStatus(string $label): string
    {
        $key = 'status';
        $html = '        <el-table-column label="' . $label . '" align="center" prop="' . $key . '">' . "\n";
        $html .= '          <template #default="scope">' . "\n";
        $html .= '            <el-tag :type="scope.row.status == 1 ? \'success\' : \'info\'">{{scope.row.status == 1 ? "启用" : "禁用"}}</el-tag>' . "\n";
        $html .= '          </template>' . "\n";
        $html .= '        </el-table-column>' . "\n";
        return $html;
    }

    protected function row(): string
    {
        $html = '';
        $excepts = ['updated_at', 'deleted_at'];
        foreach ($this->modelInfo->columns as $item) {
            if (in_array($item['column_name'], $excepts)) {
                continue;
            }
            $key = FormatHelper::camelize($item['column_name']);
            $label = $item['column_comment'] ?: $key;
            switch ($key) {
                case 'status':
                    $html .= $this->rowStatus($label);
                    break;
                default:
                    $html .= '        <el-table-column key="' . $key . '" label="' . $label . '" align="center" prop="' . $key . '" width="180" />' . "\n";
                    break;
            }
        }
        return $html;
    }

    protected function formStatus(string $label): string
    {
        $key = 'status';
        $html = '        <el-form-item label="' . $label . '" prop="' . $key . '">' . "\n";
        $html .= '          <el-radio-group v-model="formData.status">' . "\n";
        $html .= '            <el-radio :label="1">正常</el-radio>' . "\n";
        $html .= '            <el-radio :label="0">停用</el-radio>' . "\n";
        $html .= '          </el-radio-group>' . "\n";
        $html .= '        </el-form-item>' . "\n";
        return $html;
    }

    protected function form(): string
    {
        $html = '';
        $excepts = ['id', 'created_at', 'updated_at', 'deleted_at'];
        foreach ($this->modelInfo->columns as $item) {
            if (in_array($item['column_name'], $excepts)) {
                continue;
            }
            $key = FormatHelper::camelize($item['column_name']);
            $label = $item['column_comment'] ?: $key;
            switch ($key) {
                case 'status':
                    $html .= $this->formStatus($label);
                    break;
                default:
                    $html .= '      <el-form-item label="' . $label . '" prop="' . $key . '">' . "\n";
                    $html .= '        <el-input v-model="formData.' . $key . '" placeholder="请输入' . $label . '" />' . "\n";
                    $html .= '      </el-form-item>' . "\n";
                    break;
            }
        }
        return $html;
    }

    protected function rule(): string
    {
        $html = '';
        $excepts = ['created_at', 'updated_at', 'deleted_at'];
        foreach ($this->modelInfo->columns as $item) {
            if (in_array($item['column_name'], $excepts)) {
                continue;
            }
            $key = FormatHelper::camelize($item['column_name']);
            $label = $item['column_comment'] ?: $key;
            $html .= "  {$key}: [{ required: true, message: \"{$label}不能为空\", trigger: \"blur\" }],\n";
        }
        return $html;
    }

    protected function addMenu(string $comment, string $path)
    {
        $date = date('Y-m-d H:i:s');
        $category = Db::table('menu')
            ->where('parent_id', '=', 0)
            ->where('name', '=', '未分配')
            ->first(['id']);
        if (is_null($category)) {
            $categoryId = Db::table('menu')->insertGetId([
                'parent_id' => 0,
                'name' => '未分配',
                'type' => MenuType::CATALOG,
                'path' => '/unallocated',
                'component' => 'Layout',
                'perm' => '',
                'sort' => 999,
                'visible' => BaseStatus::NORMAL,
                'icon' => 'system',
                'redirect' => '/unallocated',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        } else {
            $categoryId = $category->id;
        }

        $menu = Db::table('menu')
            ->where('parent_id', '=', $categoryId)
            ->where('name', '=', "{$comment}管理")
            ->first(['id']);
        if (is_null($menu)) {
            $menuId = Db::table('menu')->insertGetId([
                'parent_id' => $categoryId,
                'name' => "{$comment}管理",
                'type' => MenuType::MENU,
                'path' => $path,
                'component' => "{$path}/index",
                'perm' => '',
                'sort' => 1,
                'visible' => BaseStatus::NORMAL,
                'icon' => 'el-icon-User',
                'redirect' => '',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            Db::table('menu')->insert([
                ['parent_id' => $menuId, 'name' => "{$comment}新增", 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => $path . ':add', 'sort' => 1, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['parent_id' => $menuId, 'name' => "{$comment}编辑", 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => $path . ':edit', 'sort' => 2, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
                ['parent_id' => $menuId, 'name' => "{$comment}删除", 'type' => MenuType::BUTTON, 'path' => '', 'component' => '', 'perm' => $path . ':delete', 'sort' => 3, 'visible' => BaseStatus::NORMAL, 'icon' => '', 'redirect' => '', 'created_at' => $date, 'updated_at' => $date],
            ]);
        }
    }
}
