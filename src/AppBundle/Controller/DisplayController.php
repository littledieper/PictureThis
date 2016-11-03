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
		$image = $this->getDoctrine()
			->getRepository('AppBundle:Image')
			->find($id);
		
		// grab the path to the image in the directory
		$helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
		$path = $helper->asset($image, 'image');
		
		return $this->render('/default/display.html.twig', array(
				'path' => $path
		));
	}
	
}