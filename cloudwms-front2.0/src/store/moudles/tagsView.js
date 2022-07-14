export default {
    namespaced: true,
    state: {
        visitedViews: [],
        cachedViews: []
    },
    getters: {
        visitedViews: (state) => state.visitedViews,
        cachedViews: (state) => state.cachedViews
    },
    mutations: {
        //添加visitedViews
        ADD_VISITED_VIEW: (state, item) => {
            if (state.visitedViews.some(v => v.path == item.path)) return;
            state.visitedViews.push(
                Object.assign({}, item, {
                    title: item.meta.title || 'no-name'
                })

            )
        },
        //删除visitedViews
        DEL_VISITED_VIEW: (state, view) => {
            for (const [i, v] of state.visitedViews.entries()) {
                if (v.path === view.path) {
                    state.visitedViews.splice(i, 1)
                    break
                }
            }
        },
        //添加缓存页面
        ADD_CACHED_VIEW: (state, item) => {
            if (state.cachedViews.includes(item.name)) return
                //判断页面是否要缓存
            if (!item.meta.noCache) {
                state.cachedViews.push(item.name)
            }
        },

        //删除缓存页面
        DEL_CACHED_VIEW: (state, item) => {
            const index = state.cachedViews.indexOf(item.name)
            index > -1 && state.cachedViews.splice(index, 1)
        },
        UP_TO_DATE_VIEW: (state, item) => {}

    },
    actions: {
        //单独添加VisitedView
        addVisitedView({ commit }, item) {
            commit('ADD_VISITED_VIEW', item)
        },

        //单独添加cachedViews
        addcachedViews({ commit }, item) {
            commit('ADD_CACHED_VIEW', item)
        },

        //统一添加
        addView({ dispatch, state }, item) {
            dispatch('addVisitedView', item)
            dispatch('addcachedViews', item)
        },

        //统一删除
        delView({ dispatch, state }, view) {
            return new Promise(resolve => {
                dispatch('delVisitedView', view)
                dispatch('delCachedView', view)
                resolve({
                    visitedViews: [...state.visitedViews],
                    cachedViews: [...state.cachedViews]
                })
            })
        },

        // 单独删除VisitedView
        delVisitedView({ commit, state }, view) {
            return new Promise(resolve => {
                commit('DEL_VISITED_VIEW', view)
                resolve([...state.visitedViews])
            })
        },

        //单独删除CachedView
        delCachedView({ commit, state }, item) {
            return new Promise(resolve => {
                commit('DEL_CACHED_VIEW', item)
                resolve([...state.cachedViews])
            })
        },
        UptodateView({ dispatch, state }, item) {
            return new Promise(resolve => {
                dispatch('delView', item.oldval).then(res => {
                    dispatch('addView', item.newval)
                    resolve([...state.visitedViews])
                })
            })
        }
    }
}