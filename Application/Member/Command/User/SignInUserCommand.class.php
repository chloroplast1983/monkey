<?php
namespace Member\Command\User;

use System\Interfaces\ICommand;

class SignInUserCommand implements ICommand
{
    /**
     * @var string cellphone 手机号
     */
    public $cellphone;
    /**
     * @var string  password 密码
     */
    public $password;

    public function __construct(
        string $cellphone,
        string $password
    ) {
        $this->cellphone = $cellphone;
        $this->password = $password;
    }
}


