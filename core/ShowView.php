<?php

namespace Core;

class ShowView
{
    private $view;
	private $data;

    public function renderView($view, $data)
    {
    	$this->view = $view;
        $this->data = $data;
        require __DIR__ . "/../app/Views/layout.phtml";
    }

    public function renderTemplate($templateView)
    {
    	require __DIR__ . "/../app/Views/templates/" . $templateView . ".phtml";
    }

    public function renderContent()
    {
        return require __DIR__ . "/../app/Views/" . $this->view . "/index.phtml";
    }

}