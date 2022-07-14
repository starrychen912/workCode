<template>
   <div class="navigation" data-v-33068c4e="">
        <div class="navigation-logo">
            <i class="fold-btn"  :class="[Icon,!data.collapse?'fold-collapse':'hide-collapse']"  data-v-33068c4e="" @click="FoldBtn" v-if="mode === 'PC'"></i>
            <i class="fold-btn"  :class="Icons"  data-v-33068c4e="" @click="FoldBtns" v-else></i>
        </div>
        <div>
            <breadcrumb></breadcrumb>
        </div>
        <slot name="slot"></slot>
    </div>
</template>

<script>
import { computed, reactive } from 'vue'
import { useStore } from 'vuex';
import Breadcrumb from '../../Breadcrumb/index.vue';
export default {
    components:{
        Breadcrumb
    },
    name: "SidebarLogo",
    props: {
        Icon: {
            type: String,
            default: "el-icon-s-fold"
        },
        Icons: {
            type: String,
            default: "el-icon-menu"
        },
        LogoName: {
            type: String,
            default: "首页"
        }
    },
    setup(props, context) {
        const store = useStore();
        let data = reactive({
            Icon: props.Icon,
            LogoName: props.LogoName,
            collapse: computed(() => store.state.setting.collapse)
        });
        function FoldBtns() {
            store.commit("setting/SAVE_SETTINGS", {
                collapse: !store.state.setting.collapse
            });
        }
        function FoldBtn() {
            context.emit("FoldBtn", data);
        }
        return {
            data,
            FoldBtn,
            FoldBtns,
            mode: computed(() => store.state.setting.device.mode)
        };
    },
    components: { Breadcrumb }
}
</script>

<style lang="scss" scoped>
    .navigation{
        h1{
            margin: 0px;
            font-size: 18px;
        }
    }
    .fold-collapse{
        transform: rotate(180deg);
        transition: all 0.5s;
    }
    .hide-collapse{
        transform: rotate(360deg);
        transition: all 0.5s;
    }
    .navigation-logo{
        padding: 20px;
        padding-left: 0px;
    }
</style>