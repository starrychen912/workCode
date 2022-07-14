// import { getLanguage } from "./cookies"
import { setting } from "../config/setting"
import { geti18n } from "./userinfo"
const {lang} = setting
export default  {
    device:{
        mode:'mobile',
    },
    //折叠栏状态
    collapse:true,
    //productdetail弹出层
    detailcollapse:true,
    //弹出框的总宽度
    dialogwidth:'100%',
    //是否为登录用户
    Userlogin:false,
    // 默认 lang 语言
    lang: geti18n() || lang,
}