import { createApp } from 'vue'
import App from './App.vue'
import Components from './components'

import './config/permission'
// 引入element-plus
import ElementPlus from 'element-plus'
// import zhCn from 'element-plus/es/locale/lang/zh-cn.js'
import 'element-plus/dist/index.css'
import '../src/assets/style/main.css'
import store from './store'
import config from '../package.json'
// import VueViewer from 'v-viewer'
//引入ElementPlus css框架
import router from './router/index.js'

import i18n from './locale'


const app = createApp(App);

//
Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
}

Array.prototype.indexofBoolast = function(item) {
    return this.indexOf(item) != -1
}

app.config.globalProperties.$version = config.version
app.use(Components);
app.use(ElementPlus);
app.use(router);
app.use(store);
app.use(i18n);



app.mount('#app')