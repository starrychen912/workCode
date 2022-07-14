import {defHttp} from '/@/utils/http/axios';
import {Modal} from 'ant-design-vue';

enum Api {
  list = '/wmscloud/wmsOrder/list',
  save='/wmscloud/wmsOrder/add',
  edit='/wmscloud/wmsOrder/edit',
  deleteOne = '/wmscloud/wmsOrder/delete',
  deleteBatch = '/wmscloud/wmsOrder/deleteBatch',
  importExcel = '/wmscloud/wmsOrder/importExcel',
  exportXls = '/wmscloud/wmsOrder/exportXls',
  wmsOrderItemList = '/wmscloud/wmsOrder/queryWmsOrderItemByMainId',
}
/**
 * 导出api
 * @param params
 */
export const getExportUrl = Api.exportXls;

/**
 * 导入api
 */
export const getImportUrl = Api.importExcel;
/**
 * 子表单查询接口
 * @param params
 */
export const queryWmsOrderItem = Api.wmsOrderItemList
/**
 * 列表接口
 * @param params
 */
export const list = (params) =>
  defHttp.get({url: Api.list, params});

/**
 * 删除单个
 */
export const deleteOne = (params,handleSuccess) => {
  return defHttp.delete({url: Api.deleteOne, params}, {joinParamsToUrl: true}).then(() => {
    handleSuccess();
  });
}
/**
 * 批量删除
 * @param params
 */
export const batchDelete = (params, handleSuccess) => {
  Modal.confirm({
    title: '确认删除',
    content: '是否删除选中数据',
    okText: '确认',
    cancelText: '取消',
    onOk: () => {
      return defHttp.delete({url: Api.deleteBatch, data: params}, {joinParamsToUrl: true}).then(() => {
        handleSuccess();
      });
    }
  });
}
/**
 * 保存或者更新
 * @param params
 */
export const saveOrUpdate = (params, isUpdate) => {
  let url = isUpdate ? Api.edit : Api.save;
  return defHttp.post({url: url, params});
}
/**
 * 子表列表接口
 * @param params
 */
export const wmsOrderItemList = (params) =>
  defHttp.get({url: Api.wmsOrderItemList, params},{isTransformResponse:false});
