<?php

namespace app\api\controller;

use app\common\controller\FinderApi;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Config;
use think\Validate;
use app\common\library\Token;
use think\Db;
use app\common\exception\UploadException;
use app\common\library\Upload;

/**
 * 插件会员接口
 */
class Finderuser extends FinderApi
{
    protected $noNeedLogin = ['login', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third','getUserInfoByToken','gethToken','createCompanyDatabase'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();


    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->Finderauth->email]);
    }

    /**
     * 会员登录
     *
     * @ApiMethod (POST)
     * @param string $email  邮箱
     * @param string $password 密码
     */
    public function login()
    {
        $account = $this->request->post('email');
        $password = $this->request->post('password');
        if (!$account || !$password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->Finderauth->login($account, $password);
        if ($ret) {
            $data = ['userinfo' => $this->Finderauth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->Finderauth->getError());
        }
    }


    /**
     * 注册会员
     *
     * @ApiMethod (POST)
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email    邮箱
     * @param string $mobile   手机号
     * @param string $code     验证码
     */
    public function register()
    {
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $email = $this->request->post('email');
        $mobile = $this->request->post('mobile');
        $code = $this->request->post('code');
        if (!$password) {
            $this->error(__('Invalid parameters'));
        }
        if ($email && !Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $ret = Ems::check($email, $code, 'register');
        // $this->error(__('Captcha is incorrect'), $ret);
        if (!$ret) {
            $this->error(__('Captcha is incorrect'), $ret);
        }
        $ret = $this->Finderauth->register($username, $password, $email, $mobile, []);
        if ($ret) {
            $data = ['userinfo' => $this->Finderauth->getUserinfo()];
            //自动创建店铺
            $data_shop = [
                'name'  => $username,
                'type'  => 'self',
                'finder_user_id'  => $data['userinfo']['user_id'],
                'create_time'  => time(),
              ];
              Db::name('shop')->insert($data_shop);

              //创建数据库
              $this->createCompanyDatabase($username);

            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->Finderauth->getError());
        }
    }

    /**
     * 退出登录
     * @ApiMethod (POST)
     */
    public function logout()
    {
        if (!$this->request->isPost()) {
            $this->error(__('Invalid parameters'));
        }
        $this->Finderauth->logout();
        $this->success(__('Logout successful'));
    }


    /**
     * 修改邮箱
     *
     * @ApiMethod (POST)
     * @param string $email   邮箱
     * @param string $captcha 验证码
     */
    public function changeemail()
    {
        $user = $this->auth->getUser();
        $email = $this->request->post('email');
        $captcha = $this->request->post('captcha');
        if (!$email || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if (\app\common\model\FinderUser::where('email', $email)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Email already exists'));
        }
        $result = Ems::check($email, $captcha, 'changeemail');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->email = 1;
        $user->verification = $verification;
        $user->email = $email;
        $user->save();

        Ems::flush($email, 'changeemail');
        $this->success();
    }



    /**
     * 重置密码
     *
     * @ApiMethod (POST)
     * @param string $email      邮箱
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetpwd()
    {
        // $type = $this->request->post("type");
        // $mobile = $this->request->post("mobile");
        $email = $this->request->post("email");
        $newpassword = $this->request->post("newpassword");
        $captcha = $this->request->post("captcha");
        if (!$newpassword || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        // if ($type == 'mobile') {
        //     if (!Validate::regex($mobile, "^1\d{10}$")) {
        //         $this->error(__('Mobile is incorrect'));
        //     }
        //     $user = \app\common\model\User::getByMobile($mobile);
        //     if (!$user) {
        //         $this->error(__('User not found'));
        //     }
        //     $ret = Sms::check($mobile, $captcha, 'resetpwd');
        //     if (!$ret) {
        //         $this->error(__('Captcha is incorrect'));
        //     }
        //     Sms::flush($mobile, 'resetpwd');
        // } else {
            if (!Validate::is($email, "email")) {
                $this->error(__('Email is incorrect'));
            }
            $user = \app\common\model\FinderUser::getByEmail($email);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Ems::check($email, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Ems::flush($email, 'resetpwd');
        // }
        //模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->Finderauth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->Finderauth->getError());
        }
    }



    /**
     * Token获取用户信息
     *
     * @ApiMethod (POST)
     * @param string $token      token
     */
    public function getUserInfoByToken()
    {
        $token = $this->request->post("token");
        // return $token;
        if (empty($token)) {
            $this->error(__('Invalid parameters'));
        }
        //模拟一次登录
        $data = Token::get($token);
        $user = Db::name('finder_user')->where(['id'=>$data['user_id']])->field('id,username,email,phone,avatar')->find();
        if ($user) {
            $user = array_merge($user, $data);
            $this->success(__('successful'),$user);
        } else {
            $this->error($this->Finderauth->getError());
        }
    }


    /**
     * 上传文件
     * @ApiMethod (POST)
     * @param File $file 文件流
     */
    public function upload()
    {
        Config::set('default_return_type', 'json');
        //必须设定cdnurl为空,否则cdnurl函数计算错误
        Config::set('upload.cdnurl', '');
        $chunkid = $this->request->post("chunkid");
        if ($chunkid) {
            if (!Config::get('upload.chunking')) {
                $this->error(__('Chunk file disabled'));
            }
            $action = $this->request->post("action");
            $chunkindex = $this->request->post("chunkindex/d");
            $chunkcount = $this->request->post("chunkcount/d");
            $filename = $this->request->post("filename");
            $method = $this->request->method(true);
            if ($action == 'merge') {
                $attachment = null;
                //合并分片文件
                try {
                    $upload = new Upload();
                    $attachment = $upload->merge($chunkid, $chunkcount, $filename);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success(__('Uploaded successful'), ['url' => $attachment->url, 'fullurl' => cdnurl($attachment->url, true)]);
            } elseif ($method == 'clean') {
                //删除冗余的分片文件
                try {
                    $upload = new Upload();
                    $upload->clean($chunkid);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success();
            } else {
                //上传分片文件
                //默认普通上传文件
                $file = $this->request->file('file');
                try {
                    $upload = new Upload($file);
                    $upload->chunk($chunkid, $chunkindex, $chunkcount);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                $this->success();
            }
        } else {
            $attachment = null;
            //默认普通上传文件
            $file = $this->request->file('file');
            try {
                $upload = new Upload($file);
                $attachment = $upload->upload();
            } catch (UploadException $e) {
                $this->error($e->getMessage());
            }

            $this->success(__('Uploaded successful'), ['url' => $attachment->url, 'fullurl' => cdnurl($attachment->url, true)]);
        }

    }


    public function createCompanyDatabase($company='test'){
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
    }

}
