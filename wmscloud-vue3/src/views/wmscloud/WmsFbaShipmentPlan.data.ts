import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
import {JVxeTypes,JVxeColumn} from '/@/components/jeecg/JVxeTable/types'
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '店铺',
    align:"center",
    dataIndex: 'shopId_dictText'
   },
   {
    title: '计划名称',
    align:"center",
    dataIndex: 'shipmentPlanName'
   },
   {
    title: '包装类型',
    align:"center",
    dataIndex: 'packageType_dictText'
   },
   {
    title: '发货地址',
    align:"center",
    dataIndex: 'fbaAddressId_dictText'
   },
   {
    title: ' 标签设置',
    align:"center",
    dataIndex: 'labelPrepPreference_dictText'
   },
   {
    title: '发货国家',
    align:"center",
    dataIndex: 'shipToCountryCode_dictText'
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
      label: "计划名称",
      field: 'shipmentPlanName',
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "发货国家",
      field: 'shipToCountryCode',
      component: 'JSearchSelect',
      componentProps:{
         dict:"wms_country,namecn,code"
      },
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '店铺',
    field: 'shopId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_shop,name,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入店铺!'},
          ];
     },
  },
  {
    label: '计划名称',
    field: 'shipmentPlanName',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入计划名称!'},
          ];
     },
  },
  {
    label: '包装类型',
    field: 'packageType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"package_type"
     },
  },
  {
    label: '发货地址',
    field: 'fbaAddressId',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_fba_address,address_name,id"
    },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入发货地址!'},
          ];
     },
  },
  {
    label: ' 标签设置',
    field: 'labelPrepPreference',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"label_prep_preference"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入 标签设置!'},
          ];
     },
  },
  {
    label: '发货国家',
    field: 'shipToCountryCode',
    component: 'JSearchSelect',
    componentProps:{
       dict:"wms_country,namecn,code"
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
//子表单数据
//子表列表数据
export const wmsFbaShipmentPlanItemColumns: BasicColumn[] = [
   {
    title: 'SPU',
    align:"center",
    dataIndex: 'spu'
   },
   {
    title: '产品标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: 'ASIN',
    align:"center",
    dataIndex: 'asin'
   },
   {
    title: 'Condition',
    align:"center",
    dataIndex: 'itemCondition_dictText'
   },
   {
    title: '数量',
    align:"center",
    dataIndex: 'quantity'
   },
   {
    title: '单箱数量',
    align:"center",
    dataIndex: 'quantityInCase'
   },
];
//子表表格配置
export const wmsFbaShipmentPlanItemJVxeColumns: JVxeColumn[] = [
    {
      title: 'SPU',
      key: 'spu',
      type: JVxeTypes.popup,
      popupCode:"wms_amazon_product_list",
      fieldConfig: [
        { source: 'spu', target: 'spu' },
        { source: 'title', target: 'title' },
      ],

      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '产品标题',
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
      title: 'ASIN',
      key: 'asin',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: 'Condition',
      key: 'itemCondition',
      type: JVxeTypes.selectSearch,
      dictCode:"amazon_condition",
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
      title: '单箱数量',
      key: 'quantityInCase',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
  ]
