import { setItem,getItem } from "../../utils/storage";
import { asyncRoutes,constantRoutes } from "../../router/routes";
/**
 * 判断这个页面是否存在权限
 * @param roles
 * @param route
 */
 function hasPermission(roles, route) {
   
    if (route.meta && route.meta.roles) {
      return roles.some(role => route.meta.roles.includes(role))
    } else {
      return true
    }
}
/**
 * 过滤权限路由跟不是权限路由
 * @param routes 
 * @param roles
 */
 export function filterAsyncRoutes(routes, roles) {
    const res = []
    routes.forEach(route => {
      const tmp = { ...route }
      if (hasPermission(roles, tmp)) {
        if (tmp.children) {
          tmp.children = filterAsyncRoutes(tmp.children, roles)
        }
        res.push(tmp)
      }
    })
    return res
}

export default {
    namespaced: true,
    state: {
        routes:  [],
        addRouters: [],
    },
    mutations:{
        SET_ROUTES:(state,routes)=>{
            state.addRouters = routes
            state.routes = constantRoutes.concat(routes)
        }
    },
    actions:{
        setRouter({ commit },data){
            setItem('routers',data)
            commit('SET_ROUTERS',data)
        },

        setSettingRouter({ commit },data){
            commit('SET_SETTINGROUTERS',data)
        },
        
        generateRoutes({ commit }, roles) {
            return new Promise(resolve => {
              let accessedRoutes    
              if (roles.includes('admin')) {
                    accessedRoutes = asyncRoutes || []
              } else {
                    accessedRoutes = filterAsyncRoutes(asyncRoutes, roles)
              }
              commit('SET_ROUTES', accessedRoutes)
              resolve(accessedRoutes)
            })
          }
    }
}
