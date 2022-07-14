<template>
  <div class="input-conected-content" :class="{'input-conected-content-active':inputstatus}">
      <div class="Polaris-TextField_1spwi">
          <div class="Polaris-TextField__Prefix_10fbz">CN¥</div>
          <input class="Polaris-TextField__Input_30ock" :type="intype" v-model="values" @input="Input" @focus="InputFocus" @blur="InputBlur" />
      </div>
  </div>
</template>

<script>
import { reactive,toRefs } from 'vue'
export default {
  props:{
    intype:{
      type:String,
      default:'text'
    }
  },
  setup(){
      const data = reactive({
        inputstatus:false,
        valuse:"0.00"
      })
      function InputFocus(){
        data.inputstatus = true
      }
      function InputBlur(){
        data.inputstatus = false
      }
      return {
        ...toRefs(data),
        InputFocus,
        InputBlur
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
    margin-right: 8px;
    position: relative;
    // z-index: 20;
    flex: 0 0 auto;
    color: rgba(109, 113, 117, 1);
    -webkit-user-select: none;
    user-select: none;
}
.Polaris-TextField__Input_30ock{
    border: none;
    text-transform: none;
    letter-spacing: normal;
    position: relative;
    z-index: 20;
    display: block;
    flex: 1 1;
    width: 100%;
    min-width: 0;
    margin: 0;
    padding: 0.5rem 0rem;
    background: none;
    border: 0.1rem solid transparent;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    -webkit-appearance: none;
    appearance: none;
    caret-color: rgba(32, 34, 35, 1);
    color: rgba(32, 34, 35, 1);
    outline: none;
}
</style>