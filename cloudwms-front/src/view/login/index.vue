 <template>
  <div class="container" :class="{'container_sign-up-mode':formLabelAlign.mode}">
      <div class="container--content">

          <div class="container_content--img" :class="{'sign--title':formLabelAlign.mode}" v-if="mode == 'PC' || !formLabelAlign.mode" >
              <div class="title title--button"    @click="ModeSign">
                  <!-- 注册 -->
                  <button>注册</button>
              </div>
              <img class="img---setup-in" :class="[!formLabelAlign.mode?'img--setup---up':'']" src="@/assets/svg/undraw_Access_account_re_8spm.svg">
          </div>


          <div class="container_content--img sign-dege"  :class="{'sign--up':formLabelAlign.mode}" v-if="mode == 'PC' || formLabelAlign.mode " >
              <div class="title title--button--setup"  @click="ModeSign">
                  <!-- 注册 -->
                  <button>登录</button>
              </div>
              <img  class="img---setup-in" :class="[formLabelAlign.mode?'img--setup-up':'']" src="@/assets/svg/undraw_Login_re_4vu2.svg">
          </div>
          
          <div class="conteiner_content--text" :class="{'sugin-from--up':formLabelAlign.mode}">
              <div class="avatar-login">
                    <div class="avatar-img" v-if="mode == 'PC'">
                        <img src="@/assets/svg/undraw_male_avatar_323b.svg">
                    </div>
                    <h2>Welcome</h2>
                    <div class="input-group" :class="{'input-focus':formLabelAlign.inputStatus}">
                        <i class="el-icon-user-solid"></i>
                        <div class="el_input--username" >
                            <!-- <h5 @click="H5Usenamefocus">Username</h5> -->
                            <input class="el_input" v-model="formLabelAlign.username" ref="formLabelAlignelintpus" @focus="UserFocus" @blur="Userblur"/>
                        </div>
                    </div>
                    <div class="input-group" :class="{'input-focus':formLabelAlign.passwordStatus}">
                        <i class="el-icon-lock"></i>
                        <div class="el_input--username" >
                            <!-- <h5 @click="H5Psswordfocus">Password</h5> -->
                            <input class="el_input" v-model="formLabelAlign.password" ref="formLabelAlignelintpu" @focus="PassFocus" @blur="Passblur"/>
                        </div>
                    </div>
                    <a class="forgot-password">忘记密码</a>
                    <div class="button--btn">
                        <button class="b-btn-login" @click="Login">登录</button>
                    </div>
              </div>
          </div>

          <div class="conteiner_content--text setup_in" :class="{'setup_in-opactiv':formLabelAlign.mode}">
              <div class="avatar-login">
                    <!-- <div class="avatar-img" v-if="mode == 'PC'">
                        <img src="@/assets/svg/undraw_male_avatar_323b.svg">
                    </div> -->
                    <h2>Set up</h2>
                    <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="auto" class="demo-ruleForm">
                        <el-form-item label="用户名" prop="username">
                            <el-input type="username" v-model="ruleForm.username" autocomplete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="checkPass">
                            <el-input type="password" v-model="ruleForm.checkPass" autocomplete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="邮箱" prop="email">
                            <el-input v-model.number="ruleForm.email"></el-input>
                        </el-form-item>
                        <el-form-item label="手机号" prop="mobile">
                            <el-input v-model.number="ruleForm.mobile"></el-input>
                        </el-form-item>
                        <el-form-item  prop="code">
                            <el-input v-model.number="ruleForm.code">
                                <template #append>
                                    <span style="cursor: pointer;">获取验证码</span>
                                </template>
                            </el-input>

                        </el-form-item>
                        <el-form-item  prop="code">
                        <div class="button--btn" >
                            <button class="b-btn-login" @click="Login">注册</button>
                        </div>
                        </el-form-item>
                    <!-- <el-form-item>
                        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
                        <el-button @click="resetForm('ruleForm')">重置</el-button>
                    </el-form-item> -->
                    </el-form>
                    <!-- <h2>Welcome</h2>
                    <div class="input-group" :class="{'input-focus':formup.inputStatus}">
                        <i class="el-icon-user-solid"></i>
                        <div class="el_input--username" >
                            <h5 @click="formupH5Usenamefocus">Username</h5>
                            <input class="el_input" v-model="formup.username" ref="elintpus" @focus="formupUserFocus" @blur="formupUserblur"/>
                        </div>
                    </div>
                    <div class="input-group" :class="{'input-focus':formup.passwordStatus}">
                        <i class="el-icon-user-solid"></i>
                        <div class="el_input--username" >
                            <h5 @click="formupH5Psswordfocus">Password</h5>
                            <input class="el_input" v-model="formup.password" ref="elintpu" @focus="formupPassFocus" @blur="formupPassblur"/>
                        </div>
                    </div> -->
                    <!-- <a class="forgot-password" style="text-align: left;">忘记密码</a> -->
                    
              </div>
          </div>

      </div>
  </div>
</template>

<script>import { reactive,ref,nextTick ,computed, watch} from "vue"
import { useStore } from 'vuex';
import {useRouter} from 'vue-router'

export default {
    setup(props,context){
        const store = useStore();
        const router = useRouter();
        const ipt =ref();
       
       const ruleForm = reactive({

       })


        const formLabelAlign = reactive({
            username:'',
            password:"",
            inputStatus:false,
            passwordStatus:false,
            mode:false,
        })



        const formup = reactive({
            username:'',
            password:"",
            inputStatus:false,
            passwordStatus:false,
            mode:false,
        })

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
        


        function formupPassFocus(e){
            formup.passwordStatus = true
        }
         function formupPassblur(){
            formup.passwordStatus = false
        }
        function formupUserFocus(e){
            formup.inputStatus = true
        }
        function formupUserblur(){
            formup.inputStatus = false
        }
        function formupModeSign(){
            formup.mode = !formup.mode
        }
        function Login(){
            store.dispatch('userinfo/login',{}).then(res =>{
                router.push({path:'/'})
            })
        }
        const validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password'))
            } else {
                if (this.ruleForm.checkPass !== '') {
                this.$refs.ruleForm.validateField('checkPass')
                }
                callback()
            }
        }
        const checkAge = (rule, value, callback) => {
            if (!value) {
                return callback(new Error('Please input the age'))
            }
            setTimeout(() => {
                if (!Number.isInteger(value)) {
                callback(new Error('Please input digits'))
                } else {
                if (value < 18) {
                    callback(new Error('Age must be greater than 18'))
                } else {
                    callback()
                }
                }
            }, 1000)
        }
        return {
            Login,
            formupPassFocus,
            formupPassblur,
            formupUserFocus,
            formupUserblur,
            formupModeSign,
            UserFocus,
            Userblur,
            PassFocus,
            Passblur,
            formLabelAlign,
            formup,
            ModeSign,
            ruleForm,
            validatePass,
            rules: {
                pass: [{ validator: validatePass, trigger: 'blur' }],
                checkPass: [{ validator: validatePass, trigger: 'blur' }],
                age: [{ validator: checkAge, trigger: 'blur' }],
            },

            mode:computed(() => store.state.setting.device.mode)
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
        formupH5Psswordfocus(){
            this.$nextTick(()=>{
                this.$refs.elintpu.focus();
            })
        },
        formupH5Usenamefocus(){
            this.$nextTick(()=>{
                this.$refs.elintpus.focus();
            })
        }

    }
}
</script>

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
    }
}
.container.container_sign-up-mode::before{
    transform: translate(100%, -50%);
}

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
        img{
            width: 100%;
            transition:  0.9s ease-in-out;
            transition-delay: .5s;
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
    
    position: absolute;
    z-index: 5;
    left: 75%;
    top: 50%;
    z-index: 3;
    transform: translate(-50%, -50%);
    display: grid;
    grid-template-columns: 1fr;
    transition: .7s ease-in-out;
    transition-delay: 0.5s;
}
.avatar-login{
    min-width: 250px;
    width: 70%;
    min-height: 300px;
    padding: 50px;
    background-color: #FFF;
    border-radius: 5px;
    display: grid;
    margin-left: 5%;
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
    grid-template-columns: 7% 93%;
    margin: 10px 0;
    padding: 5px 0;
    border-bottom: 2px solid #d9d9d9;
    i{
        position: relative;
        height: 45px;
        line-height: 45px;
        color: #d9d9d9;
        font-size: 21px;
    }
    .el_input--username{
        height: 45px;
        input{
            width: 100%;
            height: 100%;
            border: 0px;
            outline: none;
            font-size: 18px;
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
.setup_in{
    left: 25%;
    opacity: 0;
    z-index: 2;
     transform: translate(-25%, -50%);
}
// .input-focus{
//     border-bottom: 2px solid #2271ff;
// }
.input-group:before, .input-group:after {
    content: '';
    position: absolute;
    bottom: -2px;
    width: 0;
    height: 2px;
    background-color: #2271ff;
    transition: .5s;
    text-align: center;
}
.input-group:before {
    left: 0%;
}
.input-group.input-focus:before, .input-group.input-focus:after {
    width: 100%;
    left: 0%;
}
h5{
    margin:0px;
}
.input-group.input-focus h5{
    transform: translateY(-50%);
}
.input-group.input-focus i{
    // background-color: #2271ff;
    color: #2271ff;
}
.sugin-from--up{
    opacity: 0;
    z-index: 3;
    transform: translate(-75%, -50%);
}
.setup_in-opactiv{
    opacity: 1;
    z-index: 2;
    transform: translate(-50%, -50%);
}

@media only screen and(max-width:3000px){
    .avatar-login{
        width:90%;
        margin-left: 0%;
    }
}
@media only screen and(max-width:1900px){
    .avatar-login{
        width:90%;
        margin-left: 0%;
    }
}
@media only screen and(max-width:1400px){
    .avatar-login{
        width:90%;
        margin-left: 0%;
    }
}
@media only screen and(max-width:990px){
    .avatar-login{
        width:70%;
        margin-left: 5%;
    }
}
@media only screen and(max-width:790px){
    .container::before,.container_sign-up-mode::before{
        transform: translate(50%, -70%);
    }
    .conteiner_content--text{
        z-index: 7;
        left: 50%;
    }
    .container--content .container_content--img[data-v-a3ccadca]{
        justify-content: space-between;
        padding: 3rem 40% 3rem 40%;
    }
    .container--content{
        grid-template-columns: 100%;
    }
    .container.container_sign-up-mode[data-v-a3ccadca]::before {
        transform: translate(50%, 30%);
    }
    .sign--up .title button[data-v-a3ccadca]{
        background-color: #0ea5ff;
    }
    .img--setup---up{
        // transform: translateY(300px);
        transition-delay: 0.5s;
        animation: trasnroemsshow .8s;
    }
    @keyframes trasnroemsshow {
        0%{
            transform: translateY(300px);
        }
        100%{
            transform: translateY(0px);
        }
        
    }
    .img--setup-up{
        transition-delay: 0.5s;
        animation: trasnroems .8s;
    }
    @keyframes trasnroems {
        0%{
            transform: translateY(-300px);
        }
        100%{
            transform: translateY(0px);
        }
        
    }
    .title--button{
        animation: transbutton .8s;
    }
    @keyframes transbutton {
        0%{
            transform: translateY(-300px);
        }
        100%{
            transform: translateY(0px);
        }
        
    }
    .title--button--setup{
        animation: transbuttonsetup .8s;
    }
    @keyframes transbuttonsetup {
        0%{
            transform: translateY(300px);
        }
        100%{
            transform: translateY(0px);
        }
        
    }
    .avatar-login {
        width: 70%;
        margin-left: 0px;
    }
     .setup_in {
        //  left: 25%;
        //  opacity: 0;
        //  z-index: 2;
         transform: translate(100%, -50%);
    }
     .setup_in-opactiv{
        // transform: translate(25%, -50%);
        transform: translate(-50%, -50%);
        // opacity: 1;
        z-index: 7;
     }
     .sugin-from--up{
        opacity: 0;
        z-index: 3;
        transform: translate(-200%, -50%);
     }
     .conteiner_content--text {
        transition: 0.9s ease-in-out;
        transition-delay: 0.5s;
    }
   .container--content .container_content--img[data-v-a3ccadca][data-v-a3ccadca].sign--up{
        flex-direction:column-reverse;
    }

}
@media only screen and(max-width:340px){
    .container--content .container_content--img[data-v-a3ccadca][data-v-a3ccadca] {
        justify-content: space-between;
        padding: 5px;
    }
    .container.container_sign-up-mode[data-v-a3ccadca][data-v-a3ccadca]::before {
        transform: translate(50%, 5%);
    }
}
.forgot-password{
    font-size: 12px;
    text-align: right;
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

</style>