import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '物流名称',
    align:"center",
    dataIndex: 'name'
   },
   {
    title: 'Logo',
    align:"center",
    dataIndex: 'logo',
    customRender:render.renderImage,
   },
   {
    title: '网址',
    align:"center",
    dataIndex: 'webUrl'
   },
   {
    title: '包装类型',
    align:"center",
    dataIndex: 'packType_dictText'
   },
   {
    title: '状态',
    align:"center",
    dataIndex: 'status_dictText'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "物流名称",
      field: 'name',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "包装类型",
      field: 'packType',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"pack_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "状态",
      field: 'status',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"record_status"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '物流名称',
    field: 'name',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入物流名称!'},
          ];
     },
  },
  {
    label: 'Logo',
    field: 'logo',
     component: 'JImageUpload',
     componentProps:{
      },
  },
  {
    label: '网址',
    field: 'webUrl',
    component: 'Input',
  },
  {
    label: '包装类型',
    field: 'packType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"pack_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入包装类型!'},
          ];
     },
  },
  {
    label: '状态',
    field: 'status',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"record_status"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入状态!'},
          ];
     },
  },
  {
    label: '备注',
    field: 'remark',
    component: 'InputTextArea',
  },
	// TODO 主键隐藏字段，目前写死为ID
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
