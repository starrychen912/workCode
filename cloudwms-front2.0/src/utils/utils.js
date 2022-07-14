//传说中工具类
import { ShopList } from '../api/shoplist';
import { setting } from '../config/setting';
const { routeAuth } = setting
import store from '../store';
import { getItem } from './storage';
import { shoElmessage } from './Elmessage';
import router from '../router'
import path from 'path'
import { dataTool } from 'echarts';
import i18n from '../locale';
//路由操作
export async function FilterRouter(list = []) {
    let Filterlist = [];
    FilterFUN(list);

    function FilterFUN(listitme) {
        if (listitme.length != 0) {
            for (let i = 0; i < listitme.length; i++) {
                if (listitme[i].children != undefined) {
                    if (listitme[i].path != 'Settings') {
                        FilterFUN(listitme[i].children);
                    } else {
                        Filterlist.push(listitme[i]);
                    }
                } else {
                    Filterlist.push(listitme[i]);
                }
            }
        }
    }
    let routes = []
    FilterRouters(Filterlist);

    function FilterRouters(item = []) {
        for (let i = 0; i < item.length; i++) {
            if (item[i].meta != undefined && item[i].meta && item[i].meta.Authentication) {
                let data = {
                    component: item[i].component,
                    meta: item[i].meta,
                    name: item[i].name,
                    path: '/index/' + item[i].path,
                    Authentication: true
                }
                if (!routeAuth.includes(data.path)) {
                    routes.push(data)
                }
            }
        }
        store.dispatch('permission/setRouter', routes)
    }
    let Settinglist = [];
    FilterSetting(Filterlist)

    function FilterSetting(listitem = []) {
        for (let i = 0; i < listitem.length; i++) {
            if (listitem[i].meta != undefined && listitem[i].meta && listitem[i].children != undefined) {
                for (let j = 0; j < listitem[i].children.length; j++) {
                    let data = {
                        component: listitem[i].children[j].component,
                        meta: listitem[i].children[j].meta,
                        name: listitem[i].children[j].name,
                        path: '/index/Settings/' + listitem[i].children[j].path
                    }

                    Settinglist.push(data)

                }
            }
        }
        store.dispatch('permission/setSettingRouter', Settinglist)
    }
    let Shoprouterlist = {
        shoplist: [],
        Anazonshoplist: [],
    };
    ShopHomerouterlist(Filterlist);

    function ShopHomerouterlist(listitem = []) {
        listitem.forEach(el => {
            //亚马孙的router
            if (el.meta != undefined && el.meta && el.meta.AmazonAuthentication && el.meta.router == "Amazonindex") {
                let data = {
                    component: el.component,
                    meta: el.meta,
                    name: el.name,
                    path: '/Amazonshop/' + el.path,
                    AmazonAuthentication: el.meta.AmazonAuthentication
                }
                Shoprouterlist.Anazonshoplist.push(data);
            }
            //shopfly的router
            if (el.meta != undefined && el.meta && el.meta.ShopAuthentication && el.meta.router == "shopindex") {
                let data = {
                    component: el.component,
                    meta: el.meta,
                    name: el.name,
                    path: '/shop/' + el.path,
                    ShopAuthentication: el.meta.ShopAuthentication
                }
                Shoprouterlist.shoplist.push(data);
            }
        })
        store.dispatch('permission/setShopRouters', Shoprouterlist)
    }
    // console.log(Shoprouterlist);
    return;
}

/**
 * @param value
 * 测试密码是否满足条件，包括四种类型
 */
export function validatePsdReg(rule, value, callback) {
    if (!value) {
        return callback(new Error('请输入密码'))
    }
    if (!/^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$)([^\u4e00-\u9fa5\s]){6,20}$/.test(value)) {
        callback(new Error('请输入6-20位英文字母、数字或者符号。'))
    } else {
        callback()
    }
}
/**
 * @param value
 * 根据图片链接获取图片名字
 */
export function Getimgname(value) {
    if (isNaLL(value)) {
        let valuelist = value.split('/');
        let imgname = valuelist[valuelist.length - 1].split('.')
        let data = {
            name: imgname[0],
            url: valuelist.splice(3).join('/')
        };
        return data
    } else {
        return '';
    }
}
//验证是否email
export function validateEMail(rule, value, callback) {
    const reg = /^([a-zA-Z0-9]+[-_\.]?)+@[a-zA-Z0-9]+\.[a-z]+$/;
    if (value == '' || value == undefined || value == null) {
        callback(new Error('请输入邮箱'));
    } else {
        if (!reg.test(value)) {
            callback(new Error('请输入正确的邮箱'));
        } else {
            callback();
        }
    }
}
//验证是否手机号码
export function validatePhone(rule, value, callback) {
    const reg = /^[1][3-9][0-9]{9}$/;
    if (value == '' || value == undefined || value == null) {
        callback(new Error('请输入手机号码'));
    } else {
        if ((!reg.test(value)) && value != '') {
            callback(new Error('请输入正确的手机号码'));
        } else {
            callback();
        }
    }
}
//验证是否为数字
export function isNum(rule, value, callback) {
    const age = /^[0-9]*$/
    if (!age.test(value)) {
        callback(new Error('只能输入数字'))
    } else {
        callback()
    }
}

export function interobj(arr1, name, status) {
    let objects = {};

    arr1.forEach((el, key) => {
        objects[el[name]] = true
    })
    return objects;
}
//判断是否一个对象存在false
export function interCheckall(object) {
    let data = true
    for (const key in object) {
        if (data) {
            data = object[key];
        }
    }
    return data;
}
//判断是否一个对象存在true
export function interlll(object) {
    let data = false;
    for (const key in object) {
        if (object[key]) {
            data = true;
            break;
        }
    }
    return data;
}

//遍历对象值变成false
export function interfalse(arr1, name, status) {
    let objects = {};

    arr1.forEach((el, key) => {
        objects[el[name]] = false
    })
    return objects;
}
//获取所有选中的订单
export function Addinstall(object, typename) {
    let list = []
    for (const key in object) {
        if (object[key]) {
            list.push(key);
        }
    }
    if (list.length === 0) {
        return false;
    }
    if (typename == 'string') {
        return list.join(',');
    }
    return list;
}


//两数组去重
export function intersect(array1, arr2) {
    let ary = [];
    let obj = {};
    array1.forEach((element, Key) => {
        obj[element.id] = true
        ary.push(element)
    });
    arr2.forEach((el, key) => {
        if (!obj[el.id]) {
            ary.push(el)
        }
    })
    return ary;
}
//相并
export function Compound(arr1, arr2) {

}
//格式化

export function isNaLL(value) {
    if (value != '' && value != undefined && value != null) {
        return true
    }
    return false;
}

//获取图片数量
export function GetImage(array, name) {
    // console.log(array);
    let Imagenumber = 0;
    array.forEach((el, key) => {
        if (el[name] === '1' && el[name]) {
            Imagenumber++
        }
    })
    return Imagenumber;
}

//获取删除id
export function GetDeleteProductIdList(object) {
    let arr = []
    for (let key in object) {
        if (Object.hasOwnProperty.call(object, key)) {
            if (object[key]) {
                arr.push(key)
            }
        }
    }
    return arr.join(',');
}


//表格一对多
export function GetVarinans(varinanslist = [], sholist) {

    var ret = [];
    sholist.forEach(b => {
        if (varinanslist.length == 0) {
            b.forEach(vara => {
                ret.push([vara])
            })
        } else {
            ret = [];
            varinanslist.forEach(vara => {
                b.forEach(varb => {
                    ret.push(vara.concat(varb))
                })
            })
        }
        varinanslist = ret
    })
    return varinanslist
}

//后面一堆垃圾算法


export function Optionslist(array) {
    let list = [];
    array.forEach((el) => {
        if (el.values.length != 0) {
            list.push(el.values)
        }
    })
    let Varinanslist = GetVarinans([], list);

    let Varinanslists = [];


    for (let i = 0; i < Varinanslist.length; i++) {
        let data = {
            barcode: "",
            bullet_point1: "",
            bullet_point2: "",
            bullet_point3: "",
            bullet_point4: "",
            bullet_point5: "",
            compare_at_price: "0.00",
            cost: "0.00",
            form: "",
            fulfillment_service: "",
            height: "0.00",
            image_id: 0,
            inventory_id: 0,
            inventory_management: "",
            inventory_policy: 0,
            inventory_quantity: 0,
            length: "0.00",
            market_price: "0.00",
            option1: "",
            option2: "",
            option3: "",
            shipping: "0",
            shopify_variant_id: 0,
            sku: "",
            weight: 0,
            weight_unit: "",
            width: "0",
            options: Varinanslist[i],
        };
        Varinanslists.push(data)
    }
    console.log(Varinanslists);
    return Varinanslists;
}
//变体
function cartesianProductOf() {
    Array.prototype.reduce(function(a, b) {}, [])
    return Array.prototype.reduce.call(arguments, function(a, b) {
        var ret = [];
        a.forEach(function(a) {
            b.forEach(function(b) {
                ret.push(a.concat([b]));
            });
        });
        return ret;
    }, [
        []
    ]);
}

function reduedlist(array, index) {
    let arr = [
        [1, 2, 3, 5, 6],
        [4, 5, 6, 0],
        [7, 8, 9],
        [10, 11, 12],
    ];
    let list = [];

    function modesholist(list, sholist) {
        if (list.length > 0) {
            list.forEach((a) => {
                console.log(a);
            })
        }
        let varians = arr.reduce(function(a, b) {
            var ret = []
            a.forEach((a) => {
                b.forEach((b) => {
                    ret.push(a.concat(b))
                })
            })
            return ret;
        }, [
            []
        ])
    }
    modesholist(list, arr)

    // function cartesianProductOf() {
    //     return Array.prototype.reduce.call(arguments,function(a, b) {
    //         var ret = [];
    //         a.forEach(function(a) {
    //             b.forEach(function(b) {
    //                 ret.push(a.concat([b]));
    //             });
    //         });
    //         return ret;
    //     }, [[]]);
    // }
    // //   return 
    // let allArr = cartesianProductOf(...arr )
    // console.log(allArr);
}
//修改过滤数据
export function RevisiOptionslist(array) {
    let list = [];
    array.forEach((el) => {
        if (el.values.length != 0) {
            list.push(el.values)
        }
    })
    let Varinanslist = GetVarinans([], list);

    let Varinanslists = [];
    for (let i = 0; i < Varinanslist.length; i++) {
        let data = {
            price: "0.00",
            sku: i,
            imagesId: "",
            Barcode: "",
            availableQuantity: 0,
            cost: "0.00",
            Quantity: 100,
            inventoryItem: {
                countryCodeOfOrigin: null,
                harmonizedSystemCode: null,
                provinceCodeOfOrigin: null,
                tracked: true,
            },
            options: Varinanslist[i],
        };
        Varinanslists.push(data)
    }
    return Varinanslists;
}

//options中不能重复
export function optionslistname(arr, key, name) {
    let i = 0;
    arr.forEach((el) => {
        if (el[key] === name) {
            i++
        }
    })
    if (i > 1) {
        return true;
    }
}
//不能有false
export function NollFalse(arr, key1, key2, key3) {
    let data = false;
    for (let i = 0; i < arr.length; i++) {
        if (arr[i][key1]) {
            data = true
            break;
        }
        for (let j = 0; j < arr[i][key2].length; j++) {
            if (arr[i][key2][j][key3]) {
                data = true
                break;
            }
        }
    }

    return data;
}

//删除varinas
export function DeleteVariants(array, array2, array3) {
    let data = false;
    for (let i = 0; i < array.length; i++) {
        for (let j = 0; j < array[i].length; j++) {
            if (array3.indexOf(i) == -1) {
                console.log(array[i][j]);
                if (array2[array2.length - 1].value == array3[i]) {

                }
            }
        }
    }
    return data;
}
//
export function DeleteVarAtoptions(array, array2) {
    let data = {}
    let arrlist = {};
    let list = array.reduce(function(a, b, index) {
        var ret = [];
        b.inputlist.forEach((elb, elindex) => {

                arrlist[elb.value] = `${index}-${elindex}`
                    // if(a.length != 0){
                    //     ret.push(elb.value);
                    //     ret.concat(a)
                    // }else{
                    //     ret.push(elb.value)
                    // }
            })
            // arrlist.push(...ret)
        return ret;
    }, [])

    for (let i = 0; i < array2.length; i++) {
        for (let j = 0; j < array2[i].length; j++) {
            if (isNaLL(arrlist[array2[i][j].value])) {
                delete arrlist[array2[i][j].value]
            }
        }
    }
    for (const key in arrlist) {
        if (arrlist.hasOwnProperty.call(arrlist, key)) {
            const element = arrlist[key];
        }
    }
    // return arrlist
}

//数组是否重复
export function isRepeat(arr) {
    let hash = {};
    for (const index in arr) {
        if (hash[arr[index]]) {
            return true;
        } else {
            hash[arr[index]] = true;
        }
    }
    return false;
}
//options是否重复
export function isRepeatoptions(array, name) {
    let hash = {};
    for (const i in array) {
        if (array[i][name] != '') {
            if (hash[array[i][name]]) {
                return true;
            } else {
                hash[array[i][name]] = true;
            }
        }
    }
    return false;
}

//删除options中的values的
/**
 * 加密
 * @param {array} varians中的总数组
 * @param {array} 要删除的数组 delete array
 * @param {array}   options的values 删除
 * @param {string,number}   去除要配对的varians
 * @return {deletestatus,data} deletestatus删除状态，data删除回返回数据
 */
export function DeleteVarians(array, array1, array2, indexlist) {
    // let indexlist = [];
    // indexlist.push(index);
    // console.log(Object.keys(array1).length);
    // console.log(array1[0]);
    // if(Object.keys(array1).length == 1){
    //     return true;
    // }

    let deletelist = [];
    // deletelist.push(index);
    let list = [];
    //去除要过滤的索引
    // array.map((item,mapindex) => {
    //     if(index != mapindex){
    //         list.push(item);
    //     }
    // })
    let deleteindex = {};
    array.reduce(function(a, b, reduceindex) {
        if (indexlist.indexOf(reduceindex) == -1) {
            if (a.length != 0) {
                a.options.forEach((ela, aindex) => {
                    b.options.forEach((elb, bindex) => {
                        if (ela == elb) {
                            if (deleteindex[ela]) {
                                deleteindex[ela].push(b);
                            } else {
                                deleteindex[ela] = [b]
                            }
                        }
                    })
                })
            }
        }
        return array1;
    }, [])

    console.log(array);

    // console.log(deleteindex);
    if (Object.keys(deleteindex).length < Object.keys(array1.options).length) {

        // let data ={
        //     deleteindex:true,
        //     index:"",
        //     item:""
        // }
        let data = {
            deletestatus: true,
            indexlist: []
        }
        for (const key in array1.options) {
            // console.log(key);
            if (Object.hasOwnProperty.call(array1.options, key)) {
                // console.log(array1.options[key]);
                if (Object.keys(deleteindex).indexOf(`${array1.options[key]}`) == -1) {
                    let valuesindex = array2[Number(key)].values.indexOf(array1.options[key]);
                    array2[Number(key)].values.splice(valuesindex, 1);
                    let list = [];
                    for (let i = 0; i < array2.length; i++) {
                        if (array2[i].values.length != 0) {
                            list.push(array2[i]);
                        }
                    }
                    data.indexlist = list
                }
            }
        }
        return data;
    } else {
        let data = {
            deletestatus: false,
            indexlist
        }
        return data;
    }
}
//
//时间戳换成时间
export function getLocalTime(ns, timestamp = null, timetype = null) {
    let obj = { "01": 'Jan', "02": 'Feb', "03": 'Mar', "04": 'Apr', "05": 'May', "06": 'Jun', "07": 'Jul', "08": 'Aug', "09": 'Sept', "10": 'Oct', "11": 'Nov', "12": 'Dec' }
        // console.log(timestamp);
    if (isNaLL(timestamp)) {
        return Date.parse(new Date(timestamp));
    }
    if (!isNaLL(ns)) {
        return;
    }
    let time = ns;
    if (`${time}`.length == 10) {
        time = (time * 1000)
    }
    var date = new Date(time);

    let Year = date.getFullYear(); //年
    let Month = (date.getMonth() + 1); //月
    let day = date.getDate(); //日

    let Hours = date.getHours(); //小时
    // let 
    let Minutes = date.getMinutes(); //分
    let Seconds = date.getSeconds(); //秒钟

    if (`${Month}`.length == 1) {
        Month = `0${Month}`
    }

    if (`${day}`.length == 1) {
        day = `0${day}`
    }

    if (timetype == '时') {
        if (i18n.global.locale == 'zh-cn') {
            return `${Year}-${Month}-${day} ${Hours}:${Minutes}:${Seconds}`
        } else {
            return `${obj[Month]} ${day},${Year}`
        }
    } else {
        if (i18n.global.locale == 'zh-cn') {
            return `${Year}-${Month}-${day}`
        } else {
            return `${obj[Month]} ${day},${Year}`
        }
    }
}

export function ProductType(arr, id) {
    if (!isNaLL(id)) {
        return;
    }
    let list = [];

    function ProductFilter(array, id) {
        for (let i = 0; i < array.length; i++) {
            if (array[i].id == id) {
                list.unshift(array[i].id)
                return true;
            }
            if (isNaLL(array[i].children) && array[i].children.length != 0) {
                let lststatus = ProductFilter(array[i].children, id)
                if (lststatus) {
                    list.unshift(array[i].id)
                    return lststatus;
                }

            }
        }

    }
    ProductFilter(arr, id);
    // console.log(list);
    return list;
}
//是否自有店铺还是自己开店铺
export function GetShopType(id) {
    return ShopList({}).then(res => {
        if (res.code == 1) {
            res.data.forEach(el => {
                if (el.id == id) {
                    return el;
                }
            })
        }
    })
}


//删除options中的values的
/**
 * 加密
 * @param {array} varians中的总数组
 * @param {array} 要删除的数组 delete array
 * @param {array}   options的values 删除
 * @param {string,number}   去除要配对的varians
 * @return {deletestatus,data} deletestatus删除状态，data删除回返回数据
 */
export function RevisionproductDeleteVarians(array, array1, array2, indexlist) {
    let deletelist = [];
    let list = [];
    let deleteindex = {};
    array.reduce(function(a, b, reduceindex) {
        if (indexlist.indexOf(reduceindex) == -1) {
            console.log(reduceindex);
            if (a.length != 0) {
                a.options.forEach((ela, aindex) => {
                    b.options.forEach((elb, bindex) => {
                        if (ela == elb) {
                            if (deleteindex[ela]) {
                                deleteindex[ela].push(b);
                            } else {
                                deleteindex[ela] = [b]
                            }
                        }
                    })
                })
            }
        }
        return array1;
    }, [])
    if (Object.keys(deleteindex).length < Object.keys(array1.options).length) {
        let data = {
            deletestatus: true,
            indexlist: []
        }
        for (const key in array1.options) {
            // console.log(key);
            if (Object.hasOwnProperty.call(array1.options, key)) {
                // console.log(array1.options[key]);
                if (Object.keys(deleteindex).indexOf(`${array1.options[key]}`) == -1) {
                    let valuesindex = array2[Number(key)].values.indexOf(array1.options[key]);
                    array2[Number(key)].values.splice(valuesindex, 1);
                    let list = [];
                    for (let i = 0; i < array2.length; i++) {
                        if (array2[i].values.length != 0) {
                            list.push(array2[i]);
                        }
                    }
                    data.indexlist = list
                }
            }
        }
        return data;
    } else {
        let data = {
            deletestatus: false,
            indexlist
        }
        return data;
    }
}
//赋值quantity
export function Getquantity(array, item) {
    if (!isNaLL(item) || array.length == 0) {
        return array;
    }
    array.map((el) => {
        return el.Quantity = isNaLL(el.Quantity) ? el.Quantity : item;
    })
    return array;
}

//显示入库商品标题
export function SelectProductTitle(array) {
    array.forEach(arrayel => {
        if (arrayel.variants.length != 0) {
            arrayel.variants.forEach(varel => {
                let title = (isNaLL(arrayel.title) ? arrayel.title : "")
                let str = ''
                str += isNaLL(varel.option1) ? `${varel.option1}` : ""
                str += isNaLL(varel.option2) ? `/${varel.option2}` : ""
                str += isNaLL(varel.option3) ? `/${varel.option3}` : ""
                return varel.title = title + '-' + str
            })
        }
    })
    return array;
}
//防抖函数
export function debounce(fun, wait) {
    let timer = null;
    let i = 0
    return function(e) {
        if (i > 0) {
            shoElmessage(true, '点击太快,服务器支撑不住你这样点的！！！！！', 'error')
        }
        i++;
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(() => {
            fun();
            i = 0;
        }, wait)
    }
}
//节流
export function throttle(fun, wait) {
    var timer = null;
    return function() {
        var content = this;

        var arg = arguments;
        if (!timer) {
            timer = setTimeout(function() {
                fun.apply(content, arg)
                timer = null;
            }, wait)
        } else {
            clearInterval(timer)
            timer = setTimeout(function() {
                fun.apply(content, arg)
                timer = null;
            }, wait)
        }
    }
}

//返回上一页
export function goback(item = -1) {
    return router.go(item)
}
//动态添加路由
export function addRoutes(route) {
    route.forEach((route) => {
        router.addRoute(route);
    })
}
//过滤路由
export function Filterdata(list = []) {
    let res = [];
    list.forEach(el => {
        if (isNaLL(el.meta) && !el.meta.showmenu) {
            res.push(el);
        }
    })
    return res;
}

//过滤
export function flyroutelist(list = []) {
    let filtroutelist = [];
    let routelist = router.getRoutes();
    for (let i = 0; i < routelist.length; i++) {
        if (routelist[i].meta && routelist[i].meta.ShopAuthentication) {
            filtroutelist.push(routelist[i])
        }
    }
    return filtroutelist;
}

export function FilterProductType(list = [], key, indexs) {
    let array = JSON.parse(JSON.stringify(list)); //防止修改原有的
    array.forEach((item, index) => {
        item.indexs = index + 1;
        if (indexs) {
            item.indexs = `${indexs}-${index+1}`
        }
        if (item.children && item.children.length == 0) {
            delete item[key]
        }
        if (item.children && item.children.length > 0) {
            item.children = FilterProductType(item.children, key, item.indexs)
        }
    })
    return array;
}