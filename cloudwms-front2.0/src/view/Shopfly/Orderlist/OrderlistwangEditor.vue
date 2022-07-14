<template>
    <div ref='editor' class="editor_editor"></div>
    <!-- <button @click='syncHTML'>同步内容</button>
    <div :innerHTML='content.html'></div> -->
</template>

<script>
import { onMounted, onBeforeUnmount, ref, reactive } from 'vue';
import WangEditor from 'wangeditor';
import { netConfig } from '../../../config/net.config';
import { getAccessToken } from '@/utils/AccessToken'
export default {
    props:{
      editor:{
        type:String,
        default:''
      },
      height:{
          type:String,
          default:'300'
      },
      zIndex:{
          type:Number,
          default:100,
      }
    },
    name: 'app',
    setup(props,context) {
        const editor = ref();
        // const content = reactive({
        //     html: '',
        //     text: '',
        // });
        
        let instance;
        onMounted(() => {
            instance = new WangEditor(editor.value);
            Object.assign(instance.config, {
               //操作文本
                onchange(newhtml) {
                    // console.log('change',newhtml);
                    if(props.editor != newhtml){
                        context.emit('Change',newhtml)
                    }
                    // context.emit('Change',newhtml)
                },
                //失去焦距
                onblur(newhtml){
                    // console.log('onblur',newhtml);
                    context.emit('Onblur',newhtml)
                },
                //全选的时候操作
                onselectionchange(newhtml){
                  // console.log('onselectionchange',newhtml);
                  context.emit('Onselectionchange',newhtml)
                },
                //获取焦距
                onfocus(newhtml){
                  // console.log('onfocus',newhtml);
                  context.emit('Onfocus',newhtml)
                }
            });
            instance.config.focus = false
            instance.config.height = props.height
            instance.config.zIndex = props.zIndex
            //上传图片
            instance.config.uploadImgServer = `${netConfig.baseURL}/api/common/upload`
            instance.config.uploadImgHeaders = {
                token:getAccessToken()
            }
            instance.config.uploadImgHooks = {
                // 上传图片之前
                before: function(xhr) {
                    console.log(xhr)
                    // 可阻止图片上传
                    // return {
                    //     prevent: true,
                    //     msg: '需要提示给用户的错误信息'
                    // }
                },
                // 图片上传并返回了结果，图片插入已成功
                success: function(xhr) {
                    console.log('success', xhr)
                },
                // 图片上传并返回了结果，但图片插入时出错了
                fail: function(xhr, editor, resData) {
                    console.log('fail', resData)
                },
                // 上传图片出错，一般为 http 请求的错误
                error: function(xhr, editor, resData) {
                    console.log('error', xhr, resData)
                },
                // 上传图片超时
                timeout: function(xhr) {
                    console.log('timeout')
                },
                // 图片上传并返回了结果，想要自己把图片插入到编辑器中
                // 例如服务器端返回的不是 { errno: 0, data: [...] } 这种格式，可使用 customInsert
                customInsert: function(insertImgFn, result) {
                    // result 即服务端返回的接口
                    console.log('customInsert', result)

                    // insertImgFn 可把图片插入到编辑器，传入图片 src ，执行函数即可
                    insertImgFn(result.data[0])
                }
            }
            instance.create();
            instance.txt.html(props.editor)
        });
        //销毁
        onBeforeUnmount(() => {
            instance.destroy();
            instance = null;
        });
        function Init(data){
            instance.txt.html(data)
        }
        // const syncHTML = () => {
        //     content.html = instance.txt.html();
        // };

        return {
            // syncHTML,
            editor,
            Init
            // content,
        };
    },
};
</script>
<style  lang="scss" >
        .editor_editor   {
            .w-e-text-container{
                padding: 0px 10px;
            }
        }
</style>
