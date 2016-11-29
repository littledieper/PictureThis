<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Image;

class GalleryController extends Controller{
	
	/**
	 * @Route("/gallery", name="gallery")
	 */
	public function showAction(Request $request) {
		
		/*
		 * We'll be making a custom query to grab multiple rows by ID
		 * so we can randomly display the items...
		 */
		$em = $this->getDoctrine()->getManager();
		
		// retrieve max number of rows from table images
		$max = $em->createQuery("select count('id') from AppBundle\Entity\Image")->getSingleScalarResult();
		
		// is this the best way to do this?
		// get paths to images so we can use them in the html
		$helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
		$paths = array();
		for ($i = 0; $i < 5; $i++) {
			$id = rand(0, $max);
			$image = $this->getDoctrine()->getRepository('AppBundle:Image')->find($id);
			$paths[] = $helper->asset($image, 'image');
		}
		
		return $this->render('default/gallery.html.twig', array(
				'paths' => $paths
		));
	}
	
}