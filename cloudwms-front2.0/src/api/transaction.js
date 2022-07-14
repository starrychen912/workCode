import $axios from '@/request/request'

//事务列表
export function GettransactionList(data) {
    return $axios({
        url: '/api/transaction/transactionList',
        method: "post",
        data
    })
}

//事务详情
export function GettransactionDetail(data) {
    return $axios({
        url: '/api/transaction/transactionDetail',
        method: "post",
        data
    })
}

//添加事务
export function Addtransaction(data) {
    return $axios({
        url: '/api/transaction/transactionAdd',
        method: "post",
        data
    })
}
//修改事务
export function Updatetransaction(data) {
    return $axios({
        url: '/api/transaction/transactionUpdate',
        method: "post",
        data
    })
}
//删除事务
export function DeleteTransaction(data) {
    return $axios({
        url: '/api/transaction/deleteTransactionList',
        method: "post",
        data
    })
}
//关联事务
export function Correlation_Transaction(data) {
    return $axios({
        url: '/api/product_development/withTransaction',
        method: "post",
        data
    })
}
// 关联采购
export function Correlation_Purchase(data) {
    return $axios({
        url: '/api/product_development/withPurchase',
        method: "post",
        data
    })
}