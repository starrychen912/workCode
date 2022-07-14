<template>
  <el-config-provider :locale="localanguse">
    <router-view />
  </el-config-provider>
</template>
<script>
import { computed, defineComponent } from 'vue'
import {useReize} from '@/view/Home/useResize'
import i18n from './locale'
export default {
  setup() {
      useReize();
      let data = {
          name:i18n.global.locale,
          el:i18n.global.messages[i18n.global.locale]
      }
      return {
        localanguse:data
      };
  },
}
</script>

<style lang="scss">
html,
body,
#app {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #f0f2f5;
}
a{
  text-decoration: none;
  color: #000;
}
</style>
