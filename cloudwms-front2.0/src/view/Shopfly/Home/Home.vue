<template>
    <el-container>
        <el-header :class="{'el_header--bg':mode === 'mobile' }">
            <sidebar :tagview="false"></sidebar>
        </el-header>
        <el-main>
                <el-row span="24" class="el-col---list">
                    <el-col :xs="24" :sm="24" :md="8" :lg="7" :xl="7" class="card-col-list el-card" @click="ToRouter()">
                        <div class="el-icon---list-icons">
                            <i class="el-icon-s-order"></i>
                        </div>
                        <span class="el-col---title">{{t('home.order')}}</span>
                        <div class="el-col---tag">
                            <div class="tag_order">{{Ordertotal}}</div>
                        </div>
                        <i class="el-icon-right"></i>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="7" :xl="7" class="card-col-list el-card" @click="ToRouter()">
                        <div class="el-icon---list-icons awating">
                            <i class="el-icon-s-order"></i>
                        </div>
                        <span class="el-col---title">{{t('home.Awaiting')}}</span>
                        <i class="el-icon-right"></i>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8" :lg="7" :xl="7" class="card-col-list el-card" @click="ToRouter('/index/Notifications')">
                        <div class="el-icon---list-icons notificationgs">
                            <i class="el-icon-message-solid"></i>
                        </div>
                        <span class="el-col---title"> {{t('home.Notifications')}}</span>
                        <i class="el-icon-right"></i>
                    </el-col>
                </el-row>

                <div class="flex align-center justify-between flex-title--list">
                    <div class="el-golder-title">Total Sales</div>
                    <el-col :xs="24" :sm="24" :md="10" :lg="7" :xl="6" >
                        <div class="el-date--picke">
                          <el-date-picker
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
                    </el-col>
                    
                </div>
                <el-row class="flex align-center justify-between">
                    <el-col :xs="24" :sm="24" :md="14" :lg="15" :xl="17" class="el-card panel-body--list">
                        <div class="panel-body" id="panelecharts">
                            <echart ref="chart" :option="option"></echart>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="10" :lg="7" :xl="6" class="panel-body--list-right">
                        <el-col class="flex align-center justify-between el-card  planel-bodt--panl planel-bodt-border-bottom">
                            <h3>Overview</h3>
                            <div>
                                <i class="el-icon-s-tools"></i>
                            </div>
                        </el-col>
                        <el-col class=" el-card flex flex-wrap planel-bodt-border-bottom" >
                            <div class="flex align-center justify-between planel-bodt--panl">
                                <div class="">
                                    <span class="dashboard-metrics__label-title"> {{t('home.Sales')}}</span>
                                    <span class="percentage--up">100%</span>
                                </div>
                                <div class="">
                                    <span class="dashboard-metrics__label-title">{{Sales}}</span>
                                    <span class="dashboard-metrics__number-currency">{{t('home.unit')}}</span>
                                </div>
                            </div>
                            <div class="flex align-center justify-between  planel-bodt--panl">
                                <div class="">
                                    <span class="dashboard-metrics__label-title">{{t('home.Orders')}}</span>
                                    <span class="percentage--up">100%</span>
                                </div>
                                <div class="">
                                    <span class="dashboard-metrics__label-title">{{orders}}</span>
                                    <!-- <span class="dashboard-metrics__number-currency">{{t('home.unit')}}</span> -->
                                </div>
                            </div>
                        </el-col>
                        <el-col class="flex align-center justify-between el-card  planel-bodt--panl planel-bodt-border-bottom">
                           <div class="flex align-center justify-between planel-bodt--panl-list">
                                <div class="">
                                    <span class="dashboard-metrics__label-title">{{t('home.Costs')}}</span>
                                    <i class="el-icon-warning"></i>
                                    <span class="percentage--up">100%</span>
                                </div>
                                
                                <div class="">
                                    <span class="dashboard-metrics__label-title">{{Cost}}</span>
                                    <span class="dashboard-metrics__number-currency">{{t('home.unit')}}</span>
                                </div>
                            </div>
                        </el-col>
                        <el-col class="flex align-center justify-between el-card planel-bodt--panl">
                           <div class="flex align-center justify-between planel-bodt--panl-list" >
                                <div>
                                    <span class="dashboard-metrics__label-title">{{t('home.Earnings')}}</span>
                                    <span class="percentage--up">100%</span>
                                </div>
                                <div>
                                    <span class="dashboard-metrics__label-title">{{Earnings}}</span>
                                    <span class="dashboard-metrics__number-currency">{{t('home.unit')}}</span>
                                </div>
                            </div>
                        </el-col>
                    </el-col>
                </el-row>
                <el-row>
                      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" class="panel-footer">
                          <div class="panel-header"><h3><span>{{t('home.topitem')}}</span></h3></div>
                          <div class="panel-context--list">
                              <div class="panel--list-table">
                                  <span class="panel-footer-title">{{Topitem.total}}</span>
                                  <!-- <img :src="Topitem.src"> -->
                                  <div class="table-img">
                                      <el-image :src="Topitem.src"></el-image>
                                  </div>
                                  <div class="panel-footer--name">
                                      <a>{{Topitem.name}}</a>
                                  </div>
                                  <!-- <span class="dashboard-table-item__pieces">30 Pieces</span> -->
                                  <span class="dashboard-table-item__total">
                                      <span><span class="number-value">{{Topitem.total_sales}}</span> <span class="number-currency muted-text">{{t('home.unit')}}</span></span>
                                      <!-- <span title="Old value: 0{{t('home.unit')}}; Diff: 3635{{t('home.unit')}}" class="percentage dashboard-table-item--mobile percentage--up">100%</span> -->
                                  </span>
                                  <span class="dashboard-table-item__end">
                                      <div style="width:130px;">
                                          <echart  :height="150"  ></echart>
                                      </div>
                                  </span>
                              </div>
                          </div>
                      </el-col>
                </el-row>
        </el-main>
    </el-container>
</template>

<script>
import { defineComponent, reactive,ref,computed,onMounted,toRefs, watch} from "vue"
import Sidebar from "../../../components/Loyout/Sidebar/Sidebar.vue"
import ProjectTag from '../../../components/ProjectTag/ProjectTag.vue'
import Echart from "../../../components/echart/index.vue"
import { useStore } from "vuex"
import router from "../../../router"
import { GetStatistics } from "../../../api/Home"
import i18n from "../../../locale"
import { getLocalTime, isNaLL } from "../../../utils/utils"
import { useRoute ,onBeforeRouteUpdate} from 'vue-router'
import { shoElmessage } from "../../../utils/Elmessage"

export default {
    components:{
        Sidebar,
        ProjectTag,Echart
    },
    mounted(){
        this.GetTotalSales();
       
    },
    
    setup(props,context){
        const store = useStore();
        const route = useRoute();
        // store.dispatch('storeshop/setShopId',route.query.id)

        const dateTime = ref();
        const defaultTime = ref([
            new Date(2000, 1, 1, 0, 0, 0),
            new Date(2000, 2, 1, 23, 59, 59),
        ])
        
        const data = reactive({
            shop_id:route.query.id,
            start_time:"", //开始时间
            end_time:"", //结束时间
            t:i18n.global.t,
            Ordertotal:0,
            Sales:0,
            Cost:0,
            orders:0,
            Earnings:0,
            Topitem:{
                
            },
            value:[new Date(2000, 10, 10, 10, 10), new Date(2000, 10, 11, 10, 10)],
            TagStyle:{
                'border-radius':'10px',
                'background-color':'rgb(108,253,180)',
                'font-weight':'bold'
            },
            option:{
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '9%',
                    right: '9%',
                    bottom: '9%',
                    containLabel: false
                },
                //是否可以下载
                // toolbox: {
                //   feature: {
                //     saveAsImage: {}
                //   }
                // },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    
                ]
            }
        })
        function ToRouter(path){
            if(path == '/index/Products'){
                return shoElmessage(true,'等待完善','info')
            }
            router.push({
                path:"/shop/Orders",
                query:{
                    id:data.shop_id
                }
            })

            // router.push({path})
        }
        return {
            ...toRefs(data),
            defaultTime,
            dateTime,
            ToRouter,
            mode:computed(() => store.state.setting.device.mode)
        }
    },
     methods:{
        PickerChange(e){
            if(isNaLL(e)){
                let starttime = getLocalTime(this.dateTime[0].getTime());
                let endtime = getLocalTime(this.dateTime[1].getTime());
                this.start_time = starttime;
                this.end_time = endtime

                // console.log(this.start_time,this.end_time);
                this.GetTotalSales();
            }else{
                this.start_time = "";
                this.end_time = ""
            }
        },
        GetTotalSales(){
            GetStatistics({
                shop_id:this.shop_id,
                start_time:this.start_time,
                end_time:this.end_time,
            }).then((res) =>{
                if(res.code == 1){
                    this.option.xAxis.data = res.data.senveDateTime
                    this.option.series = [
                        {
                            name: 'Cost',
                            type: 'line',
                            stack: 'Total',
                            data: res.data.orderCostData
                        },
                        {
                            name: 'Price',
                            type: 'line',
                            stack: 'Total',
                            data: res.data.orderPriceData
                        },
                        {
                            name: 'Profit',
                            type: 'line',
                            stack: 'Total',
                            data: res.data.orderProfitData
                        }
                        
                    ]
                    this.$refs.chart.init(this.option);
                    this.Ordertotal = res.data.order_count 
                    this.Sales = res.data.total_sales_percent
                    this.Cost  = res.data.total_cost_percent
                    this.orders = res.data.total_orders_percent
                    this.Earnings = res.data.total_profit_percent
                    this.Topitem = res.data.top_item
                }
                

            })
        }
    },
}
</script>

<style scoped lang="scss">
*{
    box-sizing: border-box;
}

h3{
    margin-bottom: 0px;
    margin-top: 0px;
}
.card-col-list{
    width: 100%;
    // height: 100%;
    padding: 10px 10px;
    color: #6f6f91;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    cursor: pointer;
    .el-icon-s-order,.el-icon-message-solid{
        font-size: 25px;
    }
    i{
        font-size: 20px;
        font-weight: bold;
    }
}
.el-icon---list-icons{
    padding: 20px 20px;
    background-color: var(--el-color-primary);
    color: #fff;
    border-radius:5px;
    transition: all 0.8s;
    i{
        transition: all 0.8s;
    }
}

.awating{
    background-color: var(--el-color-danger);
}
.notificationgs{
    background-color: var(--el-color-success);
}
.card-col-list:hover{
    color: #000000;
    .el-icon---list-icons{
        i{
            transition: all 0.8s;
            transform: scale(1.5);
        }
    }
}
.el-card-list{
    width: 100%;
    height: auto;
}
.el-col---list{
    width: 100%;
    justify-content: space-between;
}
.el-icon-right{
    margin-right: 20px;
}
.el-col---tag{
    min-width: 10px;
    margin-right: 20px;
    .tag_order{
        border-radius: 50%;
        width: 20px;
        height: 20px;
        background-color: #fd4f4f;
        text-align: center;
        color: #fff;
        line-height: 20px;
        font-size: 12px;
    }
    .projecttag{
        margin-top: 0px;
        text-align: center;
        border-radius: 50px;
    }
}
.el-col---title{
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;
    flex: 10;
    margin-left: 8px;
}


.flex-title--list{
    width: 100%;
    padding-top: 12px;
    padding-bottom: 12px;
    
    .el-golder-title{
        font-size: 14px;
        color: #272742;
        font-weight: bold;
    }
}


.panel-body-right{
    height: 100%;
    background-color: #fff;
}
.panel-body--list{
    border-bottom: 1px solid #e5e5ec;
    border-radius: 0px;
    h3{
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
    }
    
}
.planel-bodt--panl{
    width: 100%;
    padding: 16px 24px;
    border: none;
        i{
            margin-right: 5px;
        }
}

.planel-bodt-border-bottom{
    border-radius: 0px;
    border: none;
    border-bottom: 1px solid #e5e5ec
}
.planel-bodt--panl-list{
    width: 100%;
    
}
.panel-body--list-right{
    clear: both;    
    height: 450px;
    background-color: #fff;
    position: relative;
    border:none;
}
.planel-bodt--pan{
    width: 100%;
    padding: 16px 0px;
}
.dashboard-metrics__label-title{
    margin-right: 8px;
    font-weight: 600;
    // color: #272742;
}
.percentage--up{
    font-weight: 600;
    font-size: 15px;
    line-height: 20px;
    letter-spacing: .02em;
    color: #46802a;
}
.percentage--up::before{
    content: "▲";
    margin-right: 4px;
    vertical-align: top;
}
.dashboard-metrics__number-currency{
    font-weight: 600;
    margin-left: 4px;
}





// footer
.panel-footer{
    background-color: #fff;
    margin-top:20px;
}
.panel-header{
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    color: #272742;
    position: relative;
    padding: 24px 24px 8px 24px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}
.panel-context--list{
    display: flex;
    flex-flow: column nowrap;
    padding: 16px;
}
.panel--list-table{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-flow: row nowrap;
    padding: 8px 0;
    width: auto;
    font-size: 12px;
    flex-wrap: wrap;
    .table-img{
        margin: 0 24px;
        width: 80px;
        border-radius: 3px;
    }
}
.panel-footer-title{
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    color: #272742;
    padding-left: 12px;
}
.panel-footer--name{
    display: flex;
    align-items: center;
    font-size: 12px;
    flex-grow: 4;
    flex-basis: 0;
    a{
        font-weight: normal;
        font-size: 14px;
        // line-height: 20px;
        padding: 1px;
        letter-spacing: normal;
        text-transform: initial;
        // -webkit-text-decoration-line: underline;
        text-decoration-line: underline;
        color: #62628d;
        background: transparent;
        display: inline-block;
        cursor: pointer;
        flex-grow: 4;
        flex-basis: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 100px;
        display: -webkit-box;
        height: 39.2px;
        line-height: 20px;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: initial;
    }
}
.dashboard-table-item__pieces{
    font-family: "Inter",sans-serif;
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 20px;
    text-decoration-line: none;
    letter-spacing: normal;
    text-transform: initial;
    -webkit-text-size-adjust: none;
    color: #272742;
    flex-grow: 1;
    flex-basis: 0;
    text-align: end;
    white-space: nowrap;
}
.dashboard-table-item__total{
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;
    color: #272742;
    flex-grow: 1;
    flex-basis: 0;
    text-align: end;
}
.dashboard-table-item__end{
    position: relative;
    text-align: end;
    white-space: nowrap;
    line-height: 20px;
    padding: 0 12px 0 16px;    
}
.el-date--picke{
    width: 100%;
}
:deep(.el-range-editor.el-input__inner){
    width: 100%;
}
@media only screen and(max-width:'990px'){
    .el-golder-title{
        margin-bottom: 10px;
    }
    .flex-title--list{
        flex-wrap: wrap;
        width: 100%;
    }
    .dashboard-table-item__end{
        padding: 16px;
    }
}
.el_header--bg{
    background-color: #fff;
}
</style>