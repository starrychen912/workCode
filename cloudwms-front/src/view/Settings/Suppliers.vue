<template>
<div class="grid-content bg-purple-light">
                     <el-card>
                         <div class="el_card-title">
                            <svg width="28" height="28" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.78101 9.75193C9.90612 8.75107 10.7569 8 11.7656 8H36.2344C37.2431 8 38.0939 8.75107 38.219 9.75193L41.719 37.7519C41.8682 38.9456 40.9374 40 39.7344 40H8.26556C7.06257 40 6.1318 38.9456 6.28101 37.7519L9.78101 9.75193Z" fill="#79bd55" stroke="#79bd55" stroke-width="4" stroke-linejoin="miter"/><path d="M15 18C15 18 17 22 24 22C31 22 33 18 33 18" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                            <span>AliExpress</span>
                        </div>
                        <div style="padding: 20px 0px;">
                            <div style="margin-bottom:5px;font-weight:bold;">Personalized Shipping Methods</div>
                            <span>Oberlo will auto-select the shipping method based on the product and country selected during checkout on AliExpress.</span>
                        </div>
                        <div style="padding-bottom:40px;border-bottom:1px solid rgb(222,222,232);">
                             <el-row>
                                <el-col :xs="8" :sm="8" :md="8" :lg="8" :xl="8" >
                                    <div style="font-weight:bold;padding:20px 0px;border-bottom:1px solid rgb(222,222,232);">Product</div>
                                      <div class="el_select-l" style="margin-top:20px;padding-right:20px;">
                                        <el-select v-model="value" placeholder="请选择" style="width:100%;">
                                            <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </el-col>
                                <el-col :xs="8" :sm="8" :md="8" :lg="8" :xl="8" >
                                    <div style="font-weight:bold;padding:20px 0px;border-bottom:1px solid rgb(222,222,232);">Shipping to</div>
                                     <div class="el_select-l" style="margin-top:20px;padding-right:20px;">
                                        <el-select v-model="value" placeholder="请选择" style="width:100%;">
                                            <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </el-col>
                                <el-col :xs="8" :sm="8" :md="8" :lg="8" :xl="8" >
                                    <div style="font-weight:bold;padding:20px 0px;border-bottom:1px solid rgb(222,222,232);">Shipping Method</div>
                                    <div class="el_select-l" style="margin-top:20px;padding-right:20px;">
                                        <el-select v-model="value" placeholder="请选择" style="width:100%;">
                                            <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </el-col>
                             </el-row>
                        </div>
                        <div style="margin-top:20px;">
                             <el-button type="info"><i class="el-icon-arrow-right el-icon-plus"></i>           ADD PRODUCTS</el-button>
                        </div>
                        <div class="" style="margin-top:30px;">
                            When the"Personalized shipping method" is not created or available, Oberlo will select the default shipping method. lf adefault shipping option is not available, Oberlo will select the cheapest option.
                        </div>
                        <div class="el_select-l" style="margin-top:20px;padding-right:20px;">
                            <el-select v-model="value" placeholder="请选择" style="width:50%;">
                                <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                                </el-option>
                                <template v-slot:prefix>
                                    <span class = 'prefixSlot'>Default shipping method:</span>
                                </template>
                            </el-select>
                        </div>
                        <div class="" style="margin-top:30px;">
                            Add a note to supplier on the Aliexpress checkout page.
                        </div>
                        <el-input
                            type="textarea"
                            placeholder="请输入内容"
                            v-model="textarea"
                            show-word-limit
                            :autosize="{ minRows: 5, maxRows: 10}"
                            style="margin-top:20px;"
                            >
                        </el-input>
                        <div class="flex align-start" style="margin-top:20px">
                          <el-checkbox style="padding-top:5px" class="flex align-start"></el-checkbox>
                          <div style="margin-left:10px;">
                              <div style="margin-bottom:5px;font-weight:bold;">Personalized Shipping Methods</div>
                              <span>Learn more about phone <el-link type="info">number management.</el-link></span>
                             
                          </div>
                        </div>
                     </el-card>
                     
                 </div>         
</template>

<script>
export default {
    components:{
    }
}
</script>

<style lang="scss" scoped>



.el_card-title{
    color:#000;
    font-size:20px;
    display :flex;
    align-items:center;
    span{
        font-weight :bold;
        margin-left :10px;
    }
}
</style>