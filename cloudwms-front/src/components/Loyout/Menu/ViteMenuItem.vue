<template>
    <el-menu-item class="flex align-center elmenuitem" :index="ActionIndex"  @click="Elmenu" v-if="!Help">
        <div class="el" :class="{'el-menu-item--iscollapse':iscollapse}">
            <el-popover
                placement="right"
                :width="200"
                trigger="hover"
                :content="context"
                v-if="iscollapse"
            >
                <template #reference>
                    <i :class="Elicon"></i>
                </template>
            </el-popover>
            <i :class="Elicon"  v-else></i>
            
        </div>
        <span class="is_colleapse--span" v-if="!iscollapse">{{title}}</span>
        <div class="elmenuitem-tag"></div>
    </el-menu-item>


    <li class="el-menu-item flex align-center elmenuitem"  role="menuitem"  style="padding-left: 20px;" v-if="Help" @click="Elmenu({index:'/Officialwebsite/Officialwebsite'})">
        <div class="el" :class="{'el-menu-item--iscollapse':iscollapse}" >
            <el-popover
                placement="right"
                :width="200"
                trigger="hover"
                :content="context"
                v-if="iscollapse"
            >
                <template #reference>
                    <i :class="Elicon"></i>
                </template>
            </el-popover>
            <i class="el-icon-thumb"  v-else></i>
        </div>
        <span >{{title}}</span>
        <div class="elmenuitem-tag" ></div>
    </li>
</template>

<script>
import {computed} from 'vue'
import {useStore} from 'vuex'
import { reactive } from 'vue'
import router  from '../../../router'
export default {
    name:"ViteMenuItem",
    emits:['vitemenu'],
    props:{
        MenuStatus:{
            type:String,
            default:'default'
        },
        ActionIndex:{
            type:[String,Boolean,Number,Array,Object],
            default:"1"
        },
        Elicon:{
            type:String,
            default:"el-icon-menu"
        },
        title:{
            type:String,
            default:'Navigator Two'
        },
        context:{
            type:String,
            default:'首页'
        },
        route:{
            type:Object,
            default:null
        },
        Help:{
            type:Boolean,
            default:false
        },
        iscollapse:{
            type:Boolean,
            default:false
        }
    },
    setup(props,context){
        const store = useStore();
        const data = reactive({
            // iscollapse:computed(() => store.state.app.iscollapse)
        })
        function Elmenu(e){
            context.emit('vitemenu',e);
            // if(e.index === '/Officialwebsite/Officialwebsite'){ 
            //     let url = router.resolve({path:e.index,query:{}})
            //     window.open(url .href, '_blank');
            // }else{
            //     router.push({
            //         path:e.index,
            //         query:{}
            //     })
            // }
            // if(store.state.setting.device.mode == 'mobile'){
            //     store.commit('setting/SAVE_SETTINGS',{
            //         collapse:!store.state.setting.collapse
            //     })  
            // }
        }
        return{
            data,Elmenu
        }
    }
}
</script>

<style scoped>
.elmenuitem .el{
  width:30%;
  height: auto;
  margin-right: 10px;
  display: flex;
  align-items: center;
  justify-content: right;
}
.elmenuitem span{
    transition:all 0.5s;
    display: block;
}
.elmenuitem  .is_colleapse--span{
  width: 65%;
  text-align: left;
  animation: spananim 0.5s;
  
}
/* .elmenuitem .iscollapse{
    width: 0%;
} */
@keyframes spananim {
    0%{
        opacity: 0;
    }
}
.elmenuitem i{
    font-size: 20px;
}
.elmenuitem-tag{
    height: 0%;
    transition: all 0.1s;
}
.elmenuitem.is-active .elmenuitem-tag{
    height: 100%;
    width: 4px;
    background-color: #409eff;
    position: absolute;
    right: 0px;
    transition: all 0.1s;
}
.el-menu-item--iscollapse{
    width:100% !important;
}
</style>