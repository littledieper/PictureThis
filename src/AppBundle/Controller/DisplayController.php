<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DisplayController extends Controller{
	
	/**
	 * @Route("image/{id}", name="display")
	 * 
	 */
	public function showAction($id) {
		$image = $this->getDoctrine()
			->getRepository('AppBundle:Image')
			->find($id);
		
		/**
		 * Directly pass all image info as an array so we can use
		 * the rest of the info when we display, instead of just the path.
		 * 
		 * Perhaps theres a performance benefit too?
		 */
		return $this->render('/default/display.html.twig', array(
				'image' => $image
		));
	}
	
}