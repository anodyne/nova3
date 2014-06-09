<?php namespace Nova\Aegis\Users;

interface UserInterface {

	public function getUserId();

	public function getUserLogin();

	public function getUserLoginName();

	public function getUserPassword();

}