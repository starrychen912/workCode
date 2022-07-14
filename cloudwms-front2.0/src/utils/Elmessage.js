import { ElMessage, ElNotification, ElMessageBox } from 'element-plus';
//弹出提示框
export function shoElmessage(showClose, message, type, ) {
    ElMessage({
        showClose: showClose || true,
        message: message || '恭喜你，你成功操作了',
        type: type || 'success',
    })
}
//删除提示框
export function shoElMessageBox(message = '确认要删除或修改这个文件吗？', title = '提示', obj = {}) {
    return new Promise((resolve, reject) => {
        ElMessageBox.confirm(
            message,
            title, {
                confirmButtonText: obj.confirmButtonText || '确定',
                cancelButtonText: obj.cancelButtonText || '取消',
                type: obj.type || 'warning',
                draggable: obj.draggable || true,
                ...obj,
            }
        ).then((res) => {
            resolve(res)
        }).catch((error) => {
            reject(error)
        })
    })
}