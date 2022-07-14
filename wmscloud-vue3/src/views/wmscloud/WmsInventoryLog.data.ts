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
    title: 'SKU',
    align:"center",
    dataIndex: 'inventorySku'
   },
   {
    title: '入库单号',
    align:"center",
    dataIndex: 'orderSn'
   },
   {
    title: '货架号',
    align:"center",
    dataIndex: 'warehouseShelfId_dictText'
   },
   {
    title: '入库数量',
    align:"center",
    dataIndex: 'inQuantity'
   },
   {
    title: '出库数量',
    align:"center",
    dataIndex: 'outQuantity'
   },
   {
    title: '当前库存',
    align:"center",
    dataIndex: 'stock'
   },
   {
    title: '上货证明',
    align:"center",
    dataIndex: 'proofImg',
    customRender:render.renderImage,
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
     {
      label: "创建日期",
      field: "createTime",
      component: 'RangePicker',
      componentProps: {
          showTime:true
      },
      colProps: {span: 6},
	},
	{
      label: "SKU",
      field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'inventory_sku', target: 'inventorySku' },
            ],
            multi:false
        }
    },

      colProps: {span: 6},
 	},
	{
      label: "入库单号",
      field: 'orderSn',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_order_list",
            fieldConfig: [
                { source: 'order_sn', target: 'orderSn' },
            ],
            multi:false
        }
    },

      colProps: {span: 6},
 	},
	{
      label: "货架号",
      field: 'warehouseShelfId',
      component: 'JSearchSelect',
      componentProps:{
         dict:"wms_warehouse_shelf,name,id"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: 'SKU',
    field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'inventory_sku', target: 'inventorySku' },
            ],
            multi:false
        }
    },

    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入SKU!'},
          ];
     },
  },
  {
    label: '入库单号',
    field: 'orderSn',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_order_list",
            fieldConfig: [
                { source: 'order_sn', target: 'orderSn' },
            ],
            multi:false
        }
    },

    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入入库单号!'},
          ];
     },
  },
  {
    label: '货架号',
    field: 'warehouseShelfId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_warehouse_shelf,name,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入货架号!'},
          ];
     },
  },
  {
    label: '入库数量',
    field: 'inQuantity',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入入库数量!'},
          ];
     },
  },
  {
    label: '出库数量',
    field: 'outQuantity',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入出库数量!'},
          ];
     },
  },
  {
    label: '上货证明',
    field: 'proofImg',
     component: 'JImageUpload',
     componentProps:{
      },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入上货证明!'},
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
