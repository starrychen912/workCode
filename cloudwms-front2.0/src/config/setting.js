/*
 * 配置文件 config
 */

export const setting = {
    //是否打开进度条
    progressBar: true,
    //token名称
    tokenName: 'accessToken',
    //存储位置是localStorage sessionStorage
    storage: 'localStorage',
    //标题
    title: "町町信息科技",
    // 是否删除生产环境console
    drop_console: true,
    // 是否删除生产环境debugger
    drop_debugger: true,
    //是否要验证登录
    loginInterception: false,
    //免登陆验证路由
    routesWhiteList: ['/login', '/register', '/404', '/401', '/Revision', '/logins', '/other', '/other/howitwork', '/other/support', '/other/abouts_us', '/other/faq', '/other/articles', '/other/explain', '/other/storeshop'],
    //请求不懈怠token   
    port: '8223',

    host: '0.0.0.0',

    https: false,

    open: false,

    // 语言缓存
    langKey: 'i18nlang',
    // 默认 lang 语言
    lang: 'zh-cn',
    //登录鉴权
    routeAuth: ['admin']
}