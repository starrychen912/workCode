<template>
  <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }">
          <sidebar LogoName="店铺管理"></sidebar>
      </el-header>
      <el-main>
         <el-row span="24" class="shop-list flex align-between justify-between flex-wrap" >
              <el-col :xs="24" :sm="11" :md="11" :lg="7" :xl="7">
                  <div  class="shop_type--list">
                    <div class="store_shop--list" @click="AddStoreshop('add')">
                        <div class="store_shop_list-title">
                            <svg width="180" height="180" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="50" height="50" fill="white" fill-opacity="0.01"/><path d="M24.0607 10L24.024 38" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M10 24L38 24" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                        </div>
                    </div>
                    <div style="margin-top:40px">
                      <div class="shop-title">新建店铺</div>
                      <div class="shop-visibility">新增每一个店铺，就代表你能多开一家店多赚一份钱</div>
                    </div>
                  </div>
              </el-col>
              <el-col :xs="24" :sm="11" :md="11" :lg="7" :xl="7" v-for="(item,index) in datalist" :key="index">
                  <div  class="shop_type--list">
                      <div class="shop_list-store">
                          <div class="shop_logo">
                            <div class="shop_list-logo">
                                <i class="el-icon-s-shop" v-if="item.type == 'self'" ></i>
                                <img v-if="item.type == 'shopify'" src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25 28'%3e%3cpath fill='%2395BF47' fill-rule='evenodd' d='M17.836 27.059l-.062-23.736c-.16-.16-.472-.112-.594-.076l-.813.252a5.675 5.675 0 00-.39-.957c-.576-1.1-1.42-1.682-2.44-1.683h-.003c-.068 0-.136.006-.204.012h-.008a2.234 2.234 0 00-.092-.105C12.786.29 12.216.059 11.533.079c-1.318.038-2.63.99-3.693 2.679-.75 1.19-1.318 2.683-1.48 3.84L3.767 7.4c-.764.24-.788.263-.888.982C2.803 8.928.806 24.377.806 24.377l16.743 2.895.287-.213zM12.35 1.163a1.347 1.347 0 00-.792-.208c-2.033.06-3.807 3.235-4.26 5.352l1.949-.604.347-.107c.255-1.344.896-2.738 1.733-3.636a3.821 3.821 0 011.023-.797zm-1.793 4.135l2.796-.866c.009-.728-.07-1.805-.435-2.565-.388.16-.715.44-.95.691-.628.675-1.14 1.705-1.41 2.74zM14.23 4.16l1.299-.403c-.208-.674-.7-1.805-1.7-1.994.311.802.391 1.73.4 2.397z' clip-rule='evenodd'/%3e%3cpath fill='%235E8E3E' d='M21.587 5.088c-.099-.008-2.035-.037-2.035-.037s-1.619-1.573-1.778-1.733a.399.399 0 00-.225-.103v24.053l7.256-1.804S21.844 5.447 21.825 5.31a.263.263 0 00-.238-.222z'/%3e%3cpath fill='white' d='M13.528 8.824l-.843 3.153s-.94-.429-2.054-.358c-1.635.103-1.652 1.134-1.636 1.392.09 1.41 3.799 1.718 4.008 5.021.163 2.599-1.379 4.376-3.601 4.516-2.667.169-4.135-1.405-4.135-1.405l.565-2.404s1.478 1.115 2.66 1.04c.773-.048 1.05-.677 1.021-1.121-.116-1.84-3.137-1.731-3.328-4.754-.16-2.544 1.51-5.12 5.196-5.353 1.42-.09 2.147.273 2.147.273'/%3e%3c/svg%3e">
                            </div>
                          </div>
                          <div class="shop_list-shopinfo">
                              <div class="shopinfo-title">
                                  <span class="shop-name">{{item.name}}</span> /
                                  <span class="Additional">店铺</span>
                              </div>
                              <div class="shopinfo-adress">
                                  <i class="el-icon-location-information"></i>
                                  {{item.address1}}
                              </div>
                          </div>
                      </div>
                      <div class="shop-info-operating">
                          <div class="shop-info-icon-list" style="background-color:#ff9900" @click="Amazon(item)">
                              <i class="el-icon-question"></i>
                          </div>
                          <div class="shop-info-icon-list" style="background-color:#409EFF" @click="Management(item)">
                              <i class="el-icon-menu"></i>
                          </div>
                          <div class="shop-info-icon-list" style="background-color:#67c23a" @click="EditorShop(item)">
                              <i class="el-icon-edit"></i>
                          </div>
                          <div class="shop-info-icon-list"  @click="CDeleteShop(index,item)">
                              <i class="el-icon-delete"></i>
                          </div>
                      </div>
                  </div>
              </el-col>
              
              <!-- <el-col :xs="24" :sm="11" :md="11" :lg="7" :xl="7"></el-col> -->


         </el-row>
          <!-- <div class="card_store_shop--list">
              <div class="shop--titlt">在线店铺</div>
              <el-table
                :data="datalist"
                border
                style="width: 100%">
                <el-table-column
               
                  prop="name"
                  label="店铺名称"
                  key="1"
                  min-width="150">
                </el-table-column>
                <el-table-column
               
                  prop="type"
                  label="店铺类型"
                  key="2"
                  min-width="150">
                  <template #default="scope">
                    <img :src="`/assets/img/${scope.row.type}.png`" style="width:100%;height:100%;" v-if="scope.row.type != 'self' && baseurl != ''">
                    <img :src="`/src/assets/img/${scope.row.type}.png`" style="width:100%;height:100%;" v-else-if="scope.row.type != 'self'">
                    <text v-else>总店铺</text>
                  </template>
                </el-table-column>
                <el-table-column
                  prop="address1"
                  label="店铺地址"
                  key="3"
                  min-width="120">
                </el-table-column>
                <el-table-column
                  
                  label="操作"
                  key="4"
                  min-width="100">
                  <template #default="scope" >
                    <router-link target="_blank" :to="{path:'/shop/shophome',query:scope.row}" style="color:#fff;">
                        <el-button type="primary"  size="small" @click="Management(scope)" >管理</el-button>
                    </router-link> 
                    <el-button type="primary"  size="small" @click="Management(scope)" >管理</el-button>
                    <el-button type="success"  size="small" @click="EditorShop(scope)" >操作</el-button>
                    <el-button type="danger" size="small" @click="CDeleteShop(scope.$index)" v-if="scope.row.type != 'self'">删除</el-button>
                  </template>
                </el-table-column>
              </el-table>
          </div> -->
      </el-main>
  </el-container>

</template>

<script>
import { computed, onMounted, reactive, toRefs } from 'vue';
import { deleteShop, ShopList } from '../../api/shoplist';
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue';
import router from '../../router';
import { shoElmessage } from '../../utils/Elmessage';
import { ElMessageBox } from 'element-plus'
import { useStore } from 'vuex';
import { netConfig } from '../../config/net.config';
import { getAccessToken } from '../../utils/AccessToken';
import { isNaLL } from '../../utils/utils';


export default {
  components:{Sidebar},
  setup(props,content){
    // console.log(netConfig.ba);
    const store = useStore();
    const data = reactive({
      datalist:[
        
      ],
      baseurl:computed(() => netConfig.baseURL),
      mode:computed(() => store.state.setting.device.mode)
    })
    function AddStoreshop(e){
       if(e == 'add'){
         router.push({path:'/index/Addstoreshop'})
       }else{
         shoElmessage(true,'你太急啦')
       }
    }
    onMounted(() =>{
      GetShoplist();
    })
    function GetShoplist(){
        ShopList({}).then(res =>{

          if(res.code == 1){
              data.datalist = res.data
          }
        })
    }
    function EditorShop(item){
      router.push({path:'/index/Addstoreshop',query:{
        ...item
      }})
    }
    function Amazon(item){
      console.log(item);
       let shophome = router.resolve({path:"/Amazonshop/index",query:item})
        window.open(shophome.href,'_blank');
    }
    //店铺管理
    function Management(item){
       let Authentication = store.getters['userinfo/Authentication']
       store.dispatch('storeshop/setShopId',item)
       console.log(store.getters['storeshop/shop_id']);
      if(Authentication){
          let shophome = router.resolve({path:"/shop/shophome",query:{...item}})
          window.open(shophome.href,'_blank');
      }else{
          if(!isNaLL(store.getters['userinfo/accessToken'])){
            return shoElmessage(true,'token是空，跳转这里有点问题','error')
          }
          let data = {...item,token:store.getters['userinfo/accessToken']}
          let shophome = router.resolve({path:"/shop/shophome",query:data})
          window.open(shophome.href,'_blank');
      }
    }
    function CDeleteShop(index,item){
        if(item.type == 'self'){
          return shoElmessage(true,'自我店铺不能删除','error')
        }
        ElMessageBox.confirm(
          `你确定删除${data.datalist[index].name}店铺`,
          '删除店铺',
          {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }
        ).then(res =>{
            deleteShop({
              shop_id:data.datalist[index].id
            }).then(res =>{
              if(res.code === 1 ){
                  data.datalist.splice(index,1)
                  shoElmessage(true,'删除成功')
              }else{
                  shoElmessage(true,`删除失败,原因：${res.msg}`)
              }
            })
        }).catch((error) =>{
            shoElmessage(true,'已取消','error')
        })
    }
    function GetImgItem(item){
        if(item.type == 'shopify'){
          return '@/assets/img/shopfilylse.png'
        }else if(item.type == 'amazon'){
          return '@/assets/img/amazion123.png'
        }
    }
    return{
      AddStoreshop,
      GetShoplist,
      ...toRefs(data),
      EditorShop,
      CDeleteShop,
      Management,
      GetImgItem,
      Amazon
    }
  }
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.shop_type--list{
  background-color: #fff;
  min-height: 405px;
  box-shadow:0 0 20px 0 rgba(207, 213, 226, 0.6),0 2px 4px 0 rgba(209, 214, 228, 0.5);
  border-radius: 13px;
  padding: 40px;
  cursor: pointer;
  margin-top: 20px;
  max-width: 100%;
}
.shop-visibility{
    // height: 40%;
    display: flex;
    align-items: center;
    margin-top: 5px; 
}
.store_shop--list{
    width: 100%;
    height: 60%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-family: 微软雅黑;
    
}
.shop_list-store{
    width: 100%;
    min-height: 120px;
    display: flex;
    flex-wrap: wrap;
    .shop_logo{
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .shop_list-logo{
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background-color: rgba(149, 191, 71,0.5) ;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      img{
          width: 100%;
          height: 100%;
          opacity: 1;
          position: absolute;
          left: 0px;
      }
      i{
          font-size: 100px;
          color: #fff;
      }
    }
    .shop-name{
          word-wrap: break-word;
          word-break: break-all;
          white-space: pre-wrap !important;
        }
    .shop_list-shopinfo{
      flex: 1;
      height: 100%;
      display: flex;
      align-items: center;
      // margin-left: 60px;
      flex-wrap: wrap;
      align-content: center;
      margin-top: 10px;
      .shopinfo-title{
        width: 100%;
        font-size: 25px;
        font-weight: bold;
        text-align: center;
        // span{
        //   word-wrap: break-word;
        //   word-break: break-all;
        //   white-space: pre-wrap !important;
        // }
        .Additional{
          font-size: 18px;
        }
      }
      .shopinfo-adress{
          width: 100%;
          display: flex;
          align-items: center;
          margin-top: 10px;
          font-size: 16px;
          justify-content: center;
          i{
            font-size: 20px;
            margin-right: 5px;
          }
      }
    }
}
.shop-title{
    color: #000;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;  
}
.shop-info-margin{
  width: 40px;
  height: 40px;
  background-color: #ddecfc;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  svg{
    width: 80%;
    height: 80%;
  }
}
.shop-info-icon-list{
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    background-color: #f76464;
    color: #fff;
    transition: all 0.5s;
    margin-left: 10px;
    &:hover{
      background-color: #f88686;
      i{
        transform: scale(1.5);
        transition: all 0.5s;
      }
    }
    i{
        transform: scale(1);
        transition: all 0.5s;
    }
}
.shop-info-operating{
  height: auto;
  width: 100%;
  display: flex;
  justify-content: center;
  // flex-direction: row-reverse;
  margin-top: 40px;
  
}
// .#95bf47

// .shop_type--icon{
//       width: 71px;
//       height: 71px;
//       border-radius: 50%;
//       line-height: 90px;
//       text-align: center;
//       background-image: linear-gradient(to bottom right,#ff6c61,#ff978f);
//       box-shadow: 
//             0 0 4px 0 rgba(255, 108, 97, 0.8);
//       transition: all 0.8s;
//       margin-right: 20px;
//       svg{
//         transition: all 0.8s;
//       }
//       img{
//         transition: all 0.8s;
//       }
//     }
//   .store_shop--list:hover .store_hover svg{
//     transform: scale(1.2) rotate(360deg);
//   }

// .Storeshop-list div:first-child{
//   margin-left: 0px;
// }
// .zise{
//   background-image: linear-gradient(to top left,#a58cfc,#bdaaff);
//   box-shadow: 
//             0 0 4px 0 rgba(165, 140, 252, 0.8); 
// }
// .hse{
//   background-image: linear-gradient(to top left,#ffc95e,#ffd177);
//   box-shadow: 
//             0 0 4px 0 rgba(255, 201, 94, 0.8); 
// }
// .heise{
//   background-image: linear-gradient(to top left,#c1cad6,#d4dae2);
//   box-shadow: 
//             //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
//             0 0 4px 0 rgba(193, 202, 217, 0.8); 
// }
// .lse{
//   background-image: linear-gradient(to top left,#61e1da,#a4f5f1);
//   box-shadow: 
//             //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
//             0 0 4px 0 rgba(164, 245, 241, 0.8); 
// }

// .card_store_shop--list{
//   background-color: #fff;
//   padding: 25px;
//   border-radius: 4px;
//   margin-top: 20px;
//   box-shadow:0 0 8px 0 rgba(232,237,250,.6),0 2px 4px 0 rgba(232,237,250,.5);
//   cursor: pointer;
//   .shop--titlt{
//     padding-bottom: 20px;
//   }
// }
// .shop_list--shopname{
//   width: 100%;
//   height: auto;
//   min-height: 100px;
// }
// .shop_list{
//   min-width: 250px;
//   max-width: 300px;
//   padding: 20px;
//   flex: 1;
//   display: flex;
//   flex-wrap: wrap;
//   justify-content: center;
//   cursor: pointer;
//   border-radius: 0px;
//   transition: all 0.8s;
//   margin-left: 10px;
//   margin-top: 10px;
//   border-radius: 20px;
//   .shopfilylse,.amazioncse{
//     display: none;
//     transition: all 0.8s;
//   }
//   &:first-child{
//     margin-left: 0px;
//   }
//   &:hover{
//     .shopifly123,.amazion123{
//       display: none;
//     }
//   .shopfilylse,.amazioncse{
//     display: block;
//     transition: all 0.8s;
//   }

//     border-radius: 20px;
//     background-color: #bdaaff;
//     box-shadow: 
//             //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
//             0 0 4px 0 rgba(165, 140, 252, 0.8); 
//     color: #fff;
//     .shop_title--name{
//       color:#fff;
//     }
//     .name-title{
//       color:rgb(255, 241, 241);
//     }
//   }
// }
// .shop_list--shopfly-img{
//   position: relative;
//   padding: 0px;
//   height: 50px;
//   width: 150px;
//   cursor: pointer;
//   img{
//     width: 100%;
//     height: 100%;
//   }
// }
// .shop_title--name{
//   width: 100%;
//   font-weight: bold;
//   font-size: 18px;
//   text-align: center;
//   color: #6b7788;
//   margin-bottom: 10px;
//   transition: all 0.8s;
// }
// .shop_content--list{
//   width: 100%;

// }
// .shop_list--order{
//   margin:0 auto;
//   margin-top: 5px;
//   width: 80%;
//   display: flex;
//   font-size: 14px;
//   justify-content: space-between;
//   .name-title{
//     width: 40%;
//     color: #999999;
//     text-align: justify;
//     text-align-last: justify;
//     transition: all 0.8s;
//   }
//   .shop-answer{
//     // margin-left: 5%;
//     width: 70%;
//     text-align: left;
//     margin-left: 10px;
//   }
// }
// .store_number{
//   // background-color: #a58cfc;
//   // font-weight: normal;
//   font-size: 14px;
//   text-align: center;
//   color: #fff;
//   margin-left: 10px;
//   padding: 2px 10px;
//   border-radius: 30px;
//   max-width: 44px;
//   overflow: hidden;
//   font-weight: bold;
// }
// .card_store-shop-l{
//   width: 100%;
// }
// .store_shop-list{
//   width: 100%;
//   height: auto;
//   background-color: #fff;
//   padding: 25px;
//   border-radius: 4px;
//   margin-top: 20px;
//   box-shadow:0 0 8px 0 rgba(232,237,250,.6),0 2px 4px 0 rgba(232,237,250,.5);
//   cursor: pointer;
//   .store_shop--title{
//     font-size: 16px;
//     font-weight: bold;
//   }
// }

@media screen and (max-width: 1200px) {
  
}
@media screen and (max-width: 1450px) {
    .shop_list-store{
      .shop_list-shopinfo{
        flex: none;
        width: 100%;
        margin-left: 0px;
        margin-top: 10px;
      }
    }
    
}
.flex::after{
  content: '';
  max-width: 29.1666666667%;
  flex: 0 0 29.1666666667%;
  display: block;
}
</style>