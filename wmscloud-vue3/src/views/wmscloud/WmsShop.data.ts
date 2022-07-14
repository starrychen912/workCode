import {BasicColumn} from '/@/components/Table';
import {FormSchema} from '/@/components/Table';
import { rules} from '/@/utils/helper/validator';
import { render } from '/@/utils/common/renderUtils';
//列表数据
export const columns: BasicColumn[] = [
   {
    title: '店铺类型',
    align:"center",
    dataIndex: 'shopType_dictText'
   },
   {
    title: '店铺名',
    align:"center",
    dataIndex: 'name'
   },
   {
    title: '商店的地址',
    align:"center",
    dataIndex: 'address'
   },
   {
    title: '城市',
    align:"center",
    dataIndex: 'city'
   },
   {
    title: '国家',
    align:"center",
    dataIndex: 'countryId_dictText'
   },
   {
    title: '邮箱',
    align:"center",
    dataIndex: 'email'
   },
   {
    title: '币种',
    align:"center",
    dataIndex: 'currency_dictText'
   },
   {
    title: '域名',
    align:"center",
    dataIndex: 'domain'
   },
   {
    title: '支持币种',
    align:"center",
    dataIndex: 'enabledPresentmentCurrencies_dictText'
   },
   {
    title: '时区名称',
    align:"center",
    dataIndex: 'ianaTimezone'
   },
   {
    title: '纬度',
    align:"center",
    dataIndex: 'latitude'
   },
   {
    title: '经度',
    align:"center",
    dataIndex: 'longitude'
   },
   {
    title: '未指定货币字符串',
    align:"center",
    dataIndex: 'moneyFormat'
   },
   {
    title: '电话号码',
    align:"center",
    dataIndex: 'phone'
   },
   {
    title: '所有者',
    align:"center",
    dataIndex: 'shopOwner'
   },
   {
    title: '邮政编码',
    align:"center",
    dataIndex: 'zip'
   },
   {
    title: '时区名称',
    align:"center",
    dataIndex: 'timezone'
   },
   {
    title: 'apiKey',
    align:"center",
    dataIndex: 'apikey'
   },
   {
    title: 'apiSecretKey',
    align:"center",
    dataIndex: 'apisecretkey'
   },
   {
    title: 'accessToken',
    align:"center",
    dataIndex: 'accessToken'
   },
   {
    title: '备注',
    align:"center",
    dataIndex: 'remark'
   },
];
//查询数据
export const searchFormSchema: FormSchema[] = [
];
//表单数据
export const formSchema: FormSchema[] = [
  {
    label: '店铺类型',
    field: 'shopType',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"shop_type"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入店铺类型!'},
          ];
     },
  },
  {
    label: '店铺名',
    field: 'name',
    component: 'Input',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入店铺名!'},
          ];
     },
  },
  {
    label: '商店的地址',
    field: 'address',
    component: 'Input',
  },
  {
    label: '城市',
    field: 'city',
    component: 'Input',
  },
  {
    label: '国家',
    field: 'countryId',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"wms_country,namecn,nameeng,nameengsp,id"
     },
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入国家!'},
          ];
     },
  },
  {
    label: '邮箱',
    field: 'email',
    component: 'Input',
  },
  {
    label: '币种',
    field: 'currency',
    component: 'JDictSelectTag',
    componentProps:{
        dictCode:"currency"
     },
  },
  {
    label: '域名',
    field: 'domain',
    component: 'Input',
  },
  {
    label: '支持币种',
    field: 'enabledPresentmentCurrencies',
    component: 'JSelectMultiple',
    componentProps:{
        dictCode:"currency"
     },
  },
  {
    label: '时区名称',
    field: 'ianaTimezone',
    component: 'Input',
  },
  {
    label: '纬度',
    field: 'latitude',
    component: 'InputNumber',
  },
  {
    label: '经度',
    field: 'longitude',
    component: 'InputNumber',
  },
  {
    label: '未指定货币字符串',
    field: 'moneyFormat',
    component: 'Input',
  },
  {
    label: '电话号码',
    field: 'phone',
    component: 'Input',
  },
  {
    label: '所有者',
    field: 'shopOwner',
    component: 'Input',
  },
  {
    label: '邮政编码',
    field: 'zip',
    component: 'InputNumber',
    dynamicRules: ({model,schema}) => {
          return [
                 { required: true, message: '请输入邮政编码!'},
                 { pattern: /^-?\d+\.?\d*$/, message: '请输入数字!'},
          ];
     },
  },
  {
    label: '时区名称',
    field: 'timezone',
    component: 'Input',
  },
  {
    label: 'apiKey',
    field: 'apikey',
    component: 'Input',
  },
  {
    label: 'apiSecretKey',
    field: 'apisecretkey',
    component: 'Input',
  },
  {
    label: 'accessToken',
    field: 'accessToken',
    component: 'Input',
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
