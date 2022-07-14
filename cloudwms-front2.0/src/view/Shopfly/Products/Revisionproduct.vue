<template>
<el-container>
    <el-header>
        <sidebar LogoName="修改商品"></sidebar>
    </el-header>
    <el-main class="flex flex-wrap" >
        <div class="container-fainal" >
        <div class="header---title-s flex justify-between">
            <div class="navtions-icon" @click="goBack">
                <i class="el-icon-back"></i>
            </div>
            <div class="el-button--cantal-cost">
                <loding-btn  @LoadBTN="goBack">取消</loding-btn>
                <loding-btn @LoadBTN="SavaProduct" type="primary">确定</loding-btn>
            </div>
        </div>
        <el-col :xs="24" :sm="24" :md="24" :lg="15" :xl="15" v-loading="loading">
        <div class="el_from--card">
            <div class="from_input--title">
                <span style=" color: #f80000;">*</span>
                Title
            </div>
            <div class="title--input">
              <el-input v-model="form.title" :class="{'el-input--error':form.title == '' && status}"   placeholder="Polaris-TextField__Input_30ock"></el-input>
            </div>
            <div class="from_input--title">Description</div>
            <div class="editor">
              <orderlistwang-editor 
                    :editor="form.description"
                    @Change="editorChange"
                    @Onfocus="Onfocus"
                    @Onblur="Onblur"
                    ref="description"
              ></orderlistwang-editor>
            </div>
        </div>
        <div class="el_from--card card">
            <div class="from_input--title">
                <span>Media</span>
            </div>
            <div class="upload-demo">
                <el-upload
                    drag
                    :headers="headers"
                    :action="baseUrl + '/api/user/upload'"
                    list-type='picture-card'
                    :on-remove="Remove"
                    :on-success="Success"
                    :file-list="image_urls"
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
                            <div>{{form.Margin}}</div>
                        </div>
                        <div class="profix">
                            <div class="profix-title">Profit</div>
                            <div>{{form.Profit}}</div>
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
                     <!-- <div class="price--list price--list-width" style="margin-left: 20px;">
                        <div class="el-input--title">Incoming</div>
                        <div class="el_input-price">0</div>
                    </div> -->
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
                        <el-select v-model="form.country_id" placeholder="请选择" style="width:100%;">
                            <el-option
                            v-for="item in CountryList"
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
                        <el-input placeholder="请输入" v-model="form.HScode" style="width:100%;"></el-input>
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
                        <div class="options--icon" :class="{'options--icon-active':optionstaggel[optionsindex].toggelstatsu}">
                            <i class="el-icon-delete-solid" @click="Deleteoptions(optionsindex)" v-if="optionstaggel[optionsindex].toggelstatsu"></i>
                            <i class="el-icon-edit-outline" v-if="!optionstaggel[optionsindex].toggelstatsu" @click.stop="taggleoptionstype(optionsindex)"></i>
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
                <div class="pricing-card-costper addvarubabs" @click="Addvarians" v-if="options.length < 3">
                    <i class="el-icon-plus"></i>
                    <span>添加Variants</span>
                </div>
            </block>
        </div>
        <!-- Variants -->
        <div class="el_from--card card" v-if="optionscheck">
            <div class="Variants--title">
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
                        width="35"
                        fixed="left"
                        >
                    </el-table-column>
                    <el-table-column
                        width="100"
                        fixed="left"
                        >
                        <template #default="scope">
                            <!-- <span></span> -->
                            
                            <div class="scope-img" @click="FollowupImg(scope.row,scope.$index)" >
                                <!-- <img > -->
                                <el-image style="width:100%;height:100%;" :src="GetFollowImg(scope.row.image_id)" v-if="scope.row.image_id != '' && scope.row.image_id != ''" fit="fit"></el-image>
                                <svg v-else viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true"><path d="M19 2.5A1.5 1.5 0 0 0 17.5 1h-15A1.5 1.5 0 0 0 1 2.5v15A1.5 1.5 0 0 0 2.5 19H10v-2H3.497c-.41 0-.64-.46-.4-.79l3.553-4.051c.19-.21.52-.21.72-.01L9 14l3.06-4.781a.5.5 0 0 1 .84.02l.72 1.251A5.98 5.98 0 0 1 16 10h3V2.5zm-11.5 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm12.207 10.793A1 1 0 0 0 19 15h-2v-2a1 1 0 0 0-2 0v2h-2a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 0 0 .707-1.707z"></path></svg>
                            </div>
                        </template>
                    </el-table-column>
                <el-table-column
                    prop="variant"
                    label="Variant"
                    width="80"
                    >
                    <template  #default="scope" >
                        <span :class="{'span--row':GetSttaut(scope.row)}">{{GetVariantTilte(scope.row)}}</span>
                        <!-- <span v-for="(item,index) in scope.row.options" :key="index" :class="{'span--row':GetSttaut(scope.$index)}">{{item}}{{scope.row.options.length > 1 && index+1 != scope.row.options.length?' / ':''}}</span> -->
                    </template>
                </el-table-column>
                <el-table-column
                    prop="Price"
                    label="Price"
                    min-width="110"
                    >
                     <template  #default="scope">
                        <el-input  v-model="scope.row.market_price" placeholder="请输入价格" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="Quantity"
                    label="Quantity"
                    min-width="110"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input type="number" v-model="scope.row.inventory_quantity" placeholder="请输入库存" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="sku"
                    label="SKU"
                    min-width="110"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input  v-model="scope.row.sku" placeholder="请输入sku" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="Barcode"
                    label="Barcode"
                    min-width="110"
                    show-overflow-tooltip>
                    <template  #default="scope">
                        <el-input  v-model="scope.row.barcode" placeholder="请输入barcode" />
                    </template>
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="Edit"
                    fixed="right"
                    width="80"
                    >
                    <template  #default="scope">
                        <div class="el-button--list">
                            <el-button size="mini" type="primary" @click="Edit(scope.$index,scope.row)" ></el-button>
                            <el-button size="mini" type="danger"    @click="deleteVariansclick(scope.$index,scope.row)" v-if="!GetSttaut(scope.row)"></el-button>
                            <el-button size="mini" type="danger" icon="el-icon-refresh-right" v-else @click="Recovery(scope.row)"></el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>  
        </el-col>
        <el-col  :xs="24" :sm="24" :md="24" :lg="8" :xl="8" class="product-status" v-loading="loading">
            <div class="card-box-shadong border-radio--list" >
                <div class="product--status">
                    <div class="from_input--title">Product status</div>
                    <div class="title--input">
                        <el-select v-model="form.product_status" placeholder="请选择">
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
                        <el-select v-model="form.supplier_id" placeholder="请选择">
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
        <div class="el-button--cantal-cost-bottom flex">
            <el-col  :xs="24" :sm="24" :md="24" :lg="15" :xl="15" >
                <div class="flex justify-end">
                    <loding-btn @LoadBTN="goBack">取消</loding-btn>
                    <loding-btn @LoadBTN="SavaProduct" type="primary">确定</loding-btn>
                </div>
            </el-col>
        </div>
        <!-- 编辑varians -->
        <el-dialog
            v-model="dialogVisible"
            :title="`Edit ${GetVariantTilte(dialogitem)}` "
            width="50%"
            top="5vh"
            custom-class="dialogvaisble-edit"
        >
            <div class="dialogvaisible--content" :class="{'dialogvaisible--content-checbox':!checked1}">
                <div class="Create_this_variant">
                    <el-checkbox v-model="checked1" size="medium" label="Create this variant"></el-checkbox>
                </div>
                <div class="supplementary" v-if="!checked1">This variant will not be created when you save this product.</div>
                <block v-if="checked1">
                    <div class="dialogvaisible_price" >
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
                            <el-input placeholder="请输入" v-model="dialogitem.HScode" style="width:100%;"></el-input>
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
        <!-- 修改图片 -->
        <el-dialog
            v-model="variantiamges"
            title="Select variant image"
            width="50%"
            top="5vh"
            custom-class="variantiamges-edit"
        >
            <div class="Polaris-Modal-Section_1b1h1">
                <div class="modal--title">
                    <span>You can only choose images as variant media</span>
                </div>
                <div class="Polaris-Stack__Item_yiyol">
                    <div class="Polaris-DropZone__Container_13mbo">
                        <div class="_2bRuW" >
                            <!-- <div class="OxOGX">
                                <el-upload
                                    class="upload-demo"
                                    drag
                                    action="https://jsonplaceholder.typicode.com/posts/"
                                    multiple>
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text">Add images</div>
                                </el-upload>
                            </div> -->
                            <div class="OxOGX" v-for="(item,index) in variantiamgeslist" :key="index" @click="SelectImg(item)" :class="{'OxOGXActive':item.id == image_id}">
                                <div class="_14-Wv" v-if="item.id == image_id"></div>
                                <img class="D7PNX" :src="item.url">
                                <div class="_5JIkb" v-if="item.id == image_id">
                                    <img src="https://cdn.shopifycdn.net/shopifycloud/web/assets/v1/7a68ccb72ddf127282b5994dd9eedf27.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <div class="Pagination-footer">
                    <div class="Pagination">
                        <div class="navtions-icon-left " :class="{'sho-left':varPagination>1 && varPagination<=totalpageination}" @click="PaginLeft">
                            <i class="el-icon-arrow-left"></i>
                        </div>
                        <div class="navtions-icon-rigth " :class="{'sho-rigth':totalpageination>varPagination}" @click="PaginRight">
                            <i class="el-icon-arrow-right"></i>
                        </div>
                    </div>
                    <span class="dialog-footer">
                        <el-button @click="variantiamges = false">取消</el-button>
                        <el-button type="primary" @click="SelectImgSumbit"
                        >确定</el-button
                        >
                    </span>
                </div>
                
            </template>
        </el-dialog>
    </el-main>
</el-container>
</template>

<script>
import { computed, reactive, toRefs,onMounted,ref} from 'vue'
import SidebarNavheader from '@/components/Loyout/SidebarNav/SidebarNavheader.vue'
import Sidebar from '@/components/Loyout/Sidebar/Sidebar.vue'
import OrderlistwangEditor from '../Orderlist/OrderlistwangEditor.vue'
import router  from '@/router'
import { isNaLL ,isRepeat,isRepeatoptions,RevisionproductDeleteVarians, Getimgname,ProductType} from '@/utils/utils'
import LodingBtn from '@/components/lodingBtn/index.vue'
import { Addproduct ,GetproductCategoryList,GetproductTagsList} from '@/api/Addproduct'
import { shoElmessage } from '@/utils/Elmessage'
import ElsInput from '@/components/input/els-Input.vue'
import ElsNumberInput from '@/components/input/els-number-input.vue'
import ElsSelectNumberInput from '@/components/input/els-select-number-input.vue'
import { netConfig } from '@/config/net.config'
import { getAccessToken } from '@/utils/AccessToken'
import { UpdateProduct } from '@/api/Revisionproduct'
import { GetProductlist,GetshopifyProdutList,getSupplierList,getCountryList } from '@/api/Porductapi'
import { useRoute } from 'vue-router'
import ElsNumberIn from '@/components/input/els-number-in.vue'
import { RevisionOptionslist ,DeleteVariantsAlgorithm,Assembling} from '@/utils/VariantsUtils'
export default {
  components: { SidebarNavheader, Sidebar, OrderlistwangEditor, LodingBtn, ElsInput, ElsNumberInput, ElsSelectNumberInput,ElsNumberIn },
  data(){
      return{
          dialogVisible:false,
          options:[
                // {
                //     name:"Size",
                //     values:[
                //        123123,555,88
                //     ],
                // }
            ],
            optionstaggel:{

            },
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
            Countrylist:[
                {
                    value:"Afghanistan",
                    label:"Afghanistan"
                },
                {
                    value:"Åland Islands",
                    label:"Åland Islands"
                },
                {
                    value:"Albania",
                    label:"Albania"
                },
                {
                    value:"Algeria",
                    label:"Algeria"
                }
            ],
            shippingcheck:false,
            optionscheck:false,
            status:false,
            
      }
  },

  setup(props,content){
    const indept = ref();
    const data = reactive({
            loading:false,
            query:useRoute().query,
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
                tag_ids:[],//标签ids
                category_id:"", //分类id
                product_type:"", //产品分类
                weight:'', //重量
                weight_unit:"g", //重量单位
                inventory_policy:true, //缺货下单
                product_status:0,
                delete_image_ids:[],//删除图片的id

                Length:"",//长
                wide:"",//宽
                high:"",//高


                //供应商
                supplier_id:"",
                country_id:"",
                HScode:"",

                 Margin:"",
                 Profit:""
            },
            CountryList:[],//国家
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
            
            //varian
            tableData:[],
            // 待删除
            Deletelist:[],
            
            //弹出框参数
            dialogitem:{
                availableQuantity: 0,
                imagesId: "",
                price: "",
                sku: "",
                Barcode:"",
                inventoryItem:{
                    cost: "100.00",
                    countryCodeOfOrigin: null,
                    harmonizedSystemCode: null,
                    provinceCodeOfOrigin: null,
                    tracked: true,
                },
                options: null,
                
            },

            //修改图片
            rowindex:"",
            image_id:0,
            variantiamges:false,
            // variantiamgesid:"",
            varlist:[1,1],
            varPagination:1,
            totalpageination:0,
            variantiamgeslist:[]
    })

    //返回上一页
    function goBack(){
        router.go(-1)
    }
    //是否显示删除按钮
    function GetSttaut(index){
        // console.log(index);
        if(data.Deletelist.indexOf(index) != -1){
            return true;
        }else{
            return false;
        }
        
    }
    //上传成功
    function Success(response, file, fileList){
        data.image_urls = fileList
        if(response.code != 1){
            data.image_urls.splice(data.image_urls.indexOf(file),1);
            shoElmessage(true,`上传失败,原因：${response.msg}`,'error')
        }else{
            shoElmessage(true,'上传成功')
        }
    }
    function Remove(file, fileList){
        // console.log(file,fileList);
        data.form.delete_image_ids.push(file.id)
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
        // GetSttaut,
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
        this.loading = true
        this.GetProductlists();
    },
    methods:{
        async GetProductlists(){
            let data;

            if(this.query.type == 'self'){
                await GetProductlist({

                    product_id:this.query.product_id,
                }).then(res =>{
                    if(res.code == 1){
                        data = res.data.data[0];
                    }
                })
            }else{
                await GetshopifyProdutList({
                    
                   product_id:this.query.product_id,
                }).then(res =>{
                    if(res.code == 1){
                        console.log(res.data);
                        if(res.data.length != 0){
                            data = res.data.data[0];
                        }
                    }
                })
            }
            if(data.length != 0){
                this.form.title = data.title
                    this.form.description = data.description
                    this.form.product_type = data.product_type
                    if(isNaLL(data.tag_ids)){
                        this.form.tag_ids = data.tag_ids.indexOf(',') == -1 ?[Number(data.tag_ids)]:data.tag_ids.split(',').map((el) =>  Number(el))
                    }

                    this.form.category_id = data.category_id

                    this.form.country_id = data.country_id != 0?data.country_id:""
                    this.form.supplier_id = data.supplier_id != 0?data.supplier_id:""
                    this.form.HScode = data.HScode

                    

                    this.$refs.description.Init(this.form.description);
                    let filelis =[];
                    data.images.forEach((el) =>{
                        let data = {
                            url:el.src,
                            name:Getimgname(el.src).name,
                            urls:Getimgname(el.src).url,
                            id:el.id,
                        }
                        filelis.push(data);
                    })
                    this.image_urls = filelis
                    if(data.variants.length != 0){
                        this.shippingcheck = true;
                        this.form.weight = data.variants[0].weight
                        this.form.weight_unit = data.variants[0].weight_unit
                        this.form.cost = data.variants[0].cost || 0;
                        this.form.market_price = data.variants[0].market_price|| 0;
                        this.form.compareprice = data.variants[0].compare_at_price|| 0;
                        this.form.sku = data.variants[0].sku|| 0;
                        this.form.barcode= data.variants[0].barcode|| 0;
                        this.optionscheck = data.options.length>0
                        this.form.quantity = data.variants[0].inventory_quantity || 0;

                        this.form.Length = data.variants[0].length//长
                        this.form.wide = data.variants[0].width//宽
                        this.form.high = data.variants[0].height//高

                        this.tableData = data.variants
                    }

                    if(data.options.length != 0){
                        let toggleoptions = []
                        let optionsdata = {
                                toggelstatsu:false,
                                changestatus:false,
                                inputstatus:false,
                                InputValue:"",
                                id:""
                        }
                        data.options.map((mapel) =>{
                          return  mapel.values = mapel.values.split(',')
                        })
                        data.options.forEach(el =>{
                            optionsdata.id = el.id
                            toggleoptions.push(JSON.parse(JSON.stringify(optionsdata)));
                        })

                        this.optionstaggel = toggleoptions
                        this.options = data.options
                    }
                    this.productCategoryList();
                    this.productTagsList();
                    this.ObtainSupplierList();
                    this.ObtainCounty();
            }
            
        },
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
                    this.CountryList = res.data
                }
            })
        },
        //商品TAG列表
        productTagsList(){
            GetproductTagsList({}).then(res =>{
                if(res.code === 1){
                   this.TagsList = res.data
                   this.loading = false;
                }
            })
        },
        //选择商品分类
        CascaderChange(e){
            // console.log(e);
            // console.log(this.form.category_id);
        },
        //商品分类列表
        productCategoryList(){
            GetproductCategoryList({}).then(res =>{
                if(res.code === 1){
                    this.CategoryList = res.data[0].children
                    this.form.category_id = ProductType(this.CategoryList,this.form.category_id);
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
                this.$refs[`depe${this.options[index].values.indexOf(e)}`].focus();
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
        this.loading = true;
        RevisionOptionslist(this.options,this.tableData).then(res =>{
            this.loading = false;
            this.tableData = res
        })
        // console.log("先走异步还是");
        // this.tableData = RevisionOptionslist(this.options,this.tableData,'删除');
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
        this.loading = true;
        RevisionOptionslist(this.options,this.tableData).then(res =>{
            this.loading = false;
            this.tableData = res
        })
        
    },
    //所有的options折叠栏
    taggleoptionstype(index){
        // console.log(this.optionstaggel[0],index);
        
        this.optionstaggel[index].toggelstatsu = true
        // console.log(this.optionstaggel);
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
            if(isNaLL(this.image_urls[i].response)){
                if(!isNaLL(image_url) ){
                    // console.log(this.image_urls[i]);
                    image_url = this.image_urls[i].response.data.url
                }else{
                    image_url = `${image_url},${this.image_urls[i].response.data.url}`
                }
            }
        }

        UpdateProduct({
            product_id:this.query.product_id,
            title:this.form.title, //标题
            description:this.form.description, //富文本
            shop_id:this.query.shop_id, //店铺id
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
            category_id:isNaLL(this.form.category_id)?this.form.category_id[this.form.category_id.length-1]:"", //分类id
            product_type:this.form.product_type, //产品分类
            weight:this.form.weight, //重量
            weight_unit:this.form.weight_unit, //重量单位
            inventory_policy:this.form.inventory_policy?1:0, //缺货下单
            delete_image_ids:this.form.delete_image_ids.length> 0 ? this.form.delete_image_ids.join(',') : "",//删除图片的id

            Length:this.form.Length,//长
            wide:this.form.wide,//宽
            high:this.form.high,//高


            country_id:this.form.country_id,
            supplier_id:this.form.supplier_id,
            HScode:this.form.HScode,
        }).then(res =>{
            if(res.code == 1){
                this.goBack();
                shoElmessage(true,'修改成功')
            }else{
                shoElmessage(true,`修改失败${res.msg}`,'error')
            }
        })
    },
    //添加varians
    Addvarians(){
        if(!this.optionscheck){
            return shoElmessage(true,'请你确认product has options','error')
        }
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
        // console.log(index);
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
        let obj = DeleteVariantsAlgorithm(item,this.tableData,this.options,this.deletetabel,index);
        this.deletetabel = obj.deletelist
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
            
            if(this.selectdeletelist.length == this.tableData.length){
                for(let i=0; i<this.selectdeletelist.length;i++){
                    let index = this.tableData.indexOf(this.selectdeletelist[i]);
                    this.tableData.splice(index,1);
                }
                 this.options = []
            }else{
              for(let i=0; i<this.selectdeletelist.length;i++){
                    let index = this.tableData.indexOf(this.selectdeletelist[i]);
                    this.tableData.splice(index,1);
                }
                let table =  Assembling(this.tableData);
                if(table["option1"].length != 0){
                    this.options[0].values = table["option1"]
                }else{
                    this.options = [];
                }
                if(table["option2"].length != 0){
                    this.options[1].values = table["option2"]
                }else{
                   if(this.options.length == 2){
                        this.options.splice(1,1)
                    }
                }
                if(table["option3"].length != 0){
                    this.options[2].values = table["option3"]
                }else{
                    if(this.options.length == 3){
                        this.options.splice(2,1)
                    }
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
    handleCommand(e){
        // console.log(e);
        this.form.weight_unit = e;
    },
    //文本编辑
    editorChange(e){
        this.form.description = e;
    },
    Onfocus(e){
        // console.log(e);
    },
    Onblur(e){
        // console.log(e);
    },
    //获取varianttitle
    GetVariantTilte(row){
        let str = '';
        if(isNaLL(row.option1)){
            str += row.option1
        }

        if(isNaLL(row.option2)){
            str += `/${row.option2}`
        }

        if(isNaLL(row.option3)){
            str += `/${row.option3}`
        }

        return str;
    },
    //跟换图片
    FollowupImg(row,rowindex){
        this.image_id = row.image_id
        this.rowindex = rowindex
        this.variantiamgeslist = []
        this.varlist = this.image_urls;
        this.variantiamges = !this.variantiamges
        // console.log(this.varlist.length);
        this.totalpageination = this.varlist.length/12
        if(this.totalpageination.toFixed(0) <  this.totalpageination){
            this.totalpageination = (Number(this.totalpageination.toFixed(0))+1)
        }else{
            this.totalpageination = Number(this.totalpageination.toFixed(0))
        }
        if(this.varPagination != this.totalpageination){
            for(let i=((this.varPagination-1)*12); i<this.varPagination*12;i++){
                this.variantiamgeslist.push(this.varlist[i])
            }
        }else{
            // console.log(this.varlist);
            for(let i=0; i<this.varlist.length;i++){
                this.variantiamgeslist.push(this.varlist[i])
            }
        }
    },
    //向左边走
    PaginLeft(){
        if(this.varPagination <= this.totalpageination){
            this.variantiamgeslist = []
            this.varPagination--;
            // console.log(this.varPagination,this.totalpageination);
            for(let i=((this.varPagination-1)*12); i<this.varPagination*12;i++){
                this.variantiamgeslist.push(this.varlist[i])
            }
        }
    },
    PaginRight(){
        if(this.varPagination < this.totalpageination){
            this.variantiamgeslist = []
            this.varPagination++;
            if(this.varPagination == this.totalpageination){
              let remain =  this.varlist.length - ((this.varPagination-1)*12)
                for(let i=0; i<remain;i++){
                    this.variantiamgeslist.push(this.varlist[i])
                }
            }else{
                for(let i=((this.varPagination-1)*12); i<this.varPagination*12;i++){
                    this.variantiamgeslist.push(this.varlist[i])
                }
            }       
        }
    },
    //选择图片
    SelectImg(item){
        this.image_id = item.id
    },
    //确认跟换图片
    SelectImgSumbit(){
        this.tableData[this.rowindex].image_id = this.image_id
        this.variantiamges = false;

    },
    //获取图片
    GetFollowImg(id){
        let url;
         this.image_urls.forEach(el=>{
            if(el.id == id){
                url = el.url
            }
        })
        return url;
        
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
.price--list-width{
    // width: 100%;
}
.supplementary{
    padding:0px 20px;
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
    // padding-top: 20px;
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
        padding-top: 20px;
    }
}
.options--icon-active{
    padding-top: 0px;
}
.item--input-list{
    width:48%;
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
.scope-img{
    width: 5rem;
    height:5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 0.2rem dashed #8c9196;
    border-radius: 4px;
    cursor: pointer;
    svg{
       width: 2rem; 
       height: 2rem;
       fill: #8c9196;
    }
    img{
       width: 100%; 
       height: 100%;
    }
}
.Polaris-Modal-Section_1b1h1{
    flex: 0 0 auto;
    // padding: 2rem;
}
.modal--title{
    font-size: 14px;
    color: #606266;
}
.Polaris-Stack__Item_yiyol{
    margin-top: 20px;
    min-height: 10rem;
    .Polaris-DropZone__Container_13mbo{
        position: relative;
        flex: 1 1;
    }
    ._2bRuW{
        display: grid;
        grid-template-columns: repeat(4,1fr);
        grid-gap: 0.8rem;
        -webkit-user-select: none;
        user-select: none;
        .OxOGX{
            z-index: 5;
            display: flex;
            overflow: hidden;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            border-radius: 5px;
            transform: translateZ(0);
            cursor: pointer;
            box-sizing: border-box;
            border: 1px solid rgba(201, 204, 207, 1);
            background: var(#f6f6f7,#f4f6f8);
            &:first-child{
                border: none;
                &:hover{
                    border: none;
                }
            }
            &:hover{
                box-sizing: border-box;
                border: 1px solid #409eff;
            }
        }
        .OxOGXActive{
            box-sizing: border-box;
            border: 1px solid #409eff;
        }
        ._14-Wv{
            position: absolute;
            z-index: 11;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-flow: column nowrap;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            opacity: 0.4;
            background: var(--p-interactive-default,#5c6ac4);
            border-radius: 5px;
            cursor: pointer;
        }
        ._5JIkb{
            position: absolute;
            top: 0.8rem;
            left: 0.8rem;
            z-index: 12;
        }
        .D7PNX{
            // position: absolute;
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }
    }
    .upload-demo{
        width: 100%;
        height: 100%;
        &:deep(.el-upload){
            height: 100%;
        }
    }                    
}
.Pagination-footer{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
    .Pagination{
        display: flex;
        align-items: center;
        
        .navtions-icon-left{
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            border:1px solid rgba(210, 213, 216, 1);
            cursor: pointer;
        }
        .navtions-icon-rigth{
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border:1px solid rgba(210, 213, 216, 1);
            border-left: none;
            cursor: pointer;
        }
        .sho-left{
            border:1px solid rgba(140, 145, 150, 1);
            i{
                font-weight: bold;
            }
        }
        .sho-rigth{
            border:1px solid rgba(140, 145, 150, 1);
            i{
                font-weight: bold;
            }
        }
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
            height: 10vh;
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
.variantiamges-edit{
    border-radius: 10px;
    .el-dialog__header{
        border-bottom: 1px solid rgba(225, 227, 229, 1);
    }
    .el-dialog__body{
        padding: 20px;
        border-bottom: 1px solid rgba(225, 227, 229, 1);
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