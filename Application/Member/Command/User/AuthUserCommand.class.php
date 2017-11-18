<?php
namespace Member\Command\User;

use System\Interfaces\ICommand;

class AuthUserCommand implements ICommand
{
    /**
     * @var int uid 用户id
     */
    public $uid;

    public function __construct(
        int $uid
    ) {
        $this->uid = $uid;
    }
}
