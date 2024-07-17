<template>
  <div class="app-container">
    <!-- 搜索 -->
    <div class="search-container">
      <el-form ref="queryFormRef" :model="queryParams" :inline="true">
        <el-form-item label="创建时间">
          <el-date-picker
            class="!w-[240px]"
            v-model="dateTimeRange"
            type="daterange"
            range-separator="~"
            start-placeholder="开始时间"
            end-placeholder="截止时间"
            value-format="YYYY-MM-DD"
          />
        </el-form-item>

        <el-form-item>
          <el-button type="primary" @click="handleQuery"
            ><i-ep-search />搜索</el-button
          >
          <el-button @click="handleResetQuery"><i-ep-refresh />重置</el-button>
        </el-form-item>
      </el-form>
    </div>

    <!-- 操作按钮 -->
    <el-card shadow="never" class="table-container">
      <template #header>
        <el-button
          v-hasPerm="['user:add']"
          type="success"
          @click="handleOpenDialog()"
          ><i-ep-plus />新增</el-button
        >
        <el-button
          v-hasPerm="['user:delete']"
          type="danger"
          :disabled="removeIds.length === 0"
          @click="handleDelete()"
          ><i-ep-delete />删除</el-button
        >
      </template>

      <el-table
        v-loading="loading"
        :data="pageData"
        @selection-change="handleSelectionChange"
      >
        <el-table-column type="selection" width="50" align="center" />
        <el-table-column key="id" label="id" align="center" prop="id" width="100" />
        <el-table-column key="createdAt" label="创建时间" align="center" prop="createdAt" width="100" />
        <el-table-column key="username" label="账号" align="center" prop="username" width="100" />
        <el-table-column key="password" label="密码" align="center" prop="password" width="100" />
        <el-table-column label="状态" align="center" prop="status">
          <template #default="scope">
            <el-tag :type="scope.row.status == 1 ? 'success' : 'info'">{{scope.row.status == 1 ? "启用" : "禁用"}}</el-tag>
          </template>
        </el-table-column>

        <el-table-column label="操作" fixed="right" width="220">
          <template #default="scope">
            <el-button
              v-hasPerm="['user:edit']"
              type="primary"
              link
              size="small"
              @click="handleOpenDialog(scope.row.id)"
              ><i-ep-edit />编辑</el-button
            >
            <el-button
              v-hasPerm="['user:delete']"
              type="danger"
              link
              size="small"
              @click="handleDelete(scope.row.id)"
              ><i-ep-delete />删除</el-button
            >
          </template>
        </el-table-column>
      </el-table>

      <pagination
        v-if="total > 0"
        v-model:total="total"
        v-model:page="queryParams.page"
        v-model:limit="queryParams.pageSize"
        @pagination="handleQuery"
      />
    </el-card>

    <!-- 表单弹窗 -->
    <el-dialog
      v-model="dialog.visible"
      :title="dialog.title"
      width="500px"
      @close="handleCloseDialog"
    >
      <el-form
        ref="userFormRef"
        :model="formData"
        :rules="rules"
        label-width="100px"
      >
      <el-form-item label="账号" prop="username">
        <el-input v-model="formData.username" placeholder="请输入账号" />
      </el-form-item>
      <el-form-item label="密码" prop="password">
        <el-input v-model="formData.password" placeholder="请输入密码" />
      </el-form-item>
        <el-form-item label="状态" prop="status">
          <el-radio-group v-model="formData.status">
            <el-radio :label="1">正常</el-radio>
            <el-radio :label="0">停用</el-radio>
          </el-radio-group>
        </el-form-item>


      </el-form>

      <template #footer>
        <div class="dialog-footer">
          <el-button type="primary" @click="handleSubmit">确 定</el-button>
          <el-button @click="handleCloseDialog">取 消</el-button>
        </div>
      </template>
    </el-dialog>
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: "User",
  inheritAttrs: false,
});

import UserAPI, {
  UserQuery,
  UserPageVO,
  UserForm,
} from "@/api/user";

const queryFormRef = ref(ElForm);
const userFormRef = ref(ElForm);

const loading = ref(false);
const removeIds = ref([]);
const total = ref(0);

const pageData = ref<UserPageVO[]>();

/** 查询参数  */
const queryParams = reactive<UserQuery>({
  page: 1,
  pageSize: 10,
});

const dateTimeRange = ref("");
watch(dateTimeRange, (newVal) => {
  if (newVal) {
    queryParams.startTime = newVal[0];
    queryParams.endTime = newVal[1];
  }
});

// 弹窗用户管理
const dialog = reactive({
  title: "",
  visible: false,
});
// 用户管理表单数据
const formData = reactive<UserForm>({
  status: 1,
});

const rules = reactive({
  id: [{ required: true, message: "id不能为空", trigger: "blur" }],
  username: [{ required: true, message: "账号不能为空", trigger: "blur" }],
  password: [{ required: true, message: "密码不能为空", trigger: "blur" }],
  status: [{ required: true, message: "状态不能为空", trigger: "blur" }],

});

/** 查询 */
function handleQuery() {
  loading.value = true;
  UserAPI.getPage(queryParams)
    .then((data) => {
      pageData.value = data.list;
      total.value = data.total;
    })
    .finally(() => {
      loading.value = false;
    });
}
/** 重置查询 */
function handleResetQuery() {
  queryFormRef.value.resetFields();
  dateTimeRange.value = "";
  queryParams.page = 1;
  queryParams.startTime = undefined;
  queryParams.endTime = undefined;
  handleQuery();
}

/** 行复选框选中记录选中ID集合 */
function handleSelectionChange(selection: any) {
  removeIds.value = selection.map((item: any) => item.id);
}

/** 打开用户管理弹窗 */
async function handleOpenDialog(id?: number) {
  dialog.visible = true;
  if (id) {
    dialog.title = "修改用户管理";
    UserAPI.getFormData(id).then((data) => {
      Object.assign(formData, { ...data });
    });
  } else {
    dialog.title = "新增用户管理";
  }
}

/** 关闭用户管理弹窗 */
function handleCloseDialog() {
  dialog.visible = false;

  userFormRef.value.resetFields();
  userFormRef.value.clearValidate();

  formData.id = undefined;
}

/** 提交用户管理表单 */
function handleSubmit() {
  userFormRef.value.validate((valid: any) => {
    if (valid) {
      loading.value = true;
      const id = formData.id;
      if (id) {
        UserAPI.update(id, formData)
          .then(() => {
            ElMessage.success("修改用户管理成功");
            handleCloseDialog();
            handleResetQuery();
          })
          .finally(() => (loading.value = false));
      } else {
        UserAPI.add(formData)
          .then(() => {
            ElMessage.success("新增用户管理成功");
            handleCloseDialog();
            handleResetQuery();
          })
          .finally(() => (loading.value = false));
      }
    }
  });
}

/** 删除用户管理 */
function handleDelete(id?: number) {
  const ids = [id || removeIds.value].join(",");
  if (!ids) {
    ElMessage.warning("请勾选删除项");
    return;
  }

  ElMessageBox.confirm("确认删除已选中的数据项?", "警告", {
    confirmButtonText: "确定",
    cancelButtonText: "取消",
    type: "warning",
  }).then(
    () => {
      loading.value = true;
      UserAPI.deleteByIds(ids)
        .then(() => {
          ElMessage.success("删除成功");
          handleResetQuery();
        })
        .finally(() => (loading.value = false));
    },
    () => {
      ElMessage.info("已取消删除");
    }
  );
}

onMounted(() => {
  handleQuery();
});
</script>
