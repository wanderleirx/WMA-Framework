<?php

namespace App\Controllers;

use Core\ShowView;
use App\Models\Home;

class IndexController
{

	private $ShowView;
	private $home;

	public function __construct()
	{
		$this->view = new ShowView;
		$this->home = new Home;
	}

	public function index()
	{
		$data = $this->home->getMessage();
		$this->view->renderView('Home', $data);

	}

}
