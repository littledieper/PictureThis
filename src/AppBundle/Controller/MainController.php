<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller {
	
	/**
	 * @Route("/", name="homepage")
	 */
	public function showAction(Request $request)
	{
		/*
		 * Render out the homepage.
		 * See views\default\index.html.twig for HTML
		 */
		return $this->render('default/index.html.twig');
	}
}
