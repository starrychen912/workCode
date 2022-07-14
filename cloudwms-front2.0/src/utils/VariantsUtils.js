import { isNaLL } from './utils'

//变体多对多的
export function GetVarinans(varinanslist = [], sholist) {
    console.log(sholist);
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

//修改product
/*
 *
 *
 *
 */
export function RevisionOptionslists(array) {
    console.log(array);
    let list = [];
    array.forEach((el) => {
        if (el.values.length != 0) {
            list.push(el.values)
        }
    })
    console.log(list);
    let Varinanslist = GetVarinans([], list);

    let Varinanslists = [];
    for (let i = 0; i < Varinanslist.length; i++) {
        let data = {
            price: "0.00",
            sku: "",
            imagesId: "",
            Barcode: "",
            availableQuantity: 0,
            cost: "",
            Quantity: 0,
            option1: Varinanslist[i][0] || "",
            option2: Varinanslist[i][1] || "",
            option3: Varinanslist[i][2] || "",
            inventoryItem: {
                countryCodeOfOrigin: null,
                harmonizedSystemCode: null,
                provinceCodeOfOrigin: null,
                tracked: true,
            },
            // options:Varinanslist[i],
        };
        Varinanslists.push(data)
    }
    return Varinanslists;
}

/*
    删除Variants

    array1删除variants array2是删除options array3备删除选项
*/
export function DeleteVariantsAlgorithm(item, array1, array2, array3, itemindex) {

    let tableData = array1;
    let options = array2;
    let deletelist = array3;



    // console.log(itemindex);
    let list = array3; //待删除
    if (!isNaLL(item.option1)) {
        console.log('直接走删除,option1等于空');
        if (options[0].values.length == 1) {
            options.splice(0, 1)
        } else {
            tableData.splice(itemindex, 1);
        }
        //直接走了删除

        let obj = {
            tableData: tableData,
            options: options,
            deletelist: list
        }
        return obj;
    }
    if (isNaLL(item.option1) && !isNaLL(item.option2)) {
        console.log('直接走删除', options[0].values);
        //直接走删除
        if (options[0].values.length == 1) {

            options.splice(0, 1)
        } else {
            options.forEach(el => {
                if (el.values.indexOf(item.option1) != -1) {
                    el.values.splice(el.values.indexOf(item.option1), 1);
                }
            })
        }


        //删除variants
        tableData.splice(itemindex, 1);



        let obj = {
            tableData: tableData,
            options: options,
            deletelist: list
        }
        return obj;
    }
    if (isNaLL(item.option2) && !isNaLL(item.option3)) {
        console.log('需要走过滤,option2');
        list.push(item)
        let status = false;

        for (let i = 0; i < array1.length; i++) {
            if (!list.indexofBoolast(array1[i])) {
                if (array1[i].option2 == item.option2) {
                    status = false
                    break;
                } else {
                    status = true
                }
            } else {
                if (list.length == array1.length) {
                    console.log("我进来了");
                    if (isNaLL(options[1])) {
                        options[1].values.splice(options[1].values.indexOf(list[list.length - 1].option3), 1);
                    }

                    options.splice(1, 1);
                    console.log(list);
                    list.forEach((el, index) => {
                        tableData[index].option2 = ""
                    })

                    // console.log(tableData);
                    list = [];
                }

            }
        }
        if (status) {
            // console.log("删除");
            if (array2.values.length != 1) {
                if (isNaLL(options[1])) {
                    options[1].values.splice(options[1].values.indexOf(list[list.length - 1].option3), 1);
                }
                // options[1].values.splice(options[1].values.indexOf(list[list.length -1].option2),1);
                let deletelist = [];
                list.forEach((el, index) => {
                    if (el.option2 == list[list.length - 1].option2) {
                        tableData.splice(array1.indexOf(el), 1);
                        deletelist.push(el.id);
                    }
                })
                let delist = [];
                list.forEach(el => {
                    if (deletelist.indexOf(el.id) == -1) {
                        delist.push(el);
                    }
                })
                list = delist
            } else {
                // console.log("删除")


            }
        }
        // console.log(tableData);





        let obj = {
            tableData: tableData,
            options: options,
            deletelist: list
        }
        return obj;
    }
    if (isNaLL(item.option3)) {
        console.log('需要走过滤,option3');
        list.push(item)
        let status = false;

        for (let i = 0; i < array1.length; i++) {
            if (!list.indexofBoolast(array1[i])) {
                if (array1[i].option3 == item.option3) {
                    status = false
                    break;
                } else {
                    status = true
                }
            } else {
                if (list.length == array1.length) {
                    if (isNaLL(options[2])) {
                        options[2].values.splice(options[2].values.indexOf(list[list.length - 1].option3), 1);
                    }
                    options.splice(2, 1);
                    console.log(list);
                    list.forEach((el, index) => {
                        tableData[index].option3 = ""
                    })

                    // console.log(tableData);
                    list = [];
                }

            }
        }
        if (status) {
            // console.log("删除");
            if (array2.values.length != 1) {
                if (isNaLL(options[2])) {
                    options[2].values.splice(options[2].values.indexOf(list[list.length - 1].option3), 1);
                }
                // options[2].values.splice(options[2].values.indexOf(list[list.length -1].option3),1);
                let deletelist = [];
                list.forEach((el, index) => {
                    if (el.option3 == list[list.length - 1].option3) {
                        tableData.splice(array1.indexOf(el), 1);
                        deletelist.push(el.id);
                    }
                })
                let delist = [];
                list.forEach(el => {
                    if (deletelist.indexOf(el.id) == -1) {
                        delist.push(el);
                    }
                })
                list = delist
            } else {
                // console.log("删除")


            }
        }
        // console.log(tableData);






        let obj = {
            tableData: tableData,
            options: options,
            deletelist: list
        }
        return obj;
        //需要走过滤
    }
}
//删除options
export function DeleteOptions(array, item, optionname) {
    let options = [];
    array.forEach((el, index) => {
        if (el.values.indexOf(item[optionname]) != -1) {
            el.values.splice(el.values.indexOf(item[optionname]), 1);
        }
        if (el.values.length != 0) {
            options.push(el)
        }
    })

    return options;
}

//
export function RevisionOptionslist(option, tableData) {
    return new Promise(function(resole, reject) {


        let list = [];
        option.forEach((el) => {
            if (el.values.length != 0) {
                list.push(el.values)
            }
        })
        let tablist = {};
        let Varinanslist = GetVarinans([], list);
        Varinanslist.forEach((el, index) => {
            tableData.forEach(table => {
                if (el.length == 3) {
                    if (el[0] == table.option1 && el[1] == table.option2 && el[2] == table.option3) {
                        console.log("option3");
                        if (tablist[el[0] + el[1] + el[2]] == undefined) {
                            tablist[el[0] + el[1] + el[2]] = table
                        }
                    }
                }
                if (el.length == 2) {
                    if (el[0] == table.option1 && el[1] == table.option2 && !isNaLL(el[2])) {
                        console.log("option2");
                        if (tablist[el[0] + el[1]] == undefined) {
                            table.option3 = ""
                            tablist[el[0] + el[1]] = table
                        }
                    }
                }
                if (el.length == 1) {
                    if (el[0] == table.option1 && !isNaLL(el[1]) && !isNaLL(el[2])) {
                        console.log("option1");
                        if (tablist[el[0]] == undefined) {
                            table.option2 = ""
                            table.option3 = ""
                            tablist[el[0]] = table
                        }
                    }
                }
            })
        })

        let unionlist = [];
        if (Varinanslist.length != Object.keys(tablist).length) {
            Varinanslist.forEach(el => {
                let data = {
                    barcode: "",
                    bullet_point1: "",
                    bullet_point2: "",
                    bullet_point3: "",
                    bullet_point4: "",
                    bullet_point5: "",
                    compare_at_price: "0.00",
                    cost: "0.00",
                    // create_time: 1640599334,
                    // create_time_text: "2021-12-27 18:02:14",
                    // delete_time: 0,
                    // delete_time_text: "1970-01-01 08:00:00",
                    form: "",
                    fulfillment_service: "",
                    height: "0.00",
                    // id: 230,
                    image_id: 0,
                    inventory_id: 0,
                    inventory_management: "",
                    inventory_policy: 1,
                    inventory_quantity: 0,
                    length: "0.00",
                    market_price: "0.00",
                    option1: "",
                    option2: "",
                    option3: "",
                    // option_id: 0,
                    // product_id: 160,
                    shipping: "0",
                    shopify_variant_id: 0,
                    sku: "",
                    // update_time: 0,
                    // update_time_text: "",
                    weight: 0,
                    weight_unit: "",
                    width: "0",
                };


                if (el.length == 3) {
                    if (isNaLL(tablist[el[0] + el[1] + el[2]])) {
                        unionlist.push(tablist[el[0] + el[1] + el[2]])
                    } else {
                        data.option1 = el[0]
                        data.option2 = el[1]
                        data.option3 = el[2]
                        unionlist.push(data)
                    }
                }
                if (el.length == 2) {
                    if (isNaLL(tablist[el[0] + el[1]])) {
                        unionlist.push(tablist[el[0] + el[1]])
                    } else {
                        data.option1 = el[0]
                        data.option2 = el[1]
                            // data.option3 = el[2],
                        unionlist.push(data)
                    }
                }
                if (el.length == 1) {
                    if (isNaLL(tablist[el[0]])) {
                        unionlist.push(tablist[el[0]])
                    } else {
                        data.option1 = el[0]
                            // data.option2 = el[1],
                            // data.option3 = el[2],
                        unionlist.push(data)
                    }
                }
            })

        } else {
            for (const key in tablist) {
                if (Object.hasOwnProperty.call(tablist, key)) {
                    const element = tablist[key];
                    unionlist.push(element)
                }
            }
        }

        // console.log(Varinanslist,unionlist);
        resole(unionlist);
        //  return  await unionlist;
    })
}

//选择删除
/*
options删除options
tableData删除table
根据index删除
*/
export function Assembling(tableDatas) {
    console.log(tableDatas);
    let obj = {
        "option1": [],
        "option2": [],
        "option3": [],
    }
    console.log(obj["option1"]);
    tableDatas.forEach((el) => {
        if (isNaLL(el.option1) && obj["option1"].indexOf(el.option1) == -1) {
            obj["option1"].push(el.option1)
        }
        if (isNaLL(el.option2) && obj["option2"].indexOf(el.option2) == -1) {
            obj["option2"].push(el.option2)
        }
        if (isNaLL(el.option3) && obj["option3"].indexOf(el.option3) == -1) {
            obj["option3"].push(el.option3)
        }
    })
    return obj;
}