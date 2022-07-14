<template>
  <BasicModal ref="modalRef" destroyOnClose wrapClassName="j-cgform-tab-modal" v-bind="$attrs" @register="registerModal" :width="800" @ok="handleSubmit">
  <!-- 子表单区域 -->
    <a-tabs v-model:activeKey="activeKey" @change="handleChangeTabs">
     <!--主表区域 -->
     <a-tab-pane tab="产品研发" :key="refKeys[0]" :forceRender="true" :style="tabsStyle">
       <BasicForm @register="registerForm" ref="formRef"/>
     </a-tab-pane>
  <!--子表单区域 -->
      <a-tab-pane tab="产品研发竞品" key="wmsProductCompetitive" :forceRender="true" :style="tabsStyle">
        <JVxeTable
          keep-source
          resizable
          ref="wmsProductCompetitive"
          :loading="wmsProductCompetitiveTable.loading"
          :columns="wmsProductCompetitiveTable.columns"
          :dataSource="wmsProductCompetitiveTable.dataSource"
          :height="340"
          :disabled="formDisabled"
          :rowNumber="true"
          :rowSelection="true"
          :toolbar="true"
          />
      </a-tab-pane>
      <a-tab-pane tab="产品关联" key="wmsProductRelation" :forceRender="true" :style="tabsStyle">
        <JVxeTable
          keep-source
          resizable
          ref="wmsProductRelation"
          :loading="wmsProductRelationTable.loading"
          :columns="wmsProductRelationTable.columns"
          :dataSource="wmsProductRelationTable.dataSource"
          :height="340"
          :disabled="formDisabled"
          :rowNumber="true"
          :rowSelection="true"
          :toolbar="true"
          />
      </a-tab-pane>
    </a-tabs>
  </BasicModal>
</template>

<script lang="ts" setup>
    import {ref, computed, unref,reactive} from 'vue';
    import {BasicModal, useModalInner} from '/@/components/Modal';
    import {BasicForm, useForm} from '/@/components/Form/index';
    import { JVxeTable } from '/@/components/jeecg/JVxeTable'
    import { useJvxeMethod } from '/@/hooks/system/useJvxeMethods.ts'
    import {formSchema,wmsProductCompetitiveColumns,wmsProductRelationColumns} from '../WmsProductDevelopment.data';
    import {saveOrUpdate,wmsProductCompetitiveList,wmsProductRelationList} from '../WmsProductDevelopment.api';
    import { VALIDATE_FAILED } from '/@/utils/common/vxeUtils'
    // Emits声明
    const emit = defineEmits(['register','success']);
    const isUpdate = ref(true);
    const formDisabled = ref(false);
    const modalRef = ref();
    const refKeys = ref(['wmsProductDevelopment','wmsProductCompetitive', 'wmsProductRelation', ]);
    const activeKey = ref('wmsProductDevelopment');
    const wmsProductCompetitive = ref();
    const wmsProductRelation = ref();
    const tableRefs = {wmsProductCompetitive, wmsProductRelation, };
    const wmsProductCompetitiveTable = reactive({
          loading: false,
          dataSource: [],
          columns:wmsProductCompetitiveColumns
    })
    const wmsProductRelationTable = reactive({
          loading: false,
          dataSource: [],
          columns:wmsProductRelationColumns
    })
    //表单配置
    const [registerForm, {setProps,resetFields, setFieldsValue, validate}] = useForm({
        labelWidth: 150,
        schemas: formSchema,
        showActionButtonGroup: false,
        baseColProps: {span: 24}
    });
     //表单赋值
    const [registerModal, {setModalProps, closeModal}] = useModalInner(async (data) => {
        //重置表单
        await reset();
        setModalProps({confirmLoading: false,showCancelBtn:data?.showFooter,showOkBtn:data?.showFooter});
        isUpdate.value = !!data?.isUpdate;
        formDisabled.value = !data?.showFooter;
        if (unref(isUpdate)) {
            //表单赋值
            await setFieldsValue({
                ...data.record,
            });
             requestSubTableData(wmsProductCompetitiveList, {id:data?.record?.id}, wmsProductCompetitiveTable)
             requestSubTableData(wmsProductRelationList, {id:data?.record?.id}, wmsProductRelationTable)
        }
        // 隐藏底部时禁用整个表单
       setProps({ disabled: !data?.showFooter })
    });
    //方法配置
    const [handleChangeTabs,handleSubmit,requestSubTableData,formRef] = useJvxeMethod(requestAddOrEdit,classifyIntoFormData,tableRefs,activeKey,refKeys);
    // 弹窗tabs滚动区域的高度
    const tabsStyle = computed(() => {
      let height: Nullable<string> = null
      let minHeight = '100px'
      let maxHeight: Nullable<string> = '500px'
      // 弹窗wrapper
      let modalWrapperRef = modalRef.value?.modalWrapperRef
      if (modalWrapperRef) {
        if (modalWrapperRef.fullScreen) {
          height = 'calc(' + modalWrapperRef.spinStyle.height + ' - 50px)';
          maxHeight = null
        }
      }
      return {height, minHeight, maxHeight}
    })

    async function reset(){
      await resetFields();
      activeKey.value = 'wmsProductDevelopment';
      wmsProductCompetitiveTable.dataSource = [];
      wmsProductRelationTable.dataSource = [];
    }
    function classifyIntoFormData(allValues) {
         let main = Object.assign({}, allValues.formValue)
         return {
           ...main, // 展开
           wmsProductCompetitiveList: allValues.tablesValue[0].tableData,
           wmsProductRelationList: allValues.tablesValue[1].tableData,
         }
       }
    //表单提交事件
    async function requestAddOrEdit(values) {
        try {
            setModalProps({confirmLoading: true});
            //提交表单
            await saveOrUpdate(values, isUpdate.value);
            //关闭弹窗
            closeModal();
            //刷新列表
            emit('success');
        } finally {
            setModalProps({confirmLoading: false});
        }
    }
</script>

<style lang="less" scoped>
/** 时间和数字输入框样式 */
    :deep(.ant-input-number){
        width: 100%
    }

    :deep(.ant-calendar-picker){
        width: 100%
    }
</style>

<style lang="less">
// Online表单Tab风格专属样式
.j-cgform-tab-modal {
  .ant-modal-header {
    padding-top: 8px;
    padding-bottom: 8px;
    border-bottom: none !important;
  }

  .ant-modal .ant-modal-body > .scrollbar,
  .ant-tabs-nav .ant-tabs-tab {
    padding-top: 0;
  }

  .ant-tabs-top-bar {
    width: calc(100% - 55px);
    position: relative;
    left: -14px;
  }

  .ant-tabs .ant-tabs-top-content > .ant-tabs-tabpane {
    overflow: hidden auto;
  }
}
</style>