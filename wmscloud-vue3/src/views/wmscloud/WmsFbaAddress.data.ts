import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '地址别名',
    align:"center",
    dataIndex: 'addressName'
   },
   {
    title: '店铺',
    align:"center",
    dataIndex: 'shopId_dictText'
   },
   {
    title: '发货国家',
    align:"center",
    dataIndex: 'countryId_dictText'
   },
   {
    title: '发货方名称',
    align:"center",
    dataIndex: 'sendName'
   },
   {
    title: '街道地址1',
    align:"center",
    dataIndex: 'streetAddress1'
   },
   {
    title: '街道地址2',
    align:"center",
    dataIndex: 'streetAddress2'
   },
   {
    title: '城市',
    align:"center",
    dataIndex: 'city'
   },
   {
    title: '区',
    align:"center",
    dataIndex: 'area'
   },
   {
    title: '州/省/地区',
    align:"center",
    dataIndex: 'address'
   },
   {
    title: '邮政编码',
    align:"center",
    dataIndex: 'zipCode'
   },
   {
    title: '电话号码',
    align:"center",
    dataIndex: 'phoneNumber'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "地址别名",
      field: 'addressName',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "店铺",
      field: 'shopId',
      component: 'JSearchSelect',
      componentProps:{
         dict:"wms_shop,name,id"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '地址别名',
    field: 'addressName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入地址别名!'},
          ];
     },
  },
  {
    label: '店铺',
    field: 'shopId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_shop,name,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入店铺!'},
          ];
     },
  },
  {
    label: '发货国家',
    field: 'countryId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_country,namecn,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入发货国家!'},
          ];
     },
  },
  {
    label: '发货方名称',
    field: 'sendName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入发货方名称!'},
          ];
     },
  },
  {
    label: '街道地址1',
    field: 'streetAddress1',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入街道地址1!'},
          ];
     },
  },
  {
    label: '街道地址2',
    field: 'streetAddress2',
    component: 'Input',
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
    label: '区',
    field: 'area',
    component: 'Input',
  },
  {
    label: '州/省/地区',
    field: 'address',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入州/省/地区!'},
          ];
     },
  },
  {
    label: '邮政编码',
    field: 'zipCode',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入邮政编码!'},
                 { pattern: /^[1-9]\d{5}$/, message: '请输入正确的邮政编码!'},
          ];
     },
  },
  {
    label: '电话号码',
    field: 'phoneNumber',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: false},
                 { pattern: /^1[3456789]\d{9}$/, message: '请输入正确的手机号码!'},
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
