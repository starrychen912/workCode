<template>
  <ul class="release_list">
      <li>
        <div class="release_list--img">
              <img width="40" height="40" src="https://i.gtimg.cn/club/item/face/img/2/15922_100.gif">
        </div>
        <div class="release_list--content">
              <div class="content--date">
                  <div class="username">{{chatlist.userinfo.username || '管理员'}}</div>/
                  <div class="date">{{getLocalTime(chatlist.create_time)}}</div>
              </div>
              <div class="content_s" v-html="chatlist.content">
                
              </div>
              <div class="content_s--image" v-if="GetImages(chatlist.prove_img)">
                   <el-image v-for="(item,index ) in prove_img" :key="index" :src="item || 'https://img.zcool.cn/tubelocation/f263623316891101c44f5eaef6fd.jpg'" fit="cover"></el-image>
              </div>
              <!-- 增加磁吸功能用硅胶套包住磁铁，硅胶开模费大概要7000，成本大概1元/个后面的改版开模费用大概3000，成本6元/个
                 <div class="content_s--image">
                   <el-image src="https://img.zcool.cn/tubelocation/f263623316891101c44f5eaef6fd.jpg" fit="cover"></el-image>
                 </div> -->
               <div class="release_btn">
                 <div class="edit" @click="EditCommmit(chatlist)">
                   <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M7 42H43" stroke="#999" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M11 26.7199V34H18.3172L39 13.3081L31.6951 6L11 26.7199Z" fill="#999" stroke="#999" stroke-width="4" stroke-linejoin="round"/></svg>
                 </div>
                 <div class="delete" @click="DeleteCommmit(chatlist)">
                    <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M9 10V44H39V10H9Z" fill="#999" stroke="#999" stroke-width="4" stroke-linejoin="round"/><path d="M20 20V33" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M28 20V33" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 10H44" stroke="#999" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 10L19.289 4H28.7771L32 10H16Z" fill="#999" stroke="#999" stroke-width="4" stroke-linejoin="round"/></svg>
                 </div>
                 <div class="like">
                  <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                  <path d="M27.6 18.6V11.4C27.6 8.41766 25.1823 6 22.2 6L15 22.2V42H35.916C37.7111 42.0203 39.2468 40.7149 39.516 38.94L42 22.74C42.1585 21.6957 41.8504 20.6346 41.1573 19.8375C40.4643 19.0405 39.4561 18.588 38.4 18.6H27.6Z" stroke="#999" stroke-width="4" stroke-linejoin="round"/><path d="M15 22.0002H10.194C8.08532 21.9629 6.2827 23.7096 6 25.7996V38.3996C6.2827 40.4896 8.08532 42.0369 10.194 41.9996H15V22.0002Z" fill="none" stroke="#999" stroke-width="4" stroke-linejoin="round"/></svg>
                  <span>赞</span>
                 </div>
                 <div class="commit" @click="Commit(chatlist)">
                  <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M26 4L44 22L26 39V28C12 28 6 43 6 43C6 26 11 15 26 15V4Z" fill="none" stroke="#999" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  <span>回复</span>
                 </div>
              </div>
              <template v-if="chatlist.children && chatlist.children.length > 0">
                  <chat v-for="(item,index) in chatlist.children" :key="index" :chatlist="item" @change="change"></chat>
              </template>
              
        </div>
      </li>                      
  </ul>
  <vite-dialog
    v-model="dialogVisible"
    :title="`回复${chat_item.userinfo?chat_item.userinfo.username :''}评论`"
    @ViteClose="ViteClose"
  >
    <div>
      <el-input
          type="textarea"
          placeholder="请输入内容"
          v-model="textarea"
          maxlength="1000"
          show-word-limit
          :autosize="{minRows:5}"
        >
        </el-input>
    </div>
    <template #footer>
      <el-button @click="Cancel">取 消</el-button>
      <el-button type="primary" @click="comment">回复</el-button>
    </template>
  </vite-dialog>
   <vite-dialog
    v-model="editdialogVisible"
    title="修改评论内容"
    @ViteClose="EditViteClose"
    width="50%"
    top="15vh"
  >
    <div>
      <el-input
          type="textarea"
          placeholder="请输入内容"
          v-model="editextarea"
          maxlength="1000"
          show-word-limit
          :autosize="{minRows:5}"
        >
        </el-input>
    </div>
    <template #footer>
      <el-button @click="EditViteClose">取 消</el-button>
      <el-button type="primary" @click="CommitSubmtit">确定</el-button>
    </template>
  </vite-dialog>
</template>
<script>
import { reactive, toRefs, watch } from 'vue'
import { getLocalTime, isNaLL } from '../../../utils/utils'
import ViteDialog from '@/components/ViteDialog/index.vue'
import { Addtransaction,DeleteTransaction,Updatetransaction } from '@/api/transaction.js'
import { shoElmessage, shoElMessageBox } from '../../../utils/Elmessage'
import { useStore } from 'vuex'
export default {
  components:{
    ViteDialog
  },
  emits:['change'],
  props:{
    chatlist:{
      type:[Array,Object,String],
      default:[],
    }
  },  
  setup(props,content){
    const store = useStore()
    
    const data = reactive({
      dialogVisible:false,
      editdialogVisible:false,
      textarea:'',
      chat_item:{},
      editextarea:"",
      commit_item:{},
      prove_img:[],
    })
    //回复
    function Commit(item){
      data.chat_item = item
      data.dialogVisible = true
    }
    //关闭弹出框
    function ViteClose(){
      data.dialogVisible = !data.dialogVisible
      content.emit('change','删除')
    }
    //关闭编辑评论
    function EditViteClose(){
      data.editdialogVisible = !data.editdialogVisible
    }
    //取消
    function Cancel(){
      data.dialogVisible = !data.dialogVisible
    }
    function comment(){
      if(!isNaLL(data.textarea)) return shoElmessage(true,'请输入回复内容','warning')
      Addtransaction({
        company_id:store.state.userinfo.userinfo.company_id,
        content:data.textarea,
        type:data.chat_item.type,
        parent_id:data.chat_item.id,
        company_user_id:store.state.userinfo.userinfo.id,
        to_company_user_id:data.chat_item.id,
        status:data.chat_item.status,
      }).then((res) => {
          if(res.code == 1){
            ViteClose();
            shoElmessage(true,'回复成功')
          }else{
            shoElmessage(true,'回复失败','error')
          }
      }).catch((err) => {
        
      });
    }
    //编辑评论
    function EditCommmit(item){
      data.editdialogVisible = !data.editdialogVisible
      commit_item = item
      
    }
    //
    function CommitSubmtit(){
      if(isNaLL(data.editextarea)) return shoElmessage(true,'请输入修改内容','warning')
      Updatetransaction({
        company_id:store.state.userinfo.userinfo.company_id,
        content:data.editextarea,
        title:data.title,
      }).then((res) => {
          if(res.code == 1){
            ViteClose();
            shoElmessage(true,'回复成功')
          }else{
            shoElmessage(true,'回复失败','error')
          }
      }).catch((err) => {
        
      });
    }
    //删除评论
    function DeleteCommmit(item){
      console.log(item)
      shoElMessageBox().then(res =>{
        DeleteTransaction({
          transaction_ids:item.id
        }).then(res =>{
          if(res.code === 1){
            shoElmessage(true,'删除成功')
            content.emit('change','删除')
          }else{
            shoElmessage(true,'删除失败','error')
          }
        })
      }).catch(error =>{
        console.log(error)
      })
    }
    function change(){
      content.emit('change','删除')
    }
    function GetImages(fileilist){
        if(isNaLL(fileilist)){
          data.prove_img = fileilist.split(',')
          return true
        }else{
          return false
        }
    }
    return{
      Commit,
      ...toRefs(data),
      getLocalTime,
      ViteClose,
      Cancel,
      comment,
      DeleteCommmit,
      EditCommmit,
      EditViteClose,
      CommitSubmtit,
      change,
      GetImages
    }
  },
}
</script>
<style lang="scss" scoped>
//聊天样式
.content_release{
    background-color: #f0f0f0;
    // padding: 10px;
}
.release_list{
    list-style: none;
    padding: 0px;
    margin:0px;
    ul{
      // margin-left: 48px;
    }
    li{
        padding: 10px;
        display: flex;
        // flex-wrap: wrap;
        border-bottom: 1px solid #c2c2c2;
        &:last-child{
          border-bottom: none;
        }
        .release_list--content{
            margin-left: 10px;
            flex: 1;
            .content--date{
                display: flex;
                align-items: center;
                .username{
                    padding:0px 5px;
                    font-weight: bold;
                    &:first-child{
                      padding-left: 0px;
                    }
                }
                .date{
                    padding: 0px 5px;
                }
            }
        }
        .content_s--image{
            // margin-top: 5px;
            padding: 10px 0px;
        }
        .content_s--img{
          width: 100%;
          height: 300px;
          overflow: hidden;
          img{
            width: 100%;
            height: auto;
            object-fit: cover;
          }
        }
        .release_btn{
          width: 100%;
          display: flex;
          align-items: center;
          flex-wrap: wrap;
          justify-content: flex-end;
          padding: 10px 0px;
          .like,.commit,.delete,.edit{
            padding-left: 10px;
            display: flex;
            align-items: center;
            font-size: 14px;
            cursor: pointer;
            span{
              margin-left: 4px;
            }
          }
          .delete,.edit{
            display: none;
          }
          &:hover{
            .delete,.edit{
              display: flex;
            }
          }
        }
    }
}
.release_list--img{
  padding-top: 4px;
}
.release_list li .release_list li{
      padding-right: 0px;
}
</style>