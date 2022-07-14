import ViteDialog from './ViteDialog/index.vue'
import EditWangeditor from './EditWangeditor/EditWangeditor.vue'

export default {
    install(Vue) {
        Vue.component('ViteDialog', ViteDialog)
        Vue.component('EditWangeditor', EditWangeditor)
    }
}