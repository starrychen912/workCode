 <template>
  <div class="container">
      <div class="container--content">
          <div class="container_content--img" >
              <div class="title title--button"    @click="ModeSign">
                  <!-- 注册 -->
                  <button>注册</button>
              </div>
              <img class="img---setup-in"  src="@/assets/svg/undraw_Access_account_re_8spm.svg">
          </div>

          <div class="conteiner_content--text" >
              
              <div class="avatar-login">
                    <div class="avatar-img" >
                        <img src="@/assets/svg/undraw_male_avatar_323b.svg">
                    </div>
                    <h2>Welcome</h2>
                    <div class="input-group" :class="{'input-focus':formLabelAlign.inputStatus || formLabelAlign.username != ''}">
                        <i class="el-icon-user-solid"></i>
                        <div class="el_input--username" >
                            <!-- <h5 @click="H5Usenamefocus">Username</h5> -->
                            <input class="el_input" placeholder="请输入用户名/邮箱" v-model="formLabelAlign.username" ref="formLabelAlignelintpus" @focus="UserFocus" @blur="Userblur" autocomplete="off" />
                        </div>
                    </div>
                    <div class="input-group" :class="{'input-focus':formLabelAlign.passwordStatus}">
                        <i class="el-icon-lock"></i>
                        <div class="el_input--username" >
                            <!-- <h5 @click="H5Psswordfocus">Password</h5> -->
                            <input type="password"  placeholder="请输入密码" class="el_input" v-model="formLabelAlign.password" ref="formLabelAlignelintpu" @focus="PassFocus" @blur="Passblur"/>
                        </div>
                    </div>
                    <a class="forgot-password">忘记密码</a>
                    <div class="button--btn">
                        <button class="b-btn-login" @click="Login">登录</button>
                    </div>
              </div>
          </div>
      </div>
      <!-- <div class="el--lang">
                  <el-dropdown :hide-on-click="false">
                <div class="lang">
                    <svg width="16" height="16" viewBox="0 0 48 48" fill="none">
                        <path d="M42 42L39.7143 37M26 42L28.2857 37M28.2857 37L34 24L39.7143 37M28.2857 37H39.7143" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16 6L17 9" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 11H28" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10 16C10 16 11.7895 22.2609 16.2632 25.7391C20.7368 29.2174 28 32 28 32" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 11C24 11 22.2105 19.2174 17.7368 23.7826C13.2632 28.3478 6 32 6 32" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                    <template #dropdown>
                        <el-dropdown-menu>
                            13245647895
                        </el-dropdown-menu>
                    </template>      
                </el-dropdown>
              </div> -->
     <div class="lang">
         <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" @click="Other">
            <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
            <path d="M9 18V42H39V18L24 6L9 18Z" fill="#333"/>
            <path d="M9 42V18L4 22L24 6L44 22L39 18V42H9Z" stroke="#333" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M19 29V42H29V29H19Z" fill="#FFF" stroke="#FFF" stroke-width="4" stroke-linejoin="round"/>
            <path d="M9 42H39" stroke="#333" stroke-width="4" stroke-linecap="round"/>
        </svg>
         <el-popover
                :width="150"
                :trigger="mode === 'mobile'?'click':'hover'"
                placeholder="bottom"
                popper-class="popperlang"
                style="width: auto;"
            >
                <div class="popover--list">
                    <ul class="ul--list">
                        <li :class="{'liactive':item.value == language}" v-for="(item,index) in languages" :key="index" @click="handleSetLanguage(item.value)">{{item.name}}</li>
                        <!-- <li>简体中文</li> -->
                    </ul>
                </div>
                <template #reference>
                <div class="">
                    <svg width="20" height="20" viewBox="0 0 48 48" fill="none">
                        <path d="M42 42L39.7143 37M26 42L28.2857 37M28.2857 37L34 24L39.7143 37M28.2857 37H39.7143" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16 6L17 9" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 11H28" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10 16C10 16 11.7895 22.2609 16.2632 25.7391C20.7368 29.2174 28 32 28 32" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M24 11C24 11 22.2105 19.2174 17.7368 23.7826C13.2632 28.3478 6 32 6 32" stroke="#666" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                </template>
            </el-popover>
     </div>
    
  </div>
</template>

<script>import { reactive,ref,nextTick ,computed, watch} from "vue"
import { useStore } from 'vuex';
import {useRouter} from 'vue-router'
import { shoElmessage } from "../../utils/Elmessage";
import { login } from "@/api/Userinfo";
import i18n from "../../locale";
export default {
    setup(props,context){
        const store = useStore();
        const router = useRouter();
        const ipt =ref();
       

        const langlist = i18n.global.messages;
        
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

        
        const formLabelAlign = reactive({
            username:'',
            password:"",
            inputStatus:false,
            passwordStatus:false,
            mode:false,
            redirect:undefined
        })

        function handleSetLanguage(lang){
            store.commit('setting/CHANGE_SETTINGS',{
                lang:lang
            })
            location.reload();
        }
        function PassFocus(e){
            formLabelAlign.passwordStatus = true
        }

        function Passblur(){
            if(formLabelAlign.password.length == 0 && formLabelAlign.password == ''){
                formLabelAlign.passwordStatus = false
            }
            
        }
        function UserFocus(e){
            formLabelAlign.inputStatus = true
        }
        function Userblur(){
            if(formLabelAlign.username.length == 0 && formLabelAlign.username == ''){
                formLabelAlign.inputStatus = false
            }
            
        }
        function ModeSign(){
           router.push({path:'/Revision'})
        }

        watch(
        () => router.currentRoute,
        ({ _value }) => {
          const route = _value;
        //   console.log(_value);
          formLabelAlign.redirect = (route.query && route.query.redirect) || '/';
        },
        {
          immediate: true,
        }
      );
        function Other(){
            router.push({path:'/other/howitwork'})
        }
        function Login(){
            if(formLabelAlign.username == '' || formLabelAlign.username == undefined || formLabelAlign.username == null ){
                return shoElmessage(true,'请输入用户名','error')
            }
            if(formLabelAlign.password == '' || formLabelAlign.password == undefined || formLabelAlign.password == null ){
                return shoElmessage(true,'请输入密码','error')
            }
            login({
              email:formLabelAlign.username,
              password:formLabelAlign.password  
            }).then(res => {
                if(res.code === 1){
                    store.dispatch('userinfo/login',res.data.userinfo).then(res =>{
                        // const path = formLabelAlign.redirect === '/404' || formLabelAlign.redirect === '/401' ? '/' : formLabelAlign.redirect;
                        // console.log(path);
                        router.push({path:'/index/home'})
                    })
                }else{
                    shoElmessage(true,`登录失败,原因：${res.msg}`,'error')
                }
            })
        }
        return {
            Login,
            UserFocus,
            Userblur,
            PassFocus,
            Passblur,
            formLabelAlign,
            ModeSign,
            languages,
            langlist,
            language,
            handleSetLanguage,
            Other,
            mode:computed(() => store.state.setting.device.mode),
        }
    },
    methods:{
        
        H5Usenamefocus(){
            this.$nextTick(()=>{
                this.$refs.formLabelAlignelintpus.focus();
            })
        },
        H5Psswordfocus(){
            this.$nextTick(()=>{
                this.$refs.formLabelAlignelintpu.focus();
            })
        },
    }
}
</script>
<style >
.popperlang{
    padding: 0px !important;
    min-width: 50px !important;
    width: 100px !important;
}
</style>
<style scoped lang="scss">
:deep(html, body, #app){
    background-color: #FFF;
}
.container{
    position: relative;
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
    box-sizing: border-box;
    &::before{
        content: " ";
        position: absolute;
        width: 2000px;
        height: 2000px;
        border-radius: 50%;
        background-image: linear-gradient(-45deg, #2271ff 0%, #04befe 100%);
        transition: 1.8s ease-in-out;
        z-index: 6;
        top: -10%;
        right: 48%;
        transform: translateY(-50%);
        animation: containerberfore 2s;
    }
}
@keyframes containerberfore{
    0%{
        transform: translate(100%, -50%);
    }
}
// .container.container_sign-up-mode::before{
//     transform: translate(100%, -50%);
// }

.container--content{
    width: 100%;
    height: 100%;
    position: absolute;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    .container_content--img{
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-around;
            text-align: center;
            text-align: center;
            padding: 3rem 17% 2rem 12%;
            z-index: 6;
            transform: translateX(0px);
            transition:  0.9s ease-in-out;
            transition-delay: .5s;
            animation: ContainerImg .9s;
    }
    img{
        width: 100%;
    }
    @keyframes ContainerImg {
        0%{
            transform: translateX(-100px);
        }
    }
    .title{
        width: 100%;
        button{
            outline: none;
            padding: 6px 8px;
            min-width: 100px;
            text-align: center;
            border-radius: 30px;
            border: 2px solid #FFF;
            background: none;
            color: #FFF;
            cursor: pointer;
            transition: all .3s ease;
        }
    }
    .sign--title{
        transition: 1s ease-in-out;
        transform: translateX(0px);
    }
    .sign--title img , .sign--title {
        transition: 1s ease-in-out;
        transition-delay: .5s;
        transform: translateX(-800px);
    }
    .sign-dege img,.sign-dege {
        transition: transform 1s ease-in-out;
        transition-delay: .5s;
        transform: translateX(800px);
    }
    .sign--up img, .sign--up {
        transition: transform 1s ease-in-out;
        transition-delay: .5s;
        transform: translateX(0px);
    }
}

.conteiner_content--text{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    // align-content: center;
    animation: contenttext .9s;
    a{
        width: 100%;
        text-align: right;
        font-size: 15px;
        color: #1b82ff;
    }
}
@keyframes contenttext {
    0%{
       transform: translateX(800px);
    }
}
.avatar-login{
    min-width: 250px;
    width: 50%;
    min-height: 300px;
    padding: 50px;
    background-color: #FFF;
    border-radius: 5px;
    h2{
        font-size: 2.9rem;
        text-transform: uppercase;
        margin: 15px 0;
        color: #999;
        text-align: center;
    }
}
.avatar-img{
   grid-row: 1/1;
   grid-column: 1/2;
   justify-content: center;
   text-align: center;
    img{
        width: 100px;
        height: 100px;
    }
}

.input-group{
    position: relative;
    display: grid;
    grid-template-columns: 10% 90%;
    margin: 10px 0;
    // padding: 5px 0;
    border: 2px solid #d9d9d9;
    i{
        position: relative;
        height: 45px;
        line-height: 45px;
        color: #d9d9d9;
        font-size: 21px;
        text-align: center;
    }
    .el_input--username{
        height: 45px;
        input{
            width: 100%;
            height: 100%;
            border: 0px;
            outline: none;
            font-size: 14px;
        }
        input:after{
            border: none;
        }
        h5{
            position: absolute;
            left: 25px;
            top: -2px;
            transform: translateY(70%);
            color: #d9d9d9;
            font-size: 18px;
            transition: .3s;
        }
    }
}


// .input-group:before, .input-group:after {
//     content: '';
//     position: absolute;
//     bottom: -2px;
//     width: 0;
//     height: 2px;
//     background-color: #2271ff;
//     transition: .5s;
//     text-align: center;
// }
// .input-group:before, .input-group:after {
//     content: '';
//     position: absolute;
//     right: 0px;
//     bottom: -2px;
//     width: 2px;
//     height: 45px;
//     background-color: #2271ff;
//     transition: .5s;
//     text-align: center;
// // }
// .input-group:before {
//     left: 0%;
// }
.input-group.input-focus{
    border: 2px solid #2271ff;
    transition: all .5s;
}
// .input-group.input-focus:before, .input-group.input-focus:after {
//     width: 100%;
//     left: 0%;
// }
// h5{
//     margin:0px;
// }
// .input-group.input-focus h5{
//     transform: translateY(-50%);
// }
.input-group.input-focus i{
    // background-color: #2271ff;
    color: #2271ff;
}





.button--btn{
    width: 100%;
    .b-btn-login{
        display: block;
        width: 100%;
        height: 50px;
        border-radius: 2px;
        margin: 1rem 0;
        font-size: 0.8rem;
        outline: none;
        border: none;
        background-image: linear-gradient(to right,#4096ff,#75aef3,#1b82ff);
        cursor: pointer;
        color: #fff;
        text-transform: uppercase;
        font-family: 'Roboto', sans-serif;
        background-size: 200%;
        transition: .5s;
        &:hover{
            background-position: right;
        }
    }

}
@media only screen and(max-width:1500px){
    .avatar-login{
        width: 70%;
    }
}
@media only screen and(max-width:1200px){
    .avatar-login{
        width: 100%;
    }
}
@media only screen and(max-width:1000px){
    .avatar-login{
        width: 100%;
    }
}
@media only screen and(max-width:890px){
    .avatar-login{
        width: 100%;
    }
}
@media only screen and(max-width:790px){
    .conteiner_content--text{
        position: absolute;
        z-index: 8;
        top: 20%;
    }
    .container--content[data-v-77c14c32]{
        grid-template-columns: repeat(1, 1fr);
    }
    .container--content .container_content--img[data-v-77c14c32] {
        justify-content: space-between;
    }
    .container[data-v-77c14c32]::before {
            transform: translate(50%, -73%);
    }
}
:deep(input:-internal-autofill-selected ){
    background-color: -internal-light-dark(rgb(255, 255, 255), rgb(255, 255, 255)) !important;
    -webkit-transition-delay: 111111s;
    -webkit-transition: color 11111s ease-out, background-color 111111s ease-out;
}

.el--lang{
    width: 100%;
}
//翻译
.lang{
   position: absolute;
   top: 10px;
   right: 70px;
   cursor: pointer;
   z-index: 1111;
   display: flex;
   svg{
       margin:0 10px;
   }
}
.ul--list{
     width: 100%;
     padding: 0px !important;
       li{
            list-style: none;
            padding: 10px 0px;
            width: 100%;
            text-align: center;
            &:hover{
                background-color: #d9ecff;
                color: #2e95fc;
                cursor: pointer;
            }
       }
       .liactive{
           color: #999;
           &:hover{
               background-color: #fff;
               color: #999;
           }
       }
   }
</style>