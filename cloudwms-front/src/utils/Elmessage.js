import { ElMessage, ElNotification } from 'element-plus';

export function shoElmessage(showClose,message,type,){
    ElMessage({
        showClose,
        message: message || '恭喜你，你成功操作了',
        type:type || 'success',  
    })
}