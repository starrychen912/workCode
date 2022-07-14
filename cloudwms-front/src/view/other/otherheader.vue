<template>
  <el-header class="other--header" :class="{'active':navstatus}">
      <el-col class="navbar-header" :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
          <div class="other_header--logo">
              <a class="navbar" href="#">
                <img src="../../assets/img/logo.png" width="50" height="50"> 
                <div style="font-size:35px;font-family:'楷体';font-weight:600;margin-left:10px;">町町信息科技</div>
              </a>
          </div>
          <div class="other_header--list">
            <ul>
              <li :class="{'active':item.url == activeurl}" v-for="(item,index) in navbarlist" :key="index" @click="NavBarindex(index)">
                <a :href="item.url">{{item.name}}</a>
              </li>
              <!-- <li class="header_git">
                <img src="https://i.gtimg.cn/club/item/face/img/2/15922_100.gif">
              </li> -->
              <div class="hidden-xs">
                 <el-popover
                    placement="bottom"
                    width="200"
                    trigger="click"
                    popper-class="hidden_bottomclass"
                    >
                    <template #reference>
                      <div class="reference_hidden">
                        <i class="el-icon-s-tools"></i>
                        <i class="el-icon-caret-bottom"></i>
                      </div>
                    </template>
                    <template #default>
                      <div class="hidden_content--list">
                        <div class="list" ><a href="/index/home">Login in</a></div>
                      </div>
                    </template>
                  </el-popover>
              </div>
            </ul>
          </div>
      </el-col>
  </el-header>
</template>

<script>
import { computed, reactive,toRefs } from 'vue'
import { useRoute } from 'vue-router'
export default {
  mounted(){
    let that = this
    window.addEventListener('scroll',function(e){
      if(this.scrollY > 150){
        that.navstatus = true
      }else{
        that.navstatus = false;
      }
    })
  },
  name:"OtherHeader",
  setup(props,content){
    const route = useRoute();
    // console.log(route.path);
    const data = reactive({
      activeurl:computed(() => route.path),
      navbarlist:[
        {
          name:'Home',
          url:'/other/howitwork'
        },
        {
          name:'Support',
          url:'/other/support'
        },
        {
          name:'About Us',
          url:'/other/abouts_us'
        }
      ],
      navstatus:false,
    })
    
    function NavBarindex(item){
      data.activeindex = item
    }

    return {
      ...toRefs(data),
      NavBarindex
    }
  }
}
</script>

<style scoped lang="scss">
.other--header{
  height: auto;
  flex-shrink: 0;
  text-align: center;
  background-color: #fff;
  display: flex;
  justify-content: center;
  
  position: sticky;
  top: 0px;
  z-index: 99;
}
.other--header.active{
  border-bottom: 1px solid #eeeeee;
  box-shadow: 0 2px 6px rgb(0 0 0 / 5%);
}
.navbar-header{
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}
.other_header--logo{
  height: 100px;
  line-height: 100px;
  width: auto;
  a{
    height: 100%;
    width: auto;
    display: flex;
    align-items: center;
  }
}
.other_header--list{
  height: 100px;
  line-height: 100px;
}
.other_header--list ul{
  list-style: none;
  display: flex;
  margin:0;
  height: 100%;
  li{
    user-select: none;
    padding: 0px ;
    // padding: 32px 15px;
    height: 100%;
    font-size: 16px;
    font-weight: bold;
    padding: 0px 15px;
    color: #777;
    cursor: pointer;
    position: relative;
    &::after{
        display: block;
        content: "";
        height: 4px;
        width: 100%;
        position: absolute;
        bottom: 0px;
        left: 0px;
        background: $color-bg;
        opacity: 0;
        -webkit-transition: transform 0.2s ease-out,opacity 0.2s ease-out;
        transform-origin: 50% 0%;
        transform: scale(0.01,1);
    }
    &:hover::after{
      opacity: 1;
      transform: scale(1,1);
    }
    &:hover{
      background: #ecf5ff;
      a{
        color: $color-bg;
      }
    }
    &.active{
      background: #ecf5ff;
      &::after{
        display: block;
        content: "";
        height: 4px;
        width: 100%;
        position: absolute;
        opacity: 1;
        bottom: 0px;
        left: 0px;
        background: $color-bg;
        -webkit-transition: transform 0.2s ease-out,opacity 0.2s ease-out;
        transform-origin: 50% 0%;
        transform: scale(1,1);
      }
      a{
        color: $color-bg;
      }
    }
    a{
      color: #777;
      font-size: 18px;
    }
    
  }
}
@keyframes identifier {
    0%{
      width: 0%;
    } 
}
.hidden-xs{
  padding: 0px;
  background-color: none;
  color: #777;
  display: flex;
  align-items: flex-start;
  i{
    font-size: 20px;
  }
  // padding: 15px;
  cursor: pointer;
  width: 100px;
}
.reference_hidden{
  padding: 15px;
  height: auto;
  line-height: normal;
}
.list{
  text-align: center;
  cursor: pointer;
  padding: 10px;
  &:hover{
    background: #ecf5ff;
  }
}

@media only screen and (max-width: 850px){
  .other_header--list{
    width: 100%;
    ul{
      width: 100%;
      padding: 0px;
      li{
        width: 100%;
      }
    }
  }
}
@media only screen and (max-width: 580px){
  .other_header--list{
    line-height: normal;
    height: auto;
    ul{
      li{
        padding: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
        a{
          font-size: 11px;
        }
      }
    }
  }
}
</style>
<style>
.hidden_bottomclass{
  padding: 0px!important;
  padding:5px 0px!important;
}
</style>