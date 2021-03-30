<?php
interface AccountStorage {
	public function checkAuth($login, $password);
	public function add(Account $account);
	public function loginAlreadyExists($login);
	public function readAllAccount();
	public function update($compte);
	public function updateScore($compte, $score); 
	public function resetScore();
}
