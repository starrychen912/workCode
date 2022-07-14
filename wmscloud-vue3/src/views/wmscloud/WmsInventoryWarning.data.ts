import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '商品SKU',
    align:"center",
    dataIndex: 'inventorySku'
   },
   {
    title: '最小预警值',
    align:"center",
    dataIndex: 'minValue'
   },
   {
    title: '最大预警值',
    align:"center",
    dataIndex: 'maxValue'
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
      label: "商品SKU",
      field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'inventory_sku', target: 'inventory_sku' },
            ],
            multi:true
        }
    },

      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '商品SKU',
    field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'inventory_sku', target: 'inventory_sku' },
            ],
            multi:true
        }
    },

    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入商品SKU!'},
          ];
     },
  },
  {
    label: '最小预警值',
    field: 'minValue',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入最小预警值!'},
          ];
     },
  },
  {
    label: '最大预警值',
    field: 'maxValue',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入最大预警值!'},
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
