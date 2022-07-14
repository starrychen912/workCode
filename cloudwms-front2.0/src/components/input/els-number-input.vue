2<template>
  <div class="input-conected-content" :class="[{'input-conected-content-active':inputstatus},{'input-conected-content-error':error}]">
      <div class="Polaris-TextField_1spwi">
          <div class="Polaris-TextField__Prefix_10fbz">{{t('home.unit')}}</div>
          <!-- <el-input-number class="Polaris-TextField__Input_30ock" 
              placeholder="0.00"
              @input="UpdataInput" 
              :precision="2" 
              :model-value="value"
              :step="1" 
              :max="100000000000" 
              :controls="false" 
              @change="UpdataInputChange"
              @focus="InputFocus"
              @blur="InputBlur"
             /> -->
            <input class="Polaris-TextField__Input_30ock inputclasee" 
              :value="value"
              :placeholder="placeholder" 
              @focus="InputFocus"
              @blur="InputBlur"  
              @keyup="inputketup"
              @input="inputIn"
              maxlength="16"
            >
      </div>
  </div>
</template>

<script>
import { reactive,toRefs } from 'vue'
import i18n from '../../locale'

export default {
  props:{
    intype:{
      type:String,
      default:'text'
    },
    error:{
      type:Boolean,
      default:false
    },
    placeholder:{
      type:String,
      default:'请输入'
    },
    value:{
      type:[String,Number],
      default:''
    }
  },
  // data(){
  //   return{
  //     value:""
  //   }
  // },
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
          t:i18n.global.t
      })

      function InputFocus(){
        data.inputstatus = true
      }
      function InputBlur(){
        data.inputstatus = false
      }
      function UpdataInput(val){
        content.emit('UpdataInput',val);
      }
      function UpdataInputChange(val){
        console.log(val);
      }
      return {
        ...toRefs(data),
        InputFocus,
        // InputBlur,
        UpdataInput,
        UpdataInputChange
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
.input-conected-content-error{
    border: 1px solid #ff3b3b;
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
    box-sizing: border-box;
}
.Polaris-TextField__Prefix_10fbz{
    margin-left: 5px;
    margin-right: 5px;
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
    border: 0.1rem solid transparent;
    font-size: inherit;
    font-weight: inherit;
    -webkit-appearance: none;
    appearance: none;
    caret-color: rgba(32, 34, 35, 1);
    color: rgba(32, 34, 35, 1);
    outline: none;
    border: none;
    :deep(.el-input){
      input{
        border: none;
        text-align: left;
        padding-left: 10px;
        padding-right: 10px;
      }
    }
}
.inputclasee{
  height: 38px;
  line-height: 38px;
  font-size: 14px;
  padding-top: 2px;
}
</style>