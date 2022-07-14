<?php

namespace app\index\controller;

use addons\wechat\model\WechatCaptcha;
use app\common\controller\Frontend;
use app\common\library\Ems;
use app\common\library\Sms;
use app\common\model\Attachment;
use think\Config;
use think\Cookie;
use think\Hook;
use think\Session;
use think\Validate;
use think\Db;
use think\Exception;

/**
 * 会员中心
 */
class User extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = ['login', 'register', 'third','test','wmsLogin', 'wmsregister','login_post'];
    protected $noNeedRight = ['*'];

    public function _initialize()
    {
        parent::_initialize();
        $auth = $this->auth;

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

        //监听注册登录退出的事件
        Hook::add('user_login_successed', function ($user) use ($auth) {
            $expire = input('post.keeplogin') ? 30 * 86400 : 0;
            Cookie::set('uid', $user->id, $expire);
            Cookie::set('token', $auth->getToken(), $expire);
        });
        Hook::add('user_register_successed', function ($user) use ($auth) {
            Cookie::set('uid', $user->id);
            Cookie::set('token', $auth->getToken());
        });
        Hook::add('user_delete_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
        Hook::add('user_logout_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->view->assign('title', __('User center'));
        return $this->view->fetch();
    }

    /**
     * 注册会员
     */
    public function register()
    {
        $url = $this->request->request('url', '', 'trim');
        if ($this->auth->id) {
            $this->success(__('You\'ve logged in, do not login again'), $url ? $url : url('user/index'));
        }
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $email = $this->request->post('email');
            $mobile = $this->request->post('mobile', '');
            $captcha = $this->request->post('captcha');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:6,30',
                'email'     => 'require|email',
                'mobile'    => 'regex:/^1\d{10}$/',
                '__token__' => 'require|token',
            ];

            $msg = [
                'username.require' => 'Username can not be empty',
                'username.length'  => 'Username must be 3 to 30 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
                'email'            => 'Email is incorrect',
                'mobile'           => 'Mobile is incorrect',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                'email'     => $email,
                'mobile'    => $mobile,
                '__token__' => $token,
            ];
            //验证码
            $captchaResult = true;
            $captchaType = config("fastadmin.user_register_captcha");
            if ($captchaType) {
                if ($captchaType == 'mobile') {
                    $captchaResult = Sms::check($mobile, $captcha, 'register');
                } elseif ($captchaType == 'email') {
                    $captchaResult = Ems::check($email, $captcha, 'register');
                } elseif ($captchaType == 'wechat') {
                    $captchaResult = WechatCaptcha::check($captcha, 'register');
                } elseif ($captchaType == 'text') {
                    $captchaResult = \think\Validate::is($captcha, 'captcha');
                }
            }
            if (!$captchaResult) {
                $this->error(__('Captcha is incorrect'));
            }
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
            }
            if ($this->auth->register($username, $password, $email, $mobile)) {
                $this->success(__('Sign up successful'), $url ? $url : url('user/index'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register|user\/logout)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('captchaType', config('fastadmin.user_register_captcha'));
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Register'));
        return $this->view->fetch();
    }

    /**
     * 会员登录
     */
    public function login()
    {
        $url = $this->request->request('url', '', 'trim');
        if ($this->auth->id) {
            $this->success(__('You\'ve logged in, do not login again'), $url ? $url : url('user/index'));
        }
        if ($this->request->isPost()) {
            $account = $this->request->post('account');
            $password = $this->request->post('password');
            $keeplogin = (int)$this->request->post('keeplogin');
            $token = $this->request->post('__token__');
            $rule = [
                'account'   => 'require|length:3,50',
                'password'  => 'require|length:6,30',
                '__token__' => 'require|token',
            ];

            $msg = [
                'account.require'  => 'Account can not be empty',
                'account.length'   => 'Account must be 3 to 50 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
            ];
            $data = [
                'account'   => $account,
                'password'  => $password,
                '__token__' => $token,
            ];
            var_dump($data);die;
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return false;
            }
            if ($this->auth->login($account, $password)) {
                $this->success(__('Logged in successful'), $url ? $url : url('user/index'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register|user\/logout)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Login'));
        return $this->view->fetch();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        if ($this->request->isPost()) {
            $this->token();
            //退出本站
            $this->auth->logout();
            $this->success(__('Logout successful'), url('user/index'));
        }
        $html = "<form id='logout_submit' name='logout_submit' action='' method='post'>" . token() . "<input type='submit' value='ok' style='display:none;'></form>";
        $html .= "<script>document.forms['logout_submit'].submit();</script>";

        return $html;
    }

    /**
     * 个人信息
     */
    public function profile()
    {
        $this->view->assign('title', __('Profile'));
        return $this->view->fetch();
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        if ($this->request->isPost()) {
            $oldpassword = $this->request->post("oldpassword");
            $newpassword = $this->request->post("newpassword");
            $renewpassword = $this->request->post("renewpassword");
            $token = $this->request->post('__token__');
            $rule = [
                'oldpassword'   => 'require|length:6,30',
                'newpassword'   => 'require|length:6,30',
                'renewpassword' => 'require|length:6,30|confirm:newpassword',
                '__token__'     => 'token',
            ];

            $msg = [
                'renewpassword.confirm' => __('Password and confirm password don\'t match')
            ];
            $data = [
                'oldpassword'   => $oldpassword,
                'newpassword'   => $newpassword,
                'renewpassword' => $renewpassword,
                '__token__'     => $token,
            ];
            $field = [
                'oldpassword'   => __('Old password'),
                'newpassword'   => __('New password'),
                'renewpassword' => __('Renew password')
            ];
            $validate = new Validate($rule, $msg, $field);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return false;
            }

            $ret = $this->auth->changepwd($newpassword, $oldpassword);
            if ($ret) {
                $this->success(__('Reset password successful'), url('user/login'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        $this->view->assign('title', __('Change password'));
        return $this->view->fetch();
    }

    public function attachment()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            $mimetypeQuery = [];
            $where = [];
            $filter = $this->request->request('filter');
            $filterArr = (array)json_decode($filter, true);
            if (isset($filterArr['mimetype']) && preg_match("/[]\,|\*]/", $filterArr['mimetype'])) {
                $this->request->get(['filter' => json_encode(array_diff_key($filterArr, ['mimetype' => '']))]);
                $mimetypeQuery = function ($query) use ($filterArr) {
                    $mimetypeArr = explode(',', $filterArr['mimetype']);
                    foreach ($mimetypeArr as $index => $item) {
                        if (stripos($item, "/*") !== false) {
                            $query->whereOr('mimetype', 'like', str_replace("/*", "/", $item) . '%');
                        } else {
                            $query->whereOr('mimetype', 'like', '%' . $item . '%');
                        }
                    }
                };
            } elseif (isset($filterArr['mimetype'])) {
                $where['mimetype'] = ['like', '%' . $filterArr['mimetype'] . '%'];
            }

            if (isset($filterArr['filename'])) {
                $where['filename'] = ['like', '%' . $filterArr['filename'] . '%'];
            }

            if (isset($filterArr['createtime'])) {
                $timeArr = explode(' - ', $filterArr['createtime']);
                $where['createtime'] = ['between', [strtotime($timeArr[0]), strtotime($timeArr[1])]];
            }

            $model = new Attachment();
            $offset = $this->request->get("offset", 0);
            $limit = $this->request->get("limit", 0);
            $total = $model
                ->where($where)
                ->where($mimetypeQuery)
                ->where('user_id', $this->auth->id)
                ->order("id", "DESC")
                ->count();

            $list = $model
                ->where($where)
                ->where($mimetypeQuery)
                ->where('user_id', $this->auth->id)
                ->order("id", "DESC")
                ->limit($offset, $limit)
                ->select();
            $cdnurl = preg_replace("/\/(\w+)\.php$/i", '', $this->request->root());
            foreach ($list as $k => &$v) {
                $v['fullurl'] = ($v['storage'] == 'local' ? $cdnurl : $this->view->config['upload']['cdnurl']) . $v['url'];
            }
            unset($v);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        $this->view->assign("mimetypeList", \app\common\model\Attachment::getMimetypeList());
        return $this->view->fetch();
    }



    /**
     * wms登录
     */
    public function wmslogin()
    {
        $url = $this->request->request('url', '', 'trim');
        
        if ($this->request->isPost()) {
            $account = $this->request->post('account');
            $password = $this->request->post('password');
            $keeplogin = (int)$this->request->post('keeplogin');
            $token = $this->request->post('__token__');
            $rule = [
                'account'   => 'require|length:3,50',
                'password'  => 'require|length:6,30',
                // '__token__' => 'require|token',
            ];

            $msg = [
                'account.require'  => 'Account can not be empty',
                'account.length'   => 'Account must be 3 to 50 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
            ];
            $data = [
                'account'   => $account,
                'password'  => $password,
                // '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null);
                return false;
            }

            $account_arr = explode(".",$account);
            if(count($account_arr)!=2){
                $this->error('Account should be "Companyshortname.Username"');
                return false;
            }

            $user = Db::name('jxc_admin')->where(['companyshortname' => $account_arr[0],'adminname' => $account_arr[1]])->find();
            if (!$user) {
                $this->error('Account is incorrect');
                return false;
            }

            if ($user['islock'] ==1 || $user['data_status'] ==0) {
                $this->error('Account is locked');
                return false;
            }
            if ($user['adminpass'] != md5($password)) {
                $this->error('Password is incorrect');
                return false;
            }

            // $randomkey = $this->DateTimeFormat(time(), "YmdHis") . $this->random(10);
            // $data = array("lastlogin"=>time(), "logintimes"=>$user['logintimes']+1, "lastloginip"=>$this->get_ip(), "randomkey_app"=>$randomkey);
            // Db::name('jxc_admin')->where(['id' => $user['id']])->update($data);
            // Cookie::set("jxc_jxc_adminauth", $this->encrypt($user['id']."|".$account."|".$user['randomkey']."|jxcadminauth"),time() + (3600*24*365));
            // $post = [
            //     'username' => $account,
            //     'password' => $password,
            //     'act' => 'login',
            // ];
            // $res = $this->login_post("http://183.238.147.82:8211/login.php",$post);
            // var_dump($res);die;
            // header("location:http://183.238.147.82:8211/index.php");
            header("location:http://183.238.147.82:8211/login.php?user_data=".$this->encrypt($account."|".$password)."&act=login");

        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('wmsLogin'));
        return $this->view->fetch();
    }


    /**
     * 注册wms会员
     */
    public function wmsregister()
    {
        $url = $this->request->request('url', '', 'trim');
        if ($this->auth->id) {
            $this->success(__('You\'ve logged in, do not login again'), $url ? $url : url('user/index'));
        }
        if ($this->request->isPost()) {
            $companyname = $this->request->post('companyname');
            $companyshortname = $this->request->post('companyshortname');
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $email = $this->request->post('email');
            $mobile = $this->request->post('mobile', '');
            $captcha = $this->request->post('captcha');
            $token = $this->request->post('__token__');
            $rule = [
                'companyname'  => 'require|length:6,50',
                'companyshortname'  => 'require|length:2,6',
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:6,30',
                'email'     => 'require|email',
                'mobile'    => 'regex:/^1\d{10}$/',
                '__token__' => 'require|token',
            ];

            $msg = [
                'companyname.require' => 'Companyname can not be empty',
                'companyname.length' => 'Companyname must be 6 to 50 characters',
                'companyshortname.require' => 'companyshortname can not be empty',
                'companyshortname.length' => 'companyshortname must be 2 to 6 characters',
                'username.require' => 'Username can not be empty',
                'username.length'  => 'Username must be 3 to 30 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
                'email'            => 'Email is incorrect',
                'mobile'           => 'Mobile is incorrect',
            ];
            $data = [
                'companyname'  => $companyname,
                'companyshortname'  => $companyshortname,
                'username'  => $username,
                'password'  => $password,
                'email'     => $email,
                'mobile'    => $mobile,
                '__token__' => $token,
            ];

            $is_exist = Db::name('jxc_admin')->where(['companyshortname' =>$companyshortname])->find();
            if($is_exist){
                $this->error(__('Companyshortname is already exist'));
            }

            //验证码
            $captchaResult = true;
            $captchaType = config("fastadmin.user_register_captcha");
            if ($captchaType) {
                if ($captchaType == 'mobile') {
                    $captchaResult = Sms::check($mobile, $captcha, 'register');
                } elseif ($captchaType == 'email') {
                    $captchaResult = Ems::check($email, $captcha, 'register');
                } elseif ($captchaType == 'wechat') {
                    $captchaResult = WechatCaptcha::check($captcha, 'register');
                } elseif ($captchaType == 'text') {
                    $captchaResult = \think\Validate::is($captcha, 'captcha');
                }
            }
            if (!$captchaResult) {
                $this->error(__('Captcha is incorrect'));
            }
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
            }

            $ret = $this->auth->register($username, $password, $email, $mobile, []);
            if(!$ret){
                $this->error($this->auth->getError());
            }

            $data = [
                'companyname' => $companyname,
                'companyshortname' => $companyshortname,
                'adminname' => $username,
                'adminpass' => md5($password),
                'email' => $email,
                'phone' => $mobile,
            ];
            $res = Db::name('jxc_admin')->insert($data);
            if ($res){
                // $this->createCompanyDatabase($companyname); 
                // header("location:http://183.238.147.82:8211/login.php?username=".$username."&password=".$password."&act=login");
                $this->success(__('注册成功,请等待管理员审核'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register|user\/logout)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('captchaType', config('fastadmin.user_register_captcha'));
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Register'));
        return $this->view->fetch();
    }

    public function test(){
        // Cookie::set("jxc_jxc_adminauth", $this->encrypt("190|GWX|20211215104406kLeTi2ckU0|jxcadminauth"),time() + 3600);
        // echo cookie('jxc_jxc_adminauth');die;
        // header("Set-Cookie:jxc_jxc_adminauth=191|xxx|20220225111043zXdcFwiHUJ|jxcadminauth; expires=" . gmstrftime("%a, %d-%b-%Y %H:%M:%S GMT", time() + 3600*24));
        // header("location:http://183.238.147.82:8211/index.php");
        // echo $this->encrypt("tm.zck|123456");
        echo $this->decrypt("xpERQtFf-_qiEzQHzbN0BmU");
    }

    function encrypt($txt, $key = 'cjamchz6756ZDAJDKLFJCPCNc78nbcxui'){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
        $ikey ="-cakzmhjkeDUIYFIH789789ZHJKLDHKL7897c9";
        $nh1 = rand(0,64);
        $nh2 = rand(0,64);
        $nh3 = rand(0,64);
        $ch1 = $chars[$nh1];
        $ch2 = $chars[$nh2];
        $ch3 = $chars[$nh3];
        $nhnum = $nh1 + $nh2 + $nh3;
        $knum = 0;$i = 0;
        while(isset($key[$i])) $knum +=ord($key[$i++]);
        $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
        $txt = base64_encode($txt);
        $txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
        $tmp = '';
        $j=0;$k = 0;
        $tlen = strlen($txt);
        $klen = strlen($mdKey);
        for ($i=0; $i<$tlen; $i++) {
            $k = $k == $klen ? 0 : $k;
            $j = ($nhnum+strpos($chars,$txt[$i])+ord($mdKey[$k++]))%64;
            $tmp .= $chars[$j];
        }
        $tmplen = strlen($tmp);
        $tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
        $tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
        $tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
        return $tmp;
    }


    function decrypt($txt, $key = 'cjamchz6756ZDAJDKLFJCPCNc78nbcxui'){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
        $ikey ="-cakzmhjkeDUIYFIH789789ZHJKLDHKL7897c9";
        $knum = 0;$i = 0;
        $tlen = strlen($txt);
        while(isset($key[$i])) $knum +=ord($key[$i++]);
        $ch1 = $txt[$knum % $tlen];
        $nh1 = strpos($chars,$ch1); 
        $txt = substr_replace($txt, '', $knum % $tlen--, 1);
        $ch2 = $txt[$nh1 % $tlen];
        $nh2 = strpos($chars,$ch2);
        $txt = substr_replace($txt, '', $nh1 % $tlen--, 1);
        $ch3 = $txt[$nh2 % $tlen];
        $nh3 = strpos($chars,$ch3);
        $txt = substr_replace($txt, '', $nh2 % $tlen--, 1);
        $nhnum = $nh1 + $nh2 + $nh3;
        $mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3), $nhnum % 8, $knum % 8 + 16);
        $tmp = '';
        $j=0; $k = 0;
        $tlen = strlen($txt);
        $klen = strlen($mdKey);
        for ($i=0; $i<$tlen; $i++) {
            $k = $k == $klen ? 0 : $k;
            $j = strpos($chars,$txt[$i])-$nhnum - ord($mdKey[$k++]);
            while ($j<0) $j+=64;
            $tmp .= $chars[$j];
        }
        $tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
        return base64_decode($tmp);
    }

    function DateTimeFormat($time, $format){
        $date_array = getdate($time);
        $hor = $date_array["hours"];
        $min = $date_array["minutes"];
        $sec = $date_array["seconds"];
        $mon = $date_array["mon"];
        $day = $date_array["mday"];
        $yar = $date_array["year"];
        return date($format, mktime($hor, $min, $sec, $mon, $day, $yar));
    }

    function random($length, $upper=true) {
        $hash = '';
        if(!$upper){
            $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        }else{
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        }
        $max = strlen($chars) - 1;
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    function get_ip()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $cip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
        }else{
        $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }


    public function login_post($url = 'http://183.238.147.82:8211/login.php',$post=[
        'username' => 'xxx',
        'password' => 'xxx@2022',
        'act' => 'login',
    ]){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,0);
        curl_setopt($curl,CURLOPT_COOKIEJAR,'');
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($post));
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
        $data = curl_exec($curl);
        
        $err = curl_error($curl);
        var_dump($err);die;
        curl_close($curl);
        return $err;
    }

    public function createCompanyDatabase($company='test'){
        try{
           
        //创建数据库导入数据
        $sql = "CREATE DATABASE IF NOT EXISTS `".$company."_jinxiaocun` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci";
        Db::execute($sql);

        $connect = Db::connect([
            // 数据库类型
            'type'    => 'mysql',
            // 数据库连接DSN配置
            'dsn'     => '',
            // 服务器地址
            'hostname'  => '127.0.0.1',
            // 数据库名
            'database'  => $company.'_jinxiaocun',
            // 数据库用户名
            'username'  => 'root',
            // 数据库密码
            'password'  => '81d7e8a43d8e8d4a',
            // 数据库连接端口
            'hostport'  => '3306',
            // 数据库连接参数
            'params'   => [],
            // 数据库编码默认采用utf8
            'charset'   => 'utf8',
            // 数据库表前缀
            'prefix'   => 'oc_',
        ]);


        $connect_oc = Db::connect([
            // 数据库类型
            'type'    => 'mysql',
            // 数据库连接DSN配置
            'dsn'     => '',
            // 服务器地址
            'hostname'  => '127.0.0.1',
            // 数据库名
            'database'  => 'jinxiaocun',
            // 数据库用户名
            'username'  => 'root',
            // 数据库密码
            'password'  => '81d7e8a43d8e8d4a',
            // 数据库连接端口
            'hostport'  => '3306',
            // 数据库连接参数
            'params'   => [],
            // 数据库编码默认采用utf8
            'charset'   => 'utf8',
            // 数据库表前缀
            'prefix'   => 'oc_',
        ]);

        $exist = $connect_oc->query('show tables');
                $arr_table = array_column($exist,'Tables_in_jinxiaocun');
//                    print_r($arr_table);die;
                foreach ($arr_table as $val) {
                    $connect->query('create table '.$val.' like `jinxiaocun`.'.$val);
                    // $connect->query('insert into '.$val.' select * from `jinxiaocun`.'.$val);
                    // echo 'create table '.$val.' like `'.$old_database.'`.'.$val;
                    // echo 'insert into '.$val.' select * from `'.$old_database.'`.'.$val;
                }

        return true;
                 
        }catch(Exception $e){
            echo "error:" . $e->getMessage() . "<br/>";
            return false;
        }
    }
}
