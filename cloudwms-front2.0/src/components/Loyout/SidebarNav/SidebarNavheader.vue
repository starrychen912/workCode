<template>
    <div class="userlayout-header" >
        <a :href="Href" v-if="SiderStatus">
            <img src="@/assets/logo.svg" class="logo" alt="logo">
            <div v-if="Showvariable" class="Htitle">{{t('title')}}</div>
        </a>

        <a :href="Href" class="userlayout-a" v-else>
            <div class="logimg flex align-center justify-end" :class="{'el-Logo--collapse':!Showvariable,'justify-center':!Showvariable}">
                <img :src="LogoImg" class="logo" alt="logo">
            </div>
            <div v-if="Showvariable" class="Htitle" >{{t('title')}}</div>
        </a>
    </div>
</template>

<script>
import { defineComponent, reactive, ref,computed, toRefs } from 'vue'
import { useStore } from 'vuex'
import i18n from '../../../locale'
export default defineComponent({
    // name:"SidebarNavheader",
    props:{
        title:{
            type:String,
            default:"町町信息"
        },
        LogoImg:{
            type:String,
            default:"./src/assets/logo.svg"
        },
        Href:{
            type:String,
            default:"/"
        },
        SiderStatus:{
            type:Boolean,
            default:true
        },
        Showvariable:{
            type:Boolean,
            default:true
        }
    },
    setup(){
        const t = i18n.global.t
        const data = reactive({
            theme:'light'
        })
        return {
            t,
            ...toRefs(data)
        }
    }
}
)
</script>

<style lang="scss" scoped>
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
  }


  .user-layout-wrapper{
      width: 100%;
      height: 60px;
      line-height: 60px;
      
  }
  
  .userlayout-header{
    width: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 66px !important;
    line-height: 66px !important;
    box-shadow: none !important;
    background-color: #fff;
  }
  .dark{
    .userlayout-header{
        background-color: var(--sidebar-nav-background--color);
        & > a .Htitle{
            color: var(--sidebar-color);
        }
    }
  }
  
  .userlayout-header a img{
    cursor: pointer;
    max-height: 30px;
    max-width: 30px;
  }
  .userlayout-header a{
    display: flex;
    align-items: center;
    justify-content: center;
    
  }
.userlayout-header a .Htitle{
  font-size: 18px;
  margin: 0 0 0 8px;
  font-family: "Chinese Quote", -apple-system, BlinkMacSystemFont, "Segoe UI", "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", "Helvetica Neue", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-weight: 600;
  display: inline-block;
  vertical-align: middle;
  color:#000;
  animation:mymove 0.5s;

}
@keyframes mymove{
    0%{
        opacity: 0;
    }
    50%{
        opacity: 0;
    }
    100%{
        opacity: 1;
    }
}
.Htitle{
    transition: all 2s;
}
.logimg{
    width:30%;
}
.userlayout-header .userlayout-a{
width: 100% !important;
}
.userlayout-a h1{
    width: 65%;
    text-align: left;
    margin-left: 20px !important;
}
.el-Logo--collapse{
    width: 100%;
}
</style>