<template>
<div class="grid-content bg-purple-light">
                <el-card>
                    <div class="el_card-title">
                      <svg width="28" height="28" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.78101 9.75193C9.90612 8.75107 10.7569 8 11.7656 8H36.2344C37.2431 8 38.0939 8.75107 38.219 9.75193L41.719 37.7519C41.8682 38.9456 40.9374 40 39.7344 40H8.26556C7.06257 40 6.1318 38.9456 6.28101 37.7519L9.78101 9.75193Z" fill="#79bd55" stroke="#79bd55" stroke-width="4" stroke-linejoin="miter"/><path d="M15 18C15 18 17 22 24 22C31 22 33 18 33 18" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                      <span>sulayakellyyoga.com settings</span>
                    </div>
                    <div class="el_card-list flex ">
                        <el-checkbox  name="type"></el-checkbox>
                        <div class="el_card-text">
                            <div class="el_c-e-title">Set new products as published</div>
                            <div class="el_c-type">Automatically publish products after pushing them to your store.</div>
                        </div>
                    </div>
                     <div class="el_card-list flex ">
                        <el-checkbox  name="type"></el-checkbox>
                        <div class="el_card-text">
                            <div class="el_c-e-title">Set new products as published</div>
                            <div class="el_c-type">Automatically publish products after pushing them to your store.</div>
                        </div>
                    </div>
                    <div class="el_card-list flex ">
                        <el-checkbox  name="type"></el-checkbox>
                        <div class="el_card-text">
                            <div class="el_c-e-title">Set new products as published</div>
                            <div class="el_c-type">lf this setting is on, we will ask you to set the weight for every product variant you push to your store.Select thedefault weight unit below.</div>
                        </div>
                    </div>
                    <div class="el_select-l">
                         <el-select v-model="value" placeholder="请选择" style="width:100%;">
                            <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                </el-card>
                </div>
                <div class="grid-content bg-purple-light" style="margin-top:40px;">
                <el-card>
                    <div class="el_card-title">
                      <span style="margin-left:0px;">Notify customers about shipped orders</span>
                    </div>
                    <div class="el_c-e-title" style="margin-top:20px;">
                        1.Send a notification email to the customers when the order gets fulfilled or tracking number gets updated.
                    </div>
                    <div class="el_card-title flex align-center">
                        <el-checkbox  name="type" style=""></el-checkbox>
                        <span>Set new products as published</span>
                    </div>
                    <div class="el_c-e-title" style="margin-top:20px;">
                        <span class="flex align-center">2.Add custom shipping tracking URLi<svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M24 44C29.5228 44 34.5228 41.7614 38.1421 38.1421C41.7614 34.5228 44 29.5228 44 24C44 18.4772 41.7614 13.4772 38.1421 9.85786C34.5228 6.23858 29.5228 4 24 4C18.4772 4 13.4772 6.23858 9.85786 9.85786C6.23858 13.4772 4 18.4772 4 24C4 29.5228 6.23858 34.5228 9.85786 38.1421C13.4772 41.7614 18.4772 44 24 44Z" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 37C25.3807 37 26.5 35.8807 26.5 34.5C26.5 33.1193 25.3807 32 24 32C22.6193 32 21.5 33.1193 21.5 34.5C21.5 35.8807 22.6193 37 24 37Z" fill="#FFF"/><path d="M24 12V28" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg></span>
                        <div>This link is the URL to track the fulfillment. lt wil be added to the fulfillment notification email to your customer.</div>
                    </div>

                    <div class="el_input">
                         <el-input ></el-input>
                    </div>

                    <div class="el_c-e-title" style="margin-top:20px;">
                        2.Send a notification email to the customers when the order gets fulfilled or tracking number gets updated.
                    </div>
                </el-card>
                </div>
                 <div class="grid-content bg-purple-light" style="margin-top:40px;">
                    <el-card>
                        <div class="el_card-title">
                        <span style="margin-left:0px;">Auto updates</span>
                        </div>
                        <div class="el_c-e-title" style="margin-top:20px;">
                            <div class="font-weight">when product is no longer available</div>
                            <span>Send a notification email to the customers when the order gets fulfilled or tracking number gets updated.</span>
                        </div>
                        <div class="">
                            <el-radio label="Do Noting"></el-radio>
                        </div>
                        <div class="">
                            <el-radio label="Do Noting"></el-radio>
                        </div>
                        <div class="">
                            <el-radio label="Do Noting"></el-radio>
                        </div>
                        <div class="">
                            <el-checkbox label="Notify Me" name="type"></el-checkbox>
                        </div>
                    </el-card>
                </div>
                <div class="grid-content bg-purple-light" style="margin-top:40px;">
                    <el-card>
                        <div class="el_card-title">
                            <span style="margin-left:0px;">Auto updates</span>
                        </div>
                        <div class="select_time">
                            Select the time zone that will be used in the Oberlo app
                        </div>
                        <div class="el_select-l" style="margin-left:0px;">
                            <el-select v-model="value" placeholder="请选择" style="width:100%;">
                                <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </el-card>

                </div>
</template>

<script>
// import Sidebar from '@/components/Loyout/SettingSidebar/Sidebar.vue'
export default {
    components:{
        // Sidebar
    }
}
</script>

<style lang="scss" scoped>
 :deep(.el-menu  .is-active){
    border-right: none !important;
     display: flex;
    align-items: center;
    justify-content: space-between;
}
:deep(.el-menu-item .el i){
    display:none;
}
:deep(.is-active .el i){
    display:block;
}
:deep(.el-menu .is-active){
    background-color:#fff;
    color:#0000ff;
}
:deep(.el-menu-item span){
    text-align:center;
    font-weight:1000;
    font-size:15px;
}
:deep(.el-card__body){
    padding: 20px !important;
}
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
.el_card-text{
    margin-left :10px;
    .el_c-e-title{
        color:#000;
        font-size:20px;
        font-weight :bold;
    }
    .el_c-type{
        color:#62628d;
    }
}
:deep(.el_card-list .el-checkbox){
    align-items:flex-start;
    padding-top:5px;
}
.el_card-list{
    margin-top:20px;
}
.el_select-l{
    width:500px;
    margin-top:20px;
    margin-left :20px;
}
.el_input{
    width:50%;
    margin-top:20px;
}
.font-weight{
    font-weight :bold;
}
.select_time{
    margin-top:20px;
}
</style>