import { createI18n } from 'vue-i18n/dist/vue-i18n.cjs.js'
//引入elm语言包
import ElementzhCn from 'element-plus/es/locale/lang/zh-cn'
import Elementen from 'element-plus/es/locale/lang/en'


//本项目配置
import en from './lang/en'
import zhCn from './lang/zh-cn'

import { getLanguage } from '../utils/cookies'
import { geti18n } from '../utils/userinfo'


const messages = {
  en:{
      ...Elementen.el,
      ...en
  },
  'zh-cn':{
      ...ElementzhCn.el,
      ...zhCn
  }
}

export const getLocale = () => {
    const cookieLanguage = geti18n();
    if (cookieLanguage) {
      return cookieLanguage;
    }
    //获取浏览器语言
    const language = navigator.language.toLowerCase();
    const locales = Object.keys(messages);
    for (const locale of locales) {
      if (language.indexOf(locale) > -1) {
        return locale;
      }
    }
    return 'zh';
  };

const i18n = createI18n({
    locale:getLocale(),
    messages: messages,
});

export default i18n;
