import { getItem,setItem,removeItem} from "./storage";
import { setting } from "../config/setting";
const { langKey,tokenName } = setting;

export function getUserinfo(){
    return getItem('userinfo');
}
export function setUserinfo(data){
    return setItem('userinfo',data);
}
export function removeUserinfo(){
    return removeItem('userinfo');
}
export function geti18n() {
    return getItem(langKey)
}
export function seti18n(lang) {
    return setItem(langKey,lang)
}
//设置鉴权
export function setAuthentication(auth){
    return setItem('Authentication',auth)
}
//获取鉴权
export function getAuthentication( ){
    return getItem('Authentication')
}
export function RemoveAuthentication( ){
    return removeItem('Authentication')
}

//设置token
export function setAccessToken(token){
    return setItem(tokenName,token)
}
//获取token
export function getAccessToken( ){
    return getItem(tokenName)
}
//删除token
export function RemoveAccessToken( ){
    return removeItem(tokenName)
}
