<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DisplayController extends Controller{
	
	/**
	 * @Route("image/{id}", name="app_image_display")
	 * 
	 */
	public function showAction($id) {
		return $this->render('/default/display.html.twig', array(
				'image' => $id,
		));
	}
	
}