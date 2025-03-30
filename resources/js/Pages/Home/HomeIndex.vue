<template>
    <div class="bg-[#f9fbfc] min-h-screen flex items-center">
        <div class="container mx-auto px-5 min-h-[500px]">
            <div class="flex relative shadow-sm shadow-gray-300 border h-full">
                <div class="p-8 w-[250px]">
                    <el-button type="primary" size="large">Import documents</el-button>
                    <div class="mt-9">
                        <div class="flex justify-between">
                            <span>Storage</span>
                            <span class="underline">Change plan</span>
                        </div>
                      
                        <div class="w-full h-3 rounded-[50px] bg-gray-200 my-2 storage-line relative"></div>
                        <span><span>{{ usedPercentage }}%</span> used of 2GB</span>
                    </div>
                    <div class="mt-9">
                        <span>Search</span>
                        <div>
                            <input v-model="search" @input="filterData" type="text" placeholder="e.g. image.png">
                        </div>
                    </div>
                    <div class="mt-9 mb-3">
                        <div class="flex justify-between">
                            <span>Folder</span>
                            <span>New folder</span>
                        </div>
                    </div>
                    <div class="max-h-[200px] overflow-y-scroll">
                        <el-tree
                            :default-expanded-keys="[1]"
                            :current-node-key="currentNodeKey"
                            :data="folders"
                            node-key="id"
                            highlight-current
                            @node-click="handleNodeClick"
                        />
                    </div>
                    <div class="mt-9 mb-3">
                        <div class="flex justify-between">
                            <span>Member</span>
                            <span>Select all</span>
                        </div>
                        <el-checkbox-group v-model="checkList" class="flex flex-col">
                            <el-checkbox label="All" value="all" />
                            <el-checkbox v-for="member in members" :key="member?.id" :label="member?.name" :value="member?.id" />
                        </el-checkbox-group>
                    </div>
                </div>
                <div class="flex-1 overflow-x-scroll pt-8">
                    <el-table :data="files">
                        <el-table-column type="selection" />
                        <el-table-column label="" property="url">
                            <template #default="scope">
                                <img :src="scope.row.url" alt="" width="100%" class="w-full h-[100px] object-cover rounded-md" />
                            </template>
                        </el-table-column>
                        <el-table-column property="name" label="Name" show-overflow-tooltip />
                        <el-table-column property="dimension" label="Dimension" />
                        <el-table-column property="size" label="Size" />
                    </el-table>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script setup>
import axios from '@/config/axios';
import { ElButton, ElTree, ElCheckboxGroup, ElCheckbox, ElTable, ElTableColumn } from 'element-plus';
import { onMounted, ref, watch, watchEffect, computed } from 'vue'
import debounce from 'lodash.debounce'

function transformFolders(folders) {
  return folders.map(folder => ({
    ...folder,
    label: folder.name,
    children: folder.children ? transformFolders(folder.children) : []
  }));
}
const folders = ref(null);
const members = ref(null);
const currentNodeKey = ref(1);
const files = ref(null);
const search = ref(null);
const totalSize = ref(0);
const TOTAL_STORAGE_KB = 2 * 1024 * 1024;

const handleNodeClick = (data) => {
  currentNodeKey.value = data.id
  fetchFiles()
}
const usedPercentage = computed(() => {
  return ((totalSize.value / TOTAL_STORAGE_KB) * 100).toFixed(2);
});

watchEffect(async() => {
  try {
    const response = await axios.get(route('api.folder.index'));
    if (response?.data?.status === 200) {
      const dataRes = response?.data?.data
      folders.value = transformFolders(dataRes)
    }
  } catch(e) {
    console.log(e)
  }
})
watchEffect(async() => {
  try {
    const response = await axios.get(route('api.user.index'));
    if (response?.data?.status === 200) {
      members.value = response?.data?.data
    }
  } catch(e) {
    console.log(e)
  }
})
const fetchFiles = async() => {
  try {
    const response = await axios.get(route('api.folder.show-file', {
      id: currentNodeKey.value
    }), {
      params: {
        s: search.value,
        photo_by: checkList.value
      }
    });
    if (response?.data?.status === 200) {
      files.value = response?.data?.data
      totalSize.value = files.value.reduce((sum, file) => sum + (+file?.size || 0), 0);
    }
  } catch(e) {
    console.log(e)
  }
}
onMounted(() => fetchFiles())

const checkList = ref(['all'])

const filterData = debounce(function () {
      fetchFiles()
    }, 500)
watch(checkList, () => {
  fetchFiles()
})
</script>
<style scoped>
.storage-line::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: v-bind(usedPercentage + '%');
    height: 100%;
    background-color: #3b82f6;
    border-radius: 50px;
}
</style>