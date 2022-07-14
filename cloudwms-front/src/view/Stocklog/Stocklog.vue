<template>
  <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }">
          <sidebar LogoName="库存日志">
                <template #Seacrch>
                    <!-- <search class="search-input"></search> -->
                </template>
                
          </sidebar>
      </el-header>
    <el-main>
      <div class="stock--log-content">
        <div class="stock_content-header">
          <div class="header--list">
            <label>SKU</label>
            <el-input v-model="sku" placeholder="请输入内容"></el-input>
          </div>
          <div class="header--list">
            <label></label>
            <el-date-picker
              v-model="datevalue"
              type="daterange"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              :default-time="defaulttime"
              value-format="YYYY-MM-DD"
              >
            </el-date-picker>
          </div>
          <el-button  type="primary" class="add-stock" size="medium" @click="AddStock">
            <i class="el-icon-plus"></i>
            入库
          </el-button>
          <el-button  type="primary" class="add-stock" size="medium" @click="MinusStock">
            <i class="el-icon-minus"></i>
            出库
          </el-button>
          <loding-btn type="primary" btnsize="medium" class="select-log" @LoadBTN="SelectStock">查询</loding-btn>
        </div>
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
                  prop="sku"
                  label="sku"
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
        <div class="paginations">
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
    </el-main>
  </el-container>
    <el-dialog
      v-model="dialogVisible"
      :title="Tips"
      width="50%"
  >
    <div class="content">
        <el-form :model="dialogform" label-width="120px" :rules="rules">
            <el-form-item label="选择商品：" prop="productname">
              <el-cascader style="width:100%" 
                  v-model="dialogform.productname" 
                  :options="Productlist"
                  :collapse-tags='true'
                  :props="{label:'title',value:'id',children:'variants'}" 
                  :show-all-levels="false" 
                  @change="CascaderChange"
                  popper-class="product_class"
                >
                <!-- <span></span> -->
               <template #default="{  data }">
                  <span>{{data.title}}</span>
                    <!-- <span v-if="!node.isLeaf">{{data.title}}</span> -->
                    <!-- <span v-if="Getcontent(data.option1,data.option2,data.option3) != '' ">{{Getcontent(data.option1,data.option2,data.option3)}}</span> -->
                </template>
              </el-cascader>
            </el-form-item>
            <el-form-item label="库存：">
              <label>{{stock_quantity}}</label>
            </el-form-item>
            <el-form-item label="入库数量：" prop="in_quantity" v-if="Tips == '入库'">
              <el-input v-model="dialogform.in_quantity"></el-input>
            </el-form-item>
            <el-form-item label="出库数量：" prop="out_quantity" v-else>
              <el-input v-model="dialogform.out_quantity"></el-input>
            </el-form-item>
            <el-form-item label="备注：" >
              <el-input type="textarea" v-model="dialogform.Remark"></el-input>
            </el-form-item>
        </el-form>
    </div>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">取消</el-button>
        <el-button type="primary" @click="Debounce"
          >确认</el-button
        >
      </span>
    </template>
  </el-dialog>
</template>
<script>
import { Plus } from '@element-plus/icons'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue';
import ButtonR from '../../components/Bottom/buttonR.vue';
import Loaddingbutton from '../../components/loaddingbutton/index.vue';
import LodingBtn from '../../components/lodingBtn/index.vue';
import { reactive, toRefs,onMounted,computed } from 'vue';
import { inventoryLogList, operateInventoryLog } from '../../api/Stocklog';
import { shoElmessage } from '../../utils/Elmessage';
import { getLocalTime, isNaLL, isNum ,SelectProductTitle,debounce} from '../../utils/utils';
import { GetProductlist } from '../../api/Porductapi';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';

export default {
  components:{
      Sidebar,
      ButtonR,
      Loaddingbutton,
      LodingBtn,
      Plus
  },
  setup(props,content){
    const route = useRoute();
    const store = useStore();
    const Debounce = debounce(Sumbit,200);
    const data = reactive({
      mode:computed(() => store.state.setting.device.mode),
      loading:false,
      datevalue:"",
      sku:"",
      datalist:[],
      stock_quantity:0,
      defaulttime:[
        new Date(2000, 1, 1, 0, 0, 0),
        new Date(2000, 2, 1, 23, 59, 59),
      ],
      dialogVisible:false,
      Tips:"新增库存",
      dialogform:{
        productname:"",
        in_quantity:"",
        out_quantity:"",
        Remark:"",
      },
      rules:{
        productname:[
          {
            required: true,
            message: 'Please input Activity name',
            trigger: 'blur',
          },
          {
            min: 3,
            max: 20,
            message: 'Length should be 3 to 20',
            trigger: 'blur',
          },
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
      Productlist:[],

      total:100,
      pagesize:15,
      pagecount:15,
      currentpage:1,
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
        GetProductlist({}).then(res =>{
            if(res.code == 1 ){
              let selectlist =   SelectProductTitle(res.data.data);
              data.loading = false
              data.Productlist = selectlist
            }
        })
    }
    function GetStocklog(){
      data.loading = true;
      inventoryLogList({
        sku:data.sku,
        start_time:data.datevalue[0] || '',
        end_time:data.datevalue[1] || '',
        shop_id:route.query.id,
        page_num:data.currentpage,
        per_page_num:data.pagesize
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
        if(data.stock_quantity <= 0 && data.Tips == '出库'){
            return shoElmessage(true,'库存为0，没有库存让你出库','error')
        }
        operateInventoryLog({
          product_variant_id:data.dialogform.productname[data.dialogform.productname.length -1] || '',
          in_quantity:data.dialogform.in_quantity,
          out_quantity:data.dialogform.out_quantity,
          memo:data.dialogform.Remark,
        }).then(res =>{
            if(res.code == 1){
                shoElmessage(true,`${data.Tips}成功`)
                data.dialogVisible = false
                init();
                GetStocklog();
            }else{
                shoElmessage(true,`${data.Tips}失败,原因:${res.msg}`,'error')
            }
        })
    }

    function init(){
        data.dialogform = {
            productname:"",
            in_quantity:"",
            out_quantity:"",
            Remark:"",
          },
        data.stock_quantity = 0
    }
    //获取时间
    function GetTIme(time){
      return getLocalTime(time,null,'时')
    }
    function handleClose(){

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
      handleSizeChange
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
.el-header{
  background-color: #fff;
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
  padding: 30px 10px;
}
.header--list{
  
  label{
    margin-right: 10px;
    font-size: 14px;
   white-space: nowrap;
  }
  display: flex;
  align-items: center;
  margin-left: 10px;
}
.select-log{
  margin-left: 10px;
}
.stocklog--list{
  margin-top: 20px;
  padding: 20px;
}
.add-stock{
  margin-left: 10px;
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