<template>
  <div>
    <div style="border: 1px solid #ccc; margin-top: 10px">
      <Toolbar
        :editor="editorRef"
        :defaultConfig="toolbarConfig"
        :mode="mode"
        style="border-bottom: 1px solid #ccc"
      />
      <Editor
        :defaultConfig="editorConfig"
        :mode="mode"
        v-model="valueHtml"
        style="height: 400px; overflow-y: hidden"
        @onCreated="handleCreated"
        @onChange="handleChange"
        @onDestroyed="handleDestroyed"
        @onFocus="handleFocus"
        @onBlur="handleBlur"
        @customAlert="customAlert"
        @customPaste="customPaste"
      />
    </div>
  </div>
</template>

<script>
import '@wangeditor/editor/'
import '@wangeditor/editor/dist/css/style.css';
import { onBeforeUnmount, ref, shallowRef, onMounted, watch } from 'vue';
import { Editor, Toolbar } from '@wangeditor/editor-for-vue';
import { netConfig } from '@/config/net.config';
import { getAccessToken } from '@/utils/AccessToken'
export default {
  name:"EditWangeditor",
  components: { Editor, Toolbar },
  emits:['update:modelValue'],
  props:{
    editor:{
      type:String,
      default:''
    },
    modelValue:{
      type:String,
      default:''
    }
  },
  setup(props,content) {
    
    // 编辑器实例，必须用 shallowRef，重要！
    const editorRef = shallowRef()
    // 内容 HTML
    const valueHtml = ref(props.modelValue)

    // 模拟 ajax 异步获取内容
    onMounted(() => {
        // if(props.modelValue != ''){
        //   valueHtml.value = props.modelValue
        // }
        // setTimeout(() => {
        //     if(props.modelValue != ''){
        //       valueHtml.value = props.modelValue
        //     }  
        // }, 1500)
    })
    const toolbarConfig = {
      /* 工具栏配置 */
    toolbarKeys: [
        'bold',
        'clearStyle',
        'color',
        'bgColor',
        '|',
        "through",
        "italic",
        "underline",
        '|',
        "lineHeight",
        "fontFamily",
        "fontSize",
        '|',
        // 菜单组，包含多个菜单
        {
            key: 'group-link',
            title: '链接',
            menuKeys: ['insertLink', 'editLink', 'unLink', 'viewLink']
        },
        {
            key: 'group-table',
            title: '表格',
            menuKeys: ['insertTable',
                'deleteTable',
                'insertTableRow',
                'deleteTableRow',
                'insertTableCol',
                'deleteTableCol',
                'tableHeader',
                'tableFullWidth']
        },
        '|',
        'divider',
        'emotion',
        'blockquote',
        'headerSelect',
        "codeBlock",
        '|',
        'todo',
        "bulletedList", //无序列表
        "numberedList",//有序列表
        "delIndent",
        "indent",
        '|',
        'fullScreen', //放大
        'redo',
        'undo',
        
     ]
    }


    const editorConfig = { placeholder: '请输入内容...',MENU_CONF:{} }
    //上传成功
    editorConfig.MENU_CONF['uploadImage'] = {
      server: `${netConfig.baseURL}/api/common/upload`,
      fieldName:"file",
      // 自定义增加 http  header
      headers: {
          token: getAccessToken()
      },
      onBeforeUpload(file) {
        console.log(file)
        // file 选中的文件，格式如 { key: file }
            return file

            // 可以 return
            // 1. return file 或者 new 一个 file ，接下来将上传
            // 2. return false ，不上传这个 file
        },
        // 上传进度的回调函数
        onProgress(progress) {
            // progress 是 0-100 的数字
            console.log('progress', progress)
        },
        // 单个文件上传成功之后
        onSuccess(file, res) {
            console.log(`${file.name} 上传成功`, res)
        },
        // 单个文件上传失败
        onFailed(file, res) {
            console.log(`${file.name} 上传失败`, res)
        },
        // 上传错误，或者触发 timeout 超时
        onError(file, err, res) {
            console.log(`${file.name} 上传出错`, err, res)
        },
        customInsert(res, insertFn) {
              // res 即服务端的返回结果
              let href = res.data.href || '#'
              let alt = res.data.alt || '图片'
              // 从 res 中找到 url alt href ，然后插图图片
              insertFn(res.data.fullurl, alt, href)
        },
    }
    // 组件销毁时，也及时销毁编辑器，重要！
    onBeforeUnmount(() => {
        const editor = editorRef.value
        if (editor == null) return
        editor.destroy()
    })

    // 编辑器回调函数
    const handleCreated = (editor) => {
      // console.log('created', editor);
      editorRef.value = editor // 记录 editor 实例，重要！
    }
    const handleChange = (editor) => {
      // console.log('change:', editor.getHtml());
      content.emit('update:modelValue',editor.getHtml())
    }
    const handleDestroyed = (editor) => {
      console.log('destroyed', editor)
    }
    const handleFocus = (editor) => {
        // console.log('focus', editor)
    }
    const handleBlur = (editor) => {
        // console.log('blur', editor)
    }
    const customAlert = (info, type) => {
        // alert(`【自定义提示】${type} - ${info}`)
    }
    const customPaste = (editor, event, callback) => {
        // console.log('ClipboardEvent 粘贴事件对象', event)
        // 自定义插入内容
        editor.insertText('xxx')
        // 返回值（注意，vue 事件的返回值，不能用 return）
        callback(false) // 返回 false ，阻止默认粘贴行为
        // callback(true) // 返回 true ，继续默认的粘贴行为
    }
    const insertText = () => {
        const editor = editorRef.value
        if (editor == null) return
        editor.insertText('hello world')
    }
    const installText = (val) =>{
      valueHtml.value = val
    }
    const printHtml = () => {
        const editor = editorRef.value
        if (editor == null) return
        // console.log(editor.getHtml())
    }

    const disable = () => {
        const editor = editorRef.value
        if (editor == null) return
        editor.disable()
    }

    return {
      editorRef,
      mode: 'default',
      valueHtml,
      toolbarConfig,
      editorConfig,
      handleCreated,
      handleChange,
      handleDestroyed,
      handleFocus,
      handleBlur,
      customAlert,
      customPaste,
      insertText,
      printHtml,
      disable,
      installText
    };
  }
};
</script>
