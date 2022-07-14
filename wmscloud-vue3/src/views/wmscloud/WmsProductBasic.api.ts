import {defHttp} from '/@/utils/http/axios';
import {Modal} from 'ant-design-vue';

enum Api {
  list = '/wmscloud/wmsProductBasic/list',
  save='/wmscloud/wmsProductBasic/add',
  edit='/wmscloud/wmsProductBasic/edit',
  deleteOne = '/wmscloud/wmsProductBasic/delete',
  deleteBatch = '/wmscloud/wmsProductBasic/deleteBatch',
  importExcel = '/wmscloud/wmsProductBasic/importExcel',
  exportXls = '/wmscloud/wmsProductBasic/exportXls',
  wmsProductPriceDimssionList = '/wmscloud/wmsProductBasic/queryWmsProductPriceDimssionByMainId',
  wmsProductAttachList = '/wmscloud/wmsProductBasic/queryWmsProductAttachByMainId',
  wmsProductAccessoryList = '/wmscloud/wmsProductBasic/queryWmsProductAccessoryByMainId',
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
 * 查询子表数据
 * @param params
 */
export const wmsProductPriceDimssionList = Api.wmsProductPriceDimssionList;
/**
 * 查询子表数据
 * @param params
 */
export const wmsProductAttachList = Api.wmsProductAttachList;
/**
 * 查询子表数据
 * @param params
 */
export const wmsProductAccessoryList = Api.wmsProductAccessoryList;
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
