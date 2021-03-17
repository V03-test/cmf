<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-present http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Released under the MIT License.
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use cmf\controller\AdminBaseController;

class ConfigController extends AdminBaseController
{

    public function ip_config()
    {
       $file =  file_get_contents('https://test-xyqp.oss-cn-beijing.aliyuncs.com/test/configList.json');
        $data_info = decrypt_info($file);
       if(is_array($data_info)){
           $httpList = $data_info['httpList']['ips'];
           $loginList = $data_info['loginList']['ips'];
           $hotList =   $data_info['hotList']['ips'];
           $this->assign('httpList',$httpList);
           $this->assign('loginList',$loginList);
           $this->assign('hotList',$hotList);
       }
       return $this->fetch();
    }

    public function saves()
    {
        $file = file_get_contents('https://test-xyqp.oss-cn-beijing.aliyuncs.com/test/configList.json');
        $data_info = decrypt_info($file);
        if(input('post.')) {
            $parm = input('post.');
            if(is_array($data_info)){
                $data_info['httpList']['ips'] = $parm['httpList'];
                $data_info['loginList']['ips'] = $parm['loginList'];
                $data_info['hotList']['ips'] = $parm['hotList'];
            }
            $datas = encrypt_info(json_encode($data_info));
            $res = file_put_contents('D:\configList.json',$datas);
            if($res!==false) {
                return json(["code"=>1,"message"=>"保存成功"]);
            }
        }
    }

    public function excels()
    {
        $filepath =  'D:\configList.json';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($filepath));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
    }
}
