<?php
namespace Member\Adapter\User;

use Member\Model\User;

interface IUserAdapter
{
    public function fetchOne(int $id) : User;

    public function fetchList(array $ids) : array;

    public function signUp(User $user) : bool;

    public function updatePassword(User $user) : bool;

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array;
}
