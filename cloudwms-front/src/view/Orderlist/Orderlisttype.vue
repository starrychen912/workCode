<template>
  <div class="list">
        <div class="el-checkbox--button">
            <el-checkbox :indeterminate="data.isIndeterminate" v-model="checkboxList[itemdata.id]" :key="itemdata.id"   @change="handleCheckAllChange(itemdata.id)"></el-checkbox>
        </div>
        <div class="list-tag">
            <div class="tag-text" 
                :class="{'is_active':data.name === index}" 
                v-for="(item,index) in data.list" 
                :key="index" 
                @click="Actice(item.index)">
                <!-- <span></span> -->
                <!-- {{item.name}} -->
                 {{item.name === 'images'?'Images('+data.itemnumber+'/'+itemdata.images.length+')':item.name}}
            </div>
        </div> 
        <div class="list--button">
            <el-dropdown trigger="click">
                <el-button  size="small" type="primary">
                    ACTIONS<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <template #dropdown>
                <el-dropdown-menu>
                    <el-dropdown-item @click="SelectPorduct">查找相似产品</el-dropdown-item>
                    <el-dropdown-item @click="SplitPorduct">裁剪产品</el-dropdown-item>
                    <el-dropdown-item @click="DeleteProduct(item,index)">删除产品</el-dropdown-item>
                </el-dropdown-menu>
                </template>
            </el-dropdown>
            <loding-btn Btname="INPORT TO STORE" type="primary" @LoadBTN="InportToStore(itemdata.id)"></loding-btn>
        </div>
    </div>
    <orderlistcontext 
    v-if="data.name == 0" 
    :content="itemdata"
    
    ></orderlistcontext>    
    <order-variants 
        v-if="data.name == 1" 
        :Variants="itemdata.variants || []" 
        :content="itemdata"
        @BulletPoint5="BulletPoint5"
    ></order-variants>
    <orderlist-pricing 
    @CompareBlur="CompareBlur" @PriceBlur="PriceBlur"
    v-if="data.name == 2" :Pricing="itemdata.variants" ></orderlist-pricing>
    <orderlistwang-editor v-if="data.name == 3" 
        :editor="itemdata.description"
        @Change="editorChange"
        @Onfocus="Onfocus"
        @Onblur="Onblur"
    ></orderlistwang-editor>
    <orderlist-images v-if="data.name == 4" :Imglist="itemdata.images || []"></orderlist-images>


    <el-dialog
        v-model="data.splitProduct"
        title="Split product"
        :width="data.dialogwidth"
        :before-close="handleClose"
    >  
        <div class="dialogcontent">
            <div class="product-title">
                <div>Select variants you wish to split to another product</div>
                <div>
                    <span>...or</span>
                    <a> Split by option</a>
                </div>
            </div>
            <strong data-v-7d922558="">Split by:</strong>
            <div class="product-split_product-option">
                <div class="radio-block">
                    <el-radio v-model="data.dialogradio"  ></el-radio>
                    <div class="radio--title">Color</div>
                </div>
                <div class="product-split-description">
                    <span>We will create 70 products each containing only distinct "Color" variants (A, B, E, F, G, H, I, K, L, M, N, O, P, SA, SD, SF, T, U, X, Z1, Z10, Z11, Z12, Z13, Z14, Z15, Z16, Z17, Z18, Z19, Z2, Z20, Z21, Z22, Z23, Z24, Z25, Z26, Z27, Z28, Z29, Z3, Z30, Z31, Z32, Z33, Z34, Z35, Z36, Z37, Z38, Z39, Z4, Z40, Z41, Z42, Z43, Z44, Z45, Z46, Z47, Z49, Z5, Z50, Z6 2, Z6, Z7, Z8, Z9, ZB)</span>
                </div>
            </div>
            <div class="product-split_product-option">
                <div class="radio-block">
                    <el-radio v-model="data.colorfrom"  ></el-radio>
                    <div class="radio--title">Ships From</div>
                </div>
                <div class="product-split-description">
                    <span>We will create 3 products each containing only distinct "Ships From" variants (China, SPAIN, United States)</span>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="data.dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="data.dialogVisible = false"
                >Confirm</el-button
                >
            </div>
        </template>
    </el-dialog>

    <el-dialog
        v-model="data.dialogVisible"
        title="Replace product"
        :width="data.dialogwidth"
        :before-close="handleClose"
    >
        <div class="dialog--content">
            <el-alert :closable="false"  class="el-alert--product" title="Shopify product variants will be deleted and replaced with variants from a new AliExpress product. You can edit product details in the next step. Learn more what will be changed in Shopify." type="warning" show-icon> </el-alert>
            <div class="product-overrider-model_item">
                <div class="product-model_item">
                    <div class="product-model_item-title">Shopify product</div>
                    <div class="shopify_input">
                        <el-select v-model="value" filterable placeholder="Select">
                            <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="product-model_item-icon">
                    <i class="el-icon-right"></i>
                </div>
                <div class="product-model_item">
                    <div class="product-model_item-title">Shopify product</div>
                    <div class="product-override-modal__item_component">
                        <img src="https://ae01.alicdn.com/kf/HTB1x46Je21G3KVjSZFkq6yK4XXac/Chef-Decoration-Pencil-Anti-slip-Accessories-Draw-Tools-Stainless-Steel-Portable-Mini-Sauce-Painting-Coffee-Spoon.jpg">
                        <div  class="show-product__title">
                            Chef Decoration Pencil Anti-slip Accessories Draw Tools Stainless Steel Portable Mini Sauc
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="data.dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="data.dialogVisible = false"
                >Confirm</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import { reactive ,ref,computed } from 'vue'
import Orderlistcontext from './Orderlistcontext.vue';
import OrderlistImages from './OrderlistImages.vue';
import OrderlistPricing from './OrderlistPricing.vue';
import OrderlistwangEditor from './OrderlistwangEditor.vue';
import OrderVariants from './orderVariants.vue';
import { useStore } from 'vuex';
import { importToSohpify ,updateImportList} from '../../api/Orderlist';
import { shoElmessage } from '../../utils/Elmessage';
import LodingBtn from '../../components/lodingBtn/index.vue';
import { GetImage,Addinstall } from '../../utils/utils';
import Loaddingbutton from '../../components/loaddingbutton/index.vue';
export default {
  emits:['DeleteProduct','Actice','handChange'],
  components: { Orderlistcontext, OrderVariants, OrderlistPricing, OrderlistwangEditor, OrderlistImages, LodingBtn, Loaddingbutton },
    props:{
        itemdata:{
            type:[String,Number,Object],
            default:{}
        },
        checkboxList:{
            type:Object,
            default:{}
        },
        object:{
            type:[Object],
            default:{}
        },
        Acindex:{
            type:[Number],
            default:""
        }
    },
    methods:{
        checkAlls(){
            this.$emit('handChange',{})
        },
        handleCheckAllChange(e){
            let data = this.checkboxList
            if(data[e]){
                data[e] = true
            }else{
               data[e] = false
            }
            this.$emit('handChange',data)
        }
    },
    setup(props,context){
        const store = useStore();
        const data = reactive({
            itemnumber:computed(() => GetImage(props.itemdata.images,'is_choice')),
            dialogwidth:computed(() => store.state.setting.dialogwidth),
            splitProduct:false,
            dialogVisible:false,
            dialogradio:0,
            colorfrom:1,
            name:0,
            list:[ { name:"Product", index:0 }, { name:"Variants", index:1 },{ name:"Pricing", index:2 },{ name:"Description",index:3 },{name:"images",index:4},
            ],
            checkAll:false,
            isIndeterminate:false,

            editor:false,
        })
        const checkAll = ref(false);
        function Actice(index){
              data.name = index
              context.emit('Actice')
        }
        function CheckBox(e){
            // data.statuslist.push(e);
        }
        function handleClose(){

        }
        //查询product
        function SelectPorduct(){
            data.dialogVisible = true
        }
        //裁剪product
        function SplitPorduct(){
            data.splitProduct = true
        }
       
        function DeleteProduct(item,index){
                let data = {
                    item:item,
                    index:index
                }
                context.emit('DeleteProduct')
        }
        function InportToStore(product_id){
            let data = product_id;
            console.log(data);
            if(Addinstall(props.checkboxList)){
                data = Addinstall(props.checkboxList).join();
            }
            console.log(data);
            importToSohpify({product_ids:data}).then(res =>{
                if(res.code == 1){
                    shoElmessage(true,'导入成功')
                    context.emit('InportToStroe',product_id)
                }else{
                    shoElmessage(true,`导入失败${res.msg}`,'error')
                }
            })
        }
        function editorChange(value){
            data.editor = true
        }
        //editor操作，富文本操作
        function Onfocus(value){

        }
        //公共的
        function CommenupdateImportList({bullet_point5,market_price,compare_at_price,description}){
            updateImportList({
                import_id:props.itemdata.id,
                sku:props.itemdata.sku,
                bullet_point5:bullet_point5 || null,
                market_price:market_price || null,
                compare_at_price:compare_at_price || null,
                description:description || null,
            }).then(res =>{
                if(res.code == 1){
                   shoElmessage(true,'修改成功','success')
                }else{
                    shoElmessage(true,`修改失败，原因${res.msg}`,'error')
                }
            })
        }
        //pricing操作数据
        function PriceBlur(value){
            if(value != '' ){
                 CommenupdateImportList({market_price:value});
            }
        }
        function CompareBlur(value){
            if(value != '' ){
                 CommenupdateImportList({compare_at_price:value});
            }
        }
        function Onblur(value){
            // console.log(typeof );
            if(value != '' && data.editor){
                 CommenupdateImportList({description:value});
                 data.editor = false
            }
        }
        function BulletPoint5(value){
            if(value != ''){
                CommenupdateImportList({bullet_point5:value});
            }
        }
        return {
            data,
            checkAll,
            Actice,
            InportToStore,
            SelectPorduct,
            SplitPorduct,
            DeleteProduct,
            handleClose,
            CheckBox,

            //富文本
            Onblur,
            CommenupdateImportList,
            editorChange,
            Onfocus,

            //pricing
            PriceBlur,
            CompareBlur,

            //variants
            BulletPoint5
        };
        
    }
    
}

</script>
<style >
.el-dialog__footer{
    border-top: 1px solid #e5e5ec;
}
</style>
<style scoped lang="scss">


    .list{
        display: flex;
        align-items: center;
        min-height: 50px;
        border-bottom: 1px solid rgb(218, 218, 218);
        padding-top:10px;
        .list-tag{
            height: 54px;
            width: 100%;
            display: flex;
            align-items: center;
            // margin-top: 10px;
            .tag-text{
                width: auto;
                padding: 15px 0px;
                margin:0 10px;
                font-weight: 600;
                cursor: pointer;
                color: #272742;
                // border-bottom: 2px solid var(--el-color-primary);
                // color: var(--el-color-primary);
                &:hover{
                    border-bottom: 2px solid var(--el-color-primary);
                    color: var(--el-color-primary);
                }
            }
            .is_active{
                border-bottom: 2px solid var(--el-color-primary);
                color: var(--el-color-primary);
            }
        }
    }
    .el-checkbox--button{
        padding:0px 20px;
    }
    .list--button{
        display: flex;
        align-items: center;
        padding-right: 10px;
        box-sizing: border-box;
        margin-right: 10px;
    }
    @media only screen and (max-width: 1200px){
        .el-checkbox{
            order: 1;
        }
        .list-tag{
            order: 3;
            margin-left: 10px;
            overflow: auto hidden;
            &::-webkit-scrollbar{
                width: 0px;
            }
        }
        .list--button{
            order: 2;
        }
        .list{
            flex-wrap: wrap;
        }
    }
    @media only screen and (max-width: 1200px){
        .el-checkbox{
            order: 1;
        }
        .list-tag{
            order: 3;
        }
        .list--button{
            order: 2;
        }
        .list{
            flex-wrap: wrap;
        }
    }
    .header-content{
        padding: 20px; 
    }  
    //弹出框1
    .dialog-footer{
        width: 100%;
        height: auto;
    }
    .el-alert--product{
        margin-bottom: 20px;
    }
    .product-overrider-model_item{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        .product-model_item{
            min-width: 250px;
            flex: 1;
        }
        .product-model_item-title{
            // font-size: 18px;
            margin-bottom: 8px;
            font-weight: 600; 
        }
        .el-select{
            width: 100%;
        }
        .product-model_item-icon{
            width: 70px;
            justify-content: center;
            display: flex;
            align-items: center;
            i{
                font-size: 20px;
            }
        }
        .product-override-modal__item_component{
            background: #f6f6f9;
            border-radius: 1px;
            padding: 12px;
            display: flex;
            img{
                width: 40px;
                height: 40px;
                min-width: 40px;
                margin-right: 12px;
                border-radius: 4px;
            }
        }
        .shopify_input{
            background: #f6f6f9;
            border-radius: 1px;
            padding: 12px;
        }
    }
    @media only screen and (max-width: 400px){
        .product-overrider-model_item{
            .product-model_item-icon{
                width: 100%;
                height: 50px;
                transform: rotate(90deg);
            }
        }
        
    }

    //第二个弹出框
    .product-title{
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        a{
            text-decoration: underline;
        }
    }
    .product-split_product-option{
        border-radius: 1px;
        border: none;
        background: #f6f6f9;
        padding: 12px;
        margin-top: 20px;
        .radio-block{
            display: flex;
            align-items: center;
            .el-radio{
                margin-right: 0px;
            }
        }
        .radio--title{
            font-weight: 600;
            font-size: 14px;
        }
        .product-split-description{
            color: #6f6f91;
            margin-left: 20px;
        }
    }
</style>