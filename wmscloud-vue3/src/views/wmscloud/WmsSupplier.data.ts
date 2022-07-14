import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '创建日期',
    align:"center",
    dataIndex: 'createTime'
   },
   {
    title: '供应商编码',
    align:"center",
    sorter: true,
    dataIndex: 'supplierCode'
   },
   {
    title: '供应商名称',
    align:"center",
    sorter: true,
    dataIndex: 'supplierName'
   },
   {
    title: '供应商类型',
    align:"center",
    sorter: true,
    dataIndex: 'supplierType_dictText'
   },
   {
    title: 'Logo',
    align:"center",
    dataIndex: 'logo',
    customRender:render.renderImage,
   },
   {
    title: '供应商联系人',
    align:"center",
    dataIndex: 'contact'
   },
   {
    title: '联系电话',
    align:"center",
    dataIndex: 'phoneNumber'
   },
   {
    title: '网址',
    align:"center",
    dataIndex: 'httpDomain'
   },
   {
    title: '状态',
    align:"center",
    sorter: true,
    dataIndex: 'status_dictText'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "供应商编码",
      field: 'supplierCode',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "供应商名称",
      field: 'supplierName',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "供应商类型",
      field: 'supplierType',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"wms_supplier_platform,platform_name,id"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '供应商编码',
    field: 'supplierCode',
    component: 'Input',
  },
  {
    label: '供应商名称',
    field: 'supplierName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入供应商名称!'},
          ];
     },
  },
  {
    label: '供应商类型',
    field: 'supplierType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"wms_supplier_platform,platform_name,id"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入供应商类型!'},
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
    label: '供应商联系人',
    field: 'contact',
    component: 'Input',
  },
  {
    label: '联系电话',
    field: 'phoneNumber',
    component: 'Input',
  },
  {
    label: '网址',
    field: 'httpDomain',
    component: 'Input',
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
