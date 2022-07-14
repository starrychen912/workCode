import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '类型',
    align:"center",
    dataIndex: 'type_dictText'
   },
   {
    title: '名称',
    align:"center",
    dataIndex: 'name'
   },
   {
    title: '邮编',
    align:"center",
    dataIndex: 'zipCode'
   },
   {
    title: '国家',
    align:"center",
    dataIndex: 'country'
   },
   {
    title: '省份',
    align:"center",
    dataIndex: 'provinces'
   },
   {
    title: '城市',
    align:"center",
    dataIndex: 'city'
   },
   {
    title: '详细地址',
    align:"center",
    dataIndex: 'address'
   },
   {
    title: '号码',
    align:"center",
    dataIndex: 'phone'
   },
   {
    title: '默认',
    align:"center",
    dataIndex: 'isDefault_dictText'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "类型",
      field: 'type',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"warehouse_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "名称",
      field: 'name',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "邮编",
      field: 'zipCode',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "国家",
      field: 'country',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "省份",
      field: 'provinces',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "城市",
      field: 'city',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '类型',
    field: 'type',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"warehouse_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入类型!'},
          ];
     },
  },
  {
    label: '名称',
    field: 'name',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入名称!'},
          ];
     },
  },
  {
    label: '邮编',
    field: 'zipCode',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入邮编!'},
                 { pattern: /^[1-9]\d{5}$/, message: '请输入正确的邮政编码!'},
          ];
     },
  },
  {
    label: '国家',
    field: 'country',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入国家!'},
          ];
     },
  },
  {
    label: '省份',
    field: 'provinces',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入省份!'},
          ];
     },
  },
  {
    label: '城市',
    field: 'city',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入城市!'},
          ];
     },
  },
  {
    label: '详细地址',
    field: 'address',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入详细地址!'},
          ];
     },
  },
  {
    label: '号码',
    field: 'phone',
    component: 'Input',
  },
  {
    label: '默认',
    field: 'isDefault',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"is_default"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入默认!'},
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
