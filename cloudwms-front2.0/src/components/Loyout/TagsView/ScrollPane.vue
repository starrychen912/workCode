<template>
  <el-scrollbar ref="scrollContainer" :vertical="false" class="scroll-container" :always="l_r_btn_status">
    <slot />
  </el-scrollbar>
</template>

<script>
const tagAndTagSpacing = 4 // tagAndTagSpacing

export default {
  name: 'ScrollPane',
  data() {
    return {
      left: 0,
      l_r_btn_status:false,
    }
  },
  computed: {
    scrollWrapper() {
      // console.log(this.$refs.scrollContainer.$refs.wrap.scrollWidth)
      return this.$refs.scrollContainer.$refs.wrap
    },

  },
  mounted() {
    this.scrollWrapper.addEventListener('scroll', this.emitScroll, true)
  },
  beforeDestroy() {
    this.scrollWrapper.removeEventListener('scroll', this.emitScroll)
  },
  methods: {
    handleScroll(e) {
      const eventDelta = e.wheelDelta || -e.deltaY * 40
      const $scrollWrapper = this.scrollWrapper
    },
    emitScroll() {
      this.$emit('scroll')
    },

    ScrollMove(item){
      const $scrollWrapper = this.scrollWrapper
      if(item == 'right'){
          $scrollWrapper.scrollLeft = $scrollWrapper.scrollLeft+200
          
      }else{
          $scrollWrapper.scrollLeft = $scrollWrapper.scrollLeft-200
      }
    },
    btn_L_R_Stauts(){

      const $container = this.$refs.scrollContainer.$el
      const $containerWidth = $container.offsetWidth
      const $scrollWrapper = this.scrollWrapper

      if($scrollWrapper.scrollWidth > $containerWidth+30){
        this.l_r_btn_status = true
        this.$emit('About',this.l_r_btn_status)
      }else{
        this.l_r_btn_status = false
        this.$emit('About',this.l_r_btn_status)
      }
      
    },
    moveToTarget2(domlist,event,index){
      
      const $container = this.$refs.scrollContainer.$el
      const $containerWidth = $container.offsetWidth
      const $scrollWrapper = this.scrollWrapper

      this.btn_L_R_Stauts();

      if(index == 0){
        
        $scrollWrapper.scrollLeft = 0

      }else if(index == domlist.length -1 ){

          $scrollWrapper.scrollLeft = ($scrollWrapper.scrollWidth - $containerWidth + 60)

      }else{
          const currentIndex = index

          const prevDom = domlist[currentIndex - 1]
          const nextDom = domlist[currentIndex + 1]

          //下一个位置
          const nextDomOffsetleft = (nextDom.offsetLeft + nextDom.offsetWidth + 60)

          //上一个位置
          const prevDomOffsetLeFT = prevDom.offsetLeft - 30
          // console.log(nextDomOffsetleft,prevDomOffsetLeFT,$scrollWrapper.scrollWidth,$scrollWrapper.scrollLeft)

          if(nextDomOffsetleft > $scrollWrapper.scrollLeft + $containerWidth){

             $scrollWrapper.scrollLeft = nextDomOffsetleft - $containerWidth

          }else if(prevDomOffsetLeFT < $scrollWrapper.scrollLeft){

              $scrollWrapper.scrollLeft = prevDomOffsetLeFT

          }

      }
    },

    moveToTarget(currentTag,tagList) {
      const $container = this.$refs.scrollContainer.$el
      // console.log($container);
      const $containerWidth = $container.offsetWidth
      const $scrollWrapper = this.scrollWrapper
      // console.log($scrollWrapper);
      // const tagList = this.$parent.$refs.tag

      let firstTag = null
      let lastTag = null

      // find first tag and last tag
      if (tagList.length > 0) {
        firstTag = tagList[0]
        lastTag = tagList[tagList.length - 1]
      }

      if (firstTag === currentTag) {
        $scrollWrapper.scrollLeft = 0
      } else if (lastTag === currentTag) {
        $scrollWrapper.scrollLeft = $scrollWrapper.scrollWidth - $containerWidth
      } else {
        console.log(123123)
        // find preTag and nextTag
        const currentIndex = tagList.findIndex(item => item === currentTag)
        const prevTag = tagList[currentIndex - 1]
        const nextTag = tagList[currentIndex + 1]

        // the tag's offsetLeft after of nextTag
        const afterNextTagOffsetLeft = nextTag.$el.offsetLeft + nextTag.$el.offsetWidth + tagAndTagSpacing

        // the tag's offsetLeft before of prevTag
        const beforePrevTagOffsetLeft = prevTag.$el.offsetLeft - tagAndTagSpacing

        if (afterNextTagOffsetLeft > $scrollWrapper.scrollLeft + $containerWidth) {
          $scrollWrapper.scrollLeft = afterNextTagOffsetLeft - $containerWidth

        } else if (beforePrevTagOffsetLeft < $scrollWrapper.scrollLeft) {

          $scrollWrapper.scrollLeft = beforePrevTagOffsetLeft
        }
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.scroll-container {
  white-space: nowrap;
  position: relative;
  overflow: hidden;
  width: 100%;
  :deep(.el-scrollbar__bar) {
      bottom: 0px;
    }
  :deep(.el-scrollbar__view){
    height: 100%;
    display: flex;
  }
}
</style>
