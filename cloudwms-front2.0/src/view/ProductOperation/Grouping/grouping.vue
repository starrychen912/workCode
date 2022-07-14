<template>
  <!-- 头部 -->
     <div class="product_type--header">
       <div class="product_type--header--list flex align-center">
          <div class="list--title">制造商：</div>
          <el-select v-model="value1">
              <el-option
                v-for="item in options1"
                :key="item.value"
                :label="item.label"
                :value="item.value"
                style="display: flex"
              >
              </el-option>
            </el-select>
       </div>
       <div class="product_type--header--list flex align-center">
            <div class="list--title">名称：</div>
            <el-input placeholder="请输入商品名称"></el-input>
        </div>
        <div class="product_type--header--list flex align-center">
            <el-dropdown trigger="click">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item>
                    <router-link to="#">选品计划</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">样品采购</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">商品关键词</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">常见问题</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">待处理商品</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">耳机资料</router-link>
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
           <!-- 中间商品搜索栏 -->
          <div class="product_type--header--list">
            <el-button type="primary">查询</el-button>
            <el-button>重置</el-button>
          </div>
     </div>
     <!-- 新增 -->
     <div class="product_type--btn">
       <div class="product_type--btn--list flex">
          <el-button type="primary" class="el-icon-plus" @click="editVisible('新增')">新增</el-button>
          <el-dropdown trigger="click" class="product_type_dropdown" @command="Command">
                <el-button>
                  更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <template #dropdown>
                  <el-dropdown-menu >
                    <el-dropdown-item>
                    批量删除
                    </el-dropdown-item>
                  </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
     </div>
     <!-- 分组表格 -->
     <div class="table--content">
       <el-table :border="true"
        :data="tableData"
        tooltip-effect="dark"
        style="width: 100%"
        @selection-change="handleSelectionChange"
       >
         <el-table-column label="Id" prop="id" :align="'center'"></el-table-column>
         <el-table-column label="分组名称" :align="'center'" prop="name"></el-table-column>
         <el-table-column label="创建时间" :align="'center'" prop="create_time">
          <template #default="scope">
            <span>{{getLocalTime(scope.row.create_time)}}</span>
          </template>
         </el-table-column>
         <el-table-column label="备注" :align="'center'" prop="memo"></el-table-column>
         <el-table-column  label="操作" :align="'center'">
                  <template #default="scope">
                      <div class="tableBtn">
                        <el-link
                          type="primary"
                          size="small"
                          @click="editVisible(scope.row)"
                          >修改</el-link>
                        <el-divider direction="vertical"></el-divider>
                        <el-link
                          type="primary"
                          size="small"
                          @click="deleteItem(scope.row.id)"
                          >删除</el-link
                        >
                      </div>
                    </template>
              </el-table-column>
       </el-table>
       <div class="pagination">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="pagination.page_num"
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="pagination.per_page_num"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="pagination.total">
            </el-pagination>
          </div>
     </div>
     <add-grouping
      v-model="addvisitly"
      title="新增"
      @GroupingClose='GroupingClose'
      ref="add_grouping"
     >
      
     </add-grouping>
     <editgrouping
      v-model="editvisitly"
      title="修改"
      @GroupingClose='EditGroupingClose'
      ref="edit_grouping"
     ></editgrouping>
</template>
<script>
import { onMounted, reactive, toRefs,ref } from 'vue'
import AddGrouping from './components/addgrouping.vue'
import { GetproductTagsList,DeleteproductTags } from '@/api/Tags.js'
import { useStore } from 'vuex'
import { getLocalTime } from '@/utils/utils'
import { shoElmessage } from '../../../utils/Elmessage'
import Editgrouping from './components/editgrouping.vue'
export default {
  components:{
    AddGrouping,
    Editgrouping
  },
  setup(props,content){
    const add_grouping = ref(null)
    const edit_grouping = ref(null)
    const store = useStore();
    const data = reactive({
      addvisitly:false,
      editvisitly:false,
      pagination:{
          per_page_num:10,
          page_num:1,
          total:10,
      },
      tableData:[],
    })
    //关闭修改弹出框
    function EditGroupingClose(){
      data.editvisitly = !data.editvisitly
      GetTableList();
    }
    //关闭弹出框
    function GroupingClose(){
      data.addvisitly = !data.addvisitly
      GetTableList();
    }
    //打开弹出框
    function editVisible(item){
      if(item == '新增'){
        console.log(add_grouping)
        add_grouping.value.Init();
        data.addvisitly = !data.addvisitly;
      }else{
        data.editvisitly = !data.editvisitly;
        // console.log(edit_grouping)
        edit_grouping.value.Init(item);
        // data.editvisitly = !data.editvisitly;
      }
    }
    function GetTableList(){
      GetproductTagsList({
        company_id:store.state.userinfo.userinfo.company_id,
        page_num:data.pagination.page_num,
        per_page_num:data.pagination.per_page_num,
      }).then((res) => {
        if(res.code == 1){
           console.log(res)
           data.tableData = res.data.data
        }
      })
    }
    function handleSelectionChange(){

    }
    //删除item
    function deleteItem(item){
      DeleteproductTags({
        product_tags_id:item
      }).then(res =>{
        if(res.code == 1){
          shoElmessage(true,'删除成功')
          GetTableList();
        }else{
          shoElmessage(true,`删除失败，原因${res.msg}`,'error')
        }
      })
    }
    onMounted(() =>{
      GetTableList();
    })
    return {
      editVisible,
      GroupingClose,
      EditGroupingClose,
      handleSelectionChange,
      GetTableList,
      ...toRefs(data),
      deleteItem,
      getLocalTime,
      add_grouping,
      edit_grouping
    }
  }
}
</script>
<style scoped lang="scss">
.product_type--header{
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  box-shadow: 0 1px 3px 0 rgb(0 0 0 / 10%), 0 0 3px 0 rgb(0 0 0 / 2%);
  .product_type--header--list{
    margin:5px;
    .list--title{
      width: 70px;
      text-align: right;
    }
  }
}
.product_type--btn{
  margin:15px 0px;
  .product_type--btn--list{
    :deep(.product_type_dropdown){
      margin-left: 10px;
    }
  }
}
.table--content{
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 1px 3px 0 rgb(0 0 0 / 12%), 0 0 3px 0 rgb(0 0 0 / 3%);
}
</style>