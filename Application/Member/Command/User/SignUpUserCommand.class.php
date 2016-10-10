<?php
namespace Member\Command\User;

use System\Interfaces\ICommand;

class SignUpUserCommand implements ICommand
{
    /**
     * @var string cellPhone 手机号
     */
    public $cellPhone;
    /**
     * @var string userName 用户名
     */
    public $userName;
    /**
     * @var string  password 密码
     */
    public $password;
    /**
     * @var int $uid 注册用户id,回填
     */
    public $uid;

    public function __construct(
        string $cellPhone,
        string $password,
        string $userName,
        int $uid = 0
    ) {
        $this->cellPhone = $cellPhone;
        $this->userName = $userName;
        $this->password = $password;
        $this->uid = $uid;
    }
}
