import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '产品SKU',
    align:"center",
    dataIndex: 'inventorySku'
   },
   {
    title: '店铺ID',
    align:"center",
    dataIndex: 'shopId_dictText'
   },
   {
    title: '商品标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '商品SPU',
    align:"center",
    dataIndex: 'spu'
   },
   {
    title: '条形码、UPC 或 ISBN 号',
    align:"center",
    dataIndex: 'barcode'
   },
   {
    title: '商品编码类型',
    align:"center",
    dataIndex: 'barcodeType'
   },
   {
    title: '包装高',
    align:"center",
    dataIndex: 'packageHeight'
   },
   {
    title: '包装宽',
    align:"center",
    dataIndex: 'packageWidth'
   },
   {
    title: '包装长',
    align:"center",
    dataIndex: 'packageLength'
   },
   {
    title: '单位类型',
    align:"center",
    dataIndex: 'ppuCountType'
   },
   {
    title: '是否有保质期',
    align:"center",
    dataIndex: 'isExpiredProduct_dictText'
   },
   {
    title: '币种',
    align:"center",
    dataIndex: 'currency_dictText'
   },
   {
    title: '价格',
    align:"center",
    dataIndex: 'price'
   },
   {
    title: '子分类',
    align:"center",
    dataIndex: 'itemType'
   },
   {
    title: '亚马逊分类',
    align:"center",
    dataIndex: 'amazonProductType_dictText'
   },
   {
    title: '图片',
    align:"center",
    dataIndex: 'images',
    customRender:render.renderImageList,
    // slots:{customRender:'imgs'}
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
      label: "产品SKU",
      field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'id', target: 'product_id' },
                { source: 'inventory_sku', target: 'inventory_sku' },
                { source: 'title', target: 'title' },
                { source: 'images', target: 'images' },
                { source: 'package_height', target: 'package_height' },
                { source: 'package_width', target: 'package_width' },
                { source: 'package_length', target: 'package_length' },
                { source: 'package_dimensions_unit', target: 'package_dimensions_unit' },
                { source: 'package_weight', target: 'package_weight' },
                { source: 'package_weight_unit', target: 'package_weight_unit' },
            ],
            multi:true
        }
    },

      colProps: {span: 6},
 	},
	{
      label: "商品标题",
      field: 'title',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "商品SPU",
      field: 'spu',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "search_term",
      field: 'searchTerm',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "子分类",
      field: 'itemType',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_amazon_item_type_list",
            fieldConfig: [
                { source: 'node_id', target: 'node_id' },
                { source: 'node_path', target: 'item_type' },
            ],
            multi:true
        }
    },

      colProps: {span: 6},
 	},
	{
      label: "亚马逊分类",
      field: 'amazonProductType',
      component: 'Input',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '产品SKU',
    field: 'inventorySku',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_product_list",
            fieldConfig: [
                { source: 'id', target: 'productId' },
                { source: 'inventory_sku', target: 'inventorySku' },
                { source: 'title', target: 'title' },
                { source: 'images', target: 'images' },
                { source: 'package_height', target: 'packageHeight' },
                { source: 'package_width', target: 'packageWidth' },
                { source: 'package_length', target: 'packageLength' },
                { source: 'package_dimensions_unit', target: 'packageDimensionsUnit' },
                { source: 'package_weight', target: 'packageWeight' },
                { source: 'package_weight_unit', target: 'packageWeightUnit' },
            ],
            multi:true
        }
    },

    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入产品SKU!'},
          ];
     },
  },
  {
    label: '店铺ID',
    field: 'shopId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_shop,name,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入店铺ID!'},
          ];
     },
  },
  {
    label: '商品标题',
    field: 'title',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入商品标题!'},
          ];
     },
  },
  {
    label: '商品SPU',
    field: 'spu',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入商品SPU!'},
          ];
     },
  },
  {
    label: '条形码、UPC 或 ISBN 号',
    field: 'barcode',
    component: 'Input',
  },
  {
    label: '商品编码类型',
    field: 'barcodeType',
    component: 'Input',
  },
  {
    label: '包装高',
    field: 'packageHeight',
    component: 'InputNumber',
  },
  {
    label: '包装宽',
    field: 'packageWidth',
    component: 'InputNumber',
  },
  {
    label: '包装长',
    field: 'packageLength',
    component: 'InputNumber',
  },
  {
    label: '包装尺寸单位',
    field: 'packageDimensionsUnit',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"length_unit"
     },
  },
  {
    label: '包装重量',
    field: 'packageWeight',
    component: 'InputNumber',
  },
  {
    label: '包装重量单位',
    field: 'packageWeightUnit',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"weight_unit"
     },
  },
  {
    label: 'BulletPoint1',
    field: 'bulletPoint1',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入BulletPoint1!'},
          ];
     },
  },
  {
    label: 'BulletPoint2',
    field: 'bulletPoint2',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入BulletPoint2!'},
          ];
     },
  },
  {
    label: 'BulletPoint3',
    field: 'bulletPoint3',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入BulletPoint3!'},
          ];
     },
  },
  {
    label: 'BulletPoint4',
    field: 'bulletPoint4',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入BulletPoint4!'},
          ];
     },
  },
  {
    label: 'BulletPoint5',
    field: 'bulletPoint5',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入BulletPoint5!'},
          ];
     },
  },
  {
    label: 'search_term',
    field: 'searchTerm',
    component: 'InputTextArea',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入search_term!'},
          ];
     },
  },
  {
    label: '运输重量',
    field: 'shippingWeight',
    component: 'InputNumber',
  },
  {
    label: '运输重量单位',
    field: 'shippingWeightUnit',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:""
     },
  },
  {
    label: '商品包装数量',
    field: 'itemPackageQuantity',
    component: 'Input',
  },
  {
    label: '制造商',
    field: 'manufacturer',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入制造商!'},
          ];
     },
  },
  {
    label: '数量单位',
    field: 'unitCount',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入数量单位!'},
          ];
     },
  },
  {
    label: '单位类型',
    field: 'ppuCountType',
    component: 'Input',
  },
  {
    label: '是否有保质期',
    field: 'isExpiredProduct',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"is_expired"
     },
  },
  {
    label: '币种',
    field: 'currency',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"currency"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入币种!'},
          ];
     },
  },
  {
    label: '价格',
    field: 'price',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入价格!'},
          ];
     },
  },
  {
    label: '子分类',
    field: 'itemType',
    component: 'JPopup',
    componentProps: ({ formActionType }) => {
        const {setFieldsValue} = formActionType;
        return{
            setFieldsValue:setFieldsValue,
            code:"wms_amazon_item_type_list",
            fieldConfig: [
                { source: 'node_id', target: 'nodeId' },
                { source: 'node_path', target: 'itemType' },
            ],
            multi:true
        }
    },

    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入子分类!'},
          ];
     },
     colProps: {span: 24},
  },
  {
    label: '亚马逊分类',
    field: 'amazonProductType',
    component: 'JTreeSelect',
    componentProps:{
        dict:"wms_amazon_product_type,type_name,id",
        pidValue:"0",
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入亚马逊分类!'},
          ];
     },
     colProps: {span: 24},

  },
  {
    label: '图片',
    field: 'images',
     component: 'JImageUpload',
     componentProps:{
      listType : 'picture-card',
      fileMax : 10,
      },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入图片!'},
          ];
     },
     colProps: {span: 24},
  },
  {
    label: '描述',
    field: 'description',
    component: 'JEditor',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入描述!'},
          ];
     },
     colProps: {span: 24},
  },
	// TODO 主键隐藏字段，目前写死为ID
  {
	  label: '',
	  field: 'productId',
	  component: 'Input',
	  show: false
	},
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
