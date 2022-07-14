import {defHttp} from '/@/utils/http/axios';
import {Modal} from 'ant-design-vue';

enum Api {
  list = '/wmscloud/wmsTransaction/list',
  save='/wmscloud/wmsTransaction/add',
  edit='/wmscloud/wmsTransaction/edit',
  deleteOne = '/wmscloud/wmsTransaction/delete',
  deleteBatch = '/wmscloud/wmsTransaction/deleteBatch',
  importExcel = '/wmscloud/wmsTransaction/importExcel',
  exportXls = '/wmscloud/wmsTransaction/exportXls',
  wmsTransactionDetailList = '/wmscloud/wmsTransaction/listWmsTransactionDetailByMainId',
  wmsTransactionDetailSave='/wmscloud/wmsTransaction/addWmsTransactionDetail',
  wmsTransactionDetailEdit='/wmscloud/wmsTransaction/editWmsTransactionDetail',
  wmsTransactionDetailDelete = '/wmscloud/wmsTransaction/deleteWmsTransactionDetail',
  wmsTransactionDetailDeleteBatch = '/wmscloud/wmsTransaction/deleteBatchWmsTransactionDetail',
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
 * 列表接口
 * @param params
 */
export const wmsTransactionDetailList = (params) =>
  defHttp.get({url: Api.wmsTransactionDetailList, params});

/**
 * 删除单个
 */
export const wmsTransactionDetailDelete = (params,handleSuccess) => {
  return defHttp.delete({url: Api.wmsTransactionDetailDelete, params}, {joinParamsToUrl: true}).then(() => {
    handleSuccess();
  });
}
/**
 * 批量删除
 * @param params
 */
export const wmsTransactionDetailDeleteBatch = (params, handleSuccess) => {
  Modal.confirm({
    title: '确认删除',
    content: '是否删除选中数据',
    okText: '确认',
    cancelText: '取消',
    onOk: () => {
      return defHttp.delete({url: Api.wmsTransactionDetailDeleteBatch, data: params}, {joinParamsToUrl: true}).then(() => {
        handleSuccess();
      });
    }
  });
}
/**
 * 保存或者更新
 * @param params
 */
export const  wmsTransactionDetailSaveOrUpdate = (params, isUpdate) => {
  let url = isUpdate ? Api.wmsTransactionDetailEdit : Api.wmsTransactionDetailSave;
  return defHttp.post({url: url, params});
}
/**
 * 导入
 */
export const wmsTransactionDetailImportUrl = '/wmscloud/wmsTransaction/importWmsTransactionDetail'

/**
 * 导出
 */
export const wmsTransactionDetailExportXlsUrl = '/wmscloud/wmsTransaction/exportWmsTransactionDetail'
