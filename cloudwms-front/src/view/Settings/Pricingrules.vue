<template>
  <div class="grid-content bg-purple-light">
                     <el-card>
                        <div class="pricingrules_title flex align-center justify-between">
                             <div class="el_card_title font-weight">Pricing rules</div>
                             <a>Apply to existing_products</a>
                        </div>
                        <div class="pricingrules_price">
                            <div class="p_p_title flex align-center justify-between">
                                <div class="flex align-center">
                                    <svg style="margin-right:10px;" width="28" height="28" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.9821 11.9689L31.7847 4L36.3971 11.9889L17.9821 11.9689Z" stroke="#7cbe59" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M4 14C4 12.8954 4.89543 12 6 12H42C43.1046 12 44 12.8954 44 14V42C44 43.1046 43.1046 44 42 44H6C4.89543 44 4 43.1046 4 42V14Z" fill="#7cbe59" stroke="#7cbe59" stroke-width="4" stroke-linejoin="miter"/><path d="M35.25 33H44V23H35.25C32.3505 23 30 25.2386 30 28C30 30.7614 32.3505 33 35.25 33Z" fill="#FFF" stroke="#FFF" stroke-width="4" stroke-linejoin="miter"/><path d="M44 16.5V40.5" stroke="#7cbe59" stroke-width="4" stroke-linecap="round"/></svg>
                                    Product Price:
                                    <svg style="margin-left:10px" width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M24 44C29.5228 44 34.5228 41.7614 38.1421 38.1421C41.7614 34.5228 44 29.5228 44 24C44 18.4772 41.7614 13.4772 38.1421 9.85786C34.5228 6.23858 29.5228 4 24 4C18.4772 4 13.4772 6.23858 9.85786 9.85786C6.23858 13.4772 4 18.4772 4 24C4 29.5228 6.23858 34.5228 9.85786 38.1421C13.4772 41.7614 18.4772 44 24 44Z" fill="#62628d" stroke="#62628d" stroke-width="4" stroke-linejoin="miter"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 37C25.3807 37 26.5 35.8807 26.5 34.5C26.5 33.1193 25.3807 32 24 32C22.6193 32 21.5 33.1193 21.5 34.5C21.5 35.8807 22.6193 37 24 37Z" fill="#FFF"/><path d="M24 12V28" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                                </div>
                                <div class="flex align-center">
                                    <div>Cost(USD)   x</div>
                                    <div style="margin-left: 15px;">
                                    <el-input
                                            v-model="input3"
                                            placeholder="Please input"
                                            class="input-with-select"
                                            >
                                            <template #append>
                                                <el-select v-model="select" placeholder="Select" style="width: 110px">
                                                <el-option label="Restaurant" value="1"></el-option>
                                                <el-option label="Order No." value="2"></el-option>
                                                <el-option label="Tel" value="3"></el-option>
                                                </el-select>
                                            </template>
                                    </el-input>
                                    </div>
                                </div>
                            </div>
                            <div class="p_p_title ">
                                <div style="width:100%" class="flex align-center justify-between">
                                    <div class="flex align-center">
                                    <el-switch
                                        style="margin-right: 10px;"
                                        v-model="data.value"
                                        active-color="#2d00fb"
                                        inactive-color="#bbbbcf"
                                        active-value="100"
                                        inactive-value="0">
                                    </el-switch>
                                    compare at price:
                                    <svg style="margin-left:10px" width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M24 44C29.5228 44 34.5228 41.7614 38.1421 38.1421C41.7614 34.5228 44 29.5228 44 24C44 18.4772 41.7614 13.4772 38.1421 9.85786C34.5228 6.23858 29.5228 4 24 4C18.4772 4 13.4772 6.23858 9.85786 9.85786C6.23858 13.4772 4 18.4772 4 24C4 29.5228 6.23858 34.5228 9.85786 38.1421C13.4772 41.7614 18.4772 44 24 44Z" fill="#62628d" stroke="#62628d" stroke-width="4" stroke-linejoin="miter"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 37C25.3807 37 26.5 35.8807 26.5 34.5C26.5 33.1193 25.3807 32 24 32C22.6193 32 21.5 33.1193 21.5 34.5C21.5 35.8807 22.6193 37 24 37Z" fill="#FFF"/><path d="M24 12V28" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                                </div>
                                <div class="flex align-center">
                                    <div>Cost(USD)   x</div>
                                    <div style="margin-left: 15px;">
                                    <el-input
                                            v-model="input3"
                                            placeholder="Please input"
                                            class="input-with-select"
                                            >
                                            <template #append>
                                                <el-select v-model="select" placeholder="Select" style="width: 110px">
                                                <el-option label="Restaurant" value="1"></el-option>
                                                <el-option label="Order No." value="2"></el-option>
                                                <el-option label="Tel" value="3"></el-option>
                                                </el-select>
                                            </template>
                                    </el-input>
                                    </div>
                                </div>
                                </div>
                                <div style="margin-top:20px;">
                                    Product prices must be lower than or equal to their compare at prices. If product prices are higher, compare at prices areautomatically removed.
                                </div>
                            </div>
                            <div class="p_p_advaned flex align-center">
                                 <el-switch
                                        style="margin-right: 10px;"
                                        v-model="data.value"
                                        active-color="#2d00fb"
                                        inactive-color="#bbbbcf"
                                        active-value="100"
                                        inactive-value="0">
                                </el-switch>
                                <div >
                                    <div class="font-weight">Advanced pricing rules</div>
                                    <span>Set your product markup depending on cost ranges.</span>
                                </div>
                            </div>
                        </div>
                     </el-card>
                 </div>
                  <div class="grid-content bg-purple-light" style="margin-top:20px;">
                      <el-card>
                            <div class="pricingrules_title flex align-center justify-between">
                                <div class="el_card_title font-weight">Pricing rules</div>
                                <!-- <a>Apply to existing_products</a> -->
                            </div>
                            <div style="margin-top:10px;">
                                You can set a specific cent value for your retail price. We will use this value when forming the final price for your ftems (e g,if you want the cost of your product to be xx.99 then add 99 to the fields below).
                            </div>
                             <div style="width:100%;" class="flex align-center justify-between">
                                 <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                                     <el-checkbox  name="type">Assign cents</el-checkbox>
                                    <div class="el_card-text">
                                        <el-input></el-input>
                                    </div>
                                </el-col>
                                <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                                    <el-checkbox  name="type">Assign cents</el-checkbox>
                                    <div class="el_card-text">
                                        <el-input></el-input>
                                    </div>
                                </el-col>
                             </div>
                      </el-card>
                  </div>
</template>

<script>
import { reactive } from 'vue'
export default {
    components:{
    },
    setup(){
        const data = reactive({
            value:100,
        })
        return{
            data
        }
    }
}
</script>

<style lang="scss"  scoped>
 :deep(.el-menu  .is-active){
    border-right: none !important;
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
.font-weight{
    font-weight :bold;
}
.pricingrules_title{
    a{
        text-decoration: underline;
        font-size: 15px;
        cursor: pointer;
    }
}
.p_p_title{
    padding: 20px 0px;
    border-bottom:1px solid #e5e5ec;
}
.p_p_advaned{
    padding: 20px 0px;
}
</style>