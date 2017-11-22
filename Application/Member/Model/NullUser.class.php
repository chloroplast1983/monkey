<?php
namespace Member\Model;

use System\Interfaces\INull;

class NullUser extends User implements INull
{
    public function signUp() : bool
    {
        return false;
    }

    public function signOut() : bool
    {
        return false;
    }

    public function updatePassword() : bool
    {
        return false;
    }
}
