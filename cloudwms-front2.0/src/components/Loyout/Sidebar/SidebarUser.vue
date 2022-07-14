<template>
    <div class="flex align-center SidebarUser" aria-describedby="el-popper-4906">
        <slot name="pav" />
        
        <div class="userinfo el-dropdown-selfdefine" data-v-8e021e66="" aria-haspopup="list" aria-controls="dropdown-menu-2706" role="button" tabindex="0">
            <slot name="userinfo-pav"></slot>
            <div class="screenfull" >
                <svg  class="screen-out" @click="Screen" v-if="!isFullscreen" width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                <svg  class="screen-in" @click="Screen" v-if="isFullscreen" width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6V15H42" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 6V15H6" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42V33H6" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M33 42V33H41.8995" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                <!-- <i class="el-icon-full-screen" @click="Screen"></i> -->
            </div>
            <el-dropdown :hide-on-click="false">
                <div class="Translation" style="border:none;">
                    <svg width="20" height="20" viewBox="0 0 48 48" >
                        <path d="M42 42L39.7143 37M26 42L28.2857 37M28.2857 37L34 24L39.7143 37M28.2857 37H39.7143"  stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16 6L17 9"  stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 11H28"  stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10 16C10 16 11.7895 22.2609 16.2632 25.7391C20.7368 29.2174 28 32 28 32"  stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 11C24 11 22.2105 19.2174 17.7368 23.7826C13.2632 28.3478 6 32 6 32"  stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item v-for="(item,index) in languages" :key="index" :disabled="language == item.value" @click="handleSetLanguage(item.value)" >
                            <span >{{item.name}}</span>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
             <el-popover
                    placement="bottom"
                    width="auto"
                    trigger="click"
                    popper-class="popover-contenx"
                    style="padding: 0px;"
                 >
                <div class="popover-contone">
                   <div class="userinfo-title">
                       <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="MenuItemHeader_Icon__2Xf98"><path fill="#b3efff" d="M27 26.634a.369.369 0 01-.37.366H10.371a.368.368 0 01-.37-.366V17.89a5.564 5.564 0 005.555-2.1c1.014 1.339 2.626 2.211 4.444 2.211s3.43-.872 4.444-2.211A5.583 5.583 0 0027 17.673v8.962z"></path><path d="M30 26.634a.369.369 0 01-.37.366H10.371a.368.368 0 01-.37-.366V17.89a5.564 5.564 0 005.555-2.1c1.014 1.34 2.626 2.211 4.444 2.211s3.43-.872 4.444-2.211a5.562 5.562 0 005.555 2.1v8.744zM24 33h-8c.301-.601.475-1.28.475-2v-2h7.049v2c0 .72.174 1.399.475 2zm4.535-17c-1.91 0-3.465-1.615-3.465-3.6 0-.141-.028-.274-.071-.4h7v.4c0 1.985-1.554 3.6-3.465 3.6zM23.5 12c-.043.126-.07.259-.07.4 0 1.985-1.539 3.6-3.43 3.6s-3.43-1.615-3.43-3.6c0-.141-.027-.274-.07-.4h7zM8 12h7a1.232 1.232 0 00-.071.4c0 1.985-1.554 3.6-3.465 3.6s-3.465-1.615-3.465-3.6V12zm2.317-5h19.365l1.957 3H8.36l1.957-3zm23.502 2.879L31.16 5.814A1.783 1.783 0 0029.667 5H10.333c-.602 0-1.159.304-1.493.814L6.181 9.879a1.114 1.114 0 00-.181.609v2.129c0 1.791.849 3.378 2.155 4.381l-.001.009v9.432c0 1.412 1.127 2.561 2.513 2.561h3.949v2.171c0 1.008-.805 1.829-1.795 1.829h-.359c-.594 0-1.077.393-1.077 1s.482 1 1.077 1h15.077c.594 0 1.077-.393 1.077-1s-.482-1-1.077-1h-.359c-.99 0-1.795-.821-1.795-1.829V29h3.949c1.386 0 2.513-1.149 2.513-2.561v-9.432l-.001-.009a5.514 5.514 0 002.155-4.381v-2.129c0-.217-.063-.428-.181-.609z"></path></svg>
                       <div class="username-title">Hello，你好，{{Username.username}}~</div>
                   </div>
                    <div class="order-title">订单数量：1000</div>
                    <div class="order-notion">信息通知：1000</div>
                    <div class="setting-notion">
                        <div class="setting-account">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="MenuItemHeader_Icon__2Xf98"><path fill="#fff8c8" d="M13.071 12.052h-6.02v21.041a1 1 0 001 1h11.448a1 1 0 001-1V15s-2-1.5-3.399-2.174-2.646-.775-4.03-.775z"></path><path d="M5 9.208C5 7.985 5.986 7 7.208 7h5.863c1.643 0 3.27.312 4.788.926h.001l1.666.661 1.666-.662a12.75 12.75 0 014.788-.926h6.811c1.222 0 2.208.985 2.208 2.208v15.455c0 .568-.214 1.105-.597 1.518l-4.964 5.27a2.216 2.216 0 01-1.605.693H20.55v.55c0 .568-.458 1.026-1.026 1.026s-1.026-.458-1.026-1.026v-.55H7.206a2.205 2.205 0 01-2.208-2.208V9.206zm8.071-.156h-6.02v21.041h11.448V10.386l-1.399-.56a10.89 10.89 0 00-4.03-.775zm12.91 0a10.89 10.89 0 00-4.03.775l-1.399.56v19.707H26v-6.067c0-.569.458-1.026 1.026-1.026h5.923V9.053h-6.968zm6.805 16h-4.734v5.035l4.734-5.035z"></path></svg>
                            <span>Account</span>
                        </div>
                        <div class="userinfo--seting">
                            <div class="setting" @click="Userouter('/Userinfo')">简介</div>
                            <div class="setting"  @click="Userouter('/Settings/Settings')">通用设置</div>
                            <div class="setting"  @click="SystemSetting('light')">系统设置</div>
                            <div class="logout" @click="Logout">退出登录</div>
                        </div>

                    </div>
                </div>
                <template #reference>
                    <div class="userinfo" style="padding:0px">
                        <div class="userinfo_avater" >
                            <img class="avatar" :src="UserHeader" data-v-8e021e66="">
                            <div class="userinfo_name">{{Username.username}}12346</div>
                        </div>
                        <el-icon class="el-icon-caret-bottom"></el-icon>
                    </div>
                </template>
            </el-popover>
             <slot name="UserInfo"></slot>
             <div class="el_icon-tools" @click="Tools" v-if="Settings"><i class="el-icon-s-tools"></i></div>
        </div>
    </div>
    <el-drawer
        v-model="drawer"
        :before-close="handleClose"
        :with-header="false"
        custom-class="drawer"
        size="30%"
        >
        <div class="drawer_content">
            <div class="drawer_content--ui">
                <div class="title">界面风格设置</div>
                <div class="ui_content--img">
                    <div class="img" @click="TOGGLE_THEME('dark')">
                        <img src="https://cloud.huaxiaerp.vip/img/dark.da07f9c2.svg">
                        <!-- <i class="el-icon-check" :class="{'active':theme === 'dark'}"></i> -->
                        <div class="check_icon" :class="{'active':theme === 'dark'}">
                            <svg class="icon" width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 24L20 34L40 14" stroke="#67C23A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="img" @click="TOGGLE_THEME('light')">
                        <img src="https://cloud.huaxiaerp.vip/img/light.262af236.svg">
                        <div class="check_icon" :class="{'active':theme === 'light'}">
                            <svg class="icon" width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 24L20 34L40 14" stroke="#67C23A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui_color">
                <div class="title">主题色</div>
                <div class="ui_color--list" v-if="theme == 'dark'">
                    <span class="list" :style="[{'background-color':item.bgcolor}]" v-for="(item,index) in darklist" :key="index" @click="TOGGLE_THEME_COLOR(item.bgcolor,index)" >
                        <i class="el-icon-check" :class="{'active':uiindex == index}"></i>
                    </span>
                </div>
                <div class="ui_color--list" v-else>
                    <span class="list" :style="[{'background-color':darklist[index].bgcolor}]" v-for="(item,index) in lightlist" :key="index" @click="TOGGLE_THEME_COLOR(item.bgcolor,index)" >
                        <i class="el-icon-check" :class="{'active':uiindex == index }"></i>
                    </span>
                </div>
                <div class="title">自定义颜色 </div>
                <div class="ui_color--list">
                    <el-color-picker v-model="theme_color" @change="PICKERCOLOR" show-alpha></el-color-picker>
                </div>
                <div class="title">表格边框颜色</div>
                <div class="ui_color--list">
                    <el-color-picker v-model="border_color" @change="BORDERCOLOR" show-alpha></el-color-picker>
                </div>
            </div>
            <el-divider></el-divider>
            <div class="separator">
                <div class="separator_content">
                    <div class="separator_title">不知道写什么</div>
                    <el-switch
                        v-model="switch1"
                    >
                    </el-switch>
                </div>
            </div>
        </div>
    </el-drawer>
</template>

<script>
// import store from "../../../store";
import { useStore } from 'vuex';
import i18n from '../../../locale';
import router from '../../../router';
import { reactive,computed,ref,toRefs,onMounted } from 'vue';
import { useRoute } from 'vue-router';
import screenfull from 'screenfull'
export default {
    name:"SidebarUser",
    props:{
        UserHeader:{
            type:String,
            default:'https://i.gtimg.cn/club/item/face/img/2/15922_100.gif'
        },
        Username:{
            type:[Object,String],
            default:{
                username:"战三"
            }
        },
        Settings:{
            type:Boolean,
            default:false
        }
    },

    setup(props,context){
        const store = useStore();
        const route = useRoute();
        const langlist = i18n.global.messages;
        const datas  = reactive({
            isFullscreen:false,
            drawer:false,
            uistatus:false,
            switch1:false,
            theme:computed(() => store.state.setting.theme),
            darklist:[
                {
                    bgcolor:'#409EFF'
                },{
                    bgcolor:'rgb(19, 194, 194)'
                },{
                    bgcolor:'rgb(245, 34, 45)'
                },{
                    bgcolor:'rgb(250, 173, 20)'
                },{
                    bgcolor:'rgb(47, 84, 235)'
                }
            ],
            lightlist:[
                {
                    bgcolor:'rgba(64, 158, 255,0.21)',
                },{
                    bgcolor:'rgba(19, 194, 194,0.21)',
                },{
                    bgcolor:'rgba(245, 34, 45,0.21)'
                },{
                    bgcolor:'rgba(250, 173, 20,0.21)'
                },{
                    bgcolor:'rgba(47, 84, 235,0.21)'
                }
            ],
            uiindex:0,
            theme_color:'#409EFF',
            border_color:'#409EFF',
        })
        const languages = reactive([
            {
                name: '简体中文',
                value: 'zh-cn',
            },
            {
                name: 'English',
                value: 'en',
            },
        ]);
        const language = computed(() => {
            return store.state.setting.lang
        });


        let data = {
           UserHeader:props.UserHeader,
           Username:props.Username
        }
        onMounted(() =>{
            window.addEventListener('keydown',function(e){
                if(e.keyCode == 122){
                    e.returnValue = false;
                    datas.isFullscreen = !datas.isFullscreen
                    screenfull.toggle();
                }
            },true);

            window.onresize = () =>{
                let isFull = window.fullScreen || document.webkitIsFullScreen
                datas.isFullscreen = isFull
            }


        })
        function Tools(){
            context.emit('Tools',data);
        }
        function Userouter(path){
            router.push({path})
        }
        function ShopManage(){
            router.push({
                path:"/index/Storeshop"
            })
        }
        function Logout(){
            store.dispatch('userinfo/loginout').then(res => {
                router.push({path:'/logins'})
            })
        }
        function handleSetLanguage(lang){
            store.commit('setting/CHANGE_SETTINGS',{
                lang:lang
            })
            location.reload();
        }
        //显示返回店铺管理
        function GetShopindex(){
            if(route.path.indexOf('/shop') != -1){
                return true;
            }else{
                return false;
            }
        }
        function Screen(){
            datas.isFullscreen = !datas.isFullscreen
            screenfull.toggle();
        }
        function KeyDown(event){
            console.log(event);
        }
        function SystemSetting(item){
            datas.drawer = !datas.drawer
        }
        //修改主题
        function TOGGLE_THEME(item){
            store.dispatch('setting/toggleTheme',item)

            if(datas.theme == 'light'){
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_bg',datas.lightlist[datas.uiindex].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_color',datas.darklist[datas.uiindex].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',datas.darklist[datas.uiindex].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',datas.darklist[datas.uiindex].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',datas.darklist[datas.uiindex].bgcolor)
            }else{
                //主颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-background-color',datas.darklist[datas.uiindex].bgcolor)
                //副颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',datas.darklist[datas.uiindex].bgcolor)
            }
        }
        function TOGGLE_THEME_COLOR(item,index){
            datas.uiindex = index
            datas.theme_color = item
            
            if(datas.theme == 'light'){
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_bg',item)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_color',datas.darklist[index].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',datas.darklist[index].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',datas.darklist[index].bgcolor)
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',datas.darklist[index].bgcolor)
            }else{
                //主颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-background-color',item)
                //副颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',item)
            }
            
        }
        function PICKERCOLOR(item){
            data.theme_color = item
            if(datas.theme == 'light'){
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_bg',item)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_color','#fff')
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',item)
                document.getElementsByTagName('body')[0].style.setProperty('--nav_is-active_spanbg',item)
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',item)
            }else{
                //主颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-background-color',item)
                //副颜色
                document.getElementsByTagName('body')[0].style.setProperty('--sidebar-active-border-background-color',item)
            }
            // TOGGLE_THEME_COLOR(item,0)
        }
        //修改表格颜色
        function BORDERCOLOR(item){
            data.border_color = item;
            document.getElementsByTagName('body')[0].style.setProperty('--el-table-border',item)
            document.getElementsByTagName('body')[0].style.setProperty('--el-table-border-color','#fff')
            document.getElementsByTagName('body')[0].style.setProperty('--el-border-color-lighter',item)
        }
        function handleClose(){
            datas.drawer = !datas.drawer
        }
        return{
            Userouter,
            Tools,
            Logout,
            languages,
            language,
            handleSetLanguage,
            ShopManage,
            GetShopindex,
            Screen,
            ...toRefs(datas),
            KeyDown,
            SystemSetting,
            TOGGLE_THEME,
            TOGGLE_THEME_COLOR,
            PICKERCOLOR,
            BORDERCOLOR,
            handleClose
        }
    }
}
</script>

<style lang="scss" scoped>
.el_icon-tools{
    width: 50px;
    font-size: 20px;
}
.popover-contone{
    box-sizing: border-box;
    width: 100%;
    font-size: 15px;
    ul{
        padding: 0px;
        li{
            list-style: none;
            text-align: center;
            padding: 5px 0px;
            font-size: 15px;
            cursor: pointer;
            &:hover{
                background-color: rgb(233, 233, 233);
            }
        }
    }
}
.username-title{
    padding-left: 20px;
}
.userinfo_avater{
    display: flex;
    align-items: center;
}
.userinfo_name{
    min-width: 0;
    max-width: 70px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.userinfo-title{
    width: 300px;
    display: flex;
    align-items: center;
}
.order-title,.order-notion{
    padding: 5px 60px;
    
}
.userinfo--seting{
    width: 100%;
    height: auto;
    cursor: pointer;
    .setting{
        padding: 10px 5px;
        &:hover{
            background-color: rgb(242, 248, 255);
        }
    }
    .logout{
        padding: 10px 5px;
        &:hover{
            background-color: rgb(242, 248, 255);
        }
    }
}
.setting-account{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0px;
}
.Translation{
    padding: 0px 15px;
    svg {
        fill:$locale;
        stroke: $locale;
    }
}
//放大缩小图标
.screenfull{
    display: flex;
    align-items: center;
    justify-content: center;
}
.screen-out{
    transform: scale(1);
    animation: Out 0.5s;
}
.screen-in{
    transform: scale(1);
    animation: in 0.5s;
}

.drawer_content{
    .drawer_content--ui{
        .ui_content--img{
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            
        }
        .title{
            font-size: 18px;
            padding: 20px 0px;
        }
        .img{
            width: 100px;
            height: 100px;
            position: relative;
            &:last-of-type{
                margin-left: 10px;
            }
            img{
                width: 100%;
                height: 100%;
            }
            .check_icon{
                display: none;
                position: absolute;
                font-weight: bold;
                top: calc(50% - 15px);
                right: calc(50% - 30px);
                color: #67C23A;
                width: 40%;
                height: 40%;
                &.active{
                    display: block;
                }
                
            }
            .el-icon-check{
                display: none;
                position: absolute;
                font-size: 30px;
                font-weight: bold;
                top: calc(50% - 15px);
                right: calc(50% - 30px);
                color: #67C23A;
                &.active{
                    display: block;
                }
            }
        }
    }
    .ui_color{
        .title{
            font-size: 18px;
            padding: 10px 0px;
        }
        .ui_color--list{
            width: 100%;
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            .list{
                width: 25px;
                height: 25px;
                border-radius: 2px;
                float: left;
                cursor: pointer;
                margin:5px;
                margin-right: 2px;
                padding-left: 0;
                padding-right: 0;
                text-align: center;
                color: #fff;
                font-weight: 700;
                position: relative;
                
                .el-icon-check{
                    display: none;
                    position: absolute;
                    font-size: 15px;
                    font-weight: bold;
                    top: calc(50% - 6px);
                    left: calc(50% - 8px);
                    color: #fff;
                    &.active{
                        display: block;
                    }
                }
            }
            
        }
    }
    .separator{
        display: flex;
        flex-wrap: wrap;
        .separator_content{
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .separator_title{

        }
    }
}

.icon path:nth-child(1){
    stroke-dasharray: 3000;
    stroke-dashoffset: 3000;
    animation: line-anm 5s ease forwards;
}
@keyframes line-anm {
    to{
        stroke-dashoffset: 0;
    }
}
@keyframes Out {
    0%{
       transform: scale(0); 
    }
}
@keyframes in {
    0%{
       transform: scale(2); 
    }
}
</style>
<style lang="scss">
.drawer{
    .el-drawer__body{
        padding: 20px;
    }
}
</style>