import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '节点ID',
    align:"center",
    dataIndex: 'nodeId'
   },
   {
    title: '节点Path',
    align:"center",
    dataIndex: 'nodePath',
   },
   {
    title: '关键词',
    align:"center",
    dataIndex: 'query',
  
   },
  //  {
  //   title: '大类',
  //   align:"center",
  //   dataIndex: 'mainCategory'
  //  },
  //  {
  //   title: '小类',
  //   align:"center",
  //   dataIndex: 'subCategory'
  //  },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "关键词",
      field: 'query',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '节点ID',
    field: 'nodeId',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入节点ID!'},
          ];
     },
  },
  {
    label: '节点Path',
    field: 'nodePath',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入节点Path!'},
          ];
     },
  },
  {
    label: '关键词',
    field: 'query',
    component: 'Input',
  },
  {
    label: '大类',
    field: 'mainCategory',
    component: 'Input',
  },
  {
    label: '小类',
    field: 'subCategory',
    component: 'Input',
  },
	// TODO 主键隐藏字段，目前写死为ID
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
