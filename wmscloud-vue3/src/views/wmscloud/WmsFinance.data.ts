import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '金额',
    align:"center",
    dataIndex: 'amount'
   },
   {
    title: '币种',
    align:"center",
    dataIndex: 'currency_dictText'
   },
   {
    title: '关联单号',
    align:"center",
    dataIndex: 'orderSn'
   },
   {
    title: '财务类型',
    align:"center",
    dataIndex: 'financeType_dictText'
   },
   {
    title: '资金用途',
    align:"center",
    dataIndex: 'financeUsage_dictText'
   },
   {
    title: '审核状态',
    align:"center",
    dataIndex: 'checkStatus_dictText'
   },
   {
    title: '审核用户',
    align:"center",
    dataIndex: 'checkedUser_dictText'
   },
   {
    title: '说明',
    align:"center",
    dataIndex: 'remark',
    slots: { customRender: 'htmlSlot' },
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "创建人",
      field: 'createBy',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "创建日期",
      field: 'createTime',
      component: 'DatePicker',
      colProps: {span: 6},
 	},
	{
      label: "标题",
      field: 'title',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "关联单号",
      field: 'orderSn',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_order_list",
            fieldConfig: [
                { source: 'order_sn', target: 'order_sn' },
            ],
            multi:true
        }
    },

      colProps: {span: 6},
 	},
	{
      label: "资金用途",
      field: 'financeUsage',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"finance_usage"
      },
      colProps: {span: 6},
 	},
	{
      label: "审核状态",
      field: 'checkStatus',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"check_status"
      },
      colProps: {span: 6},
 	},
	{
      label: "审核用户",
      field: 'checkedUser',
      component: 'JSelectUserByDept',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '标题',
    field: 'title',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入标题!'},
          ];
     },
  },
  {
    label: '金额',
    field: 'amount',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入金额!'},
          ];
     },
  },
  {
    label: '币种',
    field: 'currency',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"currency"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入币种!'},
          ];
     },
  },
  {
    label: '关联单号',
    field: 'orderSn',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_order_list",
            fieldConfig: [
                { source: 'order_sn', target: 'order_sn' },
            ],
            multi:true
        }
    },

  },
  {
    label: '财务类型',
    field: 'financeType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"finance_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入财务类型!'},
          ];
     },
  },
  {
    label: '资金用途',
    field: 'financeUsage',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"finance_usage"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入资金用途!'},
          ];
     },
  },
  {
    label: '审核状态',
    field: 'checkStatus',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"check_status"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入审核状态!'},
          ];
     },
  },
  {
    label: '审核用户',
    field: 'checkedUser',
    component: 'JSelectUserByDept',
    componentProps:{
        labelKey:'realname',
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入审核用户!'},
          ];
     },
  },
  {
    label: '说明',
    field: 'remark',
    component: 'JEditor',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入说明!'},
          ];
     },
  },
	// TODO 主键隐藏字段，目前写死为ID
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
