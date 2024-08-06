# options 使用方法

## 加载 options
```js
  ...
  import xxxAPI from "@/api/xxx";

  const xxxxOptions = ref<OptionType[]>([]);
  async function options() {
    xxxxOptions.value = await xxxAPI.getOptions();
  }
  options();

```

## 列表使用
```vue

  import { showDictLabel } from "@/utils/index";
  ....
  <el-table-column
    key="xxxx"
    label="xxxx"
    align="center"
    prop="xxxx"
    width="180"
  >
    <template #default="scope">
        {{ showDictLabel(xxxxOptions, scope.row.xxxx) }}
    </template>
  </el-table-column>

```

## 表单使用

```vue
  ....

  <el-form-item label="xxx" prop="xxx">
    <el-select v-model="formData.xxxx" placeholder="请选择">
      <el-option
        v-for="item in xxxxOptions"
        :key="item.value"
        :label="item.label"
        :value="item.value"
      />
    </el-select>
  </el-form-item>

```
