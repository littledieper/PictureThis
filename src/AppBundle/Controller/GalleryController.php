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
		
		// retrieve 16 random images
		$ids = array();
		$images = array();
		for ($i = 0; $i < 16; $i++) {
			$id = rand(1, $max);
			if (!in_array($id, $ids)) {
				$images[] = $this->getDoctrine()
				->getRepository('AppBundle:Image')
				->find($id);
				$ids[] = $id;	
			} else {
				$i--;
			}
		} // end for
		
		return $this->render('default/gallery.html.twig', array(
				'images' => $images
		));
	} // end showAction
}