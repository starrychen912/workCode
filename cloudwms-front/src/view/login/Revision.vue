 <template>
  <div class="container" >
      <div class="container--content">
          <div class="conteiner_content--text" >
              <div class="avatar-login">
                    <h2>Set up</h2>
                    <el-form :model="ruleForm" label-position="left" status-icon :rules="rules" ref="ruleForm" label-width="auto" class="demo-ruleForm">
                        <el-form-item label="用户名" prop="username">
                            <el-input type="username" v-model="ruleForm.username" ></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="password">
                            <el-input type="password" v-model="ruleForm.password" ></el-input>
                        </el-form-item>
                        <el-form-item label="手机号" prop="mobile">
                            <el-input v-model="ruleForm.mobile"></el-input>
                        </el-form-item>
                        <el-form-item label="邮箱" prop="email">
                            <el-input v-model="ruleForm.email"></el-input>
                        </el-form-item>
                        
                        <el-form-item  prop="code">
                            <el-input v-model="ruleForm.code">
                                <template #append>
                                    <span style="cursor: pointer;" @click="GetCode" v-loading.fullscreen.lock="fullscreenLoading">{{time == '获取验证码'?time:time+'s'}}</span>
                                </template>
                            </el-input>
                        </el-form-item>
                        <el-form-item label-width="0px">
                            <div class="button--btn" >
                                <el-button type="primary" @click="submitForm('ruleForm')" :loading="loading">注册</el-button>
                            </div>
                            <!-- <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
                            <el-button @click="resetForm('ruleForm')">重置</el-button> -->
                        </el-form-item> 
                        <el-form-item label-width="0px">
                            <div class="button--btn info" >
                                <el-button type="info" @click="resetForm('ruleForm')"  >重置</el-button>
                            </div>
                        </el-form-item> 
                    </el-form>
              </div>
              
          </div>
        <div class="container_content">
            <div class="title title--button--setup" data-v-a3ccadca=""><!-- 注册 --><button data-v-a3ccadca="" @click="LoginRouter">登录</button></div>
            <img class="img---setup-in img--setup-up" src="/src/assets/svg/undraw_Login_re_4vu2.svg" data-v-a3ccadca="">
        </div>
      </div>
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
                <div style="padding-top: 10px;">
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

<script>import { reactive,ref,nextTick ,computed, watch, toRef, toRefs} from "vue"
import { useStore } from 'vuex';
import {useRouter} from 'vue-router'
import {validatePsdReg,validateEMail,validatePhone} from '@/utils/utils'
import { SetRegister,Findersend ,Findercheck } from "@/api/Revision";
import {shoElmessage} from '@/utils/Elmessage'
import router from "../../router";
import store from "../../store";
import i18n from "../../locale";
export default {
    data(){

        return{
            fullscreenLoading:false,
            time:'获取验证码',
            loading:false,
            ruleForm:{
                username:"",
                password:"",
                email:"",
                mobile:'',
                code:""
            },
            rules: {
                // username:[{required: false, message: '请输入用户名', trigger: 'blur'},{ min: 3, max: 10, message: '长度3个字符以上 10 个字符以下', trigger: 'blur' }],
                password: [{ required: true, validator: validatePsdReg, trigger: 'blur'}],
                email: [{required: true,validator: validateEMail, trigger: 'blur' }],
                mobile: [{required: true,validator: validatePhone, trigger: 'blur' }],
                code: [{required: true,message: '请输入验证码', trigger: 'blur' },{ min: 4, max: 6, message: '必须6位数', trigger: 'blur' }],
            }
            
        }
    },
    setup(props,context){
        const store = useStore();
        const router = useRouter();
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
        function LoginRouter(){
            router.push({path:'/logins'})
        }
        function handleSetLanguage(lang){
            store.commit('setting/CHANGE_SETTINGS',{
                lang:lang
            })
            location.reload();
        }
        function Other(){
            router.push({path:'/other/howitwork'})
        }
        return {
            LoginRouter,
            mode:computed(() => store.state.setting.device.mode),
            handleSetLanguage,
            langlist,
            languages,
            language,
            Other
        }
    },
    methods:{
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
         GetCode(){
             this.fullscreenLoading = true
             if(this.time == '获取验证码'){
                 if(this.ruleForm.email != '' && this.ruleForm.email != undefined && this.ruleForm.email != null){
                     Findersend({
                            email:this.ruleForm.email,
                            event:null
                         }
                        ).then(res =>{
                            this.fullscreenLoading = false
                            if(res.code == 1){
                                this.time = 60
                                let settime  = setInterval(() => {
                                    this.time--
                                    if(this.time == 0){
                                        this.time = '获取验证码'
                                        clearInterval(settime);
                                    }
                                }, 1000);
                                shoElmessage(true,'发送成功','success')
                            }else{
                                shoElmessage(true,`发送失败，原因：${res.msg}`,'error')
                            }
                        })
                 }else{
                     this.fullscreenLoading = false
                     shoElmessage(true,'邮箱你都没有输入你想发验证码？？？？？？','error')
                 }
             }else{
                 this.fullscreenLoading = false
                 shoElmessage(true,'发送中....请等待验证码','warning')
             }
         },
        //在线验证验证码是否正确的接口
        sendFindercheck(formName){
            return Findercheck({
                email:this.ruleForm.email,
                // event:'',
                captcha:this.ruleForm.code,
            }).then(res => {
                if(res.code == 1){
                    this.submitForm(formName);
                }else{
                    shoElmessage(true,`验证码有问题,原因：${res.msg}`,'error')
                    this.loading = false
                    return false;
                }
            })
        },

        submitForm(formName) {
            this.loading = true
            this.$refs[formName].validate((valid) => {
            if (valid) {
                SetRegister(this.ruleForm).then(res => {
                    if(res.code == 1){
                        shoElmessage(true,'注册成功')
                        setTimeout(()=>{
                            store.dispatch('userinfo/login',res.data.userinfo).then(res => {
                                // const path = state.redirect === '/404' || state.redirect === '/401' ? '/' : state.redirect;
                                router.push({path:'/'})
                            })
                        },1500)
                        this.loading = false
                    }else{
                        shoElmessage(true,`你失败了，具体原因：${res.msg}`,'error')
                        setTimeout(()=>{
                            this.loading = false
                        },2000)
                    }  
                })
               
            } else {
                console.log('error submit!!');
                this.loading = false
                return false;
            }
            });
        }
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
        transform: translate(100%, -50%);
        animation: befoteBG 2s;

    }
}
@keyframes befoteBG {
    0%{
        transform: translateY(-50%);
    }
}
.conteiner_content--text{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: setupinput .9s;

}

@keyframes setupinput {
    0%{
        transform: translateX(-100%);
    }
    
}


.container--content{
    width: 100%;
    height: 100%;
    position: absolute;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}
.avatar-login{
    min-width: 250px;
    width: 50%;
    min-height: 300px;
    padding: 50px;
    background-color: #FFF;
    border-radius: 5px;
}

.button--btn{
    width: 100%;
    .el-button{
        display: block;
        width: 100%;
        height: 50px;
        border-radius: 2px;
        margin: 0px 0;
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
.info{
    .el-button{
        color: rgb(136, 136, 136);
        background-image: linear-gradient(to right,#dddddd,#d8d8d8,#dddddd);
    } 
}
.container_content{
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: space-around;
    text-align: center;
    text-align: center;
    padding: 3rem 17% 2rem 12%;
    z-index: 6;
    transition: 0.9s ease-in-out;
    transition-delay: 0.5s;
    animation: containerbtn .9s;
    .title{
        width: 100%;
        text-align: center;
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
            transition: all 0.3s ease;
        }
    }
    img{
        width: 100%;
    }
}
@keyframes containerbtn{
    0%{
        transform: translateX(100%);
    }
    
}
@media only screen and(max-width:5000px){
    .avatar-login{
        width: 50%;
    }
}
@media only screen and(max-width:1400px){
    .avatar-login{
        width: 60%;
    }
}
@media only screen and(max-width:1200px){
    .avatar-login{
        width: 70%;
    }
}
@media only screen and(max-width:990px){
    .avatar-login{
        width: 100%;
    }
}
@media only screen and(max-width:890px){
    .container{
        &::before{
            transform: translate(50%, -73%);
            animation: mobilecontainer .9s;
        }
    }
    .container--content[data-v-2ac0ee7c] {
        grid-template-columns: repeat(1, 1fr);
    }
    .conteiner_content--text{
        position: absolute;
        z-index: 8;
        top: 20%;
    }
    .avatar-login{
        width: 100%;
    }
    .container_content{
        justify-content: space-between;
    }
}
@keyframes mobilecontainer{
    0%{
        transform: translateX(-100%);
    }
    
}
@media only screen and(max-width:380px){
    .avatar-login{
        padding: 20px;
        border-radius: 0px;
    }
    // .container_content{
    //     padding: 1rem 17% 1rem 12%;
    // }
}
:deep(.el-input-group__append){
    min-width: 70px;
    text-align: center;
    background-color: #4096ff;
    border: none;
    color: #fff;
}
.lang{
   position: absolute;
   top: 10px;
   left: 70px;
   cursor: pointer;
   z-index: 1111;
   display: flex;
   align-items: center;
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