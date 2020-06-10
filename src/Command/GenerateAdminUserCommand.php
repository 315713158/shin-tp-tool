<?php
/**
 * Author: ShinChen
 * Email: ShinChen_PHP@163.com
 * Date: 2019/7/29 14:47
 */

namespace Shin\Tool\Command;

use App\Main\Model\User;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class GenerateAdminUserCommand extends Command
{
    protected function configure()
    {
        $this->setName('generate-admin-user')->setDescription('命令生成管理员用户');
    }

    protected function execute(Input $input, Output $output)
    {
        $user = new User();
        $result = $user->insertAndUpdate([
            'account' => 'ShinChen',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'nick_name' => '陈鑫',
            'phone' => '13430332432',
            'admin_status' => 1,
        ]);
        if ($result)
            $output->writeln("success");
        else
            $output->writeln("fail");
    }
}