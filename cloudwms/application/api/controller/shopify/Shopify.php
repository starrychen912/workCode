<?
namespace app\api\controller\shopify;


use app\common\controller\Api;

class Shopify extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success('请求成功222');
    }
}