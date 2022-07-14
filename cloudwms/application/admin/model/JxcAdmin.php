<?php

namespace app\admin\model;

use think\Model;
use think\Db;
use think\Exception;


class JxcAdmin extends Model
{

    

    

    // 表名
    protected $name = 'jxc_admin';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'data_status_text'
    ];
    
    protected static function init()
    {
        self::afterUpdate(function ($row) {
            $changed = $row->getChangedData();
            //如果有修改状态
            
            if (isset($changed['data_status']) && $changed['data_status']==1) {
                $res = self::createCompanyDatabase($row);
                if(!$res){
                    $this->error("fail");
                }
            }
        });


    }
    
    public function getDataStatusList()
    {
        return ['0' => __('Data_status 0'), '1' => __('Data_status 1')];
    }


    public function getDataStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['data_status']) ? $data['data_status'] : '');
        $list = $this->getDataStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }



    public static function createCompanyDatabase($row=[]){
        try{
           
        //创建数据库导入数据
        $sql = "CREATE DATABASE IF NOT EXISTS `".$row['companyshortname']."_jinxiaocun` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci";
        Db::execute($sql);

        $connect = Db::connect([
            // 数据库类型
            'type'    => 'mysql',
            // 数据库连接DSN配置
            'dsn'     => '',
            // 服务器地址
            'hostname'  => '127.0.0.1',
            // 数据库名
            'database'  => $row['companyshortname'].'_jinxiaocun',
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

        //同步用户
        $connect->query('insert into jxc_admin (`companyname`,`companyshortname`,`adminname`,`adminpass`,`email`,`phone`) VALUES ("'.$row['companyname'].'","'.$row['companyshortname'].'","'.$row['adminname'].'","'.$row['adminpass'].'","'.$row['email'].'","'.$row['phone'].'")');

        return true;
                 
        }catch(Exception $e){
            echo "error:" . $e->getMessage() . "<br/>";
            return false;
        }
    }
}
