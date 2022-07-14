import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: 'feeddocumentid',
    align:"center",
    dataIndex: 'feeddocumentid'
   },
   {
    title: 'url',
    align:"center",
    dataIndex: 'url'
   },
   {
    title: 'documentKey',
    align:"center",
    dataIndex: 'documentKey'
   },
   {
    title: 'initializationvector',
    align:"center",
    dataIndex: 'initializationvector'
   },
   {
    title: 'FeedId',
    align:"center",
    dataIndex: 'feedId'
   },
   {
    title: 'ResultDocumentId',
    align:"center",
    dataIndex: 'resultFeeddocumentid'
   },
   {
    title: '类型',
    align:"center",
    dataIndex: 'feedType'
   },
   {
    title: 'sku',
    align:"center",
    dataIndex: 'sku'
   },
   {
    title: '返回日志',
    align:"center",
    dataIndex: 'feeddocumentreturn'
   },
   {
    title: '状态:',
    align:"center",
    dataIndex: 'status'
   },
   {
    title: '状态',
    align:"center",
    dataIndex: 'resultCode'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: 'feeddocumentid',
    field: 'feeddocumentid',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入feeddocumentid!'},
          ];
     },
  },
  {
    label: 'url',
    field: 'url',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入url!'},
          ];
     },
  },
  {
    label: 'documentKey',
    field: 'documentKey',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入documentKey!'},
          ];
     },
  },
  {
    label: 'initializationvector',
    field: 'initializationvector',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入initializationvector!'},
          ];
     },
  },
  {
    label: 'FeedId',
    field: 'feedId',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入FeedId!'},
          ];
     },
  },
  {
    label: 'ResultDocumentId',
    field: 'resultFeeddocumentid',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入ResultDocumentId!'},
          ];
     },
  },
  {
    label: '类型',
    field: 'feedType',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入类型!'},
          ];
     },
  },
  {
    label: 'sku',
    field: 'sku',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入sku!'},
          ];
     },
  },
  {
    label: '返回日志',
    field: 'feeddocumentreturn',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入返回日志!'},
          ];
     },
  },
  {
    label: '状态:',
    field: 'status',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入状态:!'},
          ];
     },
  },
  {
    label: '状态',
    field: 'resultCode',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入状态!'},
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
