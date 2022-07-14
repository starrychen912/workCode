import { setting } from '@/config/setting';
import { getItem,setItem,removeItem} from './storage';
const { tokenName } = setting;
import Cookies from 'js-cookie'
//获取缓存token
export function getItemAccessToken(){
    return getItem(tokenName);
}
//设置缓存token
export function setItemAccessToken(data){
    return getItem(tokenName,data);
}
//删除缓存token
export function RemoveItemAccessToken(){
    return getItem(tokenName);
}
//获取
export function getAccessToken(){
    return Cookies.get(tokenName);
}
//设置
export function setAccessToken(data){
    return Cookies.set(tokenName,data);
}
//删除
export function RemoveAccessToken(){
    return Cookies.remove(tokenName);
}

