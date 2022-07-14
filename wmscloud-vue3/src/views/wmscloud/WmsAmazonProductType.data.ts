import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '亚马逊大类',
    align: 'left',
    sorter: true,
    dataIndex: 'typeName'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "亚马逊大类",
      field: "typeName",
      component: 'Input',
      colProps: {span: 6},
     },
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: 'pid',
    field: 'pid',
    component: 'JTreeSelect',
    componentProps: {
      dict: "wms_amazon_product_type,type_name,id",
      pidField: "pid",
      pidValue: "0",
      hasChildField: "has_child",
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入pid!'},
          ];
     },
  },
  {
    label: '亚马逊大类',
    field: 'typeName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入亚马逊大类!'},
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
