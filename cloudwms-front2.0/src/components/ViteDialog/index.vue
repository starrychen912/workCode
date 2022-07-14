<template>
  <el-dialog v-model="verification" @close="close" :title="title" :close-on-click-modal="CloseOnClockModal" :destroy-on-close="destroyOnClose" :width="width" :top="top"  :fullscreen="isFullscreen" :show-close="showClose"  custom-class="vite_dialog"  :lock-scroll="lockScroll">
    <template #title>
        <slot name="title"></slot>
        <div v-if="!Title">
          <div class="title" >{{title || '提示'}}</div>
          <div class="el-dialog_title" :class="{'icon_list--right':!viteshowClose}">
            <!-- 自定义图标 -->
            <slot name="icon"></slot>
            <!-- 默认图标 -->
            <div class="icon_list" v-if="!ICon">
              <div class="screenfull" @click="Screen" v-if="fullscreen">
                  <svg  class="screen-out out"  width="16" height="16" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" v-if="!isFullscreen">
                    <path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                    <path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                    <path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                    <path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                  </svg>
                  <svg class="screen-out in" width="16" height="16" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" v-else>
                    <path d="M33 6V15H42" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 6V15H6" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 42V33H6" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M33 42V33H41.8995" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </div>
              <i class="el-icon-close" @click="ViteClose" v-if="!viteshowClose"></i>
            </div>
          </div>
        </div>
    </template>
    <slot></slot>
    <template #footer>
        <div v-if="footer">
          <slot name="footer"></slot>
        </div>
        <div v-else>
          <el-button @click="ViteClose">取 消</el-button>
          <el-button type="primary" @click="verification = false">确 定</el-button>
        </div>
    </template>
  </el-dialog>
</template>
<script lang="ts">
import { computed, reactive, toRefs, watch,defineEmits, onMounted,nextTick } from 'vue';
import { isNaLL } from '../../utils/utils';
export default {
  name:'ViteDialog',
  emits:['update:modelValue','ViteClose'],
  props:{
    //标题
    title:{
      type:String,
      default:''
    },
    //是否在 Dialog 出现时将 body 滚动锁定
    lockScroll:{
      type:Boolean,
      default:true,
    },
    //是否显示关闭按钮一般别动
    showClose:{
      type:Boolean,
      default:false,
    },
    //是否显示vite关闭按钮
    viteshowClose:{
      type:Boolean,
      default:false,
    },
    //为 Dialog 启用可拖拽功能
    draggable:{
      type:Boolean,
      default:true,
    },
    //当关闭 Dialog 时，销毁其中的元素
    destroyOnClose:{
      type:Boolean,
      default:true,
    },
    //是否可以放大缩小
    fullscreen:{
      type:Boolean,
      default:true,
    },
    //顶部距离
    top:{
      type:String,
      default:'20px'
    },
    //宽度
    width:{
      type:String,
      default:'80%'
    },
    //v-model默认值
    modelValue: {
      type: Boolean,
      default:false,
    },
    CloseOnClockModal:{
      type:Boolean,
      default:false,
    },
    //添加样式
    CustomClass:{
      type:String,
      default:'vite_dialog'
    }
  },
  //要文档没有，自己找自己看
  setup(props,content){
    const datas = reactive({
      isFullscreen:false,
      verification:false,
      //尾部
      footer:computed(() => isNaLL(content.slots.footer)),
      //头部
      Title:computed(() => isNaLL(content.slots.title)),
      //图标
      ICon:computed(() => isNaLL(content.slots.icon)),
    })
    //关闭弹出框
    function ViteClose(){
      verclose();
      content.emit('ViteClose',datas.verification);
      AfterLeave()
    }
    //放大弹出框
    function Screen(){
      datas.isFullscreen = !datas.isFullscreen
    }
    //打开弹出框
    function open(){
      datas.verification  = true
    }
    function verclose(){
       datas.verification = false;
    }
    function DialogClose(){
      //修改弹出框
      verclose();
      AfterLeave();
      //关闭回调
      content.emit('ViteClose',datas.verification);
    }
    function AfterLeave(){
      content.emit('update:modelValue',false);
    }
    //关闭弹出框回调
    function close(){
      // console.log('close')
    }
    watch(()=> props.modelValue, (val) =>{
       if(val){
         open()
       }else{
         verclose()
       }
    })
    
    return{
      ViteClose,
      Screen,
      DialogClose,
      ...toRefs(datas),
      close,
      verclose,
      AfterLeave
    }
  }
}
</script>
<style lang="scss" scoped>
.out{
  transform: scale(1);
  animation: line-anm .5s;
}
.in{
  transform: scale(1);
  animation: line-in .5s;
}
@keyframes line-anm {
  to{
    transform: scale(0.8);
  }
}
@keyframes line-in {
  to{
    transform: scale(1.2);
  }
}
</style>
<style lang="scss">
.vite_dialog{
  .el-dialog__header{
    display: flex;
    align-items: center;
    border-bottom: 1px solid #eee;
    .el-dialog_title{
        // width: 100%;
        display: flex;
        // justify-content: space-between;
        font-size: 18px;
        cursor: pointer;
        position: absolute;
        top: var(--el-dialog-padding-primary);
        right: calc(var(--el-dialog-padding-primary) + 20px);
        .icon_list {
          display: flex;
          align-items: center;
          .screenfull {
            padding: 1px 5px;
            display: flex;
            align-items: center;
          }
          i {
            font-size: 20px;
            color: #000;
            font-weight: bold;
          }
        }
        &.icon_list--right{
          right: var(--el-dialog-padding-primary) !important;
        }
      }
  }
  .el-dialog__body{
    padding: 10px 20px;
    min-height: calc(100vh - 200px);
  }
  .el-dialog__footer{
    border-top: 1px solid #eee;
  }
  // 编辑仓库弹框
}
</style>
