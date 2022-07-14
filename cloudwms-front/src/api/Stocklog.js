import $axios from '@/request/request'
//库存日志
export function inventoryLogList(data){
    return $axios({
        url:'/api/inventory/inventoryLogList',
        method:'POST',
        data:data
    })
}
//入库跟出库
export function operateInventoryLog(data){
    return $axios({
        url:'/api/inventory/operateInventoryLog',
        method:'POST',
        data:data
    })
}