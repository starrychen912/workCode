<template>
  <div class="ordervariants" style="padding: 16px 24px 24px 24px;">
  <div class="import-list-pricing-tab__header">
      <div class="product-pricing-shipping">
          <div class="product-icon">
              <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M48 0H0V48H48V0Z" fill="white" fill-opacity="0.01"/>
                <path d="M12 39C14.2091 39 16 37.2091 16 35C16 32.7909 14.2091 31 12 31C9.79086 31 8 32.7909 8 35C8 37.2091 9.79086 39 12 39Z" stroke="#2d00fb" stroke-width="4" stroke-linejoin="round"/>
                <path d="M35 39C37.2091 39 39 37.2091 39 35C39 32.7909 37.2091 31 35 31C32.7909 31 31 32.7909 31 35C31 37.2091 32.7909 39 35 39Z" stroke="#2d00fb" stroke-width="4" stroke-linejoin="round"/>
                <path d="M8 35H2V11H31V35H16" stroke="#2d00fb" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M31 35V18H39.5714L46 26.5V35H39.8112" stroke="#2d00fb" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
          </div>
          <div class="product-pricing-shipping__body">
            <div class="product-pricing-shipping__body-text">
              <div data-v-0ea7dc85="">Show shipping to: <strong>N/A<strong></strong></strong></div>
              <div data-v-0ea7dc85="" class="product-pricing-shipping__body-text--muted">(AliExpress Standard Shipping)</div>
            </div>
            <div>
                <el-button type="info" size="mini" @click="USEChange">CHANGE </el-button>
            </div>
          </div>
      </div>
      <div class="product-pricing-shipping is--active">
          <div class="product-icon">
              <i class="el-icon-s-opportunity"></i>
          </div>
          <div class="product-pricing-shipping__body">
            <div class="product-pricing-shipping__body-text">
              <span data-v-683f8988="">Businesses in your industry are selling this product for approx. <strong>CN¥154.39</strong></span>
            </div>
            <div>
                <el-button type="info" size="mini">
                    <span class="btn-title">
                        SET CN¥154.39 PRICE
                    </span>
                </el-button>
            </div>
          </div>
      </div>
  </div>
    <el-alert
        title="提示"
        type="error"
        description="This product is already in your store."
        show-icon
        v-if="false"
        :closable="false"
        >
    </el-alert>              
    <el-table
        :data="Pricing"
        style="width: 100%"
        :row-class-name="tableRowClassName"
    >   
        <el-table-column  label="Variant" min-width="150">
            <template #default="scope"  >
                <div class="scope--img" v-if="scope.$index != 0">
                    <!-- <div class="item-title">Z6 / China</div>
                    <div class="item-span">44339541-z6-china</div> -->
                    <div class="item-title">{{scope.row.sku}}</div>
                </div>
            </template>
        </el-table-column>
        <el-table-column label="Cost" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <span>CN¥ {{scope.row.cost}}</span>
                </div>
            </template>
        </el-table-column>
        <el-table-column property="date" label="Shipping"  >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <span>CN¥ 0.00</span>
                </div>
            </template>
        </el-table-column>
         <el-table-column property="date" label="Price" min-width="150" >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="scope.row.market_price"
                        @blur="PriceBlur(scope.row.market_price)"
                        clearable>
                    </el-input>
                </div>
                <el-dropdown trigger="click" placement="bottom" v-else>
                    <el-button type="info" size="mini">CHANGE All
                        <i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item @click="clickChange('Change all price')">Change all price</el-dropdown-item>
                        <el-dropdown-item @click="clickChange('Muliply prices by')">Muliply prices by</el-dropdown-item>
                    </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </template>
            
        </el-table-column>
        <el-table-column property="name" label="Profit" min-width="100"  >
            <template #default="scope" >
                <div class="scope--text" v-if="scope.$index != 0">
                    CN¥ 1.76
                </div>
            </template>
        </el-table-column>
        <el-table-column property="address" label="Compare at price" min-width="150"  >
            <template #default="scope" >
                <div class="scope--img" v-if="scope.$index != 0">
                    <el-input
                        placeholder="请输入内容"
                        v-model="scope.row.compare_at_price"
                        @blur="CompareBlur(scope.row.compare_at_price)"
                        clearable>
                    </el-input>
                </div>
                <el-dropdown trigger="click" v-else placement="bottom">
                    <el-button type="info" size="mini">CHANGE All
                        <i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item @click="clickChange('Change all compare at price')">Change all compare at price</el-dropdown-item>
                        <el-dropdown-item @click="clickChange('Multiply compare at prices by')">Multiply compare at prices by</el-dropdown-item>
                    </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </template>
        </el-table-column>
  </el-table>
   
  </div>
  <el-dialog v-model="data.dialogFormVisible" title="Available shipping methods">
    <div class="el-dialog-body">
        <p>The selected shipping method is displayed in the price table. This is provided by the supplier and based on your country selection and a standard delivery method (eg ePacket). <br> Note: This is the cost to send an individual item and does not include premium or bulk sending options.</p>
        <div class="el-dialog--select">
            <div class="select-title">Calculate your shipping price by country</div>
            <div class="el-dialog-seltct-intput">
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
        <p class="shipping-info-modal__notice">
          These are the shipping methods you will be able to select when processing orders
        </p>
        <el-table :data="data.tableData" style="width: 100%">
            <el-table-column prop="date" label="Shipping Method" width="250px" >
                <div class="shipping--method">
                    <el-radio v-model="radio1"></el-radio>
                    <span>AliExpress Standard Shipping</span>
                </div>
            </el-table-column>
            <el-table-column prop="name" label="Estimated Delivery Time"  >
                <div>40-40days</div>
            </el-table-column>
            <el-table-column prop="address" label="Shipping Cost" >
                <div>CN¥19.18</div>
            </el-table-column>
        </el-table>
    </div>
    <template #footer>
      <span class="dialog-footer">
        <el-button type="primary" @click="data.dialogFormVisible = false" >OK</el-button
        >
      </span>
    </template>
  </el-dialog>
  <el-dialog v-model="data.changeprice" :title="data.changetitle">
      <div class="dlalog--input">
          <el-input v-model="input" placeholder="value"/>
      </div>
      <template #footer>
      <span class="dialog-footer">
        <el-button @click="data.changeprice = false">CANCEL</el-button>
        <el-button type="primary" @click="data.changeprice = false" >CHANGE</el-button>
      </span>
    </template>
  </el-dialog>


</template>

<script>
import { reactive, watch } from 'vue'
import { updateImportList } from '../../api/Orderlist'
export default {
    emits:["CompareBlur","PriceBlur"],
    props:{ 
        orderlist:{
            type:[Array,Object],
            default:[{},{}]
        },
        Pricing:{
            type:[Array,Object],
            default:[{},{}]
        }
    },
    setup(props,context){
        let modeifstatus = false
        const data = reactive({
            dialogFormVisible:false,
            changeprice:false,
            changetitle:'Change all price',
            value1:false,
            tableData: [
               {

               }]
        })
        watch(
            () => props.Pricing,
            (newval,oldval) =>{
                modeifstatus = true
            },
            {
                deep:true
            }
        )
        function PriceBlur(market_price){
            if(modeifstatus){
                context.emit('PriceBlur',market_price)
                modeifstatus = false
            }
        }
        function CompareBlur(compare_at_price){
            if(modeifstatus){
                context.emit('CompareBlur',compare_at_price)
                modeifstatus = false
            }
        }
        return {
            PriceBlur,
            data,
            modeifstatus,
            CompareBlur
        }
    },
    methods: {
    
    
    
    clickChange(item){
        this.data.changetitle = item
        this.data.changeprice = true 
    },
    USEChange(){
        this.data.dialogFormVisible = true
    },
    tableRowClassName({ row, rowIndex }) {
        // console.log(rowIndex);
        if (rowIndex === 0) {
            return 'warning-row'
        }
            return ''
      },
      handleCurrentChange(){

      },
      getSummaries(param) {
      const { columns, data } = param
      console.log(param);
      const sums = []
      columns.forEach((column, index) => {
        if (index === 0) {
          sums[index] = 'Total Cost'
          return
        }
        const values = data.map((item) => Number(item[column.property]))
        if (!values.every((value) => isNaN(value))) {
          sums[index] = `$ ${values.reduce((prev, curr) => {
            const value = Number(curr)
            if (!isNaN(value)) {
              return prev + curr
            } else {
              return prev
            }
          }, 0)}`
        } else {
          sums[index] = 'N/A'
        }
      })
      return sums
    },
      resetDateFilter() {
        this.$refs.filterTable.clearFilter('date');
      },
      clearFilter() {
        this.$refs.filterTable.clearFilter();
      },
      formatter(row, column) {
        return row.address;
      },
      filterTag(value, row) {
        return row.tag === value;
      },
      filterHandler(value, row, column) {
        const property = column['property'];
        return row[property] === value;
      }
    }
}
</script>

<style scoped lang="scss">
.ordervariants{
    display: block;
    padding: 16px 24px 24px 24px;
    border-top: 1px solid #ededf2;
    position: relative;
    z-index: 0;
    overflow-y: auto;
    max-height: 550px;
    overflow-x: hidden;
}
.import-list-pricing-tab__header{
    display: flex;
    // flex-direction: column;
    margin-bottom: 16px;
    border-bottom: 1px solid #ededf2;
    .product-pricing-shipping{
        flex: 50%;
        margin-bottom: 16px;

    }
    .product-icon{
        flex-shrink: 0;
        margin-right: 8px;
       i{
           font-size: 40px;
           color:#2d00fb ;
       }
       svg{
           margin-right: 5px;
       }
    }
}
.product-pricing-shipping{
    display: flex;
}
@media (min-width: 1200px){
    .is--active {
        border-left: 1px solid #d0d0de;
        padding-left: 24px;
    }
}

.product-pricing-shipping__body{
    display: flex;
    flex-wrap: wrap;
    margin-right: 24px;
}
.product-pricing-shipping__body-text{
    margin-bottom: 8px;
    margin-right: 24px;
}
.product-pricing-shipping__body-text--muted{
    color: #6f6f91;
}
:deep(.el-table .warning-row) {
  --el-table-tr-background-color:  var(--el-background-color-base);
  &:hover{
      --el-table-tr-background-color:  var(--el-background-color-base);
  }
}
.scope--img{
    width: 100%;
    height: 100%;
    img{
        width: 100%;
        height: 100%;
    }
}
.scope--text{
    font-weight: 600;
    color: #46802a;
}
.item-title{
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;
    color: #272742;
}
.item-span{
    font-weight: normal;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: .02em;
    color: #6f6f91;
}
.el-dialog-body{
    .select-title{
        margin-right: 20px;
    }
   .el-dialog--select{
       display: flex;
       align-items: center;
       .el-dialog-seltct-intput{
            flex: 1;
            .el-select{
                width: 100%;
            }
        }
   }
}
.shipping--method{
    width: 100%;
    display: flex;
    align-items: center;
    .el-radio{
        margin-right: 0px;
    }
}
@media only screen and (max-width: 1200px){
       .import-list-pricing-tab__header{
           flex-wrap: wrap;
           .product-pricing-shipping{
                flex: 100%;
            }
       }  
}
</style>