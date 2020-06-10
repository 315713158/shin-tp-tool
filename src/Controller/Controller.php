<?php
/**
 *  Author:        ShinChen
 *  Email:         shinchen_php@163.com
 *  Create Time:   2018/11/7 11:56
 */

namespace Shin\Tool\Controller;

use Shin\Tool\Token\Token;

/**
 * Main 控制
 *
 * Class Controller
 * @package App\Main\Controller
 */
class Controller
{
    protected $enableLoginValidate = true;

    protected $adminInfo = [];

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        #登陆
        $this->loginValidate();

    }

    /**
     * 登录验证
     */
    protected function loginValidate()
    {
        if ($this->enableLoginValidate) {

            if (isset($_SERVER['HTTP_AUTHORIZE']) && $_SERVER['HTTP_AUTHORIZE']) $this->validateToken($_SERVER['HTTP_AUTHORIZE']);
            else abort(401, '未登录');
        }
    }

    /**
     * 验证token
     *
     * @param $token
     */
    private function validateToken($token)
    {
        $token = ltrim(strstr($token, ' '));
        $this->adminInfo = (new Token)->getAdminInfo($token);
        if (!isset($this->adminInfo['data'])) abort(401, '未登录');
    }
}