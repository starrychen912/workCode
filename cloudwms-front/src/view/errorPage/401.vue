<template>
  <ErrorPage type="401" title="你没有权限去该页面..." msg="请联系管理员，或点击下面的按钮返回首页" />
</template>

<script setup>
  import ErrorPage from '@/components/ErrorPage/index.vue';
  // import { useI18n } from 'vue-i18n';
  // const { t } = useI18n();
</script>
