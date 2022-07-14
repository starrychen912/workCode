import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import { setting } from './src/config/setting.js'


import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

const { port , open , host , https } = setting;
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(),
    // Components({
    //   resolvers: [ElementPlusResolver()],
    // }),
  ],
  //引入多功能scss
  css:{
    preprocessorOptions:{
      scss:{
        additionalData: '@use "@/assets/style/scss/index.scss" as *;',
      }
    }
  },
  //文件路径映射
  resolve:{
    alias:{
      view: path.resolve(__dirname, 'src/view'),
      style: path.resolve(__dirname, 'src/assets/style'),
      '@': path.resolve(__dirname, './src')
    }
  },
  //动态代理
  server:{
    port:port,
    https:https,
    open:open,
    host:host,
    proxy:{
      '/api':{
          target:'https://shopify.ddtechinfo.com', // 凡是遇到 /api 路径的请求，都映射到 target 属性
          changeOrigin: true,
      }
    }
  },
})
