import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '中文名',
    align:"center",
    dataIndex: 'namecn'
   },
   {
    title: '英文名',
    align:"center",
    dataIndex: 'nameeng'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "中文名",
      field: 'namecn',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "英文名",
      field: 'nameeng',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '中文名',
    field: 'namecn',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入中文名!'},
          ];
     },
  },
  {
    label: '英文名',
    field: 'nameeng',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入英文名!'},
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
