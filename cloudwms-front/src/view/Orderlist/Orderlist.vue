<template>
  <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }">
          <sidebar LogoName="待导入产品列表">
                <template #Seacrch>
                    <search class="search-input" :value="keyword"  @inputketup="keyword = $event" @InputBlur="keyword = $event"  >
                        <template #append>
                            <el-button icon="el-icon-search" type="primary" @click="OptionsClick">搜索</el-button>
                        </template>
                    </search>
                </template>
          </sidebar>
      </el-header>
      <el-main>
          <div class="el-checkbox-all" v-if="productlist.length != 0">
                <div class="flex align-center">
                    <div class="el-checkbox--i">
                        <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange"></el-checkbox>
                        <!-- <span></span> -->
                    </div>
                    <!-- <el-button  size="small" type="primary" @click="ADDby">
                        <i class="el-icon-plus"></i>
                        <span>ADD BY URL OR ID</span>
                    </el-button> -->
                </div>
                <el-button class="EL-BUTTON-DELETE" size="small" type="danger" @click="DELETE" v-if="shotime">
                    <i class="el-icon-delete"></i>
                    <span>DELETE</span>
                </el-button>
            </div>
            <div v-if="productlist.length == 0" class="empty-main" >
                <el-card class="el-ekelection" v-if="!skeleton">
                    <el-skeleton :rows="10" animated  />
                </el-card>
                <empty content="产品列表为空~" v-else></empty>
            </div>

            <el-card v-for="(item,index) in productlist" :key="index" style="margin-bottom: 20px;" v-else>
                    <orderlisttype 
                    @Actice="OrderClick(e)" 
                    :checkboxList="checkedCities" 
                    :itemdata="item" 
                    :Acindex="index" 
                    @DeleteProduct="DeleteProduct(index,item.id)" 
                    @handChange="handChange" 
                    @InportToStroe="InportToStroe"
                    ref="listtype"
                    ></orderlisttype>
            </el-card>   
            
                  
     </el-main>
     <div class="pagination">
         <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page="currentpage"
                :page-sizes="[10, 50, 100, 200,300,400,500]"
                :page-size="pagesize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
            </el-pagination>
     </div>       
  </el-container>
        <el-dialog
                v-model="dialogVisible"
                title="Add product by URL or ID"
                width="30%"
                :before-close="handleClose"
            >
                <el-input v-model="input" placeholder="Please input" />
                <template #footer>
                    <el-button type="info" @click="CANCEL">CANCEL</el-button>
                    <el-button type="primary">ADD PRODUCT</el-button>
                </template>
        </el-dialog>
</template>

<script>
import { Porductlist } from '@/api/introducedProductlist'
import { computed, reactive,provide } from 'vue';
import { useStore } from 'vuex';
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue';
import Orderlistcontext from './Orderlistcontext.vue';
import OrderlistImages from './OrderlistImages.vue';
import OrderlistPricing from './OrderlistPricing.vue';
import Orderlisttype from './Orderlisttype.vue';
import OrderlistwangEditor from './OrderlistwangEditor.vue';
import OrderVariants from './orderVariants.vue';
import { DeleteImportList } from '../../api/Porductapi';
import { shoElmessage } from '../../utils/Elmessage';
import Search from '../../components/Search/Search.vue';
import { interobj ,interfalse,interCheckall,interlll,GetDeleteProductIdList} from '../../utils/utils';
import Empty from '../../components/empty/index.vue';

export default {
  components: { Sidebar, Orderlisttype, Orderlistcontext, OrderVariants, OrderlistPricing, OrderlistwangEditor, OrderlistImages, Search, Empty },
  setup(props,context){
      const store = useStore();
      provide:[]
      return {
          mode:computed(() => store.state.setting.device.mode),
      }
  },
  computed:{
      shotime(){
          return interlll(this.checkedCities);
      }
  },
  watch:{
      checkedCities(newold,odl){
          if(interlll(newold)){
             this.checkAll = false
             this.isIndeterminate = true;
            if(interCheckall(newold)){
                this.checkAll = true
                this.isIndeterminate = false;
            }
          }else{
              this.checkAll = false
              this.isIndeterminate = false;
          }
      }
  },
  data(){
        return{
            skeleton:false,
            isIndeterminate:false,
            checkAll:false,
            activeName: 'second',
            formLabelAlign:{
                name:""
            },
            isActive:0,
            dialogVisible:false,
            input:'',
            productlist:[],
            checkedCities:{},
            data:{},
            keyword:"",

            total:100,
            pagesize:10,
            pagecount:10,
            currentpage:1,
        }
    },
    created(){
        this.GetPorductlist();
    },
    methods:{
        handChange(e){
            this.checkedCities = JSON.parse(JSON.stringify(e));
        },
        CANCEL(){
            console.log(this.checkedCities);
        },
        InportToStroe(e){
            this.GetPorductlist();
        },
        DeleteProduct(index,id){
            DeleteImportList({import_ids:id}).then(res => {
                if(res.code == 1){
                    this.productlist.splice(index,1)
                    shoElmessage(true,'删除成功','success')
                }else{
                    shoElmessage(true,`添加失败，原因：${res.msg}`,'error')
                }
            })
            
        },
        DELETE(){
            let productlistid = GetDeleteProductIdList(this.checkedCities);
            
            DeleteImportList({import_ids:productlistid}).then(res => {
                if(res.code == 1){
                    let array = [];
                    let obj = {};
                    for(let i=0; i<this.productlist.length;i++){
                        if(!this.checkedCities[this.productlist[i].id]){
                            array.push(this.productlist[i]);
                            obj[this.productlist[i].id] = false
                        }
                    }
                    this.productlist = array;
                    this.checkedCities = obj
                    shoElmessage(true,'删除成功','success')
                }else{
                    shoElmessage(true,`添加失败，原因：${res.msg}`,'error')
                }
            })
        },
        GetPorductlist(){
            Porductlist({
                page_num:this.currentpage,
                per_page_num:this.pagesize
            }).then(res =>{
                if(res.code == 1){
                    this.skeleton = true
                    let list  = res.data.data
                    this.total = res.data.total
                    this.pagesize = res.data.size
                    this.currentpage = res.data.cur
                    list.forEach(element => {
                        if(element.variants != undefined && element != null){
                            element.variants.unshift({});
                        }
                    });

                    this.productlist = list
                    this.checkedCities = interfalse(list,'id');
                }
            })
        },
        handleSizeChange(e){
            this.pagesize = e;
            this.GetPorductlist();
        },
        handleCurrentChange(e){
            this.currentpage = e;
            this.GetPorductlist();
        },
        ADDby(){
            this.dialogVisible = true
        },
        handleClose(){
            this.dialogVisible = false
        },
        handleCheckAllChange(val){
            if(val){
                this.checkedCities = {...interobj(this.productlist,'id')}
            }else{
                this.checkedCities = {...interfalse(this.productlist,'id')}
            }
            this.isIndeterminate = false;
            this.checkAll  = val
        },
        OrderClick(e){
            console.log(123456);
        },
        // 搜索
        OptionsClick(){

        }
    }
}
</script>

<style lang="scss" scoped>
.el-main{
    :deep(.el-button){
      margin-left: 10px;
    }
}

:deep(.el-card__body){
    padding: 0px;
    display: block;
    box-sizing: border-box;
}

 .el-checkbox-all{
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 10px;

}

:deep(.el-button--info){
    span{
        font-weight: bold;
    }
    i{
        font-weight: bold;
    }
}
  

  //全选
 
.el-checkbox--i{
    display: flex;
    align-items: center;
    justify-content: space-between;
    
    .el-checkbox{
        height: 30px;
        padding: 0px 20px;
        background-color: #d9ecff;
        margin-right: 10px;
        border-radius: 3px;
        :deep(.el-checkbox__inner){
            border: #d9ecff;
        }
    }
    span{
        width: 2px;
        height: 30px;
        background-color: #8cc5ff;
        display: block;
    }
  }
 .page-layout__header{
     margin-top: 10px;
     padding: 0px 10px;
 }
.el-ekelection{
    padding: 20px;
}

@media only screen and(max-width:1400px){
        .el-header{
            height: auto;
            padding:0px 20px 20px 20px;
            .header{
                display: grid;
                grid-template-columns: auto auto;
                grid-gap: 4px;
            }
            
            .search-input{
                grid-column: 1/span 3;
                order: 3;
                display: flex;
                align-items: center;
                box-sizing: border-box;
            }
            :deep(.SidebarUser){
                grid-column: 3/span 1;
                order: 2;
                margin-left: 0;
                justify-content: flex-end;
            }
        }
        .el-main{
            padding: 20px;
            margin-top: 20px;
            &::-webkit-scrollbar{
                display: none;
            }
        }
       
}
@media only screen and(max-width:400px){
    .el-checkbox-all{
        flex-wrap: wrap;
        .EL-BUTTON-DELETE{
            margin-left: 0px;
        }
    }
    .el-header{
        :deep(.navigation){
            grid-column: 1/span 2;
            order: 1;
            justify-content: flex-start;
        }
    }
}
.EL-BUTTON-DELETE{
    opacity: 1;
    animation: fillmode 0.5;
}
@keyframes fillmode {
    0%{
        opacity:0;
    }
}
.empty{
    width: 100%;
    height: 500px;
    box-sizing: border-box;
    text-align: center;
    padding-top: 250px;
    
    img{
        width: 100px;
        height: 100px;
    }
    .empty--title{
        width: 100%;
        text-align: center;
        padding: 20px;
        color: #c2c2c2;
    }
}
.empty-main{
    height: 80vh;
}
.pagination{
    padding:10px 20px ;
}
</style>