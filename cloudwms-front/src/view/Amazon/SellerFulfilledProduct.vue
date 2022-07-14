<template>
  <el-container>
      <el-header>
        <sidebar LogoName="订单列表"></sidebar>
      </el-header>
      <el-main>
            <div class="orders_header flex align-center justify-between flex-wrap">
                <div class="order">
                  <div class="order-title">管理订单</div>
                  <a>了解更多信息</a>
                  <a>视频教程</a>
                </div>
                <div class="orders_search">
                  <el-input placeholder="请输入内容" v-model="input3" class="input-with-select">
                    <template #prepend>
                        <el-select v-model="select"  placeholder="请选择">
                            <el-option label="餐厅名" value="1"></el-option>
                            <el-option label="订单号" value="2"></el-option>
                            <el-option label="用户电话" value="3"></el-option>
                        </el-select>
                    </template>
                    <template #append>
                        <el-button  icon="el-icon-search"></el-button>
                    </template>
                  </el-input>
                </div>
            </div>
            <div class="prompt">卖家自配送</div>
            <div class="order-type-list ">
                <div class="order-type-header-list flex justify-between align-center flex-wrap">
                    <div class="flex align-center">
                        <div class="type_content" :class="{'type_content-active':typeindex == 0}" @click="TypeClick(0)">(0) 等待中</div>
                        <div class="type_content" :class="{'type_content-active':typeindex == 1}" @click="TypeClick(1)">(0) 未发货</div>
                        <div class="type_content" :class="{'type_content-active':typeindex == 2}" @click="TypeClick(2)">已取消</div>
                        <div class="type_content" :class="{'type_content-active':typeindex == 3}" @click="TypeClick(3)">已发货</div>
                    </div>
                    <div class="select-Seller-order" @click="SelectAmazonOrder">
                      <a>查看亚马逊物流送订单</a>
                      <i class="el-icon-arrow-right"></i>
                    </div>
                </div>
            </div>
            <el-row class="order-content flex">
              <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="3" v-if="refinestatus" class="refine">
                  <div class="refine-content">
                      <div>细化依据：</div>
                      <div class="refine-content-title">销售渠道</div>
                      <div class="refine-content-checkbox-list">
                        <div>
                          <el-checkbox>Non-Amazon</el-checkbox>
                        </div>
                         <div>
                          <el-checkbox>Amazon.com.mx</el-checkbox>
                        </div>
                        <div>
                          <el-checkbox>Non-Amazon</el-checkbox>
                        </div>
                        <div>
                          <el-checkbox>Amazon.ca</el-checkbox>
                        </div>
                         <div>
                          <el-checkbox>Amazon.com</el-checkbox>
                        </div>
                        <div>
                          <el-checkbox>SI CA Prod</el-checkbox>
                        </div>
                        <div class="addition">Marketplace</div>
                      </div>
                      <div class="refine-content-title">销售渠道</div>
                      <div class="refine-content-checkbox-list">
                          <div>
                            <el-checkbox>Non-Amazon</el-checkbox>
                          </div>
                      </div>
                  </div>
              </el-col>

              <el-col :xs="24" :sm="24" :md="refinestatus?20:24" :lg="refinestatus?20:24" :xl="refinestatus?21:24" >
                  <div class="table-content-list">
                      <div class="table_content-l-header flex align-center justify-between flex-wrap">
                          <div class="table_content-l-h flex align-end flex-wrap">
                              <div class="header-btn" @click="Refinest">{{refinestatus?'隐藏筛选条件':'显示筛选条件'}}</div>
                              <div class="order-number">7个订单</div>
                              <span class="order-date">{{daterange}}</span>
                          </div>
                          <div class="table-header-btn-list flex flex-wrap">
                              <div class="dropdown-date">
                                  <el-dropdown trigger="click" @command="handleClickDateRange">
                                    <el-button type="primary">
                                      日期范围：{{daterange}}<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu >
                                          <el-dropdown-item command="最近3天">最近3天</el-dropdown-item>
                                          <el-dropdown-item  command="最近10天">最近10天</el-dropdown-item>
                                          <el-dropdown-item  command="最近15天">最近15天</el-dropdown-item>
                                          <el-dropdown-item  command="最近一个月">最近一个月</el-dropdown-item>
                                          <el-dropdown-item  command="最近3个月">最近3个月</el-dropdown-item>
                                          <el-dropdown-item  command="最近半年">最近半年</el-dropdown-item>
                                          <el-dropdown-item  command="最近一年">最近一年</el-dropdown-item>
                                          <el-dropdown-item  command="自定义时间">自定义时间</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                  </el-dropdown>
                              </div>
                              <div class="dropdown-date">
                                  <el-dropdown trigger="click"  @command="handleClickDate">
                                    <el-button type="primary">
                                      {{sequence}}<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu >
                                          <el-dropdown-item command="订单日期（升序）">订单日期（升序）</el-dropdown-item>
                                          <el-dropdown-item command="订单日期（降序）">订单日期（降序）</el-dropdown-item>
                                          <el-dropdown-item command="发货日期（升序）">发货日期（升序）</el-dropdown-item>
                                          <el-dropdown-item command="发货日期（降序）">发货日期（降序）</el-dropdown-item>
                                          <el-dropdown-item command="配送服务（升序）">配送服务（升序）</el-dropdown-item>
                                          <el-dropdown-item command="配送服务（降序）">配送服务（降序）</el-dropdown-item>
                                          <el-dropdown-item command="状态（升序）">状态（升序）</el-dropdown-item>
                                          <el-dropdown-item command="状态（降序）">状态（降序）</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                  </el-dropdown>
                              </div>
                               <div class="dropdown-date">
                                  <el-dropdown trigger="click"  @command="handleClickPagesize">
                                    <el-button type="primary">
                                      每页结果数：{{pagesize}}<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu >
                                          <el-dropdown-item :command="15">15</el-dropdown-item>
                                          <el-dropdown-item :command="25">25</el-dropdown-item>
                                          <el-dropdown-item :command="50">50</el-dropdown-item>
                                          <el-dropdown-item :command="100">100</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                  </el-dropdown>
                              </div>
                              <div class="dropdown-date">
                                <el-button @click="SetTableSelect">设置表格首选项</el-button> 
                              </div>
                              
                             <div class="dropdown-date">
                                <el-button>刷新</el-button> 
                              </div>
                              <div class="dropdown-date" v-if="daterange == '自定义时间'">
                                  <el-date-picker
                                      style="width: 100%;"
                                      v-model="dateTime"
                                      type="datetimerange"
                                      range-separator="至"
                                      start-placeholder="开始日期"
                                      end-placeholder="结束日期"
                                      @change="PickerChange"
                                      format="YYYY-MM-DD"
                                  >
                                  </el-date-picker>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="el-order-table">
                    <el-table :data="tableData"> 
                        <el-table-column
                          type="selection"
                        >
                          
                        </el-table-column>
                        <el-table-column
                          label="订单日期"
                        >
                          <template #default>
                            <div class="font-weight">3天前</div>
                            <div>2022/1/8</div>
                            <div>上午9:36PST</div>
                          </template>
                        </el-table-column> 
                         <el-table-column
                          label="订单详情"
                        >
                          <template #default>
                            <div class="font-weight font-color">111-1586931-4009064</div>
                            <div>买家姓名：<span class="font-color">曾小微</span></div>
                            <div>配送渠道：Amazon.com</div>
                            <div>销售渠道：亚马逊</div>
                            <div>卖家订单编号：111-1586931-4009064</div>
                          </template>
                        </el-table-column>
                        <el-table-column
                          label="图片"
                          width="100"
                        >
                          <template #default>
                            <el-image fit="cover" src="https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg"></el-image>
                          </template>
                        </el-table-column> 
                        <el-table-column
                          label="商品名称"
                        >
                          <template #default>
                            <div class="font-weight font-color">111-1586931-4009064</div>
                            <div>ASIN<span class="font-color">BO9B5SBKVM</span></div>
                            <div>SKU:FSD-114</div>
                            <div>数量：1</div>
                            <div>商品小计：22.10</div>
                          </template>
                        </el-table-column> 
                        <el-table-column
                          label="买家选项"
                        >
                          <template #default>
                            <div>加急</div>
                          </template>
                        </el-table-column>
                        <el-table-column
                          label="订单状态"
                        >
                          <template #default>
                            <el-tag class="ml-2" type="success">付款完成</el-tag>
                          </template>
                        </el-table-column>
                        <el-table-column
                          label="操作"
                        >
                          <template #default>
                            <div>
                              <el-button>订单退款</el-button>
                            </div>
                          </template>
                        </el-table-column>
                         <el-table-column
                         type="expand"
                        >
                          <template #defalut="props">
                            <div>{{props}}</div>
                          </template>
                        </el-table-column>    
                    </el-table>
                  </div>
              </el-col>
            </el-row>
      </el-main>
  </el-container>
  <el-dialog
      title="设置 “管理订单” 表的默认首选项 "
      v-model="dialogVisible"
      width="70%"
      custom-class="SetTableSelect"
      >
      <div class="dialog-content">
          <div class="dialog-title">查看所有选项 <el-divider direction="vertical"></el-divider> 取消选中所有（可选）选项 <el-divider direction="vertical"></el-divider> 重置为默认首选项</div>
          <div class="dislog-content-list flex  flex-wrap">
              <div class="select--list">
                <div class="select--l-title">订单日期</div>
                <div class="checkbox--list">
                    <div>
                      <el-checkbox disabled value="true">日期</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>时间</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>自下单日起经过的时间</el-checkbox>
                    </div>
                </div>
              </div>
              <div class="select--list">
                <div class="select--l-title">订单日期</div>
                <div class="checkbox--list">
                    <div>
                      <el-checkbox disabled value="true">订单编号</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>买家姓名</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>配送渠道</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>销售渠道</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>账单国家/地区</el-checkbox>
                    </div>
                </div>
              </div>
              <div class="select--list">
                <div class="select--l-title">商品名称</div>
                <div class="checkbox--list">
                    <div>
                      <el-checkbox disabled value="true">名称</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>数量</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>SKU</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>ASIU</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>图片</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>商品小计</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>状况</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>商品编号</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>订单商品编号</el-checkbox>
                    </div>
                </div>
              </div>
              <div class="select--list">
                <div class="select--l-title">买家选项</div>
                <div class="checkbox--list">
                    <div>
                      <el-checkbox disabled value="true">买家配送服务</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>配送日期</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>配送渠道</el-checkbox>
                    </div>
                </div>
              </div>
              <div class="select--list">
                <div class="select--l-title">买家选项</div>
                <div class="checkbox--list">
                    <div>
                      <el-checkbox disabled value="true">订单配送状态</el-checkbox>
                    </div>
                    <div>
                      <el-checkbox>状态警告</el-checkbox>
                    </div>
                </div>
              </div>
          </div>
      </div>
      <template #footer>
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </template>
  </el-dialog>
</template>

<script>
import { reactive,toRefs } from 'vue'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import router from '../../router'
export default {
  components:{
    Sidebar
  },
  setup(props,content){
    const data = reactive({
        select:"订单编号",
        input3:"",
        typeindex:1,
        refinestatus:true,

        //搜索条件
        pagesize:15,
        daterange:"最近3天",
        sequence:"订单日期（升序）",

        dateTime:"",


        //弹出框
        dialogVisible:false,
        dialogloading:false,

        tableData:[
          {
            date:'2022/1/8',
            time:"上午16:36",
            order_id:1111-1586921-4009064,
            name:"Zachary",
            channel:'亚马逊'
          }
        ]
    })
    function TypeClick(index){
      data.typeindex =  index
    }
    function Refinest(){
      data.refinestatus = !data.refinestatus
    }
    //每页数
    function handleClickPagesize(e){
      data.pagesize = e
    }
    //排序
    function handleClickDate(e){
      data.sequence = e
    }
    //时间范围
    function handleClickDateRange(e){
      data.daterange = e
    }
    //自定义事件范围
    function PickerChange(e){

    }
    //设置表格选项
    function SetTableSelect(e){
        data.dialogVisible = true
    }
    //查看亚马逊的订单
    function SelectAmazonOrder(){
      router.push({path:"/Amazonshop/AmzonOrders"})
    }
    return {
      TypeClick,
      ...toRefs(data),
      Refinest,
      handleClickPagesize,
      handleClickDate,
      handleClickDateRange,
      PickerChange,
      SetTableSelect,
      SelectAmazonOrder,
    }
  } 
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.orders_header{
  width: 100%;
  padding: 20px 20px;
  background-color: #fff;
  max-width: 100%;
}
.order{
  display: flex;
  align-items: flex-end;
  padding: 10px 0px;
  flex-wrap: wrap;
  a{
    color: #007185;
    margin-left: 10px;
  }
}
.order-title{
  font-size: 30px;
  margin-right: 10px;
}
.orders_search {
  :deep(.el-select){
    .el-input{
      width: 110px;
    }
  }
} 
.prompt{
  padding:0px 20px 20px;
  background-color: #fff;
}
.order-type-list{
  padding:0px 20px 20px;
  background-color: #fff;
  .type_content{
    position: relative;
    padding: 20px 0px;
    margin-right: 30px;
    cursor: pointer;
    font-size: 20px;
    color: #007185;
    
  }
  .type_content-active{
    font-weight: bold;
    &::before{
      content: '';
      position: absolute;
      left: 0px;
      width: 100%;
      height: 2px;
      background-color: #007185;
      bottom: 0px;
    }
  }
}
.order-type-header-list{
  border-bottom: 1px solid #999;
}
.select-Seller-order{
  font-size: 20px;
  padding: 20px 0px;
  cursor: pointer;
  a{
    color: #0099ff;
  }
}
.order-content{
  background-color: #fff;
  height: auto;
  width: 100%;
  padding: 20px;
}

//内容
.table_content-l-header{
  max-width: 100%;
  box-sizing: border-box;
}
.table-header-btn-list{
  max-width: 100%;
  box-sizing: border-box;
}
.refine{
  transition: all 0.5s;
  animation: refineanimation 0.5s;
  opacity: 1;
}
@keyframes refineanimation {
  0%{
    opacity: 0;
  }
}
.refine-content{
  background-color: rgb(243,243,243); 
  padding: 10px;
  border: 1px solid rgb(211, 211, 211);
}
.refine-content-title{
  font-size: 16px;
  padding: 20px 0px 10px 0px;
  border-bottom: 1px solid #999;
  font-weight: bold;
}
.refine-content-checkbox-list{
  border-bottom: 1px solid #999;
  .addition{
    padding: 10px 0px;
    color: rgb(75, 75, 75);
  }
}
.table-content-list{
  padding:0px 20px 20px;
}
.el-order-table{
  padding:10px 20px 20px;
}
.table_content-l-h{
    .header-btn{
      background-color: #000;
      line-height: 40px;
      text-align: center;
      border-radius: 30px;
      height: 40px;
      color: #fff;
      padding: 0px 15px;
      cursor: pointer;
    }
    .order-number{
      font-size: 28px;
      font-weight: bold;
      margin-left: 10px;
    }
    .order-date{
      margin-left: 15px;
      font-size: 20px;
      color: #999;
    }
}
.dropdown-date{
  margin-left: 10px;
  padding: 10px 0px;
}
//表格

//弹出框
.dialog-title{
  color: #007185;
}
.dislog-content-list{
  margin-top: 20px;
  padding: 0px 15px;
  .select--list{
    width: 30%;
    .select--l-title{
      font-weight: bold;
    }
  }
  .checkbox--list{
    margin-top: 10px;
    .el-checkbox{
      height: 25px;
    }
  }
}

.font-weight{
  font-weight: bold;
}
.font-color{
  color: #007185;
}


@media only screen and(max-width:990px){
  .table-content-list{
    padding: 0;
  }
  .table_content-l-header{
    margin-top: 20px;
  }
}

</style>
<style lang="scss">
.SetTableSelect{
  border-radius: 10px;
  .el-dialog__header{
    border-radius: 10px;
    background-color: rgb(240,240,240);
    i{
      font-size: 22px;
    }
  }
}
</style>