<template>
      <div class="search">
        <div class="headbox">
          <div class="leftSearch">
            <div class="searchLa">库存sku：</div>
            <el-input prefix-icon="el-icon-search" v-model="search.sku"></el-input>
          </div>
          <div class="leftSearch" >
            <div class="searchLa">仓库：</div>
            <el-select v-model="search.warehouse_id" clearable >
              <el-option
                v-for="item in Warehouselist"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div>
          <div class="leftSearch" >
            <div class="searchLa">店铺：</div>
            <el-select v-model="search.shop_id" clearable >
              <el-option
                v-for="item in shop_list"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div>
          <div class="leftSearch">
            <div class="searchLa">时间：</div>
            <el-date-picker
              v-model="search.datevalue"
              type="daterange"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              :default-time="defaulttime"
              value-format="YYYY-MM-DD"
              >
            </el-date-picker>
          </div>
          <div class="leftSearch">
            <el-button type="primary" @click="GetStocklog">查询</el-button>
            <el-button @click="Cancel">重置</el-button>
          </div>
        </div>
      
      </div>
      <!-- 删除按钮 批量操作 -->
      <div class="add flex align-center">
        <el-button  type="primary" class="add-stock" size="medium" @click="AddStock">
            <i class="el-icon-plus"></i>
            入库
          </el-button>
          <el-button  type="primary" class="add-stock" size="medium" @click="MinusStock">
            <i class="el-icon-minus"></i>
            出库
        </el-button>
        <el-dropdown trigger="click" class="product_integration_dropdown" @command="Command($event,'item')" style="margin-left:10px;">
                <el-button>
                    更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <template #dropdown>
                    <el-dropdown-menu >
                      <el-dropdown-item icon="el-icon-delete">
                      批量删除
                      </el-dropdown-item>
                      <el-dropdown-item icon="el-icon-check">
                      审核
                      </el-dropdown-item>
                      <el-dropdown-item icon="el-icon-circle-close">
                      反审核
                      </el-dropdown-item>
                    </el-dropdown-menu>
                </template>
        </el-dropdown>
      </div>
      <div class="stock--log-content">
        <div class="stocklog--list">
          <el-table
                v-loading="loading"
                :data="datalist"
                border
                style="width: 100%">
                <el-table-column
                  fixed
                  prop="create_time"
                  label="创建时间"
                  min-width="120">
                  <template #default="scope">
                      <span>{{GetTIme(scope.row.create_time)}}</span>
                  </template>
                </el-table-column>
                <el-table-column
                  prop="title"
                  label="标题"
                  min-width="150">
                </el-table-column>
                <el-table-column
                  prop="inventory_sku"
                  label="商品sku"
                  min-width="150">
                </el-table-column>
                <el-table-column
                  prop="in_quantity"
                  label="入库数量"
                  min-width="120">
                </el-table-column>
                <el-table-column
                  prop="out_quantity"
                  label="出库数量"
                  min-width="120">
                </el-table-column>
                <el-table-column
                  prop="stock"
                  label="库存数量"
                  min-width="120">
                </el-table-column>
                <el-table-column
                  prop="memo"
                  label="备注"
                  min-width="120">
                </el-table-column>
              </el-table>
        </div>
        <div class="paginations flex">
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="currentpage"
              :page-sizes="[15,30,60,100, 200, 300, 400]"
              :page-size="pagesize"
              layout="total, sizes, prev, pager, next, jumper"
              :total="total">
            </el-pagination>
            
        </div>
      </div>
  <vite-dialog  v-model="dialogVisible" :title="Tips" width="50%" >
    <div class="content">
        <el-form :model="dialogform" label-width="18%" :rules="rules">
            <el-form-item label="选择商品：" prop="inventory_sku">
              <!-- <el-cascader 
                  v-model="dialogform.inventory_sku" 
                  :options="Productlist"
                  :collapse-tags='true'
                  :props="{label:'title',value:'id',children:'variants'}" 
                  :show-all-levels="false" 
                  @change="CascaderChange"
                  popper-class="product_class"
                  style="width: 100%;"
                >
               <template #default="{  data }">
                  <span>{{data.title}}</span>
                </template>
              </el-cascader> -->
              <!-- 商品 -->
              <el-select v-model="dialogform.inventory_sku"  placeholder="请选择" style="width: 100%" @change="SelectChangeProduct">
                <el-option  v-for="item in Productlist" :key="item.inventory_sku" :label="item.title" :value="item.inventory_sku"/>
              </el-select>
            </el-form-item>
             <el-form-item label="仓库：" prop="warehouse_id">
              <el-select v-model="dialogform.warehouse_id"  placeholder="请选择" style="width: 100%" @change="SelectChangeWarehouse">
                <el-option  v-for="item in Warehouselist" :key="item.id" :label="item.name" :value="item.id"/>
              </el-select>
             </el-form-item>
            <el-form-item label="库存：">
              <label>{{dialogform.stock_quantity}}</label>
            </el-form-item>
            <el-form-item label="入库数量：" prop="in_quantity" v-if="Tips == '入库'">
              <el-input v-model="dialogform.in_quantity" style="max-width:700px;"></el-input>
            </el-form-item>
            <el-form-item label="出库数量：" prop="out_quantity" v-else>
              <el-input v-model="dialogform.out_quantity" style="max-width:700px;"></el-input>
            </el-form-item>
            <el-form-item label="备注：" >
               <orderlistwang-editor
            :editor="dialogform.memo"
            @Change="editorChange"
            @Onfocus="Onfocus"
            @Onblur="Onblur"
          ></orderlistwang-editor>
            </el-form-item>
        </el-form>
    </div>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">取消</el-button>
        <el-button type="primary" @click="Debounce">
          确认
        </el-button>
      </span>
    </template>
  </vite-dialog>
</template>
<script>
import ViteDialog from '@/components/ViteDialog/index.vue'
import Sidebar from '@/components/Loyout/Sidebar/Sidebar.vue';
import ButtonR from '@/components/Bottom/buttonR.vue';
import Loaddingbutton from '@/components/loaddingbutton/index.vue';
import LodingBtn from '@/components/lodingBtn/index.vue';
import { reactive, toRefs,onMounted,computed } from 'vue';
import { inventoryLogList, operateInventoryLog } from '@/api/Stocklog';
import { shoElmessage } from '@/utils/Elmessage';
import { getLocalTime, isNaLL, isNum ,SelectProductTitle,debounce} from '@/utils/utils';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import { GetProductList } from "@/api/Porductapi";
import { warehouseList } from "@/api/warehouseManagement";
import OrderlistwangEditor from '../../Shopfly/Orderlist/OrderlistwangEditor.vue';
import {  ShopList } from "@/api/shoplist";
export default {
  components:{
      Sidebar,
      ButtonR,
      Loaddingbutton,
      LodingBtn,
      ViteDialog,
      OrderlistwangEditor
  },
  setup(props,content){
    const route = useRoute();
    const store = useStore();
    const Debounce = debounce(Sumbit,200);
    const data = reactive({
      mode:computed(() => store.state.setting.device.mode),
      loading:false,
      
      search:{
        sku:"",
        warehouse_id:"",
        datevalue:"",
        shop_id:"",
      },

      datalist:[],
      
      defaulttime:[
        new Date(2000, 1, 1, 0, 0, 0),
        new Date(2000, 2, 1, 23, 59, 59),
      ],
      dialogVisible:false,
      Tips:"新增库存",
      dialogform:{
        inventory_sku:"",
        in_quantity:"",
        out_quantity:"",
        memo:"",
        warehouse_id:"",
        stock_quantity:0,
      },
      rules:{
        inventory_sku:[
          {
            required: true,
            message: '请选择输入商品',
            trigger: 'change',
          }
        ],
        in_quantity:[
            { required: true, message: '请输入数字', trigger: 'blur' },
            { validator: isNum, trigger: 'blur' }
        ],
        out_quantity:[
            { required: true, message: '请输入数字', trigger: 'blur' },
            { validator: isNum, trigger: 'blur' }
        ]
      },
      //商品列表
      Productlist:[],
      //创库列表
      Warehouselist:[],
      shop_list:[],

      total:100,
      pagesize:15,
      pagecount:15,
      currentpage:1,
      
      PrepareProduct:[],
      Preparewarehouse:[],
    })
    onMounted(() =>{
      GetStocklog();
      GetProductlists();
    })
    function AddStock(){
      init();
      data.dialogVisible = true
      data.Tips = "入库"
    }
    function MinusStock(){
      init();
      data.dialogVisible = true
      data.Tips = "出库"
    }
    function SelectStock(){
      GetStocklog();
    }
    function handleCurrentChange(e){
      data.currentpage = e
      GetStocklog();
    }
    function handleSizeChange(e){
      data.pagesize = e
      GetStocklog();
    }
    function GetProductlists(){
        data.loading = true
        GetProductList({
          company_id:store.state.userinfo.userinfo.company_id,
        }).then(res =>{
          if(res.code == 1){
            data.Productlist = res.data.data
          }
        })
        warehouseList({
          company_id:store.state.userinfo.userinfo.company_id,
        }).then(res =>{
          if(res.code == 1){
            data.Warehouselist = res.data.data
          }
        })
        ShopList({
          company_id:store.state.userinfo.userinfo.company_id,
        }).then((res) => {
          if (res.code == 1) {
            data.shop_list = res.data.data;
          }
        });
        
    }
    function GetStocklog(){
      let start_time;
      let end_time;
      if(isNaLL(data.search.datevalue)){
         start_time = data.search.datevalue[0]
         end_time = data.search.datevalue[1]
      }
      
      data.loading = true;
      inventoryLogList({
        start_time,
        end_time,
        sku:data.search.sku,
        warehouse_id:data.search.warehouse_id,
        shop_id:data.search.shop_id,
        page_num:data.currentpage,
        per_page_num:data.pagesize,
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
          data.loading = false;
          if(res.code == 1){
              data.total = res.data.total
              data.pagesize = Number(res.data.size)
              data.currentpage = res.data.cur
              data.datalist = res.data.data
              console.log(res.data.size);
          }else{
              shoElmessage(true,`${res.msg}`,'error')
          }
      })
    }
    //选择联动库存
    function CascaderChange(e){
        data.Productlist.forEach(el => {
          el.variants.forEach(elvan =>{
              if(elvan.id == e[e.length -1]){
                  data.stock_quantity = elvan.inventory_quantity;
              }
          })
        })
    }
    
    //提交
    function Sumbit(){
        console.log(data.stock_quantity)
        if(data.stock_quantity <= 0 && data.Tips == '出库'){
            return shoElmessage(true,'库存为0，没有库存让你出库','error')
        }
        operateInventoryLog({
          ...data.dialogform,
          company_id:store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
                shoElmessage(true,`${data.Tips}成功`)
                data.dialogVisible = false
                init();
                GetStocklog();
                GetProductlists();
            }else{
                shoElmessage(true,`${data.Tips}失败,原因:${res.msg}`,'error')
            }
        })
    }

    function init(){
        data.dialogform = {
            inventory_sku:"",
            in_quantity:"",
            out_quantity:"",
            memo:"",
            warehouse_id:"",
            stock_quantity :0
          }
    }
    //获取时间
    function GetTIme(time){
      return getLocalTime(time,null,'时')
    }
    function handleClose(){

    }
    function SelectChangeProduct(event){
      console.log(event)
      data.Productlist.forEach(item =>{
        if(item.inventory_sku == event){
          data.PrepareProduct = item
            if(!isNaLL(item.inventory)){
              data.dialogform.stock_quantity = 0
            }else{
              if(isNaLL(data.dialogform.warehouse_id)  && item.inventory.length > 0){
                  item.inventory.forEach(el =>{
                    if(el.warehouse_id == data.dialogform.warehouse_id){
                      data.dialogform.stock_quantity = el.stock
                    }else{
                      data.dialogform.stock_quantity = 0
                    }
                  })
              }
            }
        }
      })
    }
    function SelectChangeWarehouse(event){
      data.Warehouselist.forEach(item =>{
        if(item.id == event){
            data.Preparewarehouse = item
            if(isNaLL(data.dialogform.inventory_sku)){
                data.Productlist.forEach(item =>{
                    if(data.dialogform.inventory_sku == item.inventory_sku){
                        console.log(isNaLL(item.inventory))
                        if(!isNaLL(item.inventory)){
                          return data.dialogform.stock_quantity = 0
                        }else{
                          item.inventory.forEach(el =>{
                              if(el.warehouse_id == event){
                                data.dialogform.stock_quantity = el.stock
                              }else{
                                data.dialogform.stock_quantity = 0
                              }
                          })
                        }
                    }
                })
            }
        }
      })
    }
    return {
      handleClose,
      Sumbit,
      ...toRefs(data),
      GetStocklog,
      SelectStock,
      MinusStock,
      AddStock,
      GetProductlists,
      CascaderChange,
      init,
      GetTIme,
      Debounce,
      handleCurrentChange,
      handleSizeChange,
      SelectChangeProduct,
      SelectChangeWarehouse
    }
  },
  methods:{
      Getcontent(value,value2,value3){
        let str = '';
        if(isNaLL(value)){
          str += value
        }
        if(isNaLL(value2)){
          str += `/${value2}`
        }
        if(isNaLL(value3)){
          str += `/${value3}`
        }
        return str;
      }
  }
}
</script>
<style>
.product_class{
  max-width: 400px;
}
</style>
<style scoped lang="scss">
.search {
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  // margin-bottom: 20px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);

  .headbox {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    width: 100%;
    .searchLa {
      width: 70px;
      text-align: right;
    }
    //具体搜索框
    .leftSearch {
      margin: 5px;
      display: flex;
      align-items: center;
      .el-input{
        flex:1;
      }
    }
  }
  //展开按钮
  .iCol {
    color: #409eff;
    cursor: pointer;
    transition: transform 0.5;
    transform: rotate(0deg);
    margin-left: 10px;
  }
  i{
      margin-left: 5px;
  }
  .show3 {
    i {
      transition: transform 0.5;
      transform: rotate(-180deg);
      margin-left: 5px;
    }
  }
}
.add{
    margin-top: 15px;
    margin-bottom: 15px;
  }
.stock--log-content{
  width: 100%;
  min-height: 100%;
  background-color: #fff;
  
}
.stock_content-header{
  min-width: 100%;
  min-height: 60px;
  // border-bottom: 1px solid #dcdfe6;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  padding: 20px 10px;
}
.select-log{
  margin-left: 10px;
}
.stocklog--list{
  margin-top: 20px;
  padding: 20px;
}

@media only screen and (max-width: 1359px){
    .btn--remove {
        margin-left: 10px;
        margin-top: 10px;
    }
}
.paginations{
  padding: 20px;
  padding-top: 0px;
}
</style>