import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '供应商名称',
    align:"center",
    dataIndex: 'platformName'
   },
   {
    title: '供应商编码',
    align:"center",
    dataIndex: 'platformCode'
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
    dataIndex: 'httpDomain'
   },
   {
    title: '状态',
    align:"center",
    dataIndex: 'status_dictText'
   },
   {
    title: '备注',
    align:"center",
    dataIndex: 'remark'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "供应商名称",
      field: 'platformName',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "供应商编码",
      field: 'platformCode',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '供应商名称',
    field: 'platformName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入供应商名称!'},
          ];
     },
  },
  {
    label: '供应商编码',
    field: 'platformCode',
    component: 'Input',
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
    field: 'httpDomain',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: false},
                 { pattern: /^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-.,@?^=%&:\/~+#]*[\w\-@?^=%&\/~+#])?$/, message: '请输入正确的网址!'},
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
