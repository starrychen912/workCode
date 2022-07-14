import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '仓库区域',
    align:"center",
    dataIndex: 'warehouseAreaId_dictText'
   },
   {
    title: '编号',
    align:"center",
    dataIndex: 'name'
   },
   {
    title: 'x轴列数量',
    align:"center",
    dataIndex: 'layoutX'
   },
   {
    title: 'y轴行数量',
    align:"center",
    dataIndex: 'layoutY'
   },
   {
    title: '说明',
    align:"center",
    dataIndex: 'remark'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "仓库区域",
      field: 'warehouseAreaId',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"wms_warehouse_area,name,id"
      },
      colProps: {span: 6},
 	},
	{
      label: "编号",
      field: 'name',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '仓库区域',
    field: 'warehouseAreaId',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"wms_warehouse_area,name,id"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入仓库区域!'},
          ];
     },
  },
  {
    label: '编号',
    field: 'name',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入编号!'},
          ];
     },
  },
  {
    label: 'x轴列数量',
    field: 'layoutX',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入x轴列数量!'},
                 { pattern: /^-?\d+$/, message: '请输入整数!'},
          ];
     },
  },
  {
    label: 'y轴行数量',
    field: 'layoutY',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入y轴行数量!'},
                 { pattern: /^-?\d+$/, message: '请输入整数!'},
          ];
     },
  },
  {
    label: '说明',
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
