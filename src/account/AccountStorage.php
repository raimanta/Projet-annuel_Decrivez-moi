<?php
interface AccountStorage {
	public function checkAuth($login, $password);
	public function add(Account $account);
	public function loginAlreadyExists($login);
	public function readAllAccount();
}
