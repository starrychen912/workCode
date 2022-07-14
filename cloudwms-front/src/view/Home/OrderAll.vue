<template>
  <el-container>
     <el-header :class="{'el_header--bg':mode === 'mobile' }">
         <sidebar LogoName="订单列表"></sidebar>
     </el-header>
     <el-main>
      <div class="header-title flex justify-between" >
            <!-- <el-button type="primary"  disabled>
                <span>EXPORT</span>
            </el-button> -->
            <div class="header_table-list flex">
                <label class="header_table--label">供应商：</label>
                <div class="table-one" @click="ProductSupplier('0')" :class="{'active-all':Supplierkey == '0'}">自己</div>
                <div class="table-two" @click="ProductSupplier('1')" :class="{'active-all':Supplierkey == '1'}">其他</div>
            </div>
            <div class="header_table-list flex">
                <div class="table-one" @click="ProductType('0')" :class="{'active-all':PorductTypekey == '0'}">全部订单</div>
                <div class="table-two" @click="ProductType('1')" :class="{'active-all':PorductTypekey == '1'}">待发货</div>
                <div class="table-three" @click="ProductType('2')" :class="{'ctive-all':PorductTypekey == '2'}">已完成</div>
            </div>
      </div>
      <div class="main-empty" v-if="orderlist.length == 0" v-loading="loading">
          <img src="@/assets/svg/empty.svg">
          <div class="text">订单是空的~</div>
      </div>
      <el-card v-for="(item,index) in orderlist" :key="index">
            <div class="order-header panel-body" >
                    <div class="order-header__statuses">
                        <img src="https://cdn.oberlo.com/img/shop-icon-shopify.svg" alt="Shopify Logo" class="order-header__logo">
                        <div class="order-header__order">
                            <a target="_blank" href="https://devddinfotech.myshopify.com/admin/orders/4019309281462">{{item.name}}</a>
                            {{getLocalTimes(item.create_time)}}
                        </div>
                        <div class="order-header__order-status">
                            <div class="order-status">
                                <span>未付费</span>
                                <span>未完成</span>
                            </div>
                        </div>
                        <div class="order-header__flag-block">
                            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M8 44L8 6C8 4.89543 8.89543 4 10 4H38C39.1046 4 40 4.89543 40 6V44L24 35.7273L8 44Z" fill="#5ba137" stroke="#5ba137" stroke-width="4" stroke-linejoin="round"/><path d="M16 18H32" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>
                <div class="panel-body--context-list">
                   <div class="order-supplier">
                       <div class="order-supplier__wrapper">
                           <div class="order-supplier__state">
                               <div class="order-supplier__title">To order is {{item.shop_name}}</div>
                           </div>
                           <div class="order-supplier__column order-supplier__name">

                               <!-- <a class="-margin-left-xs">supplier:</a> -->
                           </div>
                           <div class="order-supplier__button">
                               <el-dropdown trigger="click">
                                    <el-button  size="small" type="primary">
                                        ACTIONS<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                    <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item>Add AliExpress order number</el-dropdown-item>
                                        <el-dropdown-item>Order</el-dropdown-item>
                                    </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="order-items" v-for="(orderitem,orderitemindex) in item.order_item" :key="orderitemindex">
                    <div class="order-items__block">
                        <div class="order-item order-items__item" >
                            <div class="order-item__image">
                                <el-image  style="" :src="orderitem.images != ''?orderitem.images:''" fit="fill">
                                    <!-- <template #default="error" class="image-slot">
                                        <i class="el-icon-picture-outline"></i>
                                    </template> -->
                                </el-image>
                            </div>
                            <div class="order-item-context">
                                <div><a>{{orderitem.name}}</a></div>
                                <!-- <div class="order-item__details">Pink / Australia</div> -->
                                <div class="order-item__details">SKU:{{orderitem.sku}}</div>
                                <div>supplier:{{orderitem.supplier_name}}</div>
                            </div>
                            <div class="order-item-price--width">
                                <div>{{t('home.unit')}}{{orderitem.price}} × {{orderitem.quantity}}</div>
                                <div class="order-item-price">
                                    Total:
                                    <span>CN¥{{orderitem.price}}</span>
                                </div>
                            </div>
                           
                            <div class="order-item-button" >
                                <el-tooltip class="item" effect="dark" content="已完成" placement="top" v-if="false"> 
                                    <i class="el-icon-success"></i>
                                </el-tooltip>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Add--dote">
                    <div></div>
                    <el-button  size="mini" type="info">
                        ADD DOTE
                    </el-button>
                </div>
        </el-card>
       <el-empty :image-size="200" :description="'Your Order  List is Empty'" v-if="false">
         <span>No orders matching your search criteria</span>
       </el-empty>
     </el-main>
     <div class="elpagination">
         <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="currentpage"
            :page-sizes="[10,20,30,50,100, 200, 300, 400]"
            :page-size="pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total">
            </el-pagination>
     </div>
  </el-container>
</template>

<script>
import { reactive ,onMounted,toRefs,computed} from 'vue'
import Sidebar from '@/components/Loyout/Sidebar/Sidebar.vue'
import { GetOrderlist } from '../../api/Orders'
import { getLocalTime } from '../../utils/utils'
import router from '../../router'
import { useRoute } from 'vue-router'
import i18n from '../../locale'
import { useStore } from 'vuex'
export default {
    components:{
        Sidebar
    },

    methods:{
      getLocalTimes(item){
        return getLocalTime(item)
      }
    },
    mounted(){
        this.GetOrderlistbtn();
    },
    setup(props,context){
        const store = useStore();
        const route = useRoute();
        const data = reactive({
            orderlist:[],
            loading:true,
            t:i18n.global.t,
            mode:computed(() => store.state.setting.device.mode),
            PorductTypekey:'0',
            Supplierkey:'0',

            total:100,
            pagesize:10,
            pagecount:10,
            currentpage:1,

        })
        function GetOrderlistbtn(){
            data.loading = true
            GetOrderlist({
                // shop_id:route.query.id,
                type:data.Supplierkey,
                page_num:data.currentpage,
                per_page_num:data.pagesize,
                status:data.PorductTypekey,
            }).then(res =>{
                data.loading = false
                if(res.code === 1){
                    // console.log(res.data);
                    data.total = res.data.total
                    data.pagesize = res.data.size
                    data.currentpage = res.data.cur
                    data.orderlist = res.data.data
                }
            })
        }
        function ProductType(index){
            data.PorductTypekey = index;
            GetOrderlistbtn();
        }
        function ProductSupplier(index){
            data.Supplierkey = index;
            GetOrderlistbtn();
        }
        function handleSizeChange(e){
            data.pagesize = e
            GetOrderlistbtn();
        }
        function handleCurrentChange(e){
            data.currentpage = e
            GetOrderlistbtn();
        }
        return {
            handleSizeChange,
            handleCurrentChange,
            ...toRefs(data),
            GetOrderlistbtn,
            ProductType,
            ProductSupplier
        }
    },
    
}
</script>

<style lang="scss" scoped>
.header-title{
  color:#d1d1d1;
  margin-bottom: 10px;
}
.header_table-list{
    display: flex;
    align-items: center;
    font-size: 14px;
    .header_table--label{
        padding: 0px 5px;
        color: #000;
    }
    .table-one,.table-two,.table-three{
        background-color: #fff;
        padding: 10px 15px;
        color: #000;
        cursor: pointer;
        &:hover{
            background-color: #409EFF;
            color: #fff;
        }
    }
    .table-one{
        border-top-left-radius: 2px;
        border-bottom-left-radius: 2px;
    }
    .table-two{

    }
    .table-three{
        border-top-right-radius: 2px;
        border-bottom-right-radius: 2px;
    }
    .active-all{
        background-color: #409EFF;
        color: #fff;
    }
}
.btn-basic {
    color: #62628d;
    background-color: #ededf2;
    background-image: none;
    outline: none;
}
.el-card{
    margin-top: 20px;
}
:deep(.el-card__body){
    padding: 0px;
}
.panel-body {
    padding: 16px 24px;
    border-bottom: 1px solid #e5e5ec;
}
.order-header__statuses{
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    margin-right: 16px;
    img{
        margin-right: 10px;
    }
}
.order-header__order{
    white-space: nowrap;
    a{
        text-decoration: underline;
    }
}
.order-header__order-status{
    margin-right: 16px;
    align-items: center;
    display: inline-flex;
    .order-status{
        display: flex;
        height: 24px;
        align-items: center;
        flex-wrap: nowrap;
        
        span{
            color: #272742;
            background-color: #ededf2;
            margin-left: 8px;
            padding: 3px 9px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
        }
    }
}
.order-header__flag-block{
    flex: 1;
    text-align: right;

}
//内容
.panel-body--context-list{
    padding: 16px 24px;
    margin:0px;
}
.order-supplier{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
}
.order-supplier__wrapper{
    display: grid;
    width: 100%;
}
.order-supplier__state{
    grid-area: 1/1; 
    margin-right: 12px;
}
.order-supplier__column{
    grid-area: 1/2/2/3;
    margin-right: 12px;
    display: flex;
    align-items: center;
    cursor: pointer;
    img{
        width: 18px;
        height: 18px;
    }
    a{
        text-decoration: underline;
        margin-left: 10px;
        color: #62628d;
    }
}
.order-supplier__title{
    font-weight: 600;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: .02em;
    display: inline-block;
    min-width: 10px;
    padding: 3px 9px;
    line-height: 1;
    vertical-align: middle;
    white-space: nowrap;
    text-align: center;
    border-radius: 10px;
    color: #461e05;
    background-color: #fff175;
}
.order-supplier__button{
    width: 40%;
    grid-area: 1/6/2/6;
}
.order-items{
    padding-top: 16px;
    padding: 16px 24px;
    border-bottom: 1px solid #e5e5ec;
}
.order-items__item{
    border-radius: 1px;
    border: none;
    background: #f6f6f9;
    margin-top: 4px;
    margin-bottom: 4px;
    display: grid;
    grid-template-columns: 0.5fr 3fr auto  1fr;
    grid-gap: 12px;
    padding: 12px;
}
.order-item__image{
    grid-column:1;
    align-self: center;
    // grid-row: 1;
    img{
        max-width: 50px;
        max-height: 50px;
        border-radius: 2px;
        vertical-align: middle;
        overflow: hidden;
    }
}

.order-item__details{
    font-weight: normal;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: .02em;
    margin-top: 20px;
}
.order-item-price--width{
    grid-row: 1;
    grid-column: 4;
    text-align: right;
}
.order-item-price{
    font-weight: bold;
    margin-top: 50px;
}
.order-item-button{
    grid-column: 4;
    grid-row: 1;
    align-self: center;
    cursor: pointer;
    .item{
        i{
            font-size: 25px;
            color: #58b63c;
        }
    }
    
}
@media (max-width: 991px){
    .order-item-context{
        grid-row: 2;
        grid-column: 1/span 4;
    }
    .order-supplier__state{
        padding-bottom: 16px;
    }
    .order-supplier__column{
        padding-bottom: 16px;
        grid-area: 2/1;
    }
    .order-item-price--width{
        grid-row: 1;
        grid-column: 3/span 3;
        text-align: right;
        align-self: start;
    }
    .order-item-button{
        grid-column: 5;
        grid-row: 1;
        align-self: center;
        margin-top: 20px;
    }
    .order-header__statuses{
        flex-wrap: wrap;
        .order-header__order-status{
            margin-top: 10px;
        }
    }
}
@media (max-width: 800px){
    .order-items__item{
        grid-template-columns: 1fr   1fr;
    }
    .order-item-price--width{
        grid-row: 1;
        grid-column: 2/span 2;
        text-align: left;
        align-self: end;
    }
    .order-item-price{
        margin-top: 10px;
    }
    .order-item-context{
        grid-row: 3;
        grid-column: 1/span 4;
    }
}
@media (max-width: 600px){

    .order-item-price--width{
        grid-row: 2;
        grid-column: 1/span 4;
        text-align: left;
        align-self: start;
        .order-item-price{
            margin-top: 0px;
        }
    }
    .order-item-context{
        grid-row: 3;
        grid-column: 1/span 4;
    }
}
@media (max-width: 700px){
    .order-item__image{
        grid-row: 1;
        grid-column: 1/6;
    }
    
}
.Add--dote{
    width: 100%;
    display: grid;
    grid-template-columns: 1fr ;
    grid-template-areas: "text button";
    padding: 16px 24px;
    box-sizing: border-box;
}
.main-empty{
    width: 100%;
    height: 90%;
    background-color: #fff;
    text-align: center;
    display:flex;
    align-items: center;
    align-content: center;
    flex-wrap: wrap;
    justify-content: center;
    img{
        width: 300px;
        height: 300px;
    }
    .text{
        width: 100%;
    }
}
.elpagination{
    padding:20px;
    // height: 100px;
}
</style>