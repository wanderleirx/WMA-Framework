<?php

namespace App\Models;

class Home
{

	private $message = 'Seja bem vindo !!!';

	public function getMessage()
	{
		return $this->message;
	}
}
