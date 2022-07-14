<template>
  <div id="tags-view-container" class="tags-view-container">
    <scroll-pane ref="scrollPane" class="tags-view-wrapper flex" @scroll="handleScroll" @About="About" :class="{'tags-view-wrapper--right':abouts}">
      <a class="btn_left" v-if="abouts" @click="BtnMove('left')"><i class="el-icon-arrow-left"></i></a>
      <a class="btn_right" v-if="abouts" @click="BtnMove('right')"><i class="el-icon-arrow-right"></i></a>
      <router-link
        v-for="(item,index) in visitedViews"
        :to="{path:item.path,query:item.query}"
        tag="span"
        class="tags-view-item"
        :key="item.path"
        :class="{'active':Active === item.path,'left_active':index == 0 && abouts,'right_active':index== visitedViews.length-1 && abouts,'light':theme == 'light'}"
        :ref="`tag${index}`"
      >
      {{item.meta.title}}
        <span v-if="!isAffix(item)" class="el-icon-close"  @click.prevent.stop="closeSelectedTag(item)" />
      </router-link>
    </scroll-pane>
    <!-- <ul  :style="{left:left+'px',top:top+'px'}" class="contextmenu">
      <li @click="refreshSelectedTag(selectedTag)">Refresh</li>
      <li v-if="!isAffix(selectedTag)" @click="closeSelectedTag(selectedTag)">Close</li>
      <li @click="closeOthersTags">Close Others</li>
      <li @click="closeAllTags(selectedTag)">Close All</li>
    </ul> -->
  </div>
</template>

<script>
import ScrollPane from './ScrollPane.vue'
import { computed, reactive,ref ,nextTick, toRefs} from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
export default {
  components: { ScrollPane },
  data() {
    return {
      visible: false,
      top: 0,
      left: 0,
      selectedTag: {},
      affixTags: [],
      Domlist:[],
      abouts:false,
    }
  },
  setup(props,content){
    const store = useStore();
    const router = useRouter();
    const data = reactive({
      theme:computed(() => store.state.setting.theme),
    })
    return{
      Active:computed(() =>  {
        return router.currentRoute.value.path
      }),
      ...toRefs(data),
      
    }
  },
  computed: {
    visitedViews() {
      return this.$store.state.tagsView.visitedViews
    },
    // routes() {
    //   return this.$store.state.permission.routes
    // }
  },
  watch: {
    $route() {
      this.addTags()
      this.moveToCurrentTag()
    },
    // visible(value) {
    //   if (value) {
    //     document.body.addEventListener('click', this.closeMenu)
    //   } else {
    //     document.body.removeEventListener('click', this.closeMenu)
    //   }
    // }
  },
  mounted() {
    //初始化
    this.initTags()
    //刷新防止当前路由被代替掉
    this.addTags()
    // let root = document.querySelector(':root')
    // root.style.setProperty('--background-bg-color','red')

    // this.$refs.scrollPane.moveToTarget()
  },
  methods: {
    BtnMove(item){
      this.$refs.scrollPane.ScrollMove(item)
    },
    About(e){
      this.abouts = e
    },
    SetRef(e){
      if(this.Domlist.indexOf(e) == -1){
          this.Domlist.push(e)
      }
    },
    isActive(route) {
      return route.path === this.$route.path
    },

    isAffix(tag) {
      return tag.meta && tag.meta.affix
    },
    //过滤一开始默认tag
    filterAffixTags(routes = [], basePath = '/') {
      let tags = []
      routes.forEach(route => {
        if (route.meta && route.meta.affix) {
          const tagPath = basePath + '/' + route.path
          tags.push({
            fullPath: tagPath,
            path: tagPath,
            name: route.name,
            meta: { ...route.meta }
          })
        }
        if (route.children) {
          const tempTags = this.filterAffixTags(route.children, route.path)
          if (tempTags.length >= 1) {
              tags = [...tags, ...tempTags]
          }
        }
      })
      return tags
    },

    //初始化Tags
    initTags() {
      const routes  = this.$store.state.permission.routes
      const affixTags = this.affixTags = this.filterAffixTags(routes)
      for (const tag of affixTags) {
        if (tag.name) {
            this.$store.dispatch('tagsView/addVisitedView', tag)
        }
      }
    },

    //添加Tags
    addTags() {
      const { name } = this.$route
      if(this.$route.meta && this.$route.meta.showmenu){
        return ;
      }
      if (name) {
        this.$store.dispatch('tagsView/addView', this.$route)
      }
      return false
    },

    moveToCurrentTag() {
      let list = document.getElementsByClassName('tags-view-item')
      let index = null;
      let event = null;
      this.$nextTick(() =>{
        for(let i=0;i<list.length;i++){
          if(list[i].pathname == this.$route.path){
              event = list[i]
              index = i
              this.$refs.scrollPane.moveToTarget2(list,event,index)
          }
        }
      })
      // console.log(domlist);
      // const tags = this.$refs.tag
      //  console.log(tags);
      //   this.$nextTick(() => {
      //   let list =  document.getElementsByClassName('tags-view-item')
      //   let that = this
      //   for (const tag of list) {
      //     if (tag.pathname === this.$route.path) {
      //       console.log();
      //       that.$refs.scrollPane.moveToTarget(tag)
      //       // when query is different then update
      //       // if (tag.to.fullPath !== this.$route.fullPath) {
      //       //   this.$store.dispatch('tagsView/updateVisitedView', this.$route)
      //       // }
      //       break
      //     }
      //   }
      // })
    },
    refreshSelectedTag(view) {
      this.$store.dispatch('tagsView/delCachedView', view).then(() => {
        const { fullPath } = view
        this.$nextTick(() => {
          this.$router.replace({
            path: '/redirect' + fullPath
          })
        })
      })
    },

    closeSelectedTag(item) {
      this.$store.dispatch('tagsView/delView', item).then(({ visitedViews }) => {
        if (this.isActive(item)) {
          this.toLastView(visitedViews, item)
        }
        this.$nextTick(() =>{
          this.$refs.scrollPane.btn_L_R_Stauts();
        })
      })
    },

    closeOthersTags() {
      this.$router.push(this.selectedTag)
      this.$store.dispatch('tagsView/delOthersViews', this.selectedTag).then(() => {
        this.moveToCurrentTag()
      })
    },

    closeAllTags(view) {
      this.$store.dispatch('tagsView/delAllViews').then(({ visitedViews }) => {
        if (this.affixTags.some(tag => tag.path === view.path)) {
          return
        }
        this.toLastView(visitedViews, view)
      })
    },

    toLastView(visitedViews, view) {
      const latestView = visitedViews.slice(-1)[0]
      if (latestView) {
        this.$router.push(latestView.fullPath)
      } else {
        // now the default is to redirect to the home page if there is no tags-view,
        // you can adjust it according to your needs.
        if (view.name === 'Dashboard') {
          // to reload home page
          this.$router.replace({ path: '/redirect' + view.fullPath })
        } else {
          this.$router.push('/')
        }
      }
    },

    openMenu(tag, e) {
      const menuMinWidth = 105
      const offsetLeft = this.$el.getBoundingClientRect().left // container margin left
      const offsetWidth = this.$el.offsetWidth // container width
      const maxLeft = offsetWidth - menuMinWidth // left boundary
      const left = e.clientX - offsetLeft + 15 // 15: margin right

      if (left > maxLeft) {
        this.left = maxLeft
      } else {
        this.left = left
      }

      this.top = e.clientY
      this.visible = true
      this.selectedTag = tag
    },
    closeMenu() {
      this.visible = false
    },
    handleScroll() {
      this.closeMenu()
    }
  }
}
</script>

<style lang="scss" scoped>
.tags-view-container {
  height: 55px;
  width: 100%;
  padding: var(--el-header-padding);
  .tags-view-wrapper--right{
    padding-right: 20px;
  }
  .tags-view-wrapper {
    
    .btn_left{
      position: absolute;
      cursor: pointer;
      left: 0px;
      z-index: 111;
      height: 100%;
      background-color: #fff;
      display: flex;
      align-items: center;
      i{
        font-weight: bold;
        font-size: 20px;
      }
    }
    .btn_right{
      position: absolute;
      right: 0px;
      // top: calc(50% - 11px);
      cursor: pointer;
      z-index: 111;
      height: 100%;
      background-color: #fff;
      display: flex;
      align-items: center;
      padding-top:-10px;
      i{
        font-weight: bold;
        font-size: 20px;
      }
    }
    .left_active{
      margin-left:15px;
    }

    .tags-view-item{
      display: inline-block;
      position: relative;
      cursor: pointer;
      height: 55px;
      display: flex;
      align-items: center;
      color: #495060;
      background: #fff;
      padding: 0 15px;
      font-size: 14px;
      // &:first-of-type{
      //   margin-left: 15px;
      // }
      // &:last-of-type{
      //   margin-right: 30px;
      // }
      &::before{
        width: 60%;
        height: 3px;
        content: '';
        background: var(--sidebar-active-background-color);
        position: absolute;
        left: calc(50% - 30%);
        bottom: 5px;
        border-radius: 10px;
        transform: scale(0.00001);
        transition: all .2s;
      }
      &.active {
        // background-color:  $color-bg;
        color: var(--sidebar-active-background-color);
        border-color:  $color-bg;
        &::before{
          width: 60%;
          height: 3px;
          content: '';
          background: var(--sidebar-active-background-color);
          position: absolute;
          left: calc(50% - 30%);
          bottom: 20%;
          border-radius: 10px;
          animation: Tagsview .2s;
          transform: scale(1);
        }
        &.light{
          
          &.active {
            color: var(--nav_is-active_color,#409eff);
            &::before{
              background: var(--nav_is-active_color,#409eff);
            }
          }
        }
      }
    }
  }
  @keyframes Tagsview {
    0%{
      width: 0%;
    }
  }
  .contextmenu {
    margin: 0;
    background: #fff;
    z-index: 3000;
    position: absolute;
    list-style-type: none;
    padding: 5px 0;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 400;
    color: #333;
    box-shadow: 2px 2px 3px 0 rgba(0, 0, 0, .3);
    li {
      margin: 0;
      padding: 7px 16px;
      cursor: pointer;
      &:hover {
        background: #eee;
      }
    }
  }
}
</style>

<style lang="scss">
//reset element css of el-icon-close
.tags-view-wrapper {
  .tags-view-item {
    position: relative;
    .el-icon-close {
      display: none;
      width: 16px;
      height: 16px;
      vertical-align: 2px;
      border-radius: 50%;
      text-align: center;
      transition: all .3s cubic-bezier(.645, .045, .355, 1);
      transform-origin: 100% 50%;
      position: absolute;
      top: calc(50% - 8px);
      right: 0px;
      &:before {
        transform: scale(.6);
        display: inline-block;
        vertical-align: -2px;
      }
      &:hover {
        background-color: #b4bccc;
        color: #fff;
      }
    }
    &:hover{
      .el-icon-close {
        display: block;
      }
    }
  }
}
</style>
