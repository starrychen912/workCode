<template>
<el-container>
    <el-header>
        <sidebar LogoName="新增商品"></sidebar>
    </el-header>
    <el-main class="flex flex-wrap" >
        <div class="container-fainal">
        <div class="header---title-s flex justify-between">
            <div class="navtions-icon" @click="goBack">
                <i class="el-icon-back"></i>
            </div>
            <div class="el-button--cantal-cost">
                <loding-btn  @LoadBTN="goBack">取消</loding-btn>
                <loding-btn @LoadBTN="SavaProduct" type="primary">确定</loding-btn>
            </div>
        </div>
        <el-col  :xs="24" :sm="24" :md="24" :lg="15" :xl="15" >
        <div class="el_from--card">
            <div class="from_input--title">
                <span style=" color: #f80000;">*</span>
                Title
            </div>
            <div class="title--input">
              <el-input v-model="form.title" :class="{'el-input--error':form.title == '' && status}"   placeholder="请输入标题"></el-input>
            </div>
            <div class="from_input--title">Description</div>
            <div class="editor">
              <orderlistwang-editor
                :editor="form.description"
                @Change="editorChange"
                @Onfocus="Onfocus"
                @Onblur="Onblur"
              ></orderlistwang-editor>
            </div>
        </div>
        <div class="el_from--card card" >
            <div class="from_input--title">
                <span>Media</span>
            </div>
            <div class="upload-demo">
                <el-upload
                    drag
                    :headers="headers"
                    :action="baseUrl + '/api/finderuser/upload'"
                    list-type='picture-card'
                    :on-remove="Remove"
                    :on-success="Success"
                    :on-error="UploadError"
                    :on-change="UploadChange"
                    :file-list="image_urls"
                    :before-upload="BeforeUpload"
                    multiple
                >
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">
                             Drop file here or <em>click to upload</em>
                    </div>
                    <template #tip>
                    <!-- <div class="el-upload__tip">
                        jpg/png files with a size less than 500kb
                    </div> -->
                    </template>
                </el-upload>
            </div>
        </div>
        <div class="card-box-shadong">
            <div class="pricing-card card">
                <div class="from_input--title ">
                    <span>Pricing</span>
                </div>
                <div class="pricing_input--list flex align-center justify-between flex-wrap">
                    <div class="el-input--number ">
                          <div class="el-input--title">
                              <span>*</span>
                             Market Price：
                          </div>
                            <div class="price--list flex">
                            <els-number-input :value="form.market_price" @inputketup="form.market_price = $event" @InputBlur="form.market_price = $event" :error="Getiserror(form.market_price)"></els-number-input>
                        </div>
                    </div>
                    <div class="el-input--number">
                        <div class="el-input--title"><span>*</span>Price：</div>
                        <div class="price--list flex align-center">
                             <els-number-input  :value="form.compareprice" @inputketup="form.compareprice = $event" @InputBlur="form.compareprice = $event" :error="Getiserror(form.compareprice)"></els-number-input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pricing-card-costper">
                <div class="cost-per--item flex align-center justify-between">
                    <div class="item--input-list">
                        <div class="el-input--title"><span>*</span>Cost</div>
                        <div class="">
                            <div class="price--list flex">
                                <els-number-input :value="form.cost"  @inputketup="form.cost = $event" @InputBlur="form.cost = $event" :error="Getiserror(form.cost)"></els-number-input>
                            </div>
                        </div>
                    </div>
                    <div class="margin--profit flex">
                        <div class="Margin">
                            <div class="Margin-title">Margin</div>
                            <div>{{form.Margin || '-'}}</div>
                        </div>
                        <div class="profix">
                            <div class="profix-title">Profit</div>
                            <div>{{form.Profit || '-'}}</div>
                        </div>
                    </div>
                    
                </div>
                <div class="el-input--title">Customers won’t see this</div>
                <el-checkbox v-model="checked">Charge tax on this product</el-checkbox>
            </div>
        </div>
        <div class="card-box-shadong">
            <div class="pricing-card card">
                <div class="from_input--title ">
                    <span>Inventory</span>
                </div>
                <div class="flex justify-between flex-wrap">
                    <div class="pricing_input--list">
                         <div class="pricing_input--list-sku">
                            <div class="el-input--title">SKU (Stock Keeping Unit)</div>
                            <el-input v-model="form.sku" placeholder="sku" ></el-input>
                        </div>
                        <div class="pricing_input--list-barcode">
                            <div class="el-input--title">Barcode (ISBN, UPC, GTIN, etc.)</div>
                            <el-input v-model="form.barcode" placeholder="Barcode" ></el-input>
                        </div>
                    </div>
                </div>
                <div class="pricing_input--list">
                    <el-checkbox size="medium" v-model="quantitystatus">Track quantity</el-checkbox>
                </div>
                
                <div class="pricing_input--list">
                    <el-checkbox size="mini" v-model="form.inventory_policy" :label="form.inventory_policy" >Continue selling when out of stock</el-checkbox>
                </div>
                
            </div>
            <div class="pricing-card">
                <div class="from_input--title ">
                    <span>QUANTITY</span>
                </div>
                <div class="flex">
                    <div class="price--list price--list-width">
                        <div class="el-input--title">Available</div>
                        <el-input type="number" v-model="form.quantity" placeholder="请输入内容"></el-input>
                    </div>
                     <div class="price--list price--list-width" style="margin-left: 20px;">
                        <div class="el-input--title">Incoming</div>
                        <div class="el_input-price">0</div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Shipping -->
        <div class="card-box-shadong Shipping--list card">
           <div class="shipping-card">
                <div class="from_input--title ">
                    <span>Shipping</span>
                </div>
                <div class="physical_product">
                    <el-checkbox v-model="shippingcheck">Charge tax on this product</el-checkbox>
                </div>
           </div>
           <div class="shipping-card weight" v-if="!shippingcheck">
                <div class="tips" style="font-size:14px;">Customers won’t enter their shipping address or choose a shipping method when buying this product.</div>
           </div>
           <div class="shipping-card weight" v-if="shippingcheck">
                <div class="shipping--title">
                    <span>WEIGHT</span>
                </div>
                <div class="physical_product">
                    <div class="tips">Used to calculate shipping rates at checkout and label prices during fulfillment.</div>
                </div>
                <div class="shipping--title weight-title" >Weight</div>
                <div class="shipping-weight-list">
                    <div class="shipping-weight-input">
                       <els-select-number-input :weight_unit="form.weight_unit" @handleCommand="handleCommand" :value="form.weight" @inputketup="form.weight = $event" @InputBlur="form.weight = $event"></els-select-number-input>
                    </div>
                </div>
           </div>
           <div class="shipping-card weight" v-if="shippingcheck">
                <div class="shipping--title">
                    <span>VOLUME</span>
                </div>
                <div class="physical_product">
                    <div class="tips">Price and freight used to calculate the volume of the item.</div>
                </div>
                <div class="volume-Parameters">
                    <!-- 长 -->
                    <div class="volume-list">
                        <div class="shipping--title weight-title" >Length</div>
                        <div class="shipping-weight-list">
                            <div class="volume-input">
                                <els-number-in :name="'cm'" :weight_unit="form.Length" @handleCommand="handleCommand" :value="form.Length" @inputketup="form.Length = $event" @InputBlur="form.Length = $event"></els-number-in>
                            </div>
                        </div>
                    </div>
                    <!-- 宽 -->
                    <div class="volume-list">
                        <div class="shipping--title weight-title" >wide</div>
                        <div class="shipping-weight-list">
                            <div class="volume-input">
                                <els-number-in :name="'cm'" :weight_unit="form.wide" @handleCommand="handleCommand" :value="form.wide" @inputketup="form.wide = $event" @InputBlur="form.wide = $event"></els-number-in>
                            </div>
                        </div>
                    </div>  
                    <!-- 高 -->
                    <div class="volume-list">
                        <div class="shipping--title weight-title" >high</div>
                        <div class="shipping-weight-list">
                            <div class="volume-input">
                                <els-number-in :name="'cm'" :weight_unit="form.high" @handleCommand="handleCommand" :value="form.high" @inputketup="form.high = $event" @InputBlur="form.high = $event"></els-number-in>
                            </div>
                        </div>
                    </div> 
                </div>
           </div>
           <div class="shipping-card weight" v-if="shippingcheck">
                <div class="shipping--title">
                    <span>CUSTOMS INFORMATION</span>
                </div>
                <div class="physical_product">
                    <div class="tips">Customs authorities use this information to calculate duties when shipping internationally. Shown on printed customs forms.</div>
                </div>
                <div class="weight-title-region">
                    <div class="shipping--title weight-title" >Country/Region of origin</div>
                    <div class="shipping-weight-list">
                        <el-select v-model="form.country_id" clearable placeholder="请选择" style="width:100%;">
                            <el-option
                                v-for="item in Countrylist"
                                :key="item.id"
                                :label="item.namecn"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="tips">In most cases, where the product is manufactured.</div>
                </div>
                <div class="weight-title-region">
                    <div class="shipping--title weight-title" >HS (Harmonized System) code</div>
                    <div class="shipping-weight-list">
                        <el-input v-model="form.HScode" placeholder="请输入" style="width:100%;" clearable></el-input>
                    </div>
                    <div class="tips">Manually enter codes that are longer than 6 numbers.</div>
                </div>
           </div>
        </div>
        <!-- Options -->
        <div class="card-box-shadong options">
            <div class="options--list card">
                <div class="from_input--title">
                    <span>Options</span>
                </div>
            </div>
            <div class="options--list" >
                <el-checkbox size="mini" v-model="optionscheck">This product has options, like size or color</el-checkbox>
            </div>
            <div class="product_options--list" v-if="optionscheck">
                <div  class="product--list-options" v-for="(optionsitem,optionsindex) in options" :key="optionsindex">
                    <div class="product--options-svg">
                        <!-- 图标 -->
                        <div class="svg" :class="{'options--icon-active':false}">
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">
                                <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"></path>
                            </svg>
                        </div>
                        <!-- 输入框 -->
                        <div class="options--input">
                            <div class="product--list-name">Options name</div>
                            <span v-if="!optionstaggel[optionsindex].toggelstatsu">{{optionsitem.name}}</span>
                            <el-select   
                                :class="{'el-input--error':optionsitem.name == '' && optionstaggel[optionsindex].changestatus || GetoptionsStatus(optionsindex,optionsitem.name)}" 
                                v-model="optionsitem.name" 
                                filterable 
                                default-first-option
                                placeholder="请选择" style="width:100%;" v-if="optionstaggel[optionsindex].toggelstatsu"  allow-create @change="Changeselect(optionsindex,$event)">
                                <el-option
                                    v-for="item in optionstype"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                    </el-option>
                            </el-select>
                            <div class="error-tag" v-if="optionsitem.name == '' && optionstaggel[optionsindex].changestatus || GetoptionsStatus(optionsindex,optionsitem.name)">
                                <i class="el-icon-warning"></i>
                                {{ optionsitem.name == '' && optionstaggel[optionsindex].changestatus?'请你选择属性或者输入':"你的属性重复了" }}
                            </div>
                        </div>
                        <!-- 后面图标 -->
                        <div class="options--icon" :class="{'options--icon-active':false}">
                            <i class="el-icon-delete-solid" @click="Deleteoptions(optionsindex)"></i>
                            <i class="el-icon-edit-outline" v-if="!optionstaggel[optionsindex].toggelstatsu" @click="taggleoptionstype(optionsindex)"></i>
                        </div>
                    </div>
                    <div class="product-value--list">
                        <block v-if="optionstaggel[optionsindex].toggelstatsu">
                            <div class="product--list-name-value">
                                <div class="optiosn-value-name">Option values</div>
                            </div>
                            <div class="product--options-svg" v-for="(valuesitems,valuesindex) in optionsitem.values" :key="valuesindex">
                                <div class="svg">
                                    <svg  viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">
                                        <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"></path>
                                    </svg>
                                </div>
                                <div class="options--input">
                                    <div class="el-input--list" >
                                        <el-input
                                            :ref="`depe${valuesindex}`"
                                            :class="{'el-input--error':GetinputStatus(optionsitem.values[valuesindex],optionsindex,)}" 
                                            v-model="optionsitem.values[valuesindex]"
                                            placeholder="请输入内容" 
                                            @keyup.delete="DeleteOptioninput($event,optionsindex,valuesindex)"
                                        ></el-input>
                                    </div>
                                </div>
                                <div class="options--icon" >
                                    <i class="el-icon-delete-solid"  @click="DeleteInput(optionsindex,valuesindex)" v-if="optionsitem.values.length >1"></i>
                                </div>
                            </div>
                            <div class="product--options-svg">
                                <div class="svg" >
                                    <!-- <svg  viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">
                                        <path d="M7 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 2zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 7 14zm6-8a2 2 0 1 0-.001-4.001A2 2 0 0 0 13 6zm0 2a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 8zm0 6a2 2 0 1 0 .001 4.001A2 2 0 0 0 13 14z"></path>
                                    </svg> -->
                                </div>
                                <div class="options--input">
                                    <div class="el-input--list" >
                                        <el-input 
                                            ref="indept"
                                            v-model="optionstaggel[optionsindex].InputValue"
                                            placeholder="请输入内容"
                                             :class="{'el-input--error':optionstaggel[optionsindex].InputValue == '' && optionstaggel[optionsindex].inputstatus}"
                                            @input="InputOptions(optionsindex,$event)"
                                        ></el-input>
                                        <!-- @blur="OptionsValues(optionsindex,$event)" -->
                                        <!-- @focus="FocusOptionvalue(optionsindex,$event)" -->
                                    </div>
                                </div>
                                <div class="options--icon" >
                                </div>
                            </div>
                            
                        </block>
                        <div class="product-value--tages" v-else>
                            <div class="product--value-tage--list">
                                <block  v-for="(inputitem,index) in optionsitem.values" :key="index">
                                    <div class="tags--list" v-if="inputitem.value != ''" :class="{'active':index === 0}">
                                        {{inputitem}}
                                    </div>      
                                </block>
                            </div>
                        </div>
                    </div>
                    <div class="product--list-btn" v-if="optionstaggel[optionsindex].toggelstatsu">
                        <el-button @click="NoNe(optionsindex)" >确定</el-button>
                    </div>
                </div>  
            </div>
            <block v-if="optionscheck">
                <div class="pricing-card-costper addvarubabs" @click="Addvarians" v-if="options.length  < 3">
                    <i class="el-icon-plus"></i>
                    <span>添加Variants</span>
                </div>
            </block>
        </div>
        <!-- Variants -->
        <div class="el_from--card card" v-if="optionscheck">
            <div class="Variants--title">
                <!-- <span>Variants</span> -->
                <div>Variants</div>
                <div class="select-variants">
                    <el-button size="mini" type="danger" @click="SelectEntid()" v-if="selectdeletelist.length > 0">删除</el-button>
                </div>
            </div>
            <el-table
                ref="multipleTable"
                :data="tableData"
                tooltip-effect="dark"
                style="width: 100%"
                @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        min-width="30"
                        fixed="left"
                        >
                    </el-table-column>
                <el-table-column
                    prop="variant"
                    label="Variant"
                    min-width="80"
                    fixed="left"
                    >
                    <template  #default="scope" >
                        <span v-for="(item,index) in scope.row.options" :key="index" :class="{'span--row':GetSttaut(scope.$index)}">{{item}}{{scope.row.options.length > 1 && index+1 != scope.row.options.length?' / ':''}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="market_price"
                    label="Price"
                    min-width="100">
                     <template  #default="scope">
                        <el-input  v-model="scope.row.market_price" placeholder="Please input" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="inventory_policy"
                    label="Quantity"
                    min-width="100"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input type="number" v-model="scope.row.inventory_quantity" placeholder="Please input" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="sku"
                    label="SKU"
                    min-width="100"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input  v-model="scope.row.sku" placeholder="Please input" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="barcode"
                    label="Barcode"
                    min-width="100"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input  v-model="scope.row.barcode" placeholder="Please input" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="..."
                    fixed="right"
                    min-width="80"
                    >
                    <template  #default="scope">
                        <div class="el-button--list">
                            <el-button size="mini" type="primary" @click="Edit(scope.$index,scope.row)" icon="el-icon-edit-outline"></el-button>
                            <el-button size="mini" type="danger" icon="el-icon-delete-solid" @click="deleteVariansclick(scope.$index,scope.row)" v-if="!GetSttaut(scope.$index)"></el-button>
                            <el-button size="mini" type="danger" icon="el-icon-refresh-right" v-else @click="Recovery(scope.$index,scope.row)"></el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>  
        </el-col>
        <el-col  :xs="24" :sm="24" :md="24" :lg="8" :xl="8" class="product-status">
            <div class="card-box-shadong border-radio--list" >
                <div class="product--status">
                    <div class="from_input--title">Product status</div>
                    <div class="title--input">
                        <el-select v-model="form.product_status" clearable placeholder="请选择">
                            <el-option
                            v-for="item in productstatuslist"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="prodct--title-alter">This product will be hidden from all sales channels.</div>
                </div>
                <!-- 选择product-type -->
                <div class="product--status">
                    <div class="from_input--title">Product Type</div>
                    <div class="title--input">
                        <el-cascader style="width:100%" v-model="form.category_id" :options="CategoryList" :props="{label:'name',value:'id'}" :show-all-levels="false" @change="CascaderChange"></el-cascader>
                        <div class="prodct--title-alter">Add this product to a collection so it’s easy to find in your store.</div>
                    </div>
                </div>
                
                <!-- 选择TAGS -->
                <div class="product--status">
                    <div class="from_input--title">TAGS</div>
                    <div class="title--input">
                        <el-select
                            v-model="form.tag_ids"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            clearable
                            placeholder="请选择">
                            <el-option
                            v-for="item in TagsList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                            </el-option>
                        </el-select>
                        <div class="prodct--title-alter">Add this product to a collection so it’s easy to find in your store.</div>
                    </div>
                </div>
                <!-- <div class="product--status">
                    <div class="from_input--title">Product Suppliers</div>
                    <div class="title--input">
                        <div class="standard">select supplier</div>
                        <el-select v-model="form.supplier_id" clearable placeholder="请选择商品供应商">
                            <el-option
                            v-for="item in SupplierList"
                            :key="item.id"
                            :label="item.supplier_name"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                </div> -->
            </div>
        </el-col>
        
        </div>
        <div class="el-button--cantal-cost-bottom flex ">
            <el-col  :xs="24" :sm="24" :md="24" :lg="15" :xl="15" >
                <div class="flex justify-end">
                    <loding-btn @LoadBTN="goBack">取消</loding-btn>
                    <loding-btn @LoadBTN="SavaProduct"  type="primary">确定</loding-btn>
                </div>
            </el-col>
        </div>
        <!-- 编辑varians -->
        <el-dialog
            v-model="dialogVisible"
            title="Edit 255/442"
            width="50%"
            :before-close="handleClose"
            top="5vh"
            custom-class="dialogvaisble-edit"
        >
            <div class="dialogvaisible--content" :class="{'dialogvaisible--content-checbox':!checked1}">
                <div class="Create_this_variant">
                    <el-checkbox v-model="checked1" size="medium" label="Create this variant"></el-checkbox>
                </div>
                <block v-if="checked1">
                    <div class="dialogvaisible_price">
                    <div class="title">Price</div>
                    <els-number-input :value="dialogitem.market_price" @inputketup="dialogitem.market_price = $event" @InputBlur="dialogitem.market_price = $event" :error="Getiserror(dialogitem.market_price)" ></els-number-input>
                    <div class="Cost_per_item">
                        <div class="cost">
                            <div class="title">Cost per item</div>
                            <els-number-input :value="dialogitem.cost" @inputketup="dialogitem.cost = $event" @InputBlur="dialogitem.cost = $event" :error="Getiserror(dialogitem.cost)" ></els-number-input>
                        </div>
                        <!-- <div class="cost_margin-profit">
                            <div class="margin">
                                <div>Margin</div>
                                <div>-</div>
                            </div>
                            <div class="margin">
                                <div>Profit</div>
                                <div>-</div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="INVENTORY">
                    <div class="INVENTORY-sku">
                        <div class="title">SKU (Stock Keeping Unit)</div>
                        <el-input v-model="dialogitem.sku"></el-input>
                    </div>
                    <div class="INVENTORY-Barcode">
                        <div class="title">Barcode (ISBN, UPC, GTIN, etc.)</div>
                        <el-input v-model="dialogitem.barcode"></el-input>
                    </div>
                </div>
                <!-- <div class="QUANTITY">
                    <div class="title">QUANTITY</div>
                    <div class="quanTity-name">
                        <div class="name">Location name</div>
                        <div class="name">Available</div>
                    </div>
                </div>
                <div class="QUANTITY-location">
                    <div class="title">深圳福田</div>
                    <div class="location-input">
                        <el-input type="number"></el-input>
                    </div>
                </div> -->
                <div class="CUSTOMS_INFORMATION">
                    <div class="title">CUSTOMS INFORMATION</div>
                    <div class="CUSTOMS_INFORMATION-HS">
                        <div class="title1">HS (Harmonized System) code</div>
                            <el-input v-model="dialogitem.HScode" placeholder="请输入HS (Harmonized System) code"></el-input>
                            <!-- <el-select
                                v-model="dialogitem.HScode"
                                placeholder="Please enter a keyword"
                            >
                            <el-option
                                v-for="item in bycodelist"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select> -->
                        <div class="title2">
                            Manually enter codes that are longer than 6 numbers.
                        </div>
                    </div>
                </div>
                <div class="Tips">
                   <div class="Tips--icon-title">
                       <i class="el-icon-warning"></i>
                       <div class="tips-title">Once you save the product, you’ll be able to edit more variant details.</div>
                   </div>
                </div>
                </block>
            </div>
            <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogVisible = false">取消</el-button>
                <el-button type="primary" @click="dialogVisible = false"
                >确定</el-button
                >
            </span>
            </template>
        </el-dialog>
    </el-main>
</el-container>
</template>

<script>
import { computed, reactive, toRefs,onMounted,ref} from 'vue'
import SidebarNavheader from '../../../components/Loyout/SidebarNav/SidebarNavheader.vue'
import Sidebar from '../../../components/Loyout/Sidebar/Sidebar.vue'
import OrderlistwangEditor from '../../Orderlist/OrderlistwangEditor.vue'
import router  from '../../../router'
import { isNaLL,Optionslist ,isRepeat,isRepeatoptions,DeleteVarians,Getquantity} from '../../../utils/utils'
import LodingBtn from '../../../components/lodingBtn/index.vue'
import { Addproduct ,GetproductCategoryList,GetproductTagsList} from '../../../api/Addproduct'
import { shoElmessage } from '../../../utils/Elmessage'
import ElsInput from '../../../components/input/els-Input.vue'
import ElsNumberInput from '../../../components/input/els-number-input.vue'
import ElsSelectNumberInput from '../../../components/input/els-select-number-input.vue'
import { netConfig } from '../../../config/net.config'
import { getAccessToken } from '../../../utils/AccessToken'
import ElsNumberIn from '../../../components/input/els-number-in.vue'
import { useRoute } from 'vue-router'
import { getSupplierList,getCountryList } from '@/api/Porductapi'
export default {
  components: { SidebarNavheader, Sidebar, OrderlistwangEditor, LodingBtn, ElsInput, ElsNumberInput, ElsSelectNumberInput, ElsNumberIn },
  data(){
      return{
            btnstatus:false,
            dialogVisible:false,
            options:[],
            optionstaggel:{},
            optionsvalues:"",
            deletetabel:[],
            selectdeletelist:[],
            quantitystatus:true,
            checked:true,
            checked1:true,
            quantity:"",
            bycodelist:[
                {
                    value:"020110",
                    label:"020110"
                },
                {
                    value:"020120",
                    label:"020120"
                },
                {
                    value:"020130",
                    label:"020130"
                },
                {
                    value:"020210",
                    label:"020210"
                }
            ],
            bycode:"",
            Country:"",
            shippingcheck:true,
            optionscheck:false,
            status:false,
            
      }
  },
  setup(props,content){
    const indept = ref();
    const data = reactive({
            shop_id:useRoute().query.id,
            baseUrl:netConfig.baseURL, //上传图片url
            image_urls:[], //上传图片文件
            headers:{
                token:getAccessToken(),
            }, //上传文件额外参数
            Online:"devDDinfotech",
            Standard:"",
            Inventory:[
                {
                    value:"Shopify",
                    label:"Shopify"
                },
                {
                    value:"Oberlo",
                    label:"Oberlo"
                }
            ],
            Organizationlist:[
                {
                    value:"GEEKRIA",
                    label:"GEEKRIA"
                },
                {
                    value:"devDDinfotech",
                    label:"devDDinfotech"
                }
            ],
            Organizationname:"devDDinfotech",
            productstatuslist:[
                {
                    value:0,
                    label:"active"
                },
                {
                    value:1,
                    label:"archived"
                },
                {
                    value:2,
                    label:"draft"
                }
            ],
            TagsList:[],
            CategoryList:[],
            form:{
                title:"",
                description:"",
                mediaimglist:"",
                constotal:0,
                Inventoryname:"Shopify",
                sku:"",
                barcode:"",
                costitem:"",
                cost:'',
                compareprice:'',
                market_price:'',
                quantity:"", //数量
                product_status:"",//状态
                tag_ids:"",//标签ids
                category_id:"", //分类id
                product_type:"", //产品分类
                weight:'', //重量
                weight_unit:"g", //重量单位
                inventory_policy:true, //缺货下单
                product_status:0,
                Length:"",//长
                wide:"",//宽
                high:"",//高
                Profit:"",
                Margin:"",

                //供应商
                supplier_id:"",
                country_id:"",
                HScode:"",

            },

            
            Countrylist:[],//国家
            SupplierList:[],//供应商



            optionstype:[
                {
                    value:"Size",
                    label:"Size"
                },
                {
                    value:"Color",
                    label:"Color"
                },
                {
                    value:"Material",
                    label:"Material"
                },
                {
                    value:"Style",
                    label:"Style"
                }
            ],
            
            
            tableData:[],
            Deletelist:[],
            
            //弹出框参数
            dialogitem:{
                barcode: "",
                bullet_point1: "",
                bullet_point2: "",
                bullet_point3: "",
                bullet_point4: "",
                bullet_point5: "",
                compare_at_price: "0.00",
                cost: "0.00",
                form: "",
                fulfillment_service: "",
                height: "0.00",
                image_id: 0,
                inventory_id: 0,
                inventory_management: "",
                inventory_policy: 0,
                inventory_quantity: 0,
                length: "0.00",
                market_price: "0.00",
                option1: "",
                option2: "",
                option3: "",
                shipping: "0",
                shopify_variant_id: 0,
                sku: "",
                weight: 0,
                weight_unit: "",
                width: "0",
                options:"",
            }
    })

    //返回上一页
    function goBack(){
        router.go(-1)
    }
    //添加varians
    // function Addvarians(){
    //     let optionsitem = {
    //         name:"",
    //         values:[],
    //     }
    //     data.options.push(optionsitem);
    // }
    //是否显示删除按钮
    function GetSttaut(index){
        if(data.Deletelist.indexOf(index) != -1){
            return true;
        }else{
            return false;
        }
        
    }
    //上传成功
    function Success(response, file, fileList){
        // console.log(response);
        data.image_urls = fileList
        if(response.code != 1){
            data.image_urls.splice(data.image_urls.indexOf(file),1);
            shoElmessage(true,`上传失败,原因：${response.msg}`,'error')
        }else{
            shoElmessage(true,'上传成功')
        }
        
    }
    function Remove(file, fileList){
        data.image_urls = fileList
    }
    //删除options
    function deletaoptions(index){
        data.options.splice(index,1)
    }
    function PriceInput(val){
        // console.log(val);
    //    data.form.cost = val
    }
    function comparepriceInput(val){
        data.form.compareprice = val
    }
    function marketInput(val){
      data.form.market_price = val
    }
    return {
        ...toRefs(data),
        goBack,
        // Addvarians,
        deletaoptions,
        GetSttaut,
        PriceInput,
        comparepriceInput,
        marketInput,
        Success,
        Remove
    }
  },
  watch:{
      'form.compareprice':{
          handler:function(val){
             if(isNaLL(this.form.cost)){
               this.form.Margin = (1-(parseInt(val) - parseInt(this.form.market_price)).toFixed(2))
             }
          },
          deep:true,
      },
      'form.market_price':{
          handler:function(val){
            if(isNaLL(this.form.cost)){
                this.form.Profit     
                = (parseFloat(this.form.market_price) - parseFloat(this.form.cost)).toFixed(2) != 'NaN'?(parseFloat(this.form.market_price) - parseFloat(this.form.cost)).toFixed(2)+'CN￥':'-'
                let margin = (parseFloat(this.form.cost) / parseFloat(this.form.market_price)).toFixed(2);
                let margins = ((1-margin)*100).toFixed(1)
                this.form.Margin = margins != 'NaN' && margins != 0?margins+'%':'-'
             }
          },
          deep:true,
      },
      'form.cost':{
          handler:function(val){
             if(isNaLL(this.form.market_price)){
                this.form.Profit     
                = (parseFloat(this.form.market_price) - parseFloat(this.form.cost)).toFixed(2) != 'NaN'?(parseFloat(this.form.market_price) - parseFloat(this.form.cost)).toFixed(2)+'CN￥':'-'
                let margin = (parseFloat(this.form.cost) / parseFloat(this.form.market_price)).toFixed(2);
                let margins = ((1-margin)*100).toFixed(1)
                this.form.Margin = margins != 'NaN' && margins != 0?margins+'%':'-'
             }
             
          },
          deep:true,
      },
  },
    mounted(){
        this.productCategoryList();
        this.productTagsList();
        this.ObtainSupplierList();
        this.ObtainCounty();
    },
    methods:{
         //商品供应商
        ObtainSupplierList(){
            getSupplierList().then(res =>{
                if(res.code == 1){
                    this.SupplierList = res.data
                }
            })
        },
        //商品国家
        ObtainCounty(){
            getCountryList().then(res =>{
                if(res.code == 1){
                    this.Countrylist = res.data
                }
            })
        },
        //商品TAG列表
        productTagsList(){
            GetproductTagsList({}).then(res =>{
                if(res.code === 1){
                   this.TagsList = res.data
                }
            })
        },
        //选择商品分类
        CascaderChange(e){
            // console.log(e);
            console.log(this.form.category_id);
        },
        //商品分类列表
        productCategoryList(){
            GetproductCategoryList({}).then(res =>{
                if(res.code === 1){
                    this.CategoryList = res.data[0].children
                }
            })
        },
        Changeselect(index,item){
            // console.log(index,item);
        },
       InputOptions(index,e){
        this.optionstaggel[index].inputstatus = false;
        if(isNaLL(e)){
            this.options[index].values.push(e);
            this.$refs.indept.blur();
            this.optionstaggel[index].InputValue = ''
            this.$nextTick(() =>{
                this.$refs[`depe${this.options[index].values.length -1}`].focus();
            })
        }
    },
    DeleteOptioninput(event,opindex,vaindex){
        let value = event.target.value
        if(!isNaLL(value)){
            this.options[opindex].values.splice(vaindex,1);
            if(vaindex>0){
                this.$refs[`depe${vaindex-1}`].focus();
            }
        }
        
    },
    GetinputStatus:function(item,index){
        let i = 0;
        this.options[index].values.forEach((el) =>{
            if(el == item){
                 i++;
            }
        })
        return i>=2;
    },
    //删除options下的输入
    DeleteInput(index,optionsindex){

        this.options[index].values.splice(optionsindex,1);
    },
    //删除整个options
    Deleteoptions(optionsindex){
        this.options.splice(optionsindex,1);
        this.tableData = Optionslist(this.options);
    },
    //获取下拉框的是否报红
    GetSelectOptions(name,index){
        if(this.options[index].changestatus){
            if(isNaLL(this.options[index].name)){
                return true;
            }
        }
        return false;
    },
    //确定按钮
    NoNe(index){
        if(!isNaLL(this.options[index].name)){
            this.optionstaggel[index].changestatus = true;
            if(this.options[index].values.length == 0){
                this.optionstaggel[index].inputstatus = true;
                return;
            }
            return;
        }else{
            if(this.options[index].values.length == 0){
                this.optionstaggel[index].inputstatus = true;
                return;
            }
        }
        //判断是否values重复
        let isrepeat =  isRepeat(this.options[index].values);
        if(isrepeat){
            return;
        }

        let isrepeatname = isRepeatoptions(this.options,'name');
        // console.log(isrepeatname);
        if(isrepeatname){
            return;
        }
        this.optionstaggel[index].toggelstatsu = !this.optionstaggel[index].toggelstatsu

        this.tableData = Optionslist(this.options);
    },
    //所有的options折叠栏
    taggleoptionstype(index){
        this.optionstaggel[index].toggelstatsu = !this.optionstaggel[index].toggelstatsu
    },
    //获取输入框的状态
    GetinputValue(index,name){
        if(this.optionstaggel[index].inputstatus){
            if(this.options[index].values.length === 0){
                if(!isNaLL(name)){  
                    return true;
                }
            }
        }
        return false;
    },
    //获取options状态
    GetoptionsStatus(index,name){
        if(name == ''){
            return false;
        }
        for(let i=0;i<this.options.length;i++){
            if(index != i){
                if(name == this.options[i].name){
                    return true;
                }
            }
        }
    },
    //保存商品
     SavaProduct(){
        let list = Getquantity(this.tableData,this.form.quantity)
        this.tableData = list;
        this.status = true;
        if(!isNaLL(this.form.title)){
            return shoElmessage(true,'新增失败，请输入商品标题','error');
        }
        if(!isNaLL(this.form.cost)){
            return shoElmessage(true,'新增失败，请输入商品价格','error');
        }
        if(!isNaLL(this.form.compareprice)){
            return shoElmessage(true,'新增失败，请输入对比价格','error');
        }
        if(!isNaLL(this.form.market_price)){
            return shoElmessage(true,'新增失败，请输入市场价','error');
        }


        let image_url;
        for(let i=0; i<this.image_urls.length;i++){
            if(!isNaLL(image_url)){
                image_url = this.image_urls[i].response.data.url
            }else{
                image_url = `${image_url},${this.image_urls[i].response.data.url}`
            }
        }
    
        Addproduct({
            title:this.form.title, //标题
            description:this.form.description, //富文本
            shop_id:this.shop_id, //店铺id
            out_link:"", //在线链接
            sku:this.form.sku, //sku
            cost:this.form.cost, //
            compare_at_price:this.form.compareprice,
            market_price:this.form.market_price,
            shipping:this.form.shipping, //运费价
            barcode:this.form.barcode, //条码 
            image_urls:image_url || '', //图片
            quantity:this.form.quantity,//数量

            options:JSON.stringify(this.options),
            variants:JSON.stringify(this.tableData),
            product_status:this.form.product_status,//状态
            tag_ids:this.form.tag_ids.join(','),//标签ids
            category_id:this.form.category_id[this.form.category_id.length - 1] || '', //分类id
            product_type:this.form.product_type, //产品分类
            weight:this.form.weight, //重量
            weight_unit:this.form.weight_unit, //重量单位
            inventory_policy:this.form.inventory_policy?1:0, //缺货下单

            height:this.form.high,//高
            width:this.form.wide,//宽
            length:this.form.Length, //长

            country_id:this.form.country_id, //国家
            supplier_id:this.form.supplier_id, //供应商
            HScode:this.form.HScode //hScode
        }).then(res =>{
            if(res.code == 1){
                this.goBack();
                shoElmessage(true,'新增成功')
            }else{
                shoElmessage(true,`新增失败${res.msg}`,'error')
            }
        })
    },
    //添加varians
    Addvarians(){
        let data = {
                    name:"",
                    values:[
                        
                    ],
                }
        let optionsdata = {
                toggelstatsu:true,
                changestatus:false,
                inputstatus:false,
                InputValue:""
        }
        this.options.push(data);
        this.optionstaggel[this.options.length-1] = optionsdata
    },
    //备删除项
    GetSttaut(index){
        return this.deletetabel.indexOf(index) != -1;
    },
    //恢复varians
    Recovery(index){
          if(this.deletetabel.indexOf(index) != -1){
              this.deletetabel.splice(this.deletetabel.indexOf(index),1);
          }
    },  
    //删除varians
    deleteVariansclick(index,item){
        this.deletetabel.push(index);
        let deletestatus = DeleteVarians(this.tableData,item,this.options,this.deletetabel)
        // console.log(deletestatus);
        if(!deletestatus.deletestatus){
            this.deletetabel = deletestatus.indexlist
        }else{
            // console.log(deletestatus);
            this.options = deletestatus.indexlist
            this.tableData = Optionslist(this.options);
            this.deletetabel = [];
        }
    },
    //编辑varians
    Edit(index,item){
        this.dialogVisible = true;
        this.dialogitem = item
        // console.log(index,item);
    },
    handleSelectionChange(e){
        // console.log(e);
        this.selectdeletelist = e
    },
    //选择删除
    SelectEntid(){
        if(this.selectdeletelist.length === this.tableData.length){
            this.options = []
            this.tableData = Optionslist(this.options);
        }else{
            for(let i=0; i<this.selectdeletelist.length;i++){
                this.deleteVariansclick(i,this.selectdeletelist[i])
            }
        }
    },
    //输入框
    Getiserror(item){
        if(!isNaLL(item) && this.status){    
            return true;
        }
        return false;
    },
    //重量单位
    handleCommand(e){
        this.form.weight_unit = e;
    },
    //文本编辑
    editorChange(e){
        this.form.description = e;
    },
    Onfocus(e){
        console.log(e);
    },
    Onblur(e){
        console.log(e);
    },
    //上传失败
    UploadError(e){
        console.log(e);
    },
    //文件上传成功，失败，添加，删除
    UploadChange(e){
        console.log(e);
    },
    BeforeUpload(e){
        console.log(e,1232);
    },
    handleClose(){
        this.dialogVisible = false;
    }
  },
}
</script>

<style scoped lang="scss">
.el-header{
    background-color: #fff;
}
.container-fainal{
    margin:0 auto;
    width: 80%;
}
.from_input--title{
    font-size: 16px;
    padding: 10px 0px;
    font-weight: bold;
}
.Variants--title{
    font-size: 16px;
    padding: 10px 0px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card{
    margin-top: 10px;
}
.el_from--card{
    padding: 2rem;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 
            //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
            0 0 4px 0 rgba(0, 0, 0, 0.2);
}
:deep(.el-upload){
     width: 100%;
}
:deep(.el-upload-dragger){
    width: 100%;
    height: 100%;
    line-height:normal;
}
.el-input--number{
    width: 48%;
    height: auto;
}
.el-input--title--cn{
    display: flex;
    align-items: center;
    height: 40px;
    line-height: 40px;
    padding-left: 15px;
    // border:var(--el-input-border,var(--el-border-base));
    border-radius: var(--el-input-border-radius,var(--el-border-radius-base));
    border-top-right-radius: none;
    border-bottom-right-radius: none;
}
.el-input--title{
    font-size: 14px;
    color: rgba(0, 0, 0, 0.5);
    height: 40px;
    line-height: 40px;
    span{
        color: #f80000;
    }
}
.card-box-shadong{
    box-shadow: 
            //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
            0 0 4px 0 rgba(0, 0, 0, 0.2);   
    border-radius: 5px;
}
.pricing-card{
    padding: 20px 20px 20px 20px;
    background-color: #fff;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    border-bottom: 0.1rem solid #e1e3e5;
}
.pricing-card-costper{
    padding: 20px 20px 20px 20px;
    background-color: #fff;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    // border-bottom: 0.1rem solid var(--p-divider);
}
.el_input-price{
    height: 40px;
    line-height: 40px;
}
.pricing_input--list{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    .el-input--title{
        width: 100%;
    }
    .pricing_input--list-sku,.pricing_input--list-barcode{
        width: 48%;
    }
}
.Shipping--list{
    .shipping-card{
        padding: 20px;
        background-color: #fff;
        border-bottom: 1px solid #e1e3e5;
    }
    .weight-title-region{
        margin-top: 15px;
    }
    .weight-title{
        margin-bottom: 4px;
        font-weight: 400;
    }
    .tips{
        padding: 10px 0px;
        font-size: 12px;
        color: rgba(109, 113, 117, 1);
    }
    .physical_product{
        width: 100%;
    }
}
.item--input-list{
    width: 48%;
}
.shipping--title{
    font-size: 12px;
    font-weight: 600;
    width: 100%;
}
.volume-Parameters{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    .volume-list{
        width: 50%;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        padding: 5px;
    }
    .volume-input{
      width: 100%;
    }
}

.shipping-weight-list{
    width: 100%;
    .shipping-weight-input{
      width: 50%;
    }
}
.header---title-s{
    padding-bottom: 10px;
    .navtions-icon{
        width: 35px;
        height: 35px;
        line-height: 38px;
        // border: 1px solid rgba(186, 191, 195, 1);
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 0 4px 0 rgb(0 0 0 / 20%);
        background-color: #fff;
        i{
            font-size: 20px;
            font-weight: bold;
            color: rgba(109, 113, 117, 1);
        }
    }
    .el-button--cantal-cost{
        position: relative;
        bottom: 0px;
        padding: 0px;
    }
}
.addvarubabs{
    font-size: 14px;
    cursor: pointer;
    border-top:1px solid  #e1e3e5;
    // margin-top: 20px;
    span{
        margin-top: 10px;
    }
}
.scope--img{
    width: 100%;
    height: 100%;
    color: #6f6f91;
    font-weight: 600;
    img{
        width: 100%;
        height: 100%;
    }
}
.margin--profit{
    width: 48%;
    font-size: 14px;
    .Margin{
        width: 50%;
    }
    .Margin-title,.profix-title{
        color: rgba(109, 113, 117, 1);
    }
}

//options
.options{
    background-color: #fff;
}
.options--list{
   padding:10px 20px;
}
.product--list-options{
    border-top:1px solid  #e1e3e5;;
    padding: 1.2rem 2rem 0.5rem 2rem;
}
.product--list-name{
    padding-bottom: 5px;
    font-size: 14px;
}
.product--list-name-value{
    display: grid;
    grid-template-columns: 1.2rem 1fr minmax(2.8rem, min-content);
    align-content: center;
    gap: 1.2rem;
    margin-top: 10px;
}
.optiosn-value-name{
    grid-column: 2;
    font-size: 14px;
    padding-bottom: 5px;
}
.el-input--list{
    .el-input{
        margin-top: 10px;
        margin-bottom: 5px;
        &:first-child{
            margin-top: 0px;
        }
        
    }
}
.el-input--error{
    :deep(.el-input__inner){
        border: 1px solid #f80000;
    }
}
.product-value--list .product--options-svg{
    .svg,.options--icon{
        padding-top: 0px;
        i{
            margin-left: 10px;
        }
    }
}
.product--options-svg{
    width: 100%;
    display: grid;
    grid-template-columns: 1.2rem 1fr minmax(2.8rem,min-content);
    gap: 1.2rem;
    align-content: center;
    // align-items: center;
    
    .svg{
        padding-top: 25px;
        text-align: right;
        svg{
            fill: #5c5f62;
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
        }
    }
    
}
.options--icon{
    padding-top: 20px;
    cursor: pointer;
    i{
        margin-left: 10px;
    }
}
.product--list-btn{
    width: 100%;
    display: grid;
    grid-template-columns: 1.2rem 1fr minmax(2.8rem,min-content);
    gap: 1.2rem;
    align-content: center;
    .el-button{
        grid-column: 2;
        width: 80px;
    }
    // margin-bottom: 10px;
}
.product_options--list{
    width: 100%;
    height: auto;
    .product--options-btn{
        padding-left: 20px;
        margin-bottom: 10px;
    }
}
.product_optios--list-enpty{
    border-top:1px solid  #e1e3e5;;
    padding: 1.2rem 2rem 0 2rem;
    display: grid;
    grid-template-columns: 1.2rem 1fr minmax(2.8rem,min-content);
    gap: 1.2rem;
    .svg{
        padding-top: 25px;
        text-align: right;
        grid-row: 1/1;
        grid-column: 1/1;
        svg{
            fill: #5c5f62;
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
        }
    }
    
}
.product-value--tages{
    width: 100%;
    display: grid;
    height: auto;
    grid-template-columns: 1.2rem 1fr minmax(2.8rem, min-content);
    gap: 1.2rem;
    align-content: center;
    margin-top: 10px;
    .product--value-tage--list{
        width: 100%;
        height: 100%;
        grid-column: 2/2;
        grid-row: 1/2;
        display: flex;
        flex-wrap: wrap;
    }
    .tags--list{
        padding: 4px 10px;
        background-color: #e4e5e7;
        color: #000;
        border-radius: 2rem;
        margin-left: 10px;
        font-size: 12px;
        margin-top: 5px;
    }
    .active{
        margin-left: 0px;
    }
}
.product--options-svg{
    .options--icon-active{
        padding-top: 0px;
    }
}
.options--icon-active{
    padding-top: 0px;
}

//确定按钮
.el-button--cantal-cost{
    display: flex;
    justify-content: flex-end;
    padding: 20px;

    .lodingBtn{
        margin-left: 10px;
    }
}
//右边
.border-radio--list{
    border-radius: 10px;
}
.product--status{
    // width: 100%;
    padding: 20px;
    background-color: #fff;
    border-bottom:1px solid rgba(225, 227, 229, 1);
    &:first-child{
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    &:last-child{
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .prodct--title-alter{
        font-size: 14px;
        color: rgba(109, 113, 117, 1);
        margin-top: 10px;
    }
    .el-select{
        width: 100%;
    }
    .vendor,.standard{
        font-size: 14px;
        margin-bottom: 5px;
        color: rgba(109, 113, 117, 1);
    }
}
.error-tag{
    font-size: 12px;
    color: rgb(233, 0, 0);
    padding: 2px 0px;
}
.span--row{
    text-decoration: line-through;
    color: #d4d4d4;
}
:deep(.el-upload--picture-card){
    height: 150px;
}
.el-button--list{
    display:flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
    .el-button+.el-button{
        margin-left: 0px;
        margin-top:5px;
    }
}
.el-button--cantal-cost-bottom{
    width:100%;
    .lodingBtn{
        margin-top:10px;
        margin-left: 10px;
    }
}

</style>
<style lang="scss">
.dialogvaisble-edit{
    .el-dialog__header{
        border-bottom: 1px solid rgba(225, 227, 229, 1);
    }
    .el-dialog__body{
        
        padding:0px;
        .dialogvaisible--content{
            height: 70vh;
            overflow: auto;
            transition: all 0.8s;
        }
        .dialogvaisible--content-checbox{
            height: 20vh;
            overflow: auto;
            transition: all 0.8s;
        }
        .Create_this_variant{
            padding: 20px;

        }
        .dialogvaisible_price{
            padding: 20px;
            border-bottom: 1px solid rgba(225, 227, 229, 1);
            .Cost_per_item{
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                margin-top: 20px;
            }
            .cost_margin-profit{
                width: 50%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: space-around;
                margin-left: 10px;
            }
        }
        
    }
    .INVENTORY{
        padding: 20px;
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
        .INVENTORY-sku{
            width: 48%;
        }
         .INVENTORY-Barcode{
            width: 48%;
        }
    }
    .QUANTITY{
        padding: 20px;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
        .quanTity-name{
            display:flex;
            padding:20px 0px;
            justify-content: space-between;
        }
    }
    .QUANTITY-location{
        display: flex;
        padding: 20px;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
    }
    .CUSTOMS_INFORMATION{
        padding: 20px;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
        .CUSTOMS_INFORMATION-HS{
            margin-top: 20px;
            .title1{
                font-weight: 400;
                font-size: 14px;
                -webkit-tap-highlight-color: transparent;
                margin-bottom:5px;
            }
            .title2{
                font-weight: 400;
                font-size: 12px;
                text-transform: none;
                letter-spacing: normal;
                color: rgb(158, 158, 158);
                margin-top:5px;
            }
        }
    }
    .Tips{
        padding: 20px;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
    }
    .title{
        word-break: break-word;
        overflow-wrap: break-word;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 0.4rem;
    }
    .Tips--icon-title{
        display: flex;
        align-items: center;
        i{
            font-size: 30px;
        }
        .tips-title{
            margin-left: 10px;
        }
    }
    .el-dialog__footer{
        border-top: 1px solid rgba(225, 227, 229, 1);
    }
}
.product-status{
    margin-left:20px;
}
@media only screen and (max-width: 1200px){
    .product-status{
        margin-left:0px;
        margin-top:20px;
        width: 100%;
    }
}
@media only screen and (max-width: 790px){
    .container-fainal{
        width: 100% !important;
        margin:0 auto;
    }
}

</style>