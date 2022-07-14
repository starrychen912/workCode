<template>
    <div v-if="!dataItem.hidden" class="vite-sub--menu">
        <el-menu-item  v-if="hasOneShowingChild(dataItem.children,dataItem)" :index="resolvePath(onlyOneChild.path)" >
            <el-tooltip class="item" effect="dark" :content="onlyOneChild.meta.title" placement="right" v-if="isCollapse">
            <i :class="onlyOneChild.meta.icon"></i>
            </el-tooltip>
            <i :class="onlyOneChild.meta.icon"  v-else></i>
            <span>{{onlyOneChild.meta.title}}</span>
        </el-menu-item>
        <el-sub-menu :index="resolvePath(dataItem.path)" class="el-sub-menu--home"  v-else>
            <template #title>
                <i :class="dataItem.meta.icon"></i>
                <span>{{dataItem.meta.title}}</span>
            </template>
            <vite-sub-menu v-for="(item,index) in dataItem.children"  :key="index"  :dataItem="item" :base-path="resolvePath(item.path)" :isCollapse="isCollapse"></vite-sub-menu>
        </el-sub-menu>
    </div>
    
</template>

<script>
import ViteMenuItem from './ViteMenuItem.vue';
export default {
  components: { ViteMenuItem },
    name:"ViteSubMenu",
    props:{
        routelist:{
            type:[String,Boolean,Number,Array,Object],
            default:[]
        },
        isCollapse:{
            type:Boolean,
            default:false,
        },
        dataItem:{
            type:Object,
            default:{}
        },
        basePath:{
            type:String,
            default:''
        }
    },
    data(){
        // this.onlyOneChild = null
        return {
            onlyOneChild:null
        }
    },
    setup(props,content){
        // console.log(props.dataItem);
    },
    methods:{
        hasOneShowingChild(children = [],parent){
           const showingChildren = children.filter(item => {
                if(item.hidden){
                    return false;
                }else{
                    this.onlyOneChild = item
                    return true
                }
            })
            if (showingChildren.length === 1) {
                return true
            }
            if (showingChildren.length === 0) {
                this.onlyOneChild = { ... parent, path: '' }
                return true
            }
            return false;
        },
        resolvePath(routePath){
            return this.basePath +'/'+ routePath;
        }
    }

}
</script>

<style scoped lang="scss">
.el-menu-item{
    display: flex;
    align-items: center;
}
.el-menu--collapse .el-menu .el-sub--menu--collapse{
    min-width: 0;
}
.el-menu-item{
    span{
       &::after{
            display: inline-block;
            content: '';
            width:3px;
            height: 100%;
            background-color: var(--sidebar-active-border-background-color);
            position: absolute;
            right: 0px;
            top: 0px;
            -webkit-transition: transform 0.2s ease-out,opacity 0.2s ease-out;
            transform-origin: 0% 50%;
            transform: scale(1,0.01);
            opacity: 0;
        } 
    }
}
.el-sub-menu{
        .el-sub-menu__title{
            .svg{
                width: 24px;
                margin-right: 5px;
            }
        }
    }
.el-menu-item.is-active{
    background-color: var(--nav_is-active_bg,#409eff36);
    position: relative;

    span{
        color: var(--nav_is-active_color,#409EFF);
        &::after{
            opacity:1;
            transform: scale(1,1);
        }
    }
    i{
       color: var(--nav_is-active_color,#409EFF); 
    }
    .el-sub-menu--home{
         .el-sub-menu__title{
             color: var(--nav_is-active_bg,#409EFF);
         }
    }
}

.el-menu--collapse{
    .el-menu-item{
        span{
            height: 0;
            width: 0;
            overflow: hidden;
            visibility: hidden;
            display: inline-block;
        }
    }
    .el-sub-menu{
        .el-sub-menu__title{
            span{
                height: 0;
                // width: 0;
                overflow: hidden;
                visibility: hidden;
                display: inline-block;
                text-overflow: ellipsis;
                white-space: nowrap;
                min-width: 100%;
            }
            
        }
    }
}
.el-sub-menu.is-active.el-sub-menu--home > .el-sub-menu__title{
        i,span{
            color: var(--nav_is-active_spanbg,#409EFF);
        }
}
//light
.dark{
    .el-menu-vertical-demo{
        .vite-sub--menu{
            :deep(.el-menu--inline){
                background-color: var(--sidebar-nav-deputy-background--color);
            }
            .el-menu-item{
                span{
                    color: var(--sidebar-color);
                }
                i{
                    color: var(--sidebar-color);
                }
                &:hover{
                    background-color: var(--sidebar-active-background-color);
                    transition: all .5s;
                }
                &.is-active{
                    background-color: var(--sidebar-active-background-color);
                    transition: all .5s;
                }
            }
         
          //el-sub-menu_title选中颜色
           .el-sub-menu.is-active > .el-sub-menu__title{
                span{
                    color: var(--sidebar-active-background-color);
                }
                i{
                    color: var(--sidebar-active-background-color);
                }
            }
            .el-sub-menu{
                span{
                    color: var(--sidebar-color);
                }
                i{
                    color: var(--sidebar-color);
                }
                :deep(.el-sub-menu__title){
                    &:hover{
                        background-color: var(--sidebar-active-background-color);
                        span{
                           color: var(--sidebar-hover-color); 
                        }
                        i{
                            color: var(--sidebar-hover-color);
                        }
                    }
                }
                
            }
        }
        
    }
}
.el-menu--collapse{
    .el-menu-item{
        span{
            height: 0;
            width: 0;
            overflow: hidden;
            visibility: hidden;
            display: inline-block;
        }
    }
    .el-sub-menu{
        .el-sub-menu__title{
            span{
                height: 0;
                // width: 0;
                overflow: hidden;
                visibility: hidden;
                display: inline-block;
                text-overflow: ellipsis;
                white-space: nowrap;
                min-width: 100%;
            }
            
        }
    }
}
.vite-sub--menu{
    transition: width 0.25s;
    -webkit-transition: width 0.25s;
    -moz-transition: width 0.25s;
    -webkit-transition: width 0.25s;
    -o-transition: width 0.25s;
}
</style>
<style lang="scss">
.el-menu--collapse .el-menu .el-sub-menu--home{
    min-width: 0;
    // span{
    //     display: none;
    // }
    .el-sub-menu__title{
        .el-sub-menu__icon-arrow{
            display: none;
            // transition: all 0.2s;
        }
    }
    .el-menu-item .is-active{
        span{
            &::after{
                opacity: 0;
                transform: scale(1,0.01);
            }
        } 
    }
      
}
</style>