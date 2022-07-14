import {defHttp} from "/@/utils/http/axios";
import {Modal} from 'ant-design-vue';

enum Api {
  list = '/wmscloud/wmsAmazonProductType/rootList',
  save='/wmscloud/wmsAmazonProductType/add',
  edit='/wmscloud/wmsAmazonProductType/edit',
  deleteWmsAmazonProductType = '/wmscloud/wmsAmazonProductType/delete',
  importExcel = '/wmscloud/wmsAmazonProductType/importExcel',
  exportXls = '/wmscloud/wmsAmazonProductType/exportXls',
  loadTreeData = '/wmscloud/wmsAmazonProductType/loadTreeRoot',
  getChildList = '/wmscloud/wmsAmazonProductType/childList',
  getChildListBatch = '/wmscloud/wmsAmazonProductType/getChildListBatch',
}

/**
 * 导出api
 * @param params
 */
export const getExportUrl = Api.exportXls;
/**
 * 导入api
 * @param params
 */
export const getImportUrl = Api.importExcel;
/**
 * 列表接口
 * @param params
 */
export const list = (params) =>
  defHttp.get({url: Api.list, params});
/**
 * 删除
 */
export const deleteWmsAmazonProductType = (params,handleSuccess) => {
  return defHttp.delete({url: Api.deleteWmsAmazonProductType, params}, {joinParamsToUrl: true}).then(() => {
    handleSuccess();
  });
}
/**
 * 批量删除
 * @param params
 */
export const batchDeleteWmsAmazonProductType = (params, handleSuccess) => {
  Modal.confirm({
    title: '确认删除',
    content: '是否删除选中数据',
    okText: '确认',
    cancelText: '取消',
    onOk: () => {
      return defHttp.delete({url: Api.deleteWmsAmazonProductType, data: params}, {joinParamsToUrl: true}).then(() => {
        handleSuccess();
      });
    }
  });
}
/**
 * 保存或者更新
 * @param params
 */
export const saveOrUpdateDict = (params, isUpdate) => {
  let url = isUpdate ? Api.edit : Api.save;
  return defHttp.post({url: url, params});
}
/**
 * 查询全部树形节点数据
 * @param params
 */
export const loadTreeData = (params) =>
  defHttp.get({url: Api.loadTreeData,params});
/**
 * 查询子节点数据
 * @param params
 */
export const getChildList = (params) =>
  defHttp.get({url: Api.getChildList, params});
/**
 * 批量查询子节点数据
 * @param params
 */
export const getChildListBatch = (params) =>
  defHttp.get({url: Api.getChildListBatch, params},{isTransformResponse:false});
