<template>
    <ul>
      <li class="explanation">
        <div class="explanation_list flex">
            <div class="explanation_list--header">
              <img width="40" height="40" src="https://i.gtimg.cn/club/item/face/img/2/15922_100.gif">
            </div>
            <div class="explanation_list--content">
              <div class="explanation_list_content--username flex align-center ">
                <div class="explanation_list_content--title">{{Object.keys(chatlist).length > 0  && isNaLL(chatlist.userinfo)? `${chatlist.userinfo.username} / ${getLocalTime(chatlist.create_time)}`:'未知用户'}}</div>
                <div class="explanation_list_content--icon">
                  <!-- <i class="el-icon-edit-outline"></i> -->
                  <i class="el-icon-delete-solid" @click="DeleteCommit(chatlist)"></i>
                </div>
              </div>
              <div class="explanation_list_content--text">{{chatlist.content}}</div>
              <div class="explanation_list_content--imagse" v-if="isNaLL(chatlist.prove_img)">
                <el-image :src="chatlist.prove_img" fit="cover"></el-image>
              </div>
              <div class="explanation_list--operating">
                <!-- <div class="date">2020-10-08 12:10:20</div> -->
                <div class="like">
                  <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                    <path d="M27.6 18.6V11.4C27.6 8.41766 25.1823 6 22.2 6L15 22.2V42H35.916C37.7111 42.0203 39.2468 40.7149 39.516 38.94L42 22.74C42.1585 21.6957 41.8504 20.6346 41.1573 19.8375C40.4643 19.0405 39.4561 18.588 38.4 18.6H27.6Z" stroke="#939393" stroke-width="4" stroke-linejoin="round"/>
                    <path d="M15 22.0002H10.194C8.08532 21.9629 6.2827 23.7096 6 25.7996V38.3996C6.2827 40.4896 8.08532 42.0369 10.194 41.9996H15V22.0002Z" fill="none" stroke="#939393" stroke-width="4" stroke-linejoin="round"/></svg>
                  <span>赞</span>
                </div>
                <div class="commit" @click="Commit(chatlist)">
                  <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26 4L44 22L26 39V28C12 28 6 43 6 43C6 26 11 15 26 15V4Z" fill="none" stroke="#939393" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  <span>回复</span>
                </div>
              </div>
              <template v-if="showstatus">
                <template v-if="Getstatus(activeindex)">
                  <chat v-for="(item,index) in chatlist.children" :key="index" :chatlist="item" :activeindex="`${activeindex}-${index}`" @change="ChatChange" :showstatus="showstatus" :responsible_person_list="responsible_person_list"></chat>
                </template>
              </template>
              <!-- <template v-else>
                  <chat v-for="(item,index) in chatlist.children" :key="index" :chatlist="item" :activeindex="`${activeindex}-${index}`" @change="ChatChange" :showstatus="showstatus" :responsible_person_list="responsible_person_list"></chat>
              </template> -->
            </div>
        </div>
      </li>
    </ul> 
    <!-- <div v-if="activeindex.length > 1 && activeindex.length <= 3" class="link_list flex align-center">
      <el-link type="primary" :underline="false">{{chatlist.userinfo.username}}</el-link>
      <div class="title">等人</div>
      <el-link type="primary" :underline="false"> 更多回复 <el-icon class="el-icon-arrow-right"></el-icon></el-link>
    </div> -->
    <comment-box
     :dialogVisible="dialogVisible"
     ref="comment_box"
     @CommenClose="CommenClose"
     :responsible_person_list="responsible_person_list"
    >
    </comment-box>
</template>
<script>
import { getLocalTime, isNaLL } from '@/utils/utils'
import { reactive, toRefs, watch,ref } from 'vue'
import CommentBox from './CommentBox.vue'
import { DeleteTransaction } from '@/api/transaction.js'
import { shoElmessage } from '../../../../utils/Elmessage'
export default {
  components: { CommentBox },
  emits:['change'],
  props:{
    chatlist:{
      type:[Array,Object],
      default:{}
    },
    activeindex:{
      type:String,
      default:""
    },
    showstatus:{
      type:Boolean,
      default:false,
    },
    responsible_person_list:{
      type:[Array,Object],
      default:[]
    }
  },
  setup(props,content){
    const comment_box = ref(null);
    watch(() => props.activeindex,(val) =>{
      console.log(val)
    })
    const datas = reactive({
      dialogVisible:false,
    })
    //标题
    function Commit(item){
      datas.dialogVisible  = true;
      comment_box.value.Init(item);
    }
    //关闭弹出框
    function CommenClose(){
      datas.dialogVisible = false
      content.emit('change')
    }
    function DeleteCommit(item){
      DeleteTransaction({
        transaction_ids:item.id
      }).then(res =>{
        if(res.code == 1){
          content.emit('change')
          shoElmessage(true,'删除成功')
        }else{
          shoElmessage(true,'删除失败')
        }
      })
    }
    function ChatChange(){
      content.emit('change')
    }
    function Getstatus(item){
      let l_status = '';
      if(item.length > 2 || item.length < 3){
        l_status = Number(item.charAt(item.length-1))
      }
      if(item.length < 1 || l_status < 1){
          return true
      }else{
          return false
      }
      
    }
    return {
      ...toRefs(datas),
      getLocalTime,
      isNaLL,
      Commit,
      comment_box,
      CommenClose,
      DeleteCommit,
      ChatChange,
      Getstatus
    }
  }
}
</script>
<style lang="scss" scoped>
.link_list{
  background-color: rgb(246,246,246);
  padding: 0px 10px;
  .title{
    padding: 0px 10px;
    color: #939393;
  }
}
.explanation_title{
    display: flex;
    align-items: center;
    justify-content: space-between;
    .explanation_dropdown{
      cursor: pointer;
      .el-dropdown-link{
        color: #409EFF;
      }
    }
}
//聊天

  ul{
    list-style: none;
    padding: 0px;
    li{
      margin-top: 10px;
      &:first-child{
        margin-top: 0px;
      }
    }
  }
  
  .explanation{
    margin-top: 10px;
    .explanation_list{
      .explanation_list--header{
        padding-top: 5px;
      }
      .explanation_list--content{
        width: 100%;
        cursor: pointer;
        background-color: #fff;
        margin:0px 20px;
        padding: 5px 10px;
        border-radius: 5px;
        .explanation_list_content--title{
          font-weight: bold;
        }
        .explanation_list_content--username{
          justify-content: space-between;
          height: 30px;
          line-height: 30px;
          .explanation_list_content--icon{
              display: none;
              .el-icon-edit-outline{
                color: #409EFF;
                margin: 0px 5px;
              }
              .el-icon-delete-solid{
                color: #f56c6c;
              }
              & > [class^="el-icon"]{
                color: #939393;
                font-size: 16px;
              }
          }
          
          &:hover{
            .explanation_list_content--icon{
                display: block;
            }
          }
          
        }
        .explanation_list_content--text{
          text-align: left;
        }
        .explanation_list_content--text:hover + .explanation_list_content--username{
              background-color: #409EFF;
            .explanation_list_content--icon{
              display: block;
            }
          }
        .explanation_list_content--imagse{
          width: 200px;
          height: 200px;
          margin-top: 10px;
          img{
            width: 100%;
            height: auto;
          }
        }
        .explanation_list--operating{
          width: 100%;
          display: flex;
          justify-content: flex-end;
          align-items: center;
          padding: 10px 0px;
          .date{
            margin-right: 10px;
          }
          .like{
            display: flex;
            align-items: center;
            margin:0 2px;
            span{
               margin:0 2px;
            }
          }
          .commit{
            display: flex;
            align-items: center;
            margin:0 2px;
            span{
               margin:0 2px;
               color: #939393;
            }
          }
        }
        .explanation_list--content{
          margin: 0px;
          padding: 0px 0px 0px 10px;
        }
        
      }
    }
  }

</style>