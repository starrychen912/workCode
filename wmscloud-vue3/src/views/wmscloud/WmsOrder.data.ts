import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
import {JVxeTypes,JVxeColumn} from '/@/components/jeecg/JVxeTable/types'
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '店铺id',
    align:"center",
    dataIndex: 'shopId_dictText'
   },
   {
    title: '订单类型',
    align:"center",
    dataIndex: 'orderType_dictText'
   },
   {
    title: '订单标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '编号',
    align:"center",
    dataIndex: 'orderSn'
   },
   {
    title: '渠道订单号',
    align:"center",
    dataIndex: 'channelOrder'
   },
   {
    title: '币种',
    align:"center",
    dataIndex: 'currency_dictText'
   },
   {
    title: '总折扣',
    align:"center",
    dataIndex: 'totalDiscounts'
   },
   {
    title: '总价',
    align:"center",
    dataIndex: 'totalPrice'
   },
   {
    title: '税费',
    align:"center",
    dataIndex: 'totalTax'
   },
   {
    title: '订单状态',
    align:"center",
    dataIndex: 'orderStatus_dictText'
   },
   {
    title: '数量',
    align:"center",
    dataIndex: 'quantity'
   },
   {
    title: '采购需求时间',
    align:"center",
    dataIndex: 'purchaseDate'
   },
   {
    title: '采购类型',
    align:"center",
    dataIndex: 'purchaseType_dictText'
   },
   {
    title: '检查状态',
    align:"center",
    dataIndex: 'checkStatus_dictText'
   },
   {
    title: '检查用户',
    align:"center",
    dataIndex: 'checkedUserId_dictText'
   },
   {
    title: '收货地址',
    align:"center",
    dataIndex: 'consignee'
   },
   {
    title: '订单说明',
    align:"center",
    dataIndex: 'remark'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
     {
      label: "创建人",
      field: "createBy",
      component: 'Input', //TODO 范围查询
      colProps: {span: 6},
	},
	{
      label: "订单类型",
      field: 'orderType',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"order_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "订单标题",
      field: 'title',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "编号",
      field: 'orderSn',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "渠道订单号",
      field: 'channelOrder',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "订单状态",
      field: 'orderStatus',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"order_status"
      },
      colProps: {span: 6},
 	},
	{
      label: "采购类型",
      field: 'purchaseType',
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"purchase_type"
      },
      colProps: {span: 6},
 	},
	{
      label: "检查用户",
      field: 'checkedUserId',
      component: 'JSelectUserByDept',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '店铺id',
    field: 'shopId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_shop,name,id"
    },
  },
  {
    label: '订单类型',
    field: 'orderType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"order_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入订单类型!'},
          ];
     },
  },
  {
    label: '订单标题',
    field: 'title',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入订单标题!'},
          ];
     },
  },
  {
    label: '编号',
    field: 'orderSn',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入编号!'},
          ];
     },
  },
  {
    label: '渠道订单号',
    field: 'channelOrder',
    component: 'Input',
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
    label: '总折扣',
    field: 'totalDiscounts',
    component: 'InputNumber',
  },
  {
    label: '总价',
    field: 'totalPrice',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入总价!'},
          ];
     },
  },
  {
    label: '税费',
    field: 'totalTax',
    component: 'InputNumber',
  },
  {
    label: '订单状态',
    field: 'orderStatus',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"order_status"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入订单状态!'},
          ];
     },
  },
  {
    label: '数量',
    field: 'quantity',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入数量!'},
          ];
     },
  },
  {
    label: '采购需求时间',
    field: 'purchaseDate',
    component: 'DatePicker',
    componentProps: {
       showTime:true,
       valueFormat: 'YYYY-MM-DD HH:mm:ss'
     },
  },
  {
    label: '采购类型',
    field: 'purchaseType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"purchase_type"
     },
  },
  {
    label: '检查状态',
    field: 'checkStatus',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"check_status"
     },
  },
  {
    label: '检查用户',
    field: 'checkedUserId',
    component: 'JSelectUserByDept',
    componentProps:{
        labelKey:'realname',
     },
  },
  {
    label: '收货地址',
    field: 'consignee',
    component: 'Input',
  },
  {
    label: '订单说明',
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
//子表单数据
//子表列表数据
export const wmsOrderItemColumns: BasicColumn[] = [
   {
    title: 'sku',
    align:"center",
    dataIndex: 'inventorySku'
   },
   {
    title: '名称',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '图片',
    align:"center",
    dataIndex: 'images',
    customRender:render.renderImage,
   },
   {
    title: 'currency',
    align:"center",
    dataIndex: 'currency_dictText'
   },
   {
    title: '原价',
    align:"center",
    dataIndex: 'originalPrice'
   },
   {
    title: '售价',
    align:"center",
    dataIndex: 'price'
   },
   {
    title: '数量',
    align:"center",
    dataIndex: 'quantity'
   },
   {
    title: '编号',
    align:"center",
    dataIndex: 'orderSn'
   },
   {
    title: '重量',
    align:"center",
    dataIndex: 'weight'
   },
   {
    title: '物流状态',
    align:"center",
    dataIndex: 'dispatchStatus_dictText'
   },
   {
    title: '物流费用',
    align:"center",
    dataIndex: 'dispatchFee'
   },
   {
    title: '物流类型',
    align:"center",
    dataIndex: 'dispatchType_dictText'
   },
   {
    title: '支付金额',
    align:"center",
    dataIndex: 'payPrice'
   },
   {
    title: '退款状态',
    align:"center",
    dataIndex: 'refundStatus_dictText'
   },
   {
    title: '退款金额',
    align:"center",
    dataIndex: 'refundFee'
   },
   {
    title: '退款原因',
    align:"center",
    dataIndex: 'refundMsg'
   },
   {
    title: '快递公司名称',
    align:"center",
    dataIndex: 'expressName'
   },
   {
    title: '快递编号',
    align:"center",
    dataIndex: 'expressNo'
   },
   {
    title: '备注',
    align:"center",
    dataIndex: 'remark'
   },
];
//子表表格配置
export const wmsOrderItemJVxeColumns: JVxeColumn[] = [
    {
      title: 'sku',
      key: 'inventorySku',
      type: JVxeTypes.popup,
      popupCode:"wms_product_list",
      fieldConfig: [
        { source: 'id', target: 'productId' },
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
      title: '名称',
      key: 'title',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
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
      title: 'currency',
      key: 'currency',
      type: JVxeTypes.select,
      options:[],
      dictCode:"currency",
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '原价',
      key: 'originalPrice',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '售价',
      key: 'price',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '数量',
      key: 'quantity',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '编号',
      key: 'orderSn',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '重量',
      key: 'weight',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '物流状态',
      key: 'dispatchStatus',
      type: JVxeTypes.select,
      options:[],
      dictCode:"dispatch_status",
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '物流费用',
      key: 'dispatchFee',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '物流类型',
      key: 'dispatchType',
      type: JVxeTypes.select,
      options:[],
      dictCode:"dispatch_type",
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '支付金额',
      key: 'payPrice',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '退款状态',
      key: 'refundStatus',
      type: JVxeTypes.select,
      options:[],
      dictCode:"refund_status",
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '退款金额',
      key: 'refundFee',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '退款原因',
      key: 'refundMsg',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '快递公司名称',
      key: 'expressName',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '快递编号',
      key: 'expressNo',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
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
