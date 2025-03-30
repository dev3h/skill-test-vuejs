<template>
    <div class="bg-[#f9fbfc] min-h-screen flex items-center">
        <div class="container mx-auto px-5">
            <div class="flex relative shadow-sm shadow-gray-300 border">
                <div class="p-8 w-[250px] absolute top-0 left-0 h-full overflow-y-scroll">
                  <input type="file" @change="handleChange"/>
                    <el-button type="primary" size="large">Import documents</el-button>
                    <div class="mt-9">
                        <div class="flex justify-between">
                            <span>Storage</span>
                            <span class="underline">Change plan</span>
                        </div>
                        <div class="w-full h-3 rounded-[50px] bg-gray-200 my-2 storage-line relative"></div>
                        <span><span>6%</span> used of 2GB</span>
                    </div>
                    <div class="mt-9">
                        <span>Search</span>
                        <div>
                            <input type="text" placeholder="e.g. image.png">
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
                            :data="data"
                            :props="defaultProps"
                            @node-click="handleNodeClick"
                        />
                    </div>
                    <div class="mt-9 mb-3">
                        <div class="flex justify-between">
                            <span>Member</span>
                            <span>Select all</span>
                        </div>
                        <el-checkbox-group v-model="checkList" class="flex flex-col">
                            <el-checkbox label="Option A" value="Value A" />
                            <el-checkbox label="Option B" value="Value B" />
                        </el-checkbox-group>
                    </div>
                </div>
                <div class="flex-1 ml-[300px] overflow-x-scroll pt-8">
                    <el-table :data="tableData">
                        <el-table-column type="selection" />
                        <el-table-column label="" property="url">
                            <template #default="scope">
                                <img :src="scope.row.url" alt="" width="100%" class="w-full h-[100px] object-cover rounded-md" />
                            </template>
                        </el-table-column>
                        <el-table-column property="name" label="Name" show-overflow-tooltip />
                        <el-table-column property="dimmension" label="Dimmension" />
                        <el-table-column property="size" label="Size" />
                    </el-table>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script setup>
import { ElButton, ElTree, ElCheckboxGroup, ElCheckbox, ElTable, ElTableColumn } from 'element-plus';
import { ref } from 'vue'

const handleNodeClick = (data) => {
  console.log(data)
}
const handleChange = e => {
  const file = event.target.files[0];
  console.log(file)
}


const checkList = ref(['Value selected and disabled', 'Value A'])
const data = [
  {
    label: 'Level one 1',
    children: [
      {
        label: 'Level two 1-1',
        children: [
          {
            label: 'Level three 1-1-1',
          },
        ],
      },
    ],
  },
  {
    label: 'Level one 2',
    children: [
      {
        label: 'Level two 2-1',
        children: [
          {
            label: 'Level three 2-1-1',
          },
        ],
      },
      {
        label: 'Level two 2-2',
        children: [
          {
            label: 'Level three 2-2-1',
          },
        ],
      },
    ],
  },
  {
    label: 'Level one 3',
    children: [
      {
        label: 'Level two 3-1',
        children: [
          {
            label: 'Level three 3-1-1',
          },
        ],
      },
      {
        label: 'Level two 3-2',
        children: [
          {
            label: 'Level three 3-2-1',
          },
        ],
      },
    ],
  },
]

const tableData = [
  {
    url: '',
    name: 'abc.jpg',
    dimmension: '2000x2000',
    size: '763.3kb',
  },
  {
    url: '',
    name: 'abc.jpg',
    dimmension: '2000x2000',
    size: '763.3kb',
  },
  {
    url: '',
    name: 'abc.jpg',
    dimmension: '2000x2000',
    size: '763.3kb',
  },
]
</script>
<style scoped>
.storage-line::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6%;
    height: 100%;
    background-color: #3b82f6;
    border-radius: 50px;
}
</style>