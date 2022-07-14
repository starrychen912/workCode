// import { createApp } from 'vue'
import { createStore } from 'vuex'

const modulesFiles = import.meta.globEager('./moudles/*.js')
const modules = Object.entries(modulesFiles).reduce((modules, [path, mod]) => {
  const moduleName = path.replace(/^\.\/moudles\/(.*)\.\w+$/, '$1')
  modules[moduleName] = mod.default
  return modules
}, {})

export default createStore({
  modules,
})
