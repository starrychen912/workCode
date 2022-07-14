import i18n from '../locale';
const locale = i18n.global.locale
const message = i18n.global.messages
const global = message[locale];
const routes = [
    {
        path:"/",
        name:"index",
        meta:false,
        redirect:'/other/howitwork'
    },
    {
        path: '/index',
        component: () => import('/src/view/Home/index.vue'),
        children:[
            {
                path:'home',
                name:"home",
                meta:{title:global.route['home'],icon:'el-icon-s-home',router:'index',Authentication:true},
                component: () => import('@/view/Home/Home.vue'),
            },{
                path:'Notifications',
                name:"Notifications",
                meta:{title:global.route['Notifications'],icon:'el-icon-message-solid',router:'index',Authentication:true},
                component:() => import('@/view/Notifications/Notifications.vue')
            },{
                path:'OrderAll',
                name:"OrderAll",
                meta:{title:global.route['OrderAll'],icon:'el-icon-s-order',router:'index',Authentication:true},
                component:() => import('@/view/Home/OrderAll.vue')
            },{
                path:'Storeshop',
                name:"Storeshop",
                meta:{title:global.route['StoreShop'],icon:'el-icon-s-shop',router:'index',Authentication:true},
                component:() => import('@/view/Storeshop/Storeshop.vue')
            },
            {
                path:"Settings",
                name:'Settings',
                meta:{title:global.route['setting'],icon:'el-icon-s-tools',router:'index',Authentication:true},
                component:() => import('@/view/Settings/index.vue'),
                redirect:'/index/Settings/Settings',
                children:[
                    {
                        path:"Settings",
                        name:'Settings',
                        meta:{title:'Settings',icon:'el-icon-s-tools',router:'Settings'},
                        component:() => import('@/view/Settings/Settings.vue')
                    },
                    {
                        path:"Pricingrules",
                        name:'Pricingrules',
                        meta:{title:'Pricingrules',icon:'el-icon-s-tools',router:'Settings'},
                        component:() => import('@/view/Settings/Pricingrules.vue')
                    },
                    {
                        path:"Suppliers",
                        name:'Suppliers',
                        meta:{title:'Suppliers',icon:'el-icon-s-tools',router:'Settings'},
                        component:() => import('@/view/Settings/Suppliers.vue')
                    },
                    {
                        path:"CDRreports",
                        name:'CDRreports',
                        meta:{title:'CDRreports',icon:'el-icon-s-tools',router:'Settings'},
                        component:() => import('@/view/Settings/CDRreports.vue')
                    }
                ]
            }
            // ,{
            //     path:'ImportStoreShop',
            //     name:"ImportStoreShop",
            //     meta:{title:global.route['ImportStoreShop'],icon:'el-icon-download',router:'index',Authentication:true},
            //     component: () => import('@/view/Orderlist/Orderlist.vue'),
            // },
            // {
            //     path:'Products',
            //     name:"Products",
            //     meta:{title:global.route['Products'],icon:'el-icon-discount',router:'index',Authentication:true},
            //     component: () => import('@/view/Products/index.vue'),
            // },{
            //     path:'Orders',
            //     name:"Orders",
            //     meta:{title:global.route['Orderlist'],icon:'el-icon-s-claim',router:'index',Authentication:true},
            //     component: () => import('@/view/Order/Orders.vue'),
            // }
            // ,{
            //     path:'FindProducts',
            //     name:"FindProducts",
            //     meta:{title:global.route['FindProducts'],icon:'el-icon-search',router:'index',Authentication:true},
            //     component:() => import('@/view/FindProducts/FindProducts.vue')
            // },{
            //     path:'Storeshop',
            //     name:"Storeshop",
            //     meta:{title:global.route['StoreShop'],icon:'el-icon-s-shop',router:'index',Authentication:true},
            //     component:() => import('@/view/Storeshop/Storeshop.vue')
            // },{
            //     path:'Stocklog',
            //     name:"Stocklog",
            //     meta:{title:global.route['Stocklog'],icon:'el-icon-s-order',router:'index',Authentication:true},
            //     component:() => import('@/view/Stocklog/Stocklog.vue')
            // },{
            //     path:"/FindProductsSearch",
            //     name:"FindProductsSearch",
            //     component:() => import('@/view/FindProducts/FindProductsSearch.vue')
            // },{
            //     path:"help",
            //     name:"help",
            //     component:() => import('@/view/Help/help.vue')
            // },
            // ,{
            //     path:'Settings/General',
            //     name:"Settings",
            //     // component:() => import('@/view/Settings/Settings.vue'),
            //     // redirect:'/index/Settings/Settings',
            //     children:[
            //         {
            //             path:'General',
            //             name:"General",
            //             meta:false,
            //             component:() => import('@/view/FindProducts/FindProducts.vue')
            //         },
            //         {
            //             path:'Pricing rule',
            //             name:"General",
            //             meta:false,
            //             component:() => import('@/view/FindProducts/FindProducts.vue')
            //         },
            //         {
            //             path:'Suppliers',
            //             name:"General",
            //             meta:false,
            //             component:() => import('@/view/FindProducts/FindProducts.vue')
            //         },
            //         {
            //             path:'CDPR reports',
            //             name:"General",
            //             meta:false,
            //             component:() => import('@/view/FindProducts/FindProducts.vue')
            //         }
            //     ]
            // },{
            //     path:'Pricingrules',
            //     name:"Pricingrules",
            //     component:() => import('/src/components/Loyout/Container/Settings/Pricingrules.vue')
            // },{
            //     path:'Suppliers',
            //     name:"Suppliers",
            //     component:() => import('/src/components/Loyout/Container/Settings/Suppliers.vue')
            // },{
            //     path:'CDRreports',
            //     name:"CDRreports",
            //     component:() => import('/src/components/Loyout/Container/Settings/CDRreports.vue')
            // },
            //Settingrouter
            ,
            {
                path:"/index/Addstoreshop",
                name:"Addstoreshop",
                component:() => import('@/view/Storeshop/Addstoreshop.vue'),
            },{
                path:"/Userinfo",
                name:'Userinfo',
                meta:false,
                component:() => import('@/view/Userinfo/userinfo.vue')
            }
        ]
    },{
        path:"/Officialwebsite",
        name:"Officialwebsite",
        component:() => import('@/view/Officialwebsite/Officialwebsite.vue'),
        children:[
            {
                path:"Officialwebsite",
                name:"Officialwebsite",
                component:() => import('@/view/Officialwebsite/Officialwebsite.vue'),
            },
            
        ]
       
    },{
        path:"/Officialwebsite/Accounts",
        name:"Accounts",
        meta:false,
        component:() => import('@/view/Officialwebsite/Accounts.vue'),
    },{
        path:"/Officialwebsite/Accounts/dropshippingdetail",
        name:"dropshippingdetail",
        meta:false,
        component:() => import('@/view/Officialwebsite/dropshippingdetail.vue'),
    },{
        path:"/loginout",
        name:'loginout',
        meta:false,
        component:() => import('@/view/login/loginout.vue')
    },{
        path:"/Revision",
        name:'Revision',
        meta:false,
        component:() => import('@/view/login/Revision.vue')
    },{
        path:"/logins",
        name:'logins',
        meta:false,
        component:() => import('@/view/login/login.vue')
    },{
        path:"/401",
        name:'401',
        meta:false,
        component:() => import('@/view/errorPage/401.vue')
    },{
        path:"/404",
        name:'404',
        meta:false,
        component:() => import('@/view/errorPage/404.vue')
    },{
        path:'/:pathMatch(.*)',
        redirect:'/404'
    },{
        path:"/other",
        name:'other',
        meta:false,
        component:() => import('@/view/other/index.vue'),
        children:[
            {
                path:"howitwork",
                name:"howitwork",
                component: () => import('@/view/other/howitwork.vue'),
            },
            {
                path:"support",
                name:"support",
                component: () => import('@/view/other/support.vue'),
            },
            {
                path:"abouts_us",
                name:"abouts_us",
                component: () => import('@/view/other/abouts_us.vue'),
            },
            {
                path:"security",
                name:"security",
                component: () => import('@/view/other/security.vue'),
            },
            {
                path:"faq",
                name:"faq",
                component: () => import('@/view/other/faq.vue'),
            },
            {
                path:"articles",
                name:"articles",
                component: () => import('@/view/other/articles.vue'),
            },
            {
                path:"explain",
                name:"explain",
                component: () => import('@/view/other/explain.vue'),
            }
            ,
            {
                path:"storeshop",
                name:"storeshop",
                component: () => import('@/view/other/storeshop.vue'),
            }
            
            
        ]
    },
    {
        path:"/Amazonshop",
        name:"Amazonshop",
        meta:{
            title:"亚马逊"
        },
        component:() => import('@/view/Amazon/index.vue'),
        children:[
            {
                path:"index",
                name:"Amazonindex",
                meta:{title:global.route['home'],icon:'el-icon-s-home',router:'Amazonindex',AmazonAuthentication:true},
                component: () => import('@/view/Storeshop/Home/Home.vue'),
            },{
                path:'AmazonImportStore',
                name:"AmazonImportStore",
                meta:{title:global.route['ImportStoreShop'],icon:'el-icon-download',router:'Amazonindex',AmazonAuthentication:true},
                component: () => import('@/view/Orderlist/Orderlist.vue'),
            },{
                path:'AmazonProducts',
                name:"AmazonProducts",
                meta:{title:global.route['Products'],icon:'el-icon-s-claim',router:'Amazonindex',AmazonAuthentication:true},
                component:() => import('@/view/Amazon/Amazonproduct.vue')
            },{
                path:'AmzonOrders',
                name:"AmzonOrders",
                meta:{title:global.route['Orderlist'],icon:'el-icon-s-order',router:'Amazonindex',AmazonAuthentication:true},
                component:() => import('@/view/Amazon/AmzonOrders.vue')
            },{
                path:'AmazonFindProducts',
                name:"AmazonFindProducts",
                meta:{title:global.route['FindProducts'],icon:'el-icon-search',router:'Amazonindex',AmazonAuthentication:true},
                component:() => import('@/view/FindProducts/FindProducts.vue')
            },{
                path:'AmazonStocklog',
                name:"AmazonStocklog",
                meta:{title:global.route['Stocklog'],icon:'el-icon-tickets',router:'Amazonindex',AmazonAuthentication:true},
                component:() => import('@/view/Stocklog/Stocklog.vue')
            },{
                path:"/Amazonshop/AmazonProducts/AddAmazonProduct",
                name:"AddAmazonProduct",
                component:() => import('@/view/Amazon/AddAmzonProduct.vue')
            },{
                path:"/Amazonshop/AmazonProducts/SearchAmzonPorduct",
                name:"SearchAmzonPorduct",
                component:() => import('@/view/Amazon/SearchAmzonPorduct.vue')
            },{
                path:"/Amazonshop/AmazonProducts/productclassify",
                name:"productclassify",
                component:() => import('@/view/Amazon/productclassify.vue')
            },{
                path:"/Amazonshop/AmazonProducts/preferences",
                name:"preferences",
                component:() => import('@/view/Amazon/components/preferences.vue')
            },{
                path:"/Amazonshop/SellerFulfilledProduct",
                name:"SellerFulfilledProduct",
                component:() => import('@/view/Amazon/SellerFulfilledProduct.vue')
            }
        ]
    },
    {
        path:"/shop",
        name:"shop",
        meta:{
            title:"店铺管理"
        },
        component:() => import('@/view/Storeshop/Shoplist/index.vue'),
        children:[
            {
                path:"shophome",
                name:"shophome",
                meta:{title:global.route['home'],icon:'el-icon-s-home',router:'shopindex',ShopAuthentication:true},
                component: () => import('@/view/Storeshop/Home/Home.vue'),
            },{
                path:'ImportStoreShop',
                name:"ImportStoreShop",
                meta:{title:global.route['ImportStoreShop'],icon:'el-icon-download',router:'shopindex',ShopAuthentication:true},
                component: () => import('@/view/Orderlist/Orderlist.vue'),
            },
            {
                path:'Products',
                name:"Products",
                meta:{title:global.route['Products'],icon:'el-icon-s-claim',router:'shopindex',ShopAuthentication:true},
                component: () => import('@/view/Products/index.vue'),
            },{
                path:'Orders',
                name:"Orders",
                meta:{title:global.route['Orderlist'],icon:'el-icon-s-order',router:'shopindex',ShopAuthentication:true},
                component: () => import('@/view/Order/Orders.vue'),
            }
            ,{
                path:'FindProducts',
                name:"FindProducts",
                meta:{title:global.route['FindProducts'],icon:'el-icon-search',router:'shopindex',ShopAuthentication:true},
                component:() => import('@/view/FindProducts/FindProducts.vue')
            },{
                path:'Stocklog',
                name:"Stocklog",
                meta:{title:global.route['Stocklog'],icon:'el-icon-tickets',router:'shopindex',ShopAuthentication:true},
                component:() => import('@/view/Stocklog/Stocklog.vue')
            },
            {
                path:"/shop/Products/Addproduct",
                name:"Addproduct",
                component:() => import('@/view/Products/components/Addproduct.vue'),
            },{
                path:"/shop/Revisionproduct",
                name:"Revisionproduct",
                component:() => import('@/view/Products/Revisionproduct.vue'),
            },{
                path:"/shop/Revisionproduct/RevisionVariants",
                name:"RevisionVariants",
                component:() => import('@/view/Products/components/RevisionVariants.vue'),
            }
        ]
    }
    
];


export default routes