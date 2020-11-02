<?php

namespace application\controllers;


class Controller_404 extends Controller
{
	
	function action_index()
	{
		$data = [
			'referrer' => $_SERVER['HTTP_REFERER'],
		];
		$this->view->generate('404_view.php', 'template_view.php', $data);
	}

}
