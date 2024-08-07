<template>
  <!-- 上传组件 -->
  <el-upload
    v-model="imgPath"
    class="single-uploader"
    :show-file-list="false"
    list-type="picture-card"
    :before-upload="handleBeforeUpload"
    :http-request="uploadFile"
  >
    <img v-if="imgPath" :src="imgPath" class="single-uploader__image"/>
    <el-icon v-else class="single-uploader__icon">
      <i-ep-plus/>
    </el-icon>
  </el-upload>
</template>

<script setup lang="ts">
import {UploadRawFile, UploadRequestOptions, UploadUserFile} from "element-plus";
import FileAPI from "@/api/file";

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["update:modelValue"]);
const imgUrl = useVModel(props, "modelValue", emit);
const imgPath = ref("");

watch(
  () => props.modelValue,
  (newVal: string): void => {
    if (newVal == "") {
      imgPath.value = imgUrl.value;
    } else {
      try {
        let urlObj = new URL(newVal);
        imgPath.value = imgUrl.value;
        imgUrl.value = urlObj.pathname;
      } catch (err) {}
    }
  },
  { immediate: true }
);

/**
 * 自定义图片上传
 *
 * @param options
 */
async function uploadFile(options: UploadRequestOptions): Promise<any> {
  const data = await FileAPI.upload(options.file);
  imgPath.value = data.url;
  imgUrl.value = data.path;
}

/**
 * 限制用户上传文件的格式和大小
 */
function handleBeforeUpload(file: UploadRawFile) {
  if (file.size > 2 * 1048 * 1048) {
    ElMessage.warning("上传图片不能大于2M");
    return false;
  }
  return true;
}

</script>

<style scoped lang="scss">
.single-uploader {
  overflow: hidden;
  cursor: pointer;
  border: 1px var(--el-border-color) solid;
  border-radius: 6px;

  &:hover {
    border-color: var(--el-color-primary);
  }

  &__image {
    display: block;
    width: 178px;
    height: 178px;
  }

  &___icon {
    width: 178px;
    height: 178px;
    font-size: 28px;
    color: #8c939d;
    text-align: center;
  }
}
</style>
