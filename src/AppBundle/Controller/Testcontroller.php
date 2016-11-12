<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Testcontroller extends Controller {
	
	/**
	 * @Route("/edit", name="edit")
	 */
	public function showAction(Request $request)
	{
		return $this->render('default/edit.html.twig');
	}

}