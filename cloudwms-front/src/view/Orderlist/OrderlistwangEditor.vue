<template>
    <div ref='editor'></div>
    <!-- <button @click='syncHTML'>同步内容</button>
    <div :innerHTML='content.html'></div> -->
</template>

<script>
import { onMounted, onBeforeUnmount, ref, reactive } from 'vue';
import WangEditor from 'wangeditor';

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
