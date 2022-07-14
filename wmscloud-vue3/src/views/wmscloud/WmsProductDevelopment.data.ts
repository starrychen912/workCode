import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
import {JVxeTypes,JVxeColumn} from '/@/components/jeecg/JVxeTable/types'
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '标题',
    align:"center",
    dataIndex: 'title'
   },
   {
    title: '研发编号',
    align:"center",
    dataIndex: 'devSn'
   },
   {
    title: '标签',
    align:"center",
    dataIndex: 'tagsIds_dictText'
   },
   {
    title: '优先级',
    align:"center",
    dataIndex: 'developmentLevel_dictText'
   },
   {
    title: '品牌',
    align:"center",
    dataIndex: 'brandIds_dictText'
   },
   {
    title: '分类',
    align:"center",
    dataIndex: 'catId',
    customRender:({text}) => {
       return  render.renderCategoryTree(text,'')
   },
   },
   {
    title: '责任人',
    align:"center",
    dataIndex: 'resUserId_dictText'
   },
   {
    title: '状态',
    align:"center",
    dataIndex: 'status_dictText'
   },
   {
    title: '发布时间',
    align:"center",
    dataIndex: 'releaseTime'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
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
      label: "标题",
      field: "title",
      component: 'Input',
      colProps: {span: 6},
 	},
	{
      label: "标签",
      field: "tagsIds",
      component: 'JSelectMultiple',
      componentProps:{
         dictCode:"wms_tags,name,id",
         triggerChange: true
      },
      colProps: {span: 6},
 	},
	{
      label: "优先级",
      field: "developmentLevel",
      component: 'JDictSelectTag',
      componentProps:{
          dictCode:"development_level"
      },
      colProps: {span: 6},
 	},
	{
      label: "品牌",
      field: "brandIds",
      component: 'JSelectMultiple',
      componentProps:{
         dictCode:"wms_brand,name,id",
         triggerChange: true
      },
      colProps: {span: 6},
 	},
	{
      label: "分类",
      field: "catId",
      component: 'JCategorySelect',
      componentProps:{
          pcode:"",//back和事件未添加，暂时有问题
      },
      colProps: {span: 6},
 	},
	{
      label: "责任人",
      field: "resUserId",
      component: 'JSelectUserByDept',
      colProps: {span: 6},
 	},
];
//表单数据
export const formSchema: FormSchema[] = [
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
    label: '研发编号',
    field: 'devSn',
    component: 'Input',
  },
  {
    label: '标签',
    field: 'tagsIds',
    component: 'JSelectMultiple',
    componentProps:{
        dictCode:"wms_tags,name,id"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入标签!'},
          ];
     },
  },
  {
    label: '优先级',
    field: 'developmentLevel',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"development_level"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入优先级!'},
          ];
     },
  },
  {
    label: '品牌',
    field: 'brandIds',
    component: 'JSelectMultiple',
    componentProps:{
        dictCode:"wms_brand,name,id"
     },
  },
  {
    label: '分类',
    field: 'catId',
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
    label: '责任人',
    field: 'resUserId',
    component: 'JSelectUserByDept',
    componentProps:{
        labelKey:'realname',
     },
  },
  {
    label: '状态',
    field: 'status',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"development_status"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入状态!'},
          ];
     },
  },
  {
    label: '发布时间',
    field: 'releaseTime',
    component: 'DatePicker',
    componentProps: {
       showTime:true,
       valueFormat: 'YYYY-MM-DD HH:mm:ss'
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入发布时间!'},
          ];
     },
  },
  {
    label: '介绍',
    field: 'description',
    component: 'JEditor',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入介绍!'},
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
//子表单数据
//子表表格配置
export const wmsProductCompetitiveColumns: JVxeColumn[] = [
    {
      title: '平台',
      key: 'platformId',
      type: JVxeTypes.select,
      options:[],
      dictCode:"platform_type",
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '名称',
      key: 'name',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '价格',
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
      title: '地址',
      key: 'url',
      type: JVxeTypes.input,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
    {
      title: '评论数',
      key: 'reviews',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
    {
      title: '排名',
      key: 'ranking',
      type: JVxeTypes.inputNumber,
      width:"200px",
      placeholder: '请输入${title}',
      defaultValue:'',
    },
  ]
export const wmsProductRelationColumns: JVxeColumn[] = [
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
      title: '图片',
      key: 'images',
      type: JVxeTypes.image,
      token:true,
      responseName:"message",
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
        validateRules: [
          { required: true, message: '${title}不能为空' },
        ],
    },
  ]
