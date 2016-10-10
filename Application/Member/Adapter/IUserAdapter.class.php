<?php
namespace Member\Adapter;

use Marmot\Core;

interface IUserAdapter 
{
	public function get(int $id);

	public function getList(string $ids);

	public function signUp(User $user, array $keys = array());
}