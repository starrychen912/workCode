2<template>
  <div class="input-conected-content" :class="{'input-conected-content-active':inputstatus}">
      <div class="Polaris-TextField_1spwi">
        <input class="Polaris-TextField__Input_30ock inputclasee" 
              :value="value"
              :placeholder="placeholder" 
              @focus="InputFocus"
              @blur="InputBlur"  
              @keyup="inputketup"
              @input="inputIn"
            >
          <!-- <el-input-number class="Polaris-TextField__Input_30ock" @focus="InputFocus" @blur="InputBlur" placeholder="0.00" v-model="values" :precision="2" :step="1" :max="100000000000" :controls="false"  /> -->
          <div class="el-dropdown-menu-list">
            <el-dropdown @command="handleCommand" trigger="click">
                <div class="el-dropdown-link-li">
                  <span class="el-dropdown-link">
                      {{weight_unit}}
                    </span>
                    <el-icon class="el-icon--right"><arrow-down /></el-icon>
                </div>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item command="lb">lb</el-dropdown-item>
                    <el-dropdown-item command="kg">kg</el-dropdown-item>
                    <el-dropdown-item command="g">g</el-dropdown-item>
                    <el-dropdown-item command="oz">oz</el-dropdown-item>
                  </el-dropdown-menu>
                </template>
            </el-dropdown>
          </div>
      </div>
  </div>
</template>

<script>
import { ArrowDown } from '@element-plus/icons'
import { reactive,toRefs } from 'vue'
export default {
  emits:['inputketup','InputBlur','handleCommand'],
  components:{ArrowDown},
  props:{
    intype:{
      type:String,
      default:'text'
    },
    value:{
      type:[String,Number],
      default:''
    },
    placeholder:{
      type:String,
      default:'请输入'
    },
    error:{
      type:Boolean,
      default:false
    },
    weight_unit:{
      type:String,
      default:""
    }
  },
  methods:{
    inputketup(e){
      let vlaues = e.target.value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')
      this.$emit('inputketup',vlaues);
    },
    inputIn(e){
      // this.value = e.target.value.replace(/[^\d.]/g,'')
    },
    InputBlur(){
        this.inputstatus = false
        this.$emit('InputBlur',Number(this.value).toFixed(2))
    }
  },
  setup(props,content){
      const data = reactive({
          inputstatus:false,
          valuse:"0.00",
          // weight:'g',
      })
      function InputFocus(){
        data.inputstatus = true
      }
      function InputBlur(){
        data.inputstatus = false
      }
      function handleCommand(e){
        content.emit('handleCommand',e);
      }
      return {
        ...toRefs(data),
        InputFocus,
        // InputBlur,
        handleCommand
      }
  }
}
</script>

<style scoped lang="scss">
.input-conected-content{
    flex: 1 1 auto;
    border: 1px solid rgba(201, 204, 207, 1);
    border-radius: 4px;
}
.input-conected-content-active{
    border: 1px solid #2c96ff;
    border-radius: 4px;
}
.Polaris-TextField_1spwi{
    font-weight: 400;
    border: none;
    text-transform: none;
    letter-spacing: normal;
    position: relative;
    display: flex;
    align-items: center;
    color: rgba(109, 113, 117, 1);
    cursor: text;
}
.Polaris-TextField__Prefix_10fbz{
    margin-left: 12px;
    position: relative;
    flex: 0 0 auto;
    color: rgba(109, 113, 117, 1);
    -webkit-user-select: none;
    user-select: none;
    font-size: 14px;
}
.Polaris-TextField__Input_30ock{
    text-transform: none;
    letter-spacing: normal;
    position: relative;
    z-index: 20;
    display: block;
    flex: 1 1;
    width: 100%;
    min-width: 0;
    margin: 0;
    // padding: 0.5rem 0rem;
    background: none;
    border: 1px solid transparent;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    -webkit-appearance: none;
    appearance: none;
    caret-color: rgba(32, 34, 35, 1);
    color: rgba(32, 34, 35, 1);
    outline: none;
    border: none;
    padding: 10px;
    :deep(.el-input){
      input{
        border: none;
        text-align: left;
        padding-left: 10px;
        padding-right: 10px;
      }
    }
}
.el-dropdown-menu-list{
  width: 20%;
  height: 100%;
  height: 40px;
  line-height: 38px;
  background-color: rgba(231, 231, 231,0);
 
  cursor: pointer;
  border-left: 1px solid rgba(201, 204, 207, 1);
}
.el-dropdown-link-li{
    width: 100%;
    height: 38px;
    line-height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    i{
      margin-top: 5px;
    }
}
.inputclasee{
  height: 38px;
  line-height: 38px;
  font-size: 14px;
  // padding-top: 2px;
}
</style>