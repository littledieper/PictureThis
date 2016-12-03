<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditController extends Controller {
	
	/**
	 * @Route("/edit", name="edit")
	 */
	public function showAction(Request $request)
	{
		// display the form for editing...
		return $this->render('default/edit.html.twig');
	}

}