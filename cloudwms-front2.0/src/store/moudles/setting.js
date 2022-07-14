import defaultSettings from '@/utils/Setting'
import { getLanguage, setLanguage } from '@/utils/cookies';
import { seti18n, geti18n } from '@/utils/userinfo';

export default {
    namespaced: true,
    state: defaultSettings,
    mutations: {
        SAVE_SETTINGS(state, data) {
            Object.entries(data).forEach(([key, value]) => {
                state[key] = value
            })
        },
        CHANGE_SETTINGS(state, data) {
            Object.entries(data).forEach(([key, value]) => {
                seti18n(value)
                state[key] = value
            })
        },
        TOGGLE_THEME(state, data) {
            state.theme = data
        }
    },
    actions: {
        /**
         * @description 切换语言
         * @param {string} lang 语言 可选值： zh-cn|en
         */
        changeLanguage: ({ commit }, lang) => {
            commit('CHANGE_SETTINGS', lang);
        },
        /**
         * @description 切换主题
         * @param {string} item light
         */
        toggleTheme: ({ commit }, item) => {
            commit('TOGGLE_THEME', item)
        }
    }
}