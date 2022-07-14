<template>
  <div class="image--main">
      <div class="" v-if="Imglist.length < 0"></div>
      <div class="image-selector__image-list" v-else>
      <li class="image-selector__thumbnail" v-for="(item,index) in data.imglist" :key="index" >
          <div data-v-388ab104="" data-v-3ed78d14="" class="product-image" :class="{'product-image--is-selected':item.is_choice == '1'}" @click="Imgclick(item,index)">
              <div data-v-388ab104="" class="product-image__corner-marker">
                  <span data-v-388ab104="" class="product-image__status-icon"></span>
                  </div> 
                  <div data-v-388ab104="" class="product-image__overlay">
                      <div data-v-388ab104="" class="product-image__actions">
                          <i class="el-icon-view"></i>
                     </div>
                </div> 
            <img :src="item.src" alt="product image" class="product-image__img">
        </div>
      </li>
    </div>
  </div>
</template>

<script>
import { reactive,onMounted } from 'vue'
import { updateImageStatus } from '../../../api/Orderlist';
import { shoElmessage } from '../../../utils/Elmessage';
export default {
    props:{
        Imglist:{
            type:[Array],
            default:[]
        }
    },
    mounted(){
        this.Mounted();
    },
    setup(props,context){
        const data = reactive({
             imglist:props.Imglist
        })
        function Mounted(){
            data.imglist.forEach(element => {
                element.imgstatus = false
            });
            console.log(data.imglist);
        }
        function Imgclick(item,index){
            let is_choice = 0
            if(item.is_choice == 0){
               is_choice = 1
            }
            updateImageStatus({
                image_id:item.id,
                status:is_choice
            }).then(res =>{
                if(res.code == 1){
                    shoElmessage(true,'修改成功')
                }else{
                    shoElmessage(true,`提交失败，原因${res.msg}`,'error')
                }
            })
            data.imglist[index].is_choice = is_choice
        }
        return {
            Imgclick,
            data,
            Mounted
        }
    }
}
</script>

<style lang="scss" scoped>
    .image--main{
        overflow-y: auto;
        max-height: 550px;
        min-height: 300px;
        overflow-x: hidden;
        padding: 16px 24px 24px 24px;
    }
    .image-selector__image-list{
        list-style: none;
        display: grid;
        grid-template-rows: 177px 177px;
        grid-auto-flow: row;
        grid-template-columns: repeat(auto-fill, 177px);
        grid-column-gap: 8px;
        grid-row-gap: 8px;
        padding: 0;

    }
    .image-selector__thumbnail:first-child{
        grid-column: 1/3;
        grid-row: 1/3;
        height: auto;
    }
    .image-selector__thumbnail{
        overflow: hidden;
        position: relative;
        transform: translateZ(0);
        height: 177px;
    }
    .product-image{
        background: #ededf2;
        border-radius: 4px;
        height: 100%;
        overflow: hidden;
        overflow: hidden;
        position: relative;
        width: 100%;
        display: flex;
        cursor: pointer;
    }
    .product-image__img{
        max-width: 100%;
        height: auto;
        display: inline-flex;
        align-self: center;
    }
    .product-image__corner-marker{
        cursor: pointer;
        transition: transform .5s cubic-bezier(0.65, 0.05, 0.36, 1);
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        z-index: 11;
        border-style: solid;
        border-color: #5ba137 transparent transparent;
        border-width: 80px 80px 0 0;
    }
    .product-image--is-selected.product-image .product-image__corner-marker {
        transform: translate(-15px, -15px);
    }
    // .product-image__overlay {
    //     transition: background-color .5s cubic-bezier(0.65, 0.05, 0.36, 1);
    //     background-color: rgba(98,98,141,0);
    //     width: 100%;
    //     height: 100%;
    //     top: 0;
    //     left: 0;
    //     position: absolute;
    //     z-index: 11111111;
    // }
    .product-image__actions{
        // transition: transform .5s cubic-bezier(0.65, 0.05, 0.36, 1);
        // transform: translateY(-100px);
        // position: absolute;
        // top: 0;
        // left: 0;
        // width: 100%;
        // padding: 8px;
        i{
                background: transparent;
                float: right;
                width: 20px;
                height: 20px;
                box-shadow: none;
                cursor: pointer;
                padding: 0;
                margin: 0 0 0 8px;
                border: 0;
                -webkit-appearance: none;
                outline: none;
                color: #fff;
        }
    }
    *:before, *:after {
        box-sizing: border-box;
    }
    .product-image{background:#ededf2;border-radius:4px;height:100%;overflow:hidden;overflow:hidden;position:relative;width:100%;display:flex}
    .product-image:hover .product-image__overlay{background-color:rgba(98,98,141,.5)}
    .product-image:hover .product-image__actions{transform:translateY(0)}
    .product-image:hover .product-image__corner-marker{transform:translate(-15px, -15px)}
    .product-image--is-selected.product-image::after{border-color:#5ba137}
    .product-image--is-selected.product-image .product-image__corner-marker{transform:translate(-15px, -15px)}
    .product-image--is-selected.product-image .product-image__status-icon::after{transform:rotate(315deg) translate(3px, 2px)}
    .product-image--is-selected.product-image .product-image__status-icon::before{transform:rotate(45deg) scale(0.5, 1) translate(-4px, 3px)}
    .product-image--is-selected .product-image__corner-marker:hover .product-image__status-icon::before,
    .product-image--is-selected .product-image__corner-marker:hover .product-image__status-icon::after{transform:rotate(0deg)}
    .product-image::after{transition:border-color .5s cubic-bezier(0.65, 0.05, 0.36, 1);content:"";height:100%;left:0;pointer-events:none;position:absolute;top:0;width:100%;border-radius:4px;border:4px solid transparent}
    .product-image__corner-marker{cursor:pointer;transition:transform .5s cubic-bezier(0.65, 0.05, 0.36, 1);position:absolute;display:block;top:0;left:0;z-index:11;border-style:solid;border-color:#5ba137 transparent transparent;border-width:80px 80px 0 0;transform:translate(-50px, -50px)}
    .product-image__status-icon{display:block;position:relative}
    .product-image__status-icon::before,.product-image__status-icon::after{top:-51px;left:23px;transform-origin:center;transition:transform .2s ease;content:"";background:#fff;width:15px;height:3px;position:absolute;border-radius:5px}
    .product-image__status-icon::after{transform:rotate(90deg)}
    .product-image__img{max-width:100%;height:auto;display:inline-flex;align-self:center}
    .product-image__overlay{transition:background-color .5s cubic-bezier(0.65, 0.05, 0.36, 1);background-color:rgba(98,98,141,0);width:100%;height:100%;top:0;left:0;position:absolute}
    .product-image__actions{transition:transform .5s cubic-bezier(0.65, 0.05, 0.36, 1);transform: translateY(-100px);position:absolute;top:0;left:0;width:100%;padding:8px;box-sizing: border-box;}
    .product-image__loader{width:100%;height:100%;transform-origin:center;align-items:center;justify-content:center}
    .product-image__loader svg{height:15%}
    .slider-overlay__button{height:40px;width:40px}.slider-overlay__button svg{height:40px;width:40px;fill:#d0d0de}.slider-overlay__button:hover svg{fill:#ededf2}
</style>