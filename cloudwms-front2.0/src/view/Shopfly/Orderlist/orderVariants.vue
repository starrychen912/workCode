<template>
  <div class="ordervariants">
    <el-table
        :data="Variants"
        style="width: 100%"
        :row-class-name="tableRowClassName"
    >   
        <el-table-column   width="100">
            <template #default="scope" >
                <el-dropdown trigger="click" v-if="scope.$index == 0">
                    <el-button type="info" size="mini">USE
                        <i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item>All</el-dropdown-item>
                        <el-dropdown-item>none</el-dropdown-item>
                    </el-dropdown-menu>
                    </template>
                </el-dropdown>
                <el-switch v-model="scope.row.status" v-else :active-value="1" :inactive-value="0">
                </el-switch>
            </template>
        </el-table-column>
        <el-table-column   width="50"  >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <img :src="content.images.length != 0?content.images[0].src:''" />
                </div>
            </template>
        </el-table-column>
        <el-table-column property="sku" label="sku" min-width="300" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="scope.row.sku"
                        clearable>
                    </el-input>
                </div>
            </template>
        </el-table-column>
        <el-table-column property="name" label="bullet_point" min-width="300"  >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="scope.row.bullet_point5"
                        clearable
                        @blur="BulletPoint5(scope.row.bullet_point5)"
                        >
                    </el-input>
                </div>
            </template>
        </el-table-column>
        <el-table-column property="name" label="Color" min-width="300" v-if="false" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="scope.row.bullet_point5"
                        clearable>
                    </el-input>
                </div>
            </template>
        </el-table-column>
        <el-table-column property="name" label="Size" min-width="300" v-if="false" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="input"
               
                        clearable>
                    </el-input>
                </div>
            </template>
        </el-table-column>
        <el-table-column property="address" label="Inventory" min-width="100"  >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    {{scope.row.inventory_quantity}}
                </div>
            </template>
        </el-table-column>
        <el-table-column property="address" label="	Cost" min-width="100" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                   CN¥$ {{scope.row.cost}}
                </div>
            </template>
        </el-table-column>
  </el-table>
  </div>
</template>

<script>
import { reactive,inject, watch } from 'vue'
export default {
    emits:['BulletPoint5'],
    props:{
        content:{
            type:Object,
            default:{}
        },
        Variants:{
            type:Array,
            default:[]
        }
    },
    setup(props,context){
        let stats = false
        const data = reactive({
            value1:1,
            tableData: []
        })

        watch(
            () => props.Variants,
            (newval,oldval) => {
                stats = true
            },
            {
                deep:true,
            }
        )
        function BulletPoint5(value){
            if(stats && value != ''){
                context.emit('BulletPoint5',value);
                stats = false
            }
        }
        return {
            data,
            BulletPoint5
        }
    },
    methods: {
    
    tableRowClassName({ row, rowIndex }) {
        if (rowIndex === 0) {
            return 'warning-row'
        }
            return ''
      },
      handleCurrentChange(){

      },
      getSummaries(param) {
        const { columns, data } = param
        console.log(param);
        const sums = []
        columns.forEach((column, index) => {
            if (index === 0) {
            sums[index] = 'Total Cost'
            return
            }
            const values = data.map((item) => Number(item[column.property]))
            if (!values.every((value) => isNaN(value))) {
            sums[index] = `$ ${values.reduce((prev, curr) => {
                const value = Number(curr)
                if (!isNaN(value)) {
                return prev + curr
                } else {
                return prev
                }
            }, 0)}`
            } else {
            sums[index] = 'N/A'
            }
        })
        console.log(sums);
        return sums
        
    },
      resetDateFilter() {
        this.$refs.filterTable.clearFilter('date');
      },
      clearFilter() {
        this.$refs.filterTable.clearFilter();
      },
      formatter(row, column) {
        return row.address;
      },
      filterTag(value, row) {
        return row.tag === value;
      },
      filterHandler(value, row, column) {
        const property = column['property'];
        return row[property] === value;
      }
    }
}
</script>

<style scoped lang="scss">
.ordervariants{
    display: block;
    padding: 16px 24px 24px 24px;
    border-top: 1px solid #ededf2;
    position: relative;
    z-index: 0;
    overflow-y: auto;
    max-height: 550px;
    overflow-x: hidden;
}
:deep(.el-table .warning-row) {
  --el-table-tr-background-color:  var(--el-background-color-base);
  &:hover{
      --el-table-tr-background-color:  var(--el-background-color-base);
  }
}
.scope--img{
    width: 100%;
    height: 100%;
    color: #6f6f91;
    font-weight: 600;
    img{
        width: 100%;
        height: 100%;
    }
}
</style>