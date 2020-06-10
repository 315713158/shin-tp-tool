<?php
/**
 * Author: ShinChen
 * Email:  shinchen_php@163.com
 * Create_Date: 2018/11/12/22:49
 */

namespace Shin\Tool\Repository;


/**
 * 工具仓库
 *
 * Class Repository
 * @package Shin\Tool\Repository\Repository
 */
class Repository
{
	public function output($success, $code, $data, $message = '')
	{
		return ['success' => $success, 'code' => $code, 'data' => $data, 'message' => $message];
	}
}