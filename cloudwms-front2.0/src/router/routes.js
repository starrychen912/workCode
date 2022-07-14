/**
 * @param { path } : router链接
 * @param { name } :router名字
 * @param { hidden } :隐藏侧边栏
 * @param { redirect } :重定向router
 * @param { component } :组件文件
 * @param { children } :子router
 * @param {
 *              title:'标题'                                           @param String
 *              icon:"图标"                                            @param String
 *              router："router权限"                                    @param String
 *              affix："顶部缓存必须存在不能删除"                         @param Boolean
 *              roles：权限数组                                          @param Array
 *              hidden："不显示侧边栏"，                                 @param Boolean
 *              activeurl:"不显示侧边栏，但是又要显示侧边选中，就设置链接"  @param router
 *              showmenu:"不显示顶部缓存导航栏"  @param router        
 *          }
 * 
 */

import i18n from '../locale';
const locale = i18n.global.locale
const message = i18n.global.messages
const global = message[locale];
export const constantRoutes = [{
        path: "/",
        name: "index",
        meta: false,
        redirect: '/index'
    }, {
        path: "/other",
        name: 'other',
        meta: false,
        component: () =>
            import ('@/view/other/index.vue'),
        children: [{
                path: "howitwork",
                name: "howitwork",
                component: () =>
                    import ('@/view/other/howitwork.vue'),
            },
            {
                path: "support",
                name: "support",
                component: () =>
                    import ('@/view/other/support.vue'),
            },
            {
                path: "abouts_us",
                name: "abouts_us",
                component: () =>
                    import ('@/view/other/abouts_us.vue'),
            },
            {
                path: "security",
                name: "security",
                component: () =>
                    import ('@/view/other/security.vue'),
            },
            {
                path: "faq",
                name: "faq",
                component: () =>
                    import ('@/view/other/faq.vue'),
            },
            {
                path: "articles",
                name: "articles",
                component: () =>
                    import ('@/view/other/articles.vue'),
            },
            {
                path: "explain",
                name: "explain",
                component: () =>
                    import ('@/view/other/explain.vue'),
            }, {
                path: "storeshop",
                name: "storeshop",
                component: () =>
                    import ('@/view/other/storeshop.vue'),
            }
        ]
    }, {
        path: "/shop",
        name: "shop",
        meta: false,
        // meta:{title:global.route['ImportStoreShop'],icon:'el-icon-download'},
        component: () =>
            import ('@/view/Shopfly/index.vue'),
        children: [{
                path: "shophome",
                name: "shophome",
                meta: { title: global.route['home'], icon: 'el-icon-s-home', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/Shopfly/Home/Home.vue'),

            }, {
                path: 'ImportStoreShop',
                name: "ImportStoreShop",
                meta: { title: global.route['ImportStoreShop'], icon: 'el-icon-download', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/shopfly/Orderlist/Orderlist.vue'),
            },
            {
                path: 'Products',
                name: "Products",
                meta: { title: global.route['Products'], icon: 'el-icon-s-claim', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/shopfly/Products/index.vue'),
            }, {
                path: 'Orders',
                name: "Orders",
                meta: { title: global.route['Orderlist'], icon: 'el-icon-s-order', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/Shopfly/Order/Orders.vue'),
            }, {
                path: 'FindProducts',
                name: "FindProducts",
                meta: { title: global.route['FindProducts'], icon: 'el-icon-search', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/Shopfly/FindProducts/FindProducts.vue')
            }, {
                path: 'Stocklog',
                name: "Stocklog",
                meta: { title: global.route['Stocklog'], icon: 'el-icon-tickets', router: 'shopindex', ShopAuthentication: true },
                component: () =>
                    import ('@/view/Shopfly/Stocklog/Stocklog.vue')
            },
            {
                path: "/shop/Products/Addproduct",
                name: "Addproduct",
                component: () =>
                    import ('@/view/Shopfly/Products/components/Addproduct.vue'),
            }, {
                path: "/shop/Revisionproduct",
                name: "Revisionproduct",
                component: () =>
                    import ('@/view/Shopfly/Products/Revisionproduct.vue'),
            }, {
                path: "/shop/Revisionproduct/RevisionVariants",
                name: "RevisionVariants",
                component: () =>
                    import ('@/view/Shopfly/Products/components/RevisionVariants.vue'),
            }
        ]
    }
    //不需要权限
    , {
        path: "/Officialwebsite/Accounts",
        name: "Accounts",
        meta: false,
        component: () =>
            import ('@/view/Officialwebsite/Accounts.vue'),
    }, {
        path: "/Officialwebsite/Accounts/dropshippingdetail",
        name: "dropshippingdetail",
        meta: { showmenu: true },
        component: () =>
            import ('@/view/Officialwebsite/dropshippingdetail.vue'),
    }, {
        path: "/loginout",
        name: 'loginout',
        meta: { showmenu: true },
        component: () =>
            import ('@/view/login/loginout.vue')
    }, {
        path: "/Revision",
        name: 'Revision',
        meta: false,
        component: () =>
            import ('@/view/login/Revision.vue')
    }, {
        path: "/logins",
        name: 'logins',
        meta: { roles: ['admin', 'editor'], showmenu: true },
        component: () =>
            import ('@/view/login/login.vue')
    }, {
        path: "/401",
        name: '401',
        meta: false,
        component: () =>
            import ('@/view/errorPage/401.vue')
    }, {
        path: "/404",
        name: '404',
        meta: false,
        component: () =>
            import ('@/view/errorPage/404.vue')
    }, {
        path: "/Officialwebsite",
        name: "Officialwebsite",
        meta: false,
        component: () =>
            import ('@/view/Officialwebsite/Officialwebsite.vue'),
        children: [{
                path: "Officialwebsite",
                name: "Officialwebsite",
                component: () =>
                    import ('@/view/Officialwebsite/Officialwebsite.vue'),
            },

        ]

    }
];
export const asyncRoutes = [{
        path: '/index',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/index/home",
        meta: { roles: ['admin', 'editor'] },
        children: [{
            path: 'home',
            name: "home",
            meta: { title: global.route['home'], icon: 'el-icon-s-home', affix: true, roles: ['admin', 'editor'] },
            component: () =>
                import ('@/view/Home/Home.vue'),
        }]
    }, {
        path: '/OrderAll',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/OrderAll/index",
        meta: { roles: ['admin', 'editor'] },
        children: [{
            path: 'index',
            name: "OrderAll",
            meta: { title: global.route['OrderAll'], icon: 'el-icon-s-order' },
            component: () =>
                import ('@/view/Home/OrderAll.vue')
        }]
    }, {
        path: '/Storeshop',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/Storeshop/index",
        meta: { roles: ['admin', 'editor'] },
        children: [{
            path: 'index',
            name: "Storeshop",
            meta: { title: global.route['StoreShop'], icon: 'el-icon-s-shop', affix: true },
            component: () =>
                import ('@/view/Storeshop/Storeshop.vue')
        }]

    }, {},
    // {
    //     path: '/index/Addstoreshop',
    //     name: "Addstoreshop",
    //     meta: false,
    //     component: () =>
    //         import ('/src/view/Home/index.vue'),
    //     redirect: "/index/Addstoreshop/index",
    //     // children: [{
    //     //     path: "index",
    //     //     name: "Addstoreshop",
    //     //     meta: { title: '新增店铺', icon: 'el-icon-s-home' },
    //     //     component: () =>
    //     //         import ('@/view/Storeshop/Addstoreshop.vue'),
    //     // }]
    // },
    {
        path: '/Notifications',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/Notifications/index",
        meta: {
            roles: ['admin']
        },
        children: [{
            path: 'index',
            name: "Notifications",
            meta: { title: global.route['Notifications'], icon: 'el-icon-message-solid', roles: ['admin'] },
            component: () =>
                import ('@/view/Notifications/Notifications.vue')
        }]
    }, {
        path: '/ProductManagement',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/ProductManagement/index",
        meta: {
            title: global.route['ProductManagement'],
            icon: 'el-icon-s-goods',
            roles: ['admin', 'editor']
        },
        children: [{
                path: 'productList',
                name: "productList",
                meta: { title: global.route['productList'], icon: 'el-icon-menu', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/ProductManagement/productList.vue')
            },
            {
                path: 'inventManagement',
                name: "inventManagement",
                meta: { title: global.route['inventManagement'], icon: 'el-icon-s-goods', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/ProductManagement/inventManagement.vue')
            },
            {
                path: 'ProductType',
                name: 'ProductType',
                meta: { title: global.route['ProductType'], icon: 'el-icon-menu', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/ProductType/index.vue')
            }, {
                path: 'productIntegration',
                name: 'productIntegration',
                meta: { title: global.route['productIntegration'], icon: 'el-icon-cpu', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/productIntegration/index.vue'),
            }, {
                path: 'ProductIntegeadtionDetail',
                name: 'ProductIntegeadtionDetail',
                hidden: true,
                meta: { title: global.route['ProductIntegeadtionDetail'], icon: 'el-icon-notebook-2', hidden: true, roles: ['admin', 'editor'], activeurl: '/ProductManagement/productIntegration/' },
                component: () =>
                    import ('@/view/ProductOperation/productIntegration/ProductIntegeadtionDetail.vue')
            },
            // {
            //     path: 'productInformation',
            //     name: 'productInformation',
            //     meta: { title: global.route['productInformation'], icon: 'el-icon-notebook-2', roles: ['admin', 'editor'] },
            //     component: () =>
            //         import ('@/view/ProductOperation/productInformation/index.vue')
            // },
            {
                path: 'ecomInfoManag',
                name: 'ecomInfoManag',
                meta: { title: global.route['ecomInfoManag'], icon: 'el-icon-eleme', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/ProductManagement/ecomInfoManag.vue'),
            }, {
                path: 'ecominfoMangDetail',
                name: 'ecominfoMangDetail',
                hidden: true,
                meta: { title: global.route['ecominfoMangDetail'], icon: 'el-icon-eleme', roles: ['admin', 'editor'], hidden: true, activeurl: '/ProductManagement/ecomInfoManag/' },
                component: () =>
                    import ('@/view/ProductOperation/ProductManagement/components/ecominfoMangDetail.vue'),
            }, {
                path: 'grouping',
                name: 'grouping',
                meta: { title: global.route['Grouping'], icon: 'el-icon-connection', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/ProductOperation/Grouping/grouping.vue'),
            }
        ]
    },
    // {
    //     path: '/wareManagement',
    //     component: () =>
    //         import ('/src/view/Home/index.vue'),
    //     redirect: "/wareManagement/index",
    //     meta: {
    //         title: global.route['wareManagement'],
    //         icon: 'el-icon-sell',
    //         roles: ['admin', 'editor']
    //     },

    //     children: [{
    //             path: 'shippingManagement',
    //             name: "shippingManagement",
    //             meta: { title: global.route['shippingManagement'], icon: 'el-icon-sold-out', roles: ['admin', 'editor'] },
    //             component: () =>
    //                 import ('@/view/wareManagement/shippingManagement.vue')
    //         }, {
    //             path: 'receiveManagement',
    //             name: "receiveManagement",
    //             meta: { title: global.route['receiveManagement'], icon: 'el-icon-sell', roles: ['admin', 'editor'] },
    //             component: () =>
    //                 import ('@/view/wareManagement/receiveManagement.vue')
    //         }, {
    //             path: 'returnsManagement',
    //             name: "returnsManagement",
    //             meta: { title: global.route['returnsManagement'], icon: 'el-icon-s-release', roles: ['admin', 'editor'] },
    //             component: () =>
    //                 import ('@/view/wareManagement/returnsManagement.vue')
    //         }, {
    //             path: 'shipping',
    //             name: "shipping",
    //             hidden: true,
    //             meta: { title: global.route['shipping'], icon: 'el-icon-sold-out', roles: ['admin', 'editor'] },
    //             component: () =>
    //                 import ('@/view/wareManagement/shipping.vue')
    //         },

    //     ]
    // },

    {
        path: '/purchasingManagement',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/index",
        meta: {
            roles: ['admin', 'editor']
        },
        children: [{
                path: 'index',
                name: "purchasingManagement",
                meta: { title: global.route['purchasingManagement'], icon: 'el-icon-s-claim', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/purchasingManagement/index.vue')
            },

        ]
    },
    {
        path: '/Logisticsmanagement',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/Logisticsmanagement/index",
        meta: {
            title: global.route['Logisticsmanagement'],
            icon: 'el-icon-truck',
            roles: ['admin', 'editor']
        },
        children: [{
                path: 'FBA',
                name: "FBA",
                meta: { title: global.route['FBA'], icon: 'el-icon-truck', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/Logistics/Logisticsmanagement/Logisticsmanagement.vue')
            }, {
                path: 'Straight',
                name: "Straight",
                hidden: true,
                meta: { title: global.route['Straight'], icon: 'el-icon-truck', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/Logistics/Logisticsmanagement/Straight.vue')
            }, {
                path: 'AddFBA',
                name: "AddFBA",
                hidden: true,
                meta: { title: global.route['AddFBA'], icon: 'el-icon-truck', roles: ['admin', 'editor'], hidden: true, activeurl: '/Logisticsmanagement/FBA' },
                component: () =>
                    import ('@/view/Logistics/components/AddFba.vue')
            },
            {
                path: 'perFBA',
                name: "perFBA",
                hidden: true,
                meta: { title: global.route['perFBA'], icon: 'el-icon-truck', roles: ['admin', 'editor'], hidden: true, activeurl: '/Logisticsmanagement/FBA' },
                component: () =>
                    import ('@/view/Logistics/components/perfectFba.vue')
            },
            {
                path: 'importFba',
                name: "importFba",
                hidden: true,
                meta: { title: global.route['importFba'], icon: 'el-icon-truck', roles: ['admin', 'editor'], hidden: true, activeurl: '/Logisticsmanagement/FBA' },
                component: () =>
                    import ('@/view/Logistics/components/importFba.vue')
            }, {
                path: 'FbaDetail',
                name: "FbaDetail",
                hidden: true,
                meta: { title: global.route['FbaDetail'], icon: 'el-icon-truck', roles: ['admin', 'editor'], hidden: true, activeurl: '/Logisticsmanagement/FBA' },
                component: () =>
                    import ('@/view/Logistics/components/FbaDetail.vue')
            }
        ]
    }, {
        path: '/affair',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/affair/index",
        meta: {
            roles: ['admin', 'editor'],
            title: global.route['affair'],
        },
        children: [{
                path: 'index',
                name: "affair",
                meta: { title: global.route['affairlist'], icon: 'el-icon-notebook-1', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/affair/index.vue')
            },
            // {
            //     path: 'Addaffair',
            //     name: 'Addaffair',
            //     hidden: true,
            //     meta: { title: global.route['Addaffair'], icon: 'el-icon-notebook-1', roles: ['admin', 'editor'] },
            //     component: () =>
            //         import ('@/view/affair/Addaffair.vue')
            // }
        ]
    }, {
        path: '/purchasingManagement/materialPurchasing',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/materialPurchasing/index",
        meta: false,
        children: [{
            path: 'index',
            name: "materialPurchasing",
            meta: { title: global.route['materialPurchasing'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/materialPurchasing.vue')
        }]
    },
    {
        path: '/purchasingManagement/purchaseOrder',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/purchaseOrder/index",
        meta: false,
        children: [{
            path: 'index',
            name: "purchaseOrder",
            meta: { title: global.route['purchaseOrder'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/purchaseOrder.vue')
        }]
    },
    {
        path: '/purchasingManagement/specialPurchasing',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/specialPurchasing/index",
        meta: false,
        children: [{
            path: 'index',
            name: "specialPurchasing",
            meta: { title: global.route['specialPurchasing'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/specialPurchasing.vue')
        }]
    },
    {
        path: '/purchasingManagement/examplesPurchasing',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/examplesPurchasing/index",
        meta: false,
        children: [{
            path: 'index',
            name: "examplesPurchasing",
            meta: { title: global.route['examplesPurchasing'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/examplesPurchasing.vue')
        }]
    }, {
        path: '/purchasingManagement/transactionPurchase',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/transactionPurchase/index",
        meta: false,
        children: [{
            path: 'index',
            name: "transactionPurchase",
            meta: { title: global.route['transactionPurchase'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/transactionPurchase.vue')
        }]
    }, {
        path: '/purchasingManagement/mySettlement',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/mySettlement/index",
        meta: false,
        children: [{
            path: 'index',
            name: "mySettlement",
            meta: { title: global.route['mySettlement'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/mySettlement.vue')
        }]
    },
    // {
    //     path: '/purchasingManagement/addPurchasing',
    //     component: () =>
    //         import ('/src/view/Home/index.vue'),
    //     redirect: "/purchasingManagement/addPurchasing/index",
    //     meta: false,
    //     children: [{
    //         path: 'index',
    //         name: "addPurchasing",
    //         meta: { title: global.route['addPurchasing'], icon: 'el-icon-s-release' },
    //         component: () =>
    //             import ('@/view/purchasingManagement/addPurchasing.vue')
    //     }]
    // }
    , {
        path: '/purchasingManagement/purchaseOrder',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/purchaseOrder/index",
        meta: false,
        children: [{
            path: 'index',
            name: "purchaseOrder",
            meta: { title: global.route['purchaseOrder'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/purchaseOrder.vue')
        }]
    },

    {
        path: '/purchasingManagement/myHarvest',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/purchasingManagement/myHarvest/index",
        meta: false,
        children: [{
            path: 'index',
            name: "myHarvest",
            meta: { title: global.route['myHarvest'], icon: 'el-icon-s-release' },
            component: () =>
                import ('@/view/purchasingManagement/myHarvest.vue')
        }]
    }, {
        path: '/productInformation/brandInfo',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/productInformation/brandInfo/index",
        meta: false,
        children: [{
            path: 'index',
            name: "brandInfo",
            meta: { title: global.route['brandInfo'], icon: 'el-icon-notebook-2' },
            component: () =>
                import ('@/view/ProductOperation/productInformation/brandInfo.vue')
        }]
    }, {
        path: '/productInformation/infoClassify',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/productInformation/infoClassify/index",
        meta: false,
        children: [{
            path: 'index',
            name: "infoClassify",
            meta: { title: global.route['infoClassify'], icon: 'el-icon-notebook-2' },
            component: () =>
                import ('@/view/ProductOperation/productInformation/infoClassify.vue')
        }]
    }, {
        path: '/productInformation/addBrand',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/productInformation/addBrand/index",
        meta: false,
        children: [{
            path: 'index',
            name: "addBrand",
            meta: { title: global.route['addBrand'], icon: 'el-icon-notebook-2' },
            component: () =>
                import ('@/view/ProductOperation/productInformation/addBrand.vue')
        }]
    }, {
        path: '/Sales',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/Sales/index",
        meta: {
            roles: ['admin', 'editor'],
            title: global.route['Sales'],
        },
        children: [{
                path: 'index',
                name: "Sales",
                meta: { title: global.route['Sales'], icon: 'el-icon-notebook-2' },
                component: () =>
                    import ('@/view/Sales/index.vue'),

            },
            {
                path: 'manualreport',
                name: "manualreport",
                hidden: true,
                meta: { title: global.route['manualreport'], icon: 'el-icon-notebook-2', hidden: true, },
                component: () =>
                    import ('@/view/Sales/manualreport.vue')
            }
        ]

    },
    {
        path: '/User',
        component: () =>
            import ('/src/view/Home/index.vue'),
        meta: {
            roles: ['admin', 'editor'],
            title: global.route['UserManagement'],
            icon: 'el-icon-s-custom',
        },
        children: [{
                path: 'personalData',
                name: "personalData",
                meta: { title: global.route['personalData'], icon: 'el-icon-s-custom' },
                component: () =>
                    import ('@/view/UserManagement/personalData.vue')
            }, {
                path: 'Department',
                name: "Department",
                meta: { title: global.route['Department'], icon: 'el-icon-s-custom' },
                component: () =>
                    import ('@/view/UserManagement/Department.vue')
            }, {
                path: 'membersCompany',
                name: "membersCompany",
                meta: { title: global.route['membersCompany'], icon: 'el-icon-s-custom' },
                component: () =>
                    import ('@/view/UserManagement/membersCompany.vue')
            },


        ]

    },
    {
        path: "/Loft",
        component: () =>
            import ('/src/view/Home/index.vue'),
        meta: {
            roles: ['admin', 'editor'],
            title: global.route['LoftManagement'],
            icon: 'el-icon-s-home',
        },
        children: [{
                path: 'index',
                name: "LoftManagement",
                meta: { title: global.route['LoftManagement'], icon: 'el-icon-s-home' },
                component: () =>
                    import ('@/view/LoftManagement/Loft.vue')
            }, {
                path: 'Receipt',
                name: "Receipt",
                meta: { title: global.route['ReceiptManagement'], icon: 'el-icon-truck' },
                component: () =>
                    import ('@/view/LoftManagement/Receipt.vue')
            },
            {
                path: 'Ship',
                name: "Ship",
                meta: { title: global.route['ShipManagement'], icon: 'el-icon-truck' },
                component: () =>
                    import ('@/view/LoftManagement/Ship.vue')
            },
            {
                path: 'inventory',
                name: "inventory",
                meta: { title: global.route['inventory'], icon: 'el-icon-s-data' },
                component: () =>
                    import ('@/view/LoftManagement/inventory.vue')
            },
            //  {
            //     path: 'boxing',
            //     name: "boxing",
            //     meta: { title: global.route['boxing'], icon: 'el-icon-box' },
            //     component: () =>
            //         import ('@/view/LoftManagement/boxing.vue')
            // }, 
            {
                path: 'shippingManagement',
                name: "shippingManagement",
                meta: { title: global.route['shippingManagement'], icon: 'el-icon-sold-out', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/wareManagement/shippingManagement.vue')
            }, {
                path: 'receiveManagement',
                name: "receiveManagement",
                meta: { title: global.route['receiveManagement'], icon: 'el-icon-sell', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/wareManagement/receiveManagement.vue')
            }, {
                path: 'returnsManagement',
                name: "returnsManagement",
                meta: { title: global.route['returnsManagement'], icon: 'el-icon-s-release', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/wareManagement/returnsManagement.vue')
            }, {
                path: 'returnsDetail',
                name: "returnsDetail",
                hidden: true,
                meta: { title: global.route['returnsDetail'], icon: 'el-icon-s-release', roles: ['admin', 'editor'], hidden: true, activeurl: '/Loft/returnsManagement/' },
                component: () =>
                    import ('@/view/wareManagement/components/returnsDetail.vue')
            },
            {
                path: 'shipping',
                name: "shipping",
                hidden: true,
                meta: { title: global.route['shipping'], icon: 'el-icon-sold-out', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/wareManagement/shipping.vue')
            },


        ]
    }, {
        path: "/Materials",
        component: () =>
            import ('/src/view/Home/index.vue'),
        meta: {
            roles: ['admin', 'editor'],
            title: global.route['Materials'],
            icon: 'el-icon-receiving',
        },
        children: [{
                path: 'materials',
                name: "materials",
                meta: { title: global.route['Materials'], icon: 'el-icon-receiving' },
                component: () =>
                    import ('@/view/Materials/materials.vue')
            },
            //  {
            //     path: 'materialstype',
            //     name: "materialstype",
            //     meta: { title: global.route['Materialstype'], icon: 'el-icon-receiving' },
            //     component: () =>
            //         import ('@/view/Materials/materialstype.vue'),
            // }
        ]
    }, {
        path: '/:pathMatch(.*)',
        redirect: '/404'
    },
    {
        path: '/systemSettings',
        component: () =>
            import ('/src/view/Home/index.vue'),
        redirect: "/systemSettings/index",
        meta: {
            title: global.route['systemSettings'],
            icon: 'el-icon-setting',
            roles: ['admin', 'editor']
        },
        children: [{
                path: 'brandManagement',
                name: "brandManagement",
                meta: { title: global.route['brandManagement'], icon: 'el-icon-price-tag', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/brandManagement.vue')
            },
            {
                path: 'country',
                name: "country",
                meta: { title: global.route['country'], icon: 'el-icon-s-flag', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/country.vue')
            },
            {
                path: 'marketManagement',
                name: "marketManagement",
                meta: { title: global.route['marketManagement'], icon: 'el-icon-takeaway-box', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/marketManagement.vue')
            },
            {
                path: 'platform',
                name: "platform",
                meta: { title: global.route['platform'], icon: 'el-icon-s-platform', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/platform.vue')

            }, {
                path: 'operationLog',
                name: "operationLog",
                meta: { title: global.route['operationLog'], icon: 'el-icon-edit-outline', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/operationLog.vue')
            }, {
                path: 'Shelves',
                name: "Shelves",
                meta: { title: global.route['ShelvesManagement'], icon: 'el-icon-guide', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/Shelves.vue'),

            },
            {
                path: 'expressComManag',
                name: "expressComManag",
                meta: { title: global.route['expressComManag'], icon: 'el-icon-s-promotion', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/expressComManag.vue')
            },
            {
                path: 'channelManage',
                name: "channelManage",
                meta: { title: global.route['channelManage'], icon: 'el-icon-s-management', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/channelManage.vue')
            },
            {
                path: 'supplierManagement',
                name: "supplierManagement",
                meta: { title: global.route['supplierManagement'], icon: 'el-icon-user-solid', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/supplierManagement.vue')
            },
            {
                path: 'financialManagement',
                name: "financialManagement",
                meta: { title: global.route['financialManagement'], icon: 'el-icon-s-finance', roles: ['admin', 'editor'] },
                component: () =>
                    import ('@/view/systemSettings/financialManagement.vue')
            }
        ]
    },

    // ,{
    //     path:"/Settings",
    //     name:'Settings',
    //     meta:{title:global.route['setting'],icon:'el-icon-setting'},
    //     component: () => import('/src/view/Home/index.vue'),
    //     redirect:'/Settings/index',
    //     children:[
    //             {
    //                 path:"Settings",
    //                 name:'Settings',
    //                 meta:{title:'Settings',icon:'el-icon-setting'},
    //                 component:() => import('@/view/Settings/index.vue'),
    //             },
    //             {
    //                 path:"Pricingrules",
    //                 name:'Pricingrules',
    //                 meta:{title:'Pricingrules',icon:'el-icon-setting'},
    //                 component:() => import('@/view/Settings/Pricingrules.vue')
    //             },
    //             {
    //                 path:"Suppliers",
    //                 name:'Suppliers',
    //                 meta:{title:'Suppliers',icon:'el-icon-setting'},
    //                 component:() => import('@/view/Settings/Suppliers.vue')
    //             },
    //             {
    //                 path:"CDRreports",
    //                 name:'CDRreports',
    //                 meta:{title:'CDRreports',icon:'el-icon-setting'},
    //                 component:() => import('@/view/Settings/CDRreports.vue')
    //             }
    //         ]
    // }
]



export default constantRoutes