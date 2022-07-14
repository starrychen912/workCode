<template>
  <el-container>
     <el-header>
        <sidebar ></sidebar>
     </el-header>
     <el-main>
         <el-card>
          <div class="empty">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="40" height="40" preserveAspectRatio="xMidYMid meet" >
             <defs>
              <clipPath id="__lottie_element_190"><rect width="30" height="30" x="0" y="0"></rect></clipPath>
              <filter id="__lottie_element_195" filterUnits="objectBoundingBox" x="0%" y="0%" width="100%" height="100%">
                <feComponentTransfer in="SourceGraphic"><feFuncA type="table" tableValues="1.0 0.0"></feFuncA></feComponentTransfer>
              </filter><mask id="__lottie_element_194" mask-type="alpha"><g filter="url(#__lottie_element_195)">
                <rect width="30" height="30" x="0" y="0" fill="#ffffff" opacity="0"></rect>
                <g transform="matrix(1,0,0,1,0,0)" opacity="1" style="display: block;">
                <g opacity="1" transform="matrix(1,0,0,1,15,14.5)"><path fill="rgb(198,207,216)" fill-opacity="1" d=" M10,7.5 C10,7.5 9.92300033569336,7.5 9.92300033569336,7.5 C8.404999732971191,5.370999813079834 8,2.4790000915527344 8,0.8939999938011169 C8,0.8939999938011169 8,-1.5 8,-1.5 C8,-5.918000221252441 4.418000221252441,-9.5 0,-9.5 C-4.418000221252441,-9.5 -8,-5.918000221252441 -8,-1.5 C-8,-1.5 -8,0.8939999938011169 -8,0.8939999938011169 C-8,2.4790000915527344 -8.774999618530273,5.60699987411499 -9.925000190734863,7.5 C-9.925000190734863,7.5 -10,7.5 -10,7.5 C-10.552000045776367,7.5 -11,7.947000026702881 -11,8.5 C-11,9.053000450134277 -10.489999771118164,9.312999725341797 -9.937999725341797,9.312999725341797 C-9.937999725341797,9.312999725341797 10.062999725341797,9.312999725341797 10.062999725341797,9.312999725341797 C10.616000175476074,9.312999725341797 11,9.053000450134277 11,8.5 C11,7.947000026702881 10.553000450134277,7.5 10,7.5z"></path></g></g></g></mask></defs><g clip-path="url(#__lottie_element_190)">
                <g mask="url(#__lottie_element_194)" style="display: block;">
                <g transform="matrix(1,0,0,1,11.75,21.750999450683594)" opacity="1">
                <g opacity="1" transform="matrix(1,0,0,1,3.25,3.25)">
                    <path fill="rgb(198,207,216)" fill-opacity="1" d=" M0,-3 C-1.656999945640564,-3 -3,-1.656999945640564 -3,0 C-3,1.656999945640564 -1.656999945640564,3 0,3 C1.656999945640564,3 3,1.656999945640564 3,0 C3,-1.656999945640564 1.656999945640564,-3 0,-3z"></path>
                </g></g></g><g transform="matrix(1,0,0,1,0,0)" opacity="1" style="display: block;transform: matrix(0.98, 0, 0, 1, 0, 0);"><g opacity="1" transform="matrix(1,0,0,1,15,11.5)"><path fill="rgb(198,207,216)" fill-opacity="1" d=" M8,3.8940000534057617 C8,3.8940000534057617 8,1.5 8,1.5 C8,-2.2260000705718994 5.447999954223633,-5.3480000495910645 2,-6.23799991607666 C2,-6.23799991607666 2,-6.5 2,-6.5 C2,-7.605000019073486 1.1050000190734863,-8.5 0,-8.5 C-1.1050000190734863,-8.5 -2,-7.605000019073486 -2,-6.5 C-2,-6.5 -2,-6.23799991607666 -2,-6.23799991607666 C-5.447999954223633,-5.3480000495910645 -8,-2.2260000705718994 -8,1.5 C-8,1.5 -8,3.8940000534057617 -8,3.8940000534057617 C-8,5.484000205993652 -8.326000213623047,7.046999931335449 -8.9350004196167,8.5 C-8.9350004196167,8.5 8.9350004196167,8.5 8.9350004196167,8.5 C8.326000213623047,7.047999858856201 8,5.484000205993652 8,3.8940000534057617z"></path></g><g opacity="1" transform="matrix(1,0,0,1,15,23)"><path fill="rgb(198,207,216)" fill-opacity="1" d=" M10,-1 C10,-1 -10,-1 -10,-1 C-10.552000045776367,-1 -11,-0.5529999732971191 -11,0 C-11,0.5529999732971191 -10.552000045776367,1 -10,1 C-10,1 10,1 10,1 C10.553000450134277,1 11,0.5529999732971191 11,0 C11,-0.5529999732971191 10.553000450134277,-1 10,-1z"></path></g></g></g></svg>
                <div class="your--notification">Your Notification List is Empty</div>
                <div class="we--till-notify">We will notify you about changes to product(s) availability or price</div>
             </div>
         </el-card>
     </el-main>
  </el-container>
</template>

<script>

import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
export default {
  components:{
    Sidebar
  }
}
</script>

<style lang="scss" scoped>
.el-header{
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
}
:deep(.el-card__body){
  height: calc(100vh - 150px);
  // vertical-align: middle;
}
.empty{
  width: 100%;
  height: 100%;
  text-align: center;
  margin-top: calc(100vh - 75vh);
    svg{
       width: 200px;
       height: 200px;
       background-color: #fff;
    }
}
.your--notification{
    font-size: 19px;
    font-weight: bold;
    text-align: center;
}
.we--till-notify{
  font-size: 15px;
  font-weight: bold;
  text-align: center;
  color: #6f6f91;
}
</style>