<?php
/**
 * Author: ShinChen
 * Email:  shinchen_php@163.com
 * Create_Date: 2018/11/13/19:34
 */

namespace Shin\Tool\Model;

use think\Model as BaseModel;

abstract class Model extends BaseModel
{
    /**
     * 新增与更新(更新$where 非空)
     *
     * @param array $params
     * @param array $where
     * @return array
     */
    public function insertAndUpdate(array $params, array $where = []): array
    {
        return ['success' => $this->save($params, $where)];
    }
}