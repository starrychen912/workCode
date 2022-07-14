import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
import {JVxeTypes,JVxeColumn} from '/@/components/jeecg/JVxeTable/types'
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '商品类型',
    align:"center",
    dataIndex: 'productType_dictText'
   },
   {
    title: '标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '库存sku',
    align:"center",
    dataIndex: 'inventorySku'
   },
   {
    title: '品牌',
    align:"center",
    dataIndex: 'brandId_dictText'
   },
   {
    title: '分类',
    align:"center",
    dataIndex: 'categoryId',
    customRender:({text}) => {
       return  render.renderCategoryTree(text,'')
   },
   },
   {
    title: '标签',
    align:"center",
    dataIndex: 'tagIds_dictText'
   },
   {
    title: '商品状态',
    align:"center",
    dataIndex: 'status_dictText'
   },
   {
    title: '供应商ID',
    align:"center",
    dataIndex: 'supplierId_dictText'
   },
   {
    title: '图片',
    align:"center",
    dataIndex: 'images',
    // customRender:render.renderImage,
    customRender:render.renderImageList,
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
	{
      label: "创建人",
      field: "createBy",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "创建日期",
      field: "createTime",
      component: 'DatePicker',
      componentProps: {
         showTime:true
       },
      colProps: {span: 6},
 	},
	{
      label: "商品类型",
      field: "productType",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"product_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "标题",
      field: "title",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "库存sku",
      field: "inventorySku",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "品牌",
      field: "brandId",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"wms_brand,name,id"
      },
      colProps: {span: 6},
 	},
	{
      label: "分类",
      field: "categoryId",
      component: 'JCategorySelect',
      componentProps:{
          pcode:"",//back和事件未添加，暂时有问题
      },
      colProps: {span: 6},
 	},
	{
      label: "标签",
      field: "tagIds",
      component: 'JSelectMultiple',
      componentProps:{
         dictCode:"wms_tags,name,id",
         triggerChange: true
      },
      colProps: {span: 6},
 	},
	{
      label: "商品状态",
      field: "status",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"product_status"
      },
      colProps: {span: 6},
 	},
	{
      label: "供应商ID",
      field: "supplierId",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"wms_supplier,supplier_name,id"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '商品类型',
    field: 'productType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"product_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入商品类型!'},
          ];
     },
  },
  {
    label: '标题',
    field: 'title',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入标题!'},
          ];
     },
  },
  {
    label: '库存sku',
    field: 'inventorySku',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入库存sku!'},
          ];
     },
  },
  {
    label: '品牌',
    field: 'brandId',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"wms_brand,name,id"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入品牌!'},
          ];
     },
  },
  {
    label: '分类',
    field: 'categoryId',
    component: 'JCategorySelect',
    componentProps:{
       pcode:"", //TODO back和事件未添加，暂时有问题
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入分类!'},
          ];
     },
  },
  {
    label: '标签',
    field: 'tagIds',
    component: 'JSelectMultiple',
    componentProps:{
        dictCode:"wms_tags,name,id"
     },
  },
  {
    label: '商品状态',
    field: 'status',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"product_status"
     },
  },
  {
    label: '供应商ID',
    field: 'supplierId',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"wms_supplier,supplier_name,id"
     },
  },
  {
    label: '图片',
    field: 'images',
    component: 'JImageUpload',
    componentProps:{
      listType : 'picture-card',
      fileMax : 10,
      },
  },
  {
    label: '产品介绍',
    field: 'description',
    component: 'JEditor',
  },
	// TODO 主键隐藏字段，目前写死为ID
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
//子表单数据
export const wmsProductPriceDimssionFormSchema: FormSchema[] = [
  {
    label: '重量',
    field: 'weight',
    component: 'InputNumber',
  },
  {
    label: '重量单位',
    field: 'weightUnit',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"weight_unit"
     },
  },
  {
    label: '原价',
    field: 'originalPrice',
    component: 'InputNumber',
  },
  {
    label: '成本价',
    field: 'cost',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入成本价!'},
          ];
     },
  },
  {
    label: '市场价',
    field: 'marketPrice',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入市场价!'},
          ];
     },
  },
  {
    label: '零售价',
    field: 'retailPrice',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入零售价!'},
          ];
     },
  },
  {
    label: '长',
    field: 'length',
    component: 'InputNumber',
  },
  {
    label: '宽',
    field: 'width',
    component: 'InputNumber',
  },
  {
    label: '高',
    field: 'height',
    component: 'InputNumber',
  },
  {
    label: '尺寸单位',
    field: 'dimensionsUnit',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"length_unit"
     },
  },
  {
    label: '条形码、UPC 或 ISBN 号',
    field: 'barcode',
    component: 'Input',
  },
  {
    label: '编码',
    field: 'encoding',
    component: 'Input',
  },
  {
    label: '包装长',
    field: 'packageHeight',
    component: 'InputNumber',
  },
  {
    label: '包装宽',
    field: 'packageWidth',
    component: 'InputNumber',
  },
  {
    label: '包装高',
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
    label: 'B2B价',
    field: 'b2bPrice',
    component: 'InputNumber',
  },
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
export const wmsProductAttachFormSchema: FormSchema[] = [
  {
    label: '材质',
    field: 'texture',
    component: 'Input',
  },
  {
    label: '用途',
    field: 'usedfor',
    component: 'Input',
  },
  {
    label: '附加属性',
    field: 'attachAttr',
    component: 'JSelectMultiple',
    componentProps:{
        dictCode:"attach_attr"
     },
  },
  {
    label: '海关名称',
    field: 'hsName',
    component: 'Input',
  },
  {
    label: '海关代码',
    field: 'hsCode',
    component: 'Input',
  },
	{
	  label: '',
	  field: 'id',
	  component: 'Input',
	  show: false
	},
];
//子表表格配置
export const wmsProductAccessoryColumns: JVxeColumn[] = [
    {
      title: '库存sku',
      key: 'inventorySku',
      type: JVxeTypes.popup,
      popupCode:"wms_product_list",
      fieldConfig: [
        { source: 'inventory_sku', target: 'inventorySku' },
        { source: 'title', target: 'title' },
        { source: 'images', target: 'images' },
      ],

      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '标题',
      key: 'title',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '图片',
      key: 'images',
      type: JVxeTypes.image,
      token:true,
      responseName:"message",
      disabled:true,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '成本价',
      key: 'cost',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '关联数量',
      key: 'num',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '备注',
      key: 'remark',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
  ]
