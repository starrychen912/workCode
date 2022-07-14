<template>
    <div class="search-input-prepend-append">
        <div class="prepends">
            <slot name="prepend">

            </slot>
        </div>
        <input class="el-input-search" 
            :value="value"
            :placeholder="placeholder" 
            @focus="InputFocus"
            @blur="InputBlur"  
            @keyup="inputketup"
            @input="inputIn"
            placeholder-style="color:red"
        >
        <div class="el-input-group__appends">
             <slot name="append">
                
             </slot>
        </div>
    </div>
</template>

<script>import { reactive } from "vue"

export default {
    name:"Search",
    props:{
        mode:{
            type:Boolean,
            default:false
        },
        value:{
            type:[String,Number],
            default:''
        },
        placeholder:{
            type:String,
            default:'请输入'
        }
    },
    setup(props,context){
        
        const data = reactive({
            InputValue:""
        })
        function inputketup(e){   
            context.emit('inputketup',e.target.value)
        };
        function InputBlur(e){
            context.emit('InputBlur', e.target.value)
        }
        function OptionsClick(index){
            // context.emit('click');
        }
        function inputIn(e){
            // context.emit('inputIn', e)
        }
        return {
            data,
            inputketup,
            OptionsClick,
            InputBlur,
            inputIn
        }
        
    }
}
</script>

<style scoped lang="scss">
.el-input-search{
    -webkit-appearance: none;
    background-color: #fff;
    background-image: none;
    // border-radius: 4px;
    // border: 1px solid #dcdfe6;
    border: none;
    box-sizing: border-box;
    color: #606266;
    display: inline-block;
    height: 45px;
    line-height: 45px;
    outline: none;
    padding: 0 15px;
    transition: border-color .2s cubic-bezier(.645,.045,.355,1);
    width: 100%;
    cursor: pointer;
    font-size: 15px;
    border:1px solid #409eff;
    &:focus{
        outline: none;
        border-color: #409eff;
    }
}

.search-input-prepend-append{
    position: relative;
    font-size: 14px;
    border-spacing: 0;
    border-collapse: separate;
    // display: inline-table;
    display: flex;
    grid-column: 1/span 3;
    order: 3;
    line-height: normal;
    width: 100%;
    border-radius: 4px;
}
.el-button-search{
    display: inline-block;
    line-height: 1;
    min-height: 40px;
    white-space: nowrap;
    cursor: pointer;
    background: var(--el-button-background-color,var(--el-color-white));
    border: var(--el-border-base);
    border-color: var(--el-button-border-color,var(--el-border-color-base));
    color: var(--el-button-font-color,var(--el-text-color-regular));
    -webkit-appearance: none;
    text-align: center;
    box-sizing: border-box;
    outline: 0;
    transition: .1s;
    font-weight: var(--el-button-font-weight);
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    padding: 12px 20px;
    font-size: var(--el-font-size-base,14px);
    border-right: none;
}
.el-input-group__appends{
    :deep(.el-button){
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        border-left: none;
        border-right: none;
        height: 45px;
        padding: 13px 20px;
        // line-height: 45px;
    }
}
.prepends{
    :deep(.el-button){
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        border-left: none;
        border-right: none;
        height: 45px;
        // line-height: 45px;
    }
}
@media only screen and(max-width:790px){
    .el-input-search{
        background-color:#f4f7ff;
    }
}
</style>