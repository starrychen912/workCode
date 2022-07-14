<template>
  <el-container>
    <el-row style="width:100%">
    <el-col :xs="24" :sm="24" :md="24" :lg="17" :xl="18">
            <el-header>
                <sidebar LogoName="AliExpress">
                    <template #Seacrch>
                        <div class="el-dropdown" aria-describedby="el-popper-4906">
                            <div class="flex align-center" :class="[data.Searceinput?'el--input':'el--input---input']">
                                <el-input v-model="data.Searchkey" placeholder="Search product" @blur="InputBlur" @focus="InputFocus" >
                                    <template #prefix>
                                    <i class="el-input__icon el-icon-search"></i>
                                    </template>
                                    <template #append v-if="data.Searceinput">
                                        <el-button type="primary" >SEARCH</el-button>
                                    </template>
                                </el-input>
                                <div class="filters--search flex align-center" @click="Opendrawer()">
                                    <i class="el-input__icon el-icon-s-operation"></i>
                                    <span>Filters</span>
                                </div>
                            </div> 
                        </div>
                    </template>
                    <template #pav>
                        <div class="filters--pav" @click="Opendrawer()" >
                            <i class="el-input__icon el-icon-s-operation"></i>
                            <span>Filters</span>
                        </div>
                    </template>
                </sidebar>
            </el-header>
            <el-main>
                 <div class="empty_list" v-if="data.cardlist.length === 0">
                     <img src="@/assets/svg/empty.svg">
                     <div class="empty---title">you order is empty！！！</div>
                 </div>
                 <div class="header" v-else>
                        <div class="header-checkbox">
                            <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
                        </div>
                        </div>
                        <div class="el_card_l-context"  v-loading="data.loading">
                            <el-card class="el_card-list" v-for="(item,index) in data.cardlist" :key="index" :class="{'el_card-border':index == data.index}" @click="Elclick(index)">
                                <div class="el_card-checkbox disabled"  :class="{'hidedisabled':data.hidedisabled}">
                                    <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange"></el-checkbox>
                                </div>
                                <div class="block">
                                    <el-image fit="fill" src="https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg"></el-image>
                                </div>
                                <div class="block-text-content">
                                    <div>Vnazvnasi 2020 Yoga Set Leggings And Tops Fitness SportsSuits Gym Clothing Yoga Bra And Seamless Leggings RunningTops And Pant</div>
                                    <span>by Vnazvnasi Official Store (AliExpress)</span>
                                    <li v-if="false">13 unavailable variants</li>
                                </div>
                                <div class="block-price" >
                                    <div class="Price-view">
                                        <div>Shopify Price:$24.00~$28.00</div>
                                        <div>Cost:$24.00~$28.00</div>
                                    </div>
                                    <i class="el-icon-arrow-right" data-v-47142436="" data-v-33068c4e=""></i>
                                </div>
                            </el-card>
                        </div>
                        <div class="pagination-block">
                            <el-pagination
                                v-model:currentPage="data.currentPage4"
                                :page-sizes="[100, 200, 300, 400]"
                                :page-size="100"
                                layout="total, sizes, prev, pager, next, jumper"
                                :total="400"
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                v-if="data.cardlist.length != 0"
                            >
                        </el-pagination>
                    </div>
            </el-main>
          </el-col>
        <el-col :xs="0" :sm="0" :md="0" :lg="7" :xl="6" style="height: 100%;overflow:hidden auto;" >
            <products-detail ></products-detail>
        </el-col>
        </el-row>
            <el-drawer
                v-model="data.drawer"
                title="Filter my products"
                :direction="data.direction"
                :before-close="handleClose"
            >
                <div class="el_drawer-context">
                    <div class="el_drawer-header">Status</div>
                    <el-radio-group v-model="data.Status">
                        <el-radio :label="1">All</el-radio>
                        <el-radio :label="2">Removed from Shopify</el-radio>
                        <el-radio :label="3">Gone from supplier</el-radio>
                    </el-radio-group>
                </div>
                <div class="el_drawer-context">
                    <div class="el_drawer-header">Price updates</div>
                    <el-radio-group v-model="data.Price">
                            <el-radio :label="'All'">All</el-radio>
                            <el-radio :label="'ON'">ON</el-radio>
                            <el-radio :label="'Off'">Off</el-radio>
                    </el-radio-group>
                </div>
                <div class="el_drawer-context" style="position: absolute;bottom:0px;">
                    <el-button type="info" :disabled="!Disdisabled">Clear all filters</el-button>
                    <el-button type="primary" @click="handleClose">DONE</el-button>
                </div>
        </el-drawer>
        <el-drawer
                v-model="drawrstatus"
                title="Filter my products"
                :direction="data.direction"
                :before-close="DetailClose"
                size="50%"
            >
               <products-detail></products-detail>
        </el-drawer>     
  </el-container>
</template>

<script>
import { computed, reactive, watch,onMounted } from 'vue';
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue';
import ProductsDetail from './ProductsDetail.vue';
import { useStore } from 'vuex';
import { GetshopifyProdutList } from '../../api/shopifyProdutList';
import { GetProductlist } from '../../api/Porductapi';


export default {
    components:{
        Sidebar,
        ProductsDetail
    },
     setup(){
        const store = useStore();
        onMounted(()=>{
            GetshopifyProdutListbtn();
            GetProductlists();
        })
        let data = reactive({
            keyword:"",
            currentPage4:1,
            drawerdetail:true,
            drawer:false,
            direction:'rtl',
            Price:'All',
            Status:1,
            hidedisabled:false,
            index:0,
            cardlist:[{},{},{}],
            loading:false,
            Searceinput:false,
            Searchkey:""
        });
        const drawrstatus = computed(() =>{
            return store.state.setting.detailcollapse 
        })
        const handleSizeChange = (val) => {
            console.log(`${val} items per page`)
        }
        const handleCurrentChange = (val) => {
            console.log(`current page: ${val}`)
        }
        function Opendrawer(){
            data.drawer = !data.drawer
        }
        let Disdisabled = computed(()=>{
            return data.Price != 'All' || data.Status != 1
        })
        function Elclick(index){
            data.index = index
            if(!store.state.app.collapse){
                data.drawerdetail = !data.drawerdetail
            }
            
        }
        function GetProductlists(){
            GetProductlist({}).then(res =>{
                console.log(res);
                if(res.code == 1){
                    console.log(res);
                }
            })
        }
        function DetailClose(){
            store.commit('setting/SAVE_SETTINGS',{detailcollapse:!store.state.setting.detailcollapse})
        }
        function GetshopifyProdutListbtn(){
            data.loading = true
            GetshopifyProdutList({}).then(res => {
                if(res.code == 1){
                    data.loading = false
                    data.cardlist = res.data
                }
            })
        }
        function InputFocus(){
            data.Searceinput = true
        }
        function InputBlur(){
            
            data.Searceinput = false
        }
        return {
            DetailClose,
            Elclick,
            GetProductlists,
            Opendrawer,
            Disdisabled,
            data,
            handleCurrentChange,
            handleSizeChange,
            drawrstatus,
            InputBlur,
            InputFocus
        }
    },
    methods:{
        handleClose(open){
           this.data.drawer = !this.data.drawer
        }
        
        
    }

}
</script>

<style lang="scss" scoped>
.el_card_l-context{
    margin-top: 20px;
}
.pagination-block{
    text-align: right;
    margin-top: 10px;
}
.el-header{
    height: auto;
    padding-bottom: 10px;
}
.header{
    text-align: left;
}
:deep(.el_card-list){
    box-shadow: none;
    border: none;
    border-bottom: 1px solid var(--el-card-border-color);
}
:deep(.el-card){
    border-radius: 0px;
}
:deep(.el_card-list .el-card__body){
    display: flex;
    align-items: flex-start;
    padding: 20px !important;
    position: relative;
    border-radius: 0px;
    .block{
        width: 60px;
        height: 60px;
        border-radius: 2px;
        .el-image{
            width: 100%;
            height: 100%;
            border-radius: 2px;
        }
    }
    .block-text-content{
        width: 70%;
        height: 100%;
        text-align: left;
        margin-left: 10px;
        span{
            color:rgb(124, 124, 124)

        }
        li{
            margin-top: 10px;
            color: #ff7600;
        }
    }
    .block-price{
        width: 30%;
        height: auto;
        text-align: right;
        display: none;
        justify-content: flex-end;
        i{
            padding-top: 2px;
            margin-left: 20px;
        }
    }
}
.el_card-list:hover{
    background-color: rgb(240, 240, 240);
}
.el_card-border{
    outline: #70cbdf;
    outline-style: solid;
    outline-width: 3px;
    outline-offset: -1px;
}
.el_card-border:hover{
    background-color:  #f6fdff;
    border-radius: 0px;
}
  .header{
    text-align: left;
    .list{
        display: flex;
        align-items: center;
        height: 50px;
        padding:0px 20px;
        border-bottom: 1px solid rgb(218, 218, 218);
    }
}



.filters--search,.filters--pav{
    line-height: 48px;
    padding: 0 16px;
    cursor: pointer;
    display: flex;
    span{
        margin-left: 4px;
        font-weight: 600;
    }
}
.filters--search i,.filters--pav i{
    font-size: 22px;
    font-weight: 600;
    line-height: normal;
    display: flex;
    align-items: center;
}




.header-checkbox{
    display: inline;
    width: auto;
    padding: 10px;
    border-radius: 2px;
    background-color: #d9ecff;
    margin-right: 10px;
    border-radius: 3px;
}
.el_card-checkbox{
    position:absolute;
    top:0px;
}

:deep(.el-card__body .el-checkbox){
    height: auto;
}
.disabled{
    display: none;
}
.el_card-list:hover .disabled{
    display: block;
}
.hidedisabled{
    display: block;
}


.el_drawer-header{
    font-size: 18px;
    font-weight: bold;
    color: #272742;
}
.el_drawer-context{
    padding: 24px;
    border-top: 1px solid #e5e5ec;
}
:deep(.el-drawer__body){
    padding: 0px;
}
.el-radio{
    width: 100%;
}

//搜索框
.el--input---input{
     width: 300px;
     transition: all 0.5s;
    :deep(.el-input__inner){
        height: 45px;
        line-height: 45px;
        background-color: rgba(0,0,0,0);
        border: none;
        color: #000;
    }
}
.el--input{
    width: 700px;
    transition: all 0.5s;
    :deep(.el-input__inner){
        height: 45px;
        line-height: 45px;
    }
    .el-input__icon{
        line-height: 45px;
        font-weight: bold;
    }
}

@media only screen and (min-width: 840px){
    .block-price{
        display: flex !important;
    }
}
@media only screen and (max-width: 800px){
    .el-header{
        background-color: #fff;
    }
}


.products_input--secath{
    width: 100%;
    height: 100px;
    margin: 20px 0px;
    padding: 0px 20px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    .el-input{
        width: 80%;
    }
}
.empty_list{
    width: 100%;
    height: 500px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    align-content: center;
    flex-wrap: wrap;
    img{
        width: 50%;
        height: 50%;

    }
    .empty---title{
        width: 100%;
        height: auto;
        text-align: center;
        margin-top: 20px;
        color: var($font-text-color);
        font-weight: bold;
    }
}
:deep(.el-input-group__append){
    background-color: var(--el-color-primary);
    border: none;
    color: #fff;
}
@media only screen and (max-width:1800px){
    .el--input{
        width: 500px;
        transition: all 0.5s;
    }
    .el--input---input{
        width: 300px;
        transition: all 0.5s;
    }

}
@media only screen and (max-width:1600px){
    .el--input{
        width: 450px;
        transition: all 0.5s;
    }
    .el--input---input{
        width: 300px;
        transition: all 0.5s;
    }
}
.filters--search{
    display: none;
}
@media only screen and (max-width:1400px){
    .el-dropdown{
        justify-content: flex-end;
    }
    .el--input{
        width: 100%;
        transition: all 0.5s;
    }
    .el--input---input{
        width: 30%;
        transition: all 0.5s;
    }
    .filters--search{
        display: flex;
    }
    .filters--pav{
        display: none;
    }
}
@media only screen and (max-width:600px){
    .el--input{
        width: 100%;
        transition: all 0.5s;
    }
    .el--input---input{
        width: 100%;
        transition: all 0.5s;
    }
}
</style>