<template>
   <div class="product_type">
     <!-- 头部 -->
     <div class="product_type--header">
       <!-- <div class="product_type--header--list flex align-center">
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
       </div> -->
       <div class="product_type--header--list flex align-center">
            <div class="list--title">名称：</div>
            <el-input placeholder="请输入商品名称" v-model="name"></el-input>
        </div>
        <!-- <div class="product_type--header--list flex align-center">
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
          </div> -->
           <!-- 中间商品搜索栏 -->
          <div class="product_type--header--list">
            <el-button type="primary" @click="GetTableList">查询</el-button>
            <!-- <el-button>重置</el-button> -->
          </div>
     </div>
     <!-- 新增 -->
     <div class="product_type--btn">
       <div class="product_type--btn--list flex">
          <el-button type="primary" class="el-icon-plus" @click="CommonAddParent('新增',null)">新增</el-button>
          <el-dropdown trigger="click" class="product_type_dropdown" @command="Command">
                <el-button>
                  更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item command="批量删除">批量删除</el-dropdown-item>
                  </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
     </div>
     <!-- 表格 -->
     <div class="table_content" >
       <div class="table_list" v-if="tableData.length != 0" >
          <el-table
              :data="tableData"
              row-key="id"
              :border="true"
              default-expand-all
              ref="districtTable"
              @select-all="SelectAll"
              @select="Select"
              @selection-change="handleSelectionChange"
              :select-on-indeterminate="selectonindeterminate"
              @toggleAllSelection="toggleAllSelection"
              :row-style="RowStyle"
            >
              <el-table-column type="selection" width="55"> </el-table-column>
              <el-table-column  label="编号" :align="'center'" prop="id"></el-table-column>
              <el-table-column prop="img_url" label="分类图片" :align="'center'">
                <template #default="scope">
                    <el-image
                      style="width: 80px; height: 80px"
                      :src="scope.row.img_url" 
                      fit="cover"
                    >
                    </el-image>
                </template>
              </el-table-column>
              <el-table-column prop="name" label="分类名称" :align="'center'"></el-table-column>
               <el-table-column prop="eng_name" label="英文名称" :align="'center'"></el-table-column>
              
              <el-table-column prop="is_effective" label="是否有效" :align="'center'">
                  <template #default="scope">
                      <el-tag :type="scope.row.is_effective == 1?'success':'error'">{{scope.row.is_effective == 1?'是':'否'}}</el-tag>
                  </template>
              </el-table-column>
              <el-table-column prop="seo_description" label="描述" :align="'center'">
                  <template #default="scope">
                    <span>{{scope.row.seo_description}}</span>
                  </template>
              </el-table-column>
              <el-table-column prop="create_time" label="创建时间" :align="'center'">
                <template #default="scope">
                  <span>{{getLocalTime(scope.row.create_time)}}</span>
                </template>
              </el-table-column>
              <el-table-column  label="操作" :align="'center'">
                  <template #default="scope">
                      <div class="tableBtn">
                        <el-link
                          type="primary"
                          size="small"
                          @click="CommonAddParent('新增',scope.row)"
                          v-if="Get_Add_PorductType_Status(scope.row)"
                          >添加</el-link>
                        <el-divider direction="vertical" v-if="Get_Add_PorductType_Status(scope.row)"></el-divider>
                        <el-link
                          type="primary"
                          size="small"
                          @click="CommonAddParent('修改',scope.row)"
                          >修改</el-link>
                        <el-divider direction="vertical"></el-divider>
                        <el-link
                          type="primary"
                          size="small"
                          @click="deleteItem(scope.$index,scope.row)"
                          >删除</el-link
                        >
                      </div>
                    </template>
              </el-table-column>
            </el-table>
       </div>
        <div class="product_type--skeleton" v-else>
          <el-skeleton :rows="10" animated v-if="!empty_status"  />
          <el-empty v-if="empty_status" ></el-empty>
       </div>
       <!-- 分页 -->
      <div class="pagination-list">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="querInfo.pagenum"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="querInfo.per_page_num"
          layout="total, sizes, prev, pager, next, jumper"
          :total="querInfo.total"
        >
        </el-pagination>
      </div>
     </div>
   </div>
   <add-produc-type 
      :addproducypeeditVisi="editVisi"
      @DialogClose="DialogClose"
      ref="addproductype"
      :datalist="tableData"
    >

   </add-produc-type>
</template>
<script>
import { reactive, toRefs,ref, nextTick, onMounted } from 'vue'
import { getLocalTime, isNaLL } from '../../../utils/utils';
import {GetProductCategoryList} from '@/api/Addproduct.js'
import AddProducType from './components/AddProducType.vue';
import { DeleteCategoryid } from '@/api/productCategory'
import { shoElmessage, shoElMessageBox } from '../../../utils/Elmessage';

export default {
  components:{
    AddProducType
  },
  setup(props,content){
    const districtTable = ref(null);
    const pagination = ref(null);
    const addproductype = ref(null);
    const datas = reactive({
      name:"",
      querInfo:{
        per_page_num:10,
        pagenum:1,
        total:10,
      },
      empty_status:false,
      tableData:[],
      checkedkeys:false,
      selectonindeterminate:false,
      clientHeight:0,
      
      editVisi:false,
      flielist:[],
      
      deletelist:[],
    })
    onMounted(() =>{
      GetTableList();
    })
    //获取数据
    function GetTableList(){
        GetProductCategoryList({
            name:datas.name,
            page_num:datas.querInfo.page_num,
            per_page_num:datas.querInfo.per_page_num,
        }).then(res => {
          if(res.code == 1){
              datas.empty_status = true
              datas.tableData = res.data.data
              datas.querInfo = {
                total:res.data.total,
                page_num:res.data.cur,
                per_page_num:res.data.size
              }
              // datas.querInfo = res.data
              datas.tableData = setTableIndex(datas.tableData)
            }
        })
    }
    function SelectAll(selection){
     
      const isSelect = selection.some(el =>{
        const tableDataIds = datas.tableData.map(j => j.id)
        return tableDataIds.includes(el.id)
      })
      const isCabcel = !datas.tableData.every(el =>{
        const selectid = selection.map(j => j.id)
        return selectid.includes(el.id)
      })
      if(isSelect){
        selection.map(el =>{
            if(el.children){
              toggleSelection(el.children,true)
            }
        })
      }

      if(isCabcel){
        datas.tableData.map(el =>{
            if(el.children){
              toggleSelection(el.children,false)
            }
        })
      }
    }

    function Select(selection,row){
      const hasSelect = selection.some(el =>{
        return el.id == row.id
      })
      if(hasSelect){
          selection.map(el =>{
              if(el.children){
                toggleSelection(el.children,true)
              }
          })
      }else{
        if(row.children){
            toggleSelection(row.children,false)
        }
      }
    }
    function toggleAllSelection(e){
      // console.log(e,123456)
    }
    function handleSelectionChange(selection,first){
      // console.log(selection,datas.selectonindeterminate)
    }
    //批量删除
    function Command(e){
      if(e == '批量删除'){
        console.log(datas.deletelist)
      }
    }
    function toggleSelection(item,first){
      if(first){
        datas.deletelist.push(item)
      }else{
        datas.deletelist.splice(datas.deletelist.indexOf(item),1)
      }
      item.map((row) =>{
        if(!isNaLL(row.children)){
            districtTable.value.toggleRowSelection(row,first)
        }else{
            districtTable.value.toggleRowSelection(row,first)
            toggleSelection(row.children,first)
        }
      })
    }
    function SelecTable(item){
      return true
    }
    // 关闭弹框
    function DialogClose(){
      datas.editVisi = !datas.editVisi
      GetTableList();
    }
    //删除商品分类
    function deleteItem(index,item){
      shoElMessageBox('确定删除当前商品类型，获取删除当前列表商品类型？').then(res =>{
        DeleteCategoryid({
          category_ids:item.id
        }).then(res =>{
          if(res.code == 1){
            GetTableList();
            shoElmessage(true,'删除成功')
          }else{
            shoElmessage(true,'删除失败','error')
          }
        })
      })
    }
    //添加产品类型
    function AddParent_id(id,item){
      datas.editVisi = true
      addproductype.value.Init({title:'新增',data:id})
    }
    // 修改商品分类
    function editVisible(item) {
       datas.editVisi = true
       addproductype.value.Init({title:'修改',...item})
    }
    //公共的添加修改分类
    function CommonAddParent(title,item = null){
       datas.editVisi = true
       addproductype.value.Init({title:title,...item})
    }

    function setTableIndex(array,index){
      array.forEach((item,key) => {
        item.index = key+1;
        if(index){
          item.index = `${index}-${key+1}` 
        }
        if(item.children && item.children.length == 0){
          delete item['children']
        }
        if(item.children && item.children.length>0){
          setTableIndex(item.children,item.index)
        }
      });
      return array
    }
    function Get_Add_PorductType_Status(item){
      return `${item.index}`.length < 5
    }
    function RowStyle({row,rowIndex}){
      if(`${row.index}`.length == 1){
          return {
            'background':'#fafafa'
          }
      }else if(row.index.length <= 3){
        return {
          'background':'rgb(240,249,235)'
        }
      }else if(row.index.length >= 5){
        return {
          'background':'rgb(253,245,230)'
        }
      }
    }
    function handleSizeChange(e){
      data.querInfo.per_page_num = e
      GetTableList()
    }
    function handleCurrentChange(e){
      data.querInfo.page_num = e
      GetTableList()
    }
    return{
      handleSizeChange,
      handleCurrentChange,
      RowStyle,
      Get_Add_PorductType_Status,
      ...toRefs(datas),
      toggleSelection,
      SelectAll,
      Select,
      handleSelectionChange,
      districtTable,
      toggleAllSelection,
      SelecTable,
      pagination,
      DialogClose,
      editVisible,
      addproductype,
      deleteItem,
      Command,
      AddParent_id,
      setTableIndex,
      CommonAddParent,
      getLocalTime,
      GetTableList
    }
  },
}
</script>
<style lang="scss">
.dialog_Protype{
 .el-dialog__header{

    border-bottom: 1px solid #eee;
  }
  .el-dialog__body{
    padding: 20px;
  }
  .el-dialog__footer{
    border-top: 1px solid #eee;
  }}
</style>
<style lang="scss" scoped>
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
.table_content{
  max-height: calc(100% - 160px);
  min-height: 0px;
  background-color: #fff;
  box-sizing: border-box;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  padding: 20px;
  overflow: auto;
  cursor: pointer;
  &::-webkit-scrollbar{
      width: 6px;
      height: 10px;
  }
    /*定义滚动条轨道 内阴影+圆角*/
  &::-webkit-scrollbar-track {
      box-shadow: inset 0 0 0px #f1f1f1;
      border-radius: 2px;
      background-color: #f1f1f1;
  }

  /*定义滑块 内阴影+圆角*/
  &::-webkit-scrollbar-thumb {
      border-radius: 2px;
      box-shadow: inset 0 0 0px #f1f1f1;
      background-color: #c1c1c1;

  }
}
.pagination-list{
  padding: 15px 0px;
}
.product_type{
  width: 100%;
  height: 100%;

}
.product_type--skeleton{
  padding: 20px;
  height: 50vh;
  overflow: hidden;
  margin-top: 15px;
  // background-color: #fff;
}
.product_type--btn{
  margin:15px 0px;
  .product_type--btn--list{
    :deep(.product_type_dropdown){
      margin-left: 10px;
    }
  }
}

</style>