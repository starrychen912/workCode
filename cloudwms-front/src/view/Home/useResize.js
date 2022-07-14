/*
 *                   ___====-_  _-====___
 *             _--^^^#####//      \\#####^^^--_
 *          _-^##########// (    ) \\##########^-_
 *         -############//  |\^^/|  \\############-
 *       _/############//   (@::@)   \############\_
 *      /#############((     \\//     ))#############\
 *     -###############\\    (oo)    //###############-
 *    -#################\\  / VV \  //#################-
 *   -###################\\/      \//###################-
 *  _#/|##########/\######(   /\   )######/\##########|\#_
 *  |/ |#/\#/\#/\/  \#/\##\  |  |  /##/\#/  \/\#/\#/\#| \|
 *  `  |/  V  V  `   V  \#\| |  | |/#/  V   '  V  V  \|  '
 *     `   `  `      `   / | |  | | \   '      '  '   '
 *                      (  | |  | |  )
 *                     __\ | |  | | /__
 *                    (vvv(VVV)(VVV)vvv)
 *
 *      ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *                神兽保佑            永无BUG
 *
 * @Descripttion:
 * @version:
 * @Date: 2021-04-20 11:06:21
 * @LastEditors: huzhushan@126.com
 * @LastEditTime: 2021-04-29 11:31:50
 * @Author: huzhushan@126.com
 * @HomePage: https://huzhushan.gitee.io/vue3-element-admin
 * @Github: https://github.com/huzhushan/vue3-element-admin
 * @Donate: https://huzhushan.gitee.io/vue3-element-admin/donate/
 */

import { onBeforeMount, onBeforeUnmount /*watch*/ } from 'vue'
// import { useRouter } from 'vue-router';
import { useStore } from 'vuex'

const WIDTH = 1200
const Mobile = 790 
export const useReize = () => {
  const store = useStore()
  // const router = useRouter();
  // const route = router.currentRoute;

  const isMobile = () => {
    return window.innerWidth < WIDTH
  }

  const isMobilesize = () =>{
    return window.innerWidth < Mobile
  } 
  
  const resizeMobile = () =>{
    if(isMobilesize()){
        let data = {
           device:{
              mode:'mobile'
           },
           detailcollapse:false,
           dialogwidth:'100%'
        }
        store.commit('setting/SAVE_SETTINGS',data)
    }else{
      let data = {
          device:{
            mode:'PC'
          }
        }
        store.commit('setting/SAVE_SETTINGS',data)
    }
  }

  const resizeHandler = () => {
    if (isMobile()) {
        store.commit('setting/SAVE_SETTINGS', {collapse:false,dialogwidth:'80%'})
        if(window.innerWidth>Mobile){
          store.commit('setting/SAVE_SETTINGS', {detailcollapse:true})
        }
    } else {
        store.commit('setting/SAVE_SETTINGS', {collapse:true,detailcollapse:false,dialogwidth:'65%'})
    }
  }

  onBeforeMount(() => {
    resizeHandler()
    resizeMobile()
    window.addEventListener('resize', resizeHandler)
    window.addEventListener('resize', resizeMobile)
  })

  onBeforeUnmount(() => {
    window.removeEventListener('resize', resizeHandler)
    window.addEventListener('resize', resizeMobile)
  })

  // // 监听路由的时候不能使用useRoute获取路由，否则会有警告
  // watch(route, () => {
  //   if (store.state.app.device === 'mobile' && !store.state.app.sidebar.collapse) {
  //     store.commit('app/setCollapse', 1)
  //   }
  // })
}
