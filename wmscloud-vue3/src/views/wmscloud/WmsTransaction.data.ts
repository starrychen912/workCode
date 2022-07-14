import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '标题',
    align:"center",
    sorter: true,
    dataIndex: 'title'
   },
   {
    title: '类型',
    align:"center",
    sorter: true,
    dataIndex: 'type_dictText'
   },
   {
    title: '关联ID',
    align:"center",
    sorter: true,
    dataIndex: 'relateId'
   },
   {
    title: '相关人员',
    align:"center",
    dataIndex: 'relateUserIds_dictText'
   },
   {
    title: ' 负责人',
    align:"center",
    dataIndex: 'principal_dictText'
   },
   {
    title: '处理状态',
    align:"center",
    dataIndex: 'status_dictText'
   },
   {
    title: '内容',
    align:"center",
    dataIndex: 'content',
    slots: { customRender: 'htmlSlot' },
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "标题",
      field: "title",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "类型",
      field: "type",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"transaction_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "关联ID",
      field: "relateId",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: " 负责人",
      field: "principal",
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
    label: '类型',
    field: 'type',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"transaction_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入类型!'},
          ];
     },
  },
  {
    label: '关联ID',
    field: 'relateId',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入关联ID!'},
          ];
     },
  },
  {
    label: '相关人员',
    field: 'relateUserIds',
    component: 'JSelectUserByDept',
    componentProps:{
        labelKey:'realname',
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入相关人员!'},
          ];
     },
  },
  {
    label: ' 负责人',
    field: 'principal',
    component: 'JSelectUserByDept',
    componentProps:{
        labelKey:'realname',
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入 负责人!'},
          ];
     },
  },
  {
    label: '处理状态',
    field: 'status',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"transaction_follow"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入处理状态!'},
          ];
     },
  },
  {
    label: '内容',
    field: 'content',
    component: 'JEditor',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入内容!'},
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

//子表列表数据
export const wmsTransactionDetailColumns: BasicColumn[] = [
   {
    title: '事务',
    align:"center",
    dataIndex: 'transactionId_dictText'
   },
   {
    title: '标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '内容',
    align:"center",
    dataIndex: 'content',
    slots: { customRender: 'htmlSlot' },
   },
];
//子表表单数据
export const wmsTransactionDetailFormSchema: FormSchema[] = [
  // TODO 子表隐藏字段，目前写死为ID
  {
    label: '',
    field: 'id',
    component: 'Input',
    show: false
  },
  {
    label: '事务',
    field: 'transactionId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_transaction,title,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入事务!'},
          ];
     },
  },
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
    label: '内容',
    field: 'content',
    component: 'JEditor',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入内容!'},
          ];
     },
  },
];
