<template>
  <el-container>
        <el-header>
            <sidebar LogoName="修改商品"></sidebar>
        </el-header>
        <el-main class="flex flex-wrap">
            <div class="container-fainal">
                <div class="revisionvarinants--title">
                    <div class="navtion-icon">
                        <i class="el-icon-back"></i>
                    </div>
                    <div class="revisionvarinants_title--icon">
                      <h1 >x/x/2</h1>
                    </div>
                    <div class="revisionvarinants_buton-save">
                        <loding-btn type="primary">Save</loding-btn>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between content">
                  <el-col  :xs="24" :sm="24" :md="24" :lg="8" :xl="15" >
                    <div class="revisionvarinants_content">
                        <div class="product_content-detail">
                            <div class="content-img">
                              <img src="https://cdn.shopify.com/s/files/1/0600/1390/4054/products/BE369FC1E5B6698959BE7AE26BB0960D.jpg?v=1640678492">
                            </div>
                            <div class="product-content">
                                <div>{{title}}</div>
                                <span>Active</span>
                                <div class="product-item">3 variants</div>
                                <div class="product-back-to-product">
                                  <a>Back to product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="revisionvarinants_variants--list">
                      <div class="variants--list-title">
                          Variants
                      </div>
                      <div class="variants--list">
                        <div class="variants--list-ul">
                          <ul>
                            <li>
                              <div class="variants--img">
                                <img src="https://cdn.shopify.com/s/files/1/0600/1390/4054/products/BE369FC1E5B6698959BE7AE26BB0960D.jpg?v=1640678492">
                              </div>
                              <div class="variants-tag">x / x / 2</div>
                            </li>
                            <li>
                              <div class="variants--img">
                                <img src="https://cdn.shopify.com/s/files/1/0600/1390/4054/products/BE369FC1E5B6698959BE7AE26BB0960D.jpg?v=1640678492">
                              </div>
                              <div class="variants-tag">x / x / 2</div>
                            </li>
                            <li>
                              <div class="variants--img">
                                <img src="https://cdn.shopify.com/s/files/1/0600/1390/4054/products/BE369FC1E5B6698959BE7AE26BB0960D.jpg?v=1640678492">
                              </div>
                              <div class="variants-tag">x / x / 2</div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                </el-col>
                <el-col  :xs="24" :sm="24" :md="24" :lg="15" :xl="15">
                    <div class="content-options">
                        <div class="content-options-title">
                           <span>Options</span>
                        </div>
                        <div class="options-list">
                          <div class="options-type_list">

                              <div class="type-size" v-for="(item,index) in options" :key="index">
                                  <span>{{item}}</span>
                                  <el-input v-model="form.option1" v-if="index == 0"></el-input>
                                  <el-input v-model="form.option2" v-if="index == 1"></el-input>
                                  <el-input v-model="form.option3" v-if="index == 2"></el-input>
                              </div>
                              <!-- <div class="type-size">
                                  <span>Material</span>
                                  <el-input v-model="form.material"></el-input>
                              </div>
                              <div class="type-size">
                                  <span>Color</span>
                                  <el-input v-model="form.color"></el-input>
                              </div> -->
                          </div>
                          <div class="change-img-content">
                              <div class="options-img">
                                   <img src="https://cdn.shopify.com/s/files/1/0600/1390/4054/products/4486CFF0485AE0DE863935CC474B90B4.jpg?v=1640678492">
                              </div>
                              <div class="change-img-text">Change image</div>
                          </div>
                        </div>
                    </div>
                    <!-- Pricing -->
                    <div class="common">
                        <div class="title">
                           <span>Pricing</span>
                        </div>
                        <div class="pricing border_bottom">
                            <div class="price">
                                <div class="price-title">MarketPrice</div>
                                <els-number-input v-model="form.market_price"></els-number-input>
                            </div>
                            <div class="compare_at_price">
                                <div class="price-title">Compare at price</div>
                                <els-number-input v-model="form.compare_at_price"></els-number-input>
                            </div>
                        </div>
                        <div class="pricing">
                            <div class="price">
                                <div class="price-title">Cost per item</div>
                                <els-number-input v-model="form.cost"></els-number-input>
                                <span>Customers won’t see this</span>
                            </div>
                            <div class="Margin-Profit">
                                <div class="Margin">
                                  <div>Margin</div>
                                  <div>-</div>
                                </div>
                                <div class="Profit">
                                  <div>Profit</div>
                                  <div>-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- inventoy -->
                    <div class="common inventoy">
                        <div class="title">
                           <span>Inventory</span>
                        </div>
                        <div class="border_bottom inventoy">
                            <div class="inventoy--input flex align-center">
                                <div class="inventoy--input-sku">
                                    <div class="sku-title">SKU (Stock Keeping Unit)</div>
                                    <el-input v-model="form.sku" placeholder="sku" ></el-input>
                                </div>
                                <div class="inventoy--input-sku">
                                    <div class="barcode-title">Barcode (ISBN, UPC, GTIN, etc.)</div>
                                    <el-input v-model="form.barcode" placeholder="sku" ></el-input>
                                </div>
                            </div>
                            <div class="checkbox">
                              <el-checkbox v-model="invertoycheckbox">Track quantity</el-checkbox>
                            </div>
                            <div class="checkbox">
                              <el-checkbox v-model="stockcheckbox">Continue selling when out of stock</el-checkbox>
                            </div>
                        </div>
                        <div class="quantity">
                          <div class="quantity-Available">
                            <div class="quantity--title">
                              QUANTITY
                            </div>
                            <el-input-number v-model="form.inventory_quantity" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
                          </div>
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="common">
                        <div class="title">
                           <span>Shipping</span>
                        </div>
                        <div class="border_bottom shipping-physical">
                            <el-checkbox v-model="shippingcheckbox">This is a physical product</el-checkbox>
                        </div>
                        <div class="shipping-addition" v-if="!shippingcheckbox">Customers won’t enter their shipping address or choose a shipping method when buying this product.</div>
                        <div class="shipping-content border_bottom" v-else>
                            <div class="shipping-weight ">
                              <div class="weight-title">WEIGHT</div>
                              <div class="weight-addition">Used to calculate shipping rates at checkout and label prices during fulfillment.</div>
                              <div class="weight-input-title">Weight</div>
                              <div class="weight-input">
                                <els-select-number-input :weight_unit="form.weight_unit" @handleCommand="handleCommand" :value="form.weight" @inputketup="form.weight = $event" @InputBlur="form.weight = $event"></els-select-number-input>
                              </div>
                            </div>
                        </div>
                        <div class="custos_information">
                            <div class="custos-title">CUSTOMS INFORMATION</div>
                            <div class="custos-addition">Customs authorities use this information to calculate duties when shipping internationally. Shown on printed customs forms.</div>
                            <div class="origin">
                                <div class="origin-title">Country/Region of origin</div>
                                <el-select v-model="country_id"  clearable placeholder="请选择" style="width:100%;">
                                    <el-option
                                        v-for="item in Countrylist"
                                        :key="item.id"
                                        :label="item.namecn"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                                <span class="Tips">In most cases, where the product is manufactured.</span>
                            </div>
                            <div class="code">
                                <div class="code-title">HS (Harmonized System) code</div>
                                <el-input v-model="HScode"></el-input>
                                <span class="Tips">Manually enter codes that are longer than 6 numbers.</span>
                            </div>
                        </div>
                    </div>
                    <div class="loading-btn">
                         <loding-btn type="primary">Save</loding-btn>
                    </div>
                </el-col>
                </div>
            </div>
            
        </el-main>
  </el-container>
</template>

<script>
import { reactive,toRefs,onMounted} from 'vue'
import Sidebar from '@/components/Loyout/Sidebar/Sidebar.vue'
import OrderlistwangEditor from '../../Orderlist/OrderlistwangEditor.vue'
import ElsNumberIn from '@/components/input/els-number-in.vue'
import ElsNumberInput from '@/components/input/els-number-input.vue'
import ElsSelectNumberInput from '@/components/input/els-select-number-input.vue'
import { getCountryList } from '@/api/Porductapi'
import LodingBtn from '@/components/lodingBtn/index.vue'
export default {
  components:{
    Sidebar,
    OrderlistwangEditor,
    ElsNumberIn,
    ElsNumberInput,
    ElsSelectNumberInput,
    LodingBtn
},
  setup(){
    const data = reactive({
      HScode: "123456",
      category_id: 0,
      country_id: 1,
      images: [{id: 630, product_id: 212,}],
      shop_id: 4,
      title: "test import 002",
      variants:[
        {},{},{}
      ],
      form:{
        barcode: "2131231",
        compare_at_price: "36.00",
        cost: "23.00",
        market_price: "34.00",
        image_id: 630,
        inventory_id: 0,
        inventory_management: "",
        inventory_policy: 1,
        inventory_quantity: 234,
        option1: "x",
        option2: "xl",
        option3: "xxl",
        shipping: "0.00",
        shopify_variant_id: 0,
        sku: "bfhywewew",
        weight: 0,
        weight_unit: "g",
        width: "11.00",
        length: "12.00",
        height: "23.00",
        country_id:"",
      },
      options:['Size','Material','Color'],
      //国家数据
      Countrylist:[],
      //
      invertoycheckbox:true,
      stockcheckbox:true,
      shippingcheckbox:true,
    })
    
    return{
      ...toRefs(data)
    }
  },
  mounted(){
    this.init();
  },
  methods:{
    init(){
      this.ObtainCounty();
    },
    ObtainCounty(){
            getCountryList().then(res =>{
                if(res.code == 1){
                    this.Countrylist = res.data
                    console.log(this.Countrylist);
                }
            })
        },
  }
}
</script>

<style scoped lang="scss">
  .el-header{
    background-color: #fff;
  }
  .container-fainal{
    margin:0 auto;
    width: 80%;
    cursor: pointer;
  }
  .revisionvarinants--title{
    display: flex;
    justify-content: space-between;
  }
  .navtion-icon{
        width: 35px;
        height: 35px;
        line-height: 38px;
        // border: 1px solid rgba(186, 191, 195, 1);
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 0 4px 0 rgb(0 0 0 / 20%);
        background-color: #fff;
        margin-right: 10px;

        i{
            font-size: 20px;
            font-weight: bold;
            color: rgba(109, 113, 117, 1);
        } 
  }
  .revisionvarinants_title--icon{
        grid-area: title / title / title / title;
        align-self: center;
        flex: 1 1 auto;
        h1{
          margin:0;
        }
  }
  .revisionvarinants_buton-save{
    grid-area: actions / actions / actions / actions;
    flex: 1 1 auto;
    place-content: flex-end;
    display: flex;
    align-items: flex-start;
  }
  .revisionvarinants_content{
      max-width: 100%;
      padding: 1rem;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 
            //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
            0 0 4px 0 rgba(0, 0, 0, 0.2);
  }
    //内容
  .product_content-detail{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
  }

  .content-img{
    flex: 0 0 auto;
    min-width: 0;
    width: 100%;
    img{
      width: 100%;
      height: 100%;
    }
  }
  .product-content{
    flex: 1 1 auto;
    min-width: 0;
    span{
      display: inline-flex;
      padding: 0.2rem 0.8rem;
      background-color:#aee9d1;
      color: #000;
      font-size: 12px;
      border-radius: 20px;
      margin-top: 0.4rem;
      margin-top: 0.4rem;
    }
    .product-item{
      margin-top: 0.4rem;
      color: #6d7175;
    }
    a{
      color: #2c6ecb;
    }
    .product-back-to-product{
      margin-top: 0.4rem;
      color: #2c6ecb;
      text-decoration: underline;
      cursor: pointer;
    }
  }

  .revisionvarinants_variants--list{
    margin-top: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 
            0 0 4px 0 rgba(0, 0, 0, 0.2);
    .variants--list-title{
      padding: 1rem;
      // border-bottom: 1px solid #6d7175;
    }
    .variants--list{
      margin-top: 0;
      .variants--list-ul{
        max-height: 700px;
        ul{
          margin:0;
          padding: 0;
          list-style: none;
          li{
              border-top: none;
              border-color: #c9cccf;
              margin:0;
              padding: 0.8rem 1rem;
              color: #000;
              text-decoration: none;
              display: flex;
              align-items: center;
              cursor: pointer;
              border-bottom: 1px solid #c9cccf;
              &:last-child{
                border-bottom: none;
              }
              &:hover{
                background-color: #f1f2f3;
              }
              .variants-tag{
                margin-left: 10px;
              }
              .variants--img{
                border:1px solid #e1e3e5;
                border-radius: 4px;
                max-width: 100%;
                display: block;
                overflow: hidden;
                width: 40px;
                height: 40px;

                img{
                  width: 100%;
                  height: 100%;
                }
              }
          }
        }
      }
    }
  }

  .content{
    margin-top:10px;
  }
  .content-options{
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 4px 0 rgb(0 0 0 / 20%);
  }
  .content-options-title{
    width: 100%;
    padding: 20px 0px 0px;
    // flex: 1fr;
  }
  .options-list{
    max-width: 100%;
    flex-wrap: wrap;
    display: flex;
    align-items: stretch;
    margin-top: 20px;
    .type-size{
      margin-top: 20px;
    }
  }
  .options-type_list{
      flex: 1 1 auto;
  }
  .change-img-content{
    cursor: pointer;
    flex: 0 0 auto;
    margin-left: 10px;
    .change-img-text{
      margin-top: 20px;
      text-align: center;
      text-decoration: #2c6ecb;
      color: #2c6ecb;
    }
  }
  .options-img{
    border: 0.1rem dashed #eee;
    margin-top: 30px;
    img{
      width: 10rem;
    }
  }
  .common{
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 4px 0 rgb(0 0 0 / 20%);
    margin-top: 20px;
    .title{
      padding: 20px 20px 0px 20px;
      font-weight: bold;
    }
    .content{
      padding: 0px 20px;
    }
    .border_bottom{
      border-bottom: 1px solid #e1e3e5;
    }
  }
  .pricing{
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      .price{
        width: 48%;
        height: auto;
        span{
          color: #6d7175;
        }
      }
      .compare_at_price{
        width: 48%;
        height: auto;
      }
      .price-title{
        padding: 5px 0px;
      }
  }
  .Margin-Profit{
    width: 48%;
    display: flex;
    align-items: center;
    // justify-content: space-between;
    .Profit{
      margin-left: 30%;
    }
  }
  .inventoy{
    .inventoy--input{
      padding: 20px;
      justify-content: space-between;
    }
    .inventoy--input-sku{
      width: 48%;
    }
    .sku-title{
      padding: 5px 0px;
    }
    .barcode-title{
      padding: 5px 0px;
    }
    .checkbox{
      padding:0px 20px;
    }
  }

  .quantity-Available{
    .quantity--title{
      padding: 5px 0px;
    }
    padding: 20px;
  }


  .shipping--title{
    padding: 5px 0px;
  }
  .shipping-physical{
    padding: 20px;
  }
  .shipping-content{
    padding: 20px;
    transition: all 0.8s;
  }
  .shipping-weight{
    // padding: 20px;
    .weight-title{
      // padding: ;
      font-weight: bold;
      font-size: 14px;
    }
    .weight-addition{
      padding: 10px 0px;
      color: #6d7175;
    }
    .weight-input-title{
      padding: 5px 0px;
    }
    .weight-input{
      width: 50%;
    }
  }
  .custos_information{
    padding: 20px;
    .custos-title{
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      line-height: 1.6rem;
    }
    .custos-addition{
      font-size: 13px;
      color: #6d7175;
      margin-bottom: 10px;
    }
    
  }
  .origin{
    margin-top: 15px;
    margin-bottom: 15px;
    .Tips{
      font-size: 13px;
      color: #6d7175;
      margin-bottom: 10px;
    }
    .origin-title{
      padding: 5px 0px;
    }
  }
  .code{
    margin-bottom: 15px;
    .Tips{
      font-size: 13px;
      color: #6d7175;
      margin-bottom: 10px;
    }
    .code-title{
      padding: 5px 0px;
    }
  }
   .shipping-addition{
      color: #6d7175;
      padding: 20px;
    }
    .loading-btn{
      margin-top: 20px;
      margin-bottom: 20px;
      display: flex;
      justify-content: flex-end;
    }
</style>