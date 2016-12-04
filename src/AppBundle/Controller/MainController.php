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
		 * We'll be making a custom query to grab multiple rows by ID
		 * so we can randomly display the items...
		 */
		$em = $this->getDoctrine()->getManager();
		// retrieve max number of rows from table images
		$max = $em->createQuery("select count('id') from AppBundle\Entity\Image")->getSingleScalarResult();
		
		// retrieve 8 random images
		$images = array();
		for ($i = 0; $i < 8; $i++) {
			$id = rand(1, $max);
			$images[] = $this->getDoctrine()
			->getRepository('AppBundle:Image')
			->find($id);
		} // end for
	
		
		/*
		 * Render out the homepage.
		 * See views\default\index.html.twig for HTML
		 */
		return $this->render('default/index.html.twig', array(
				'images' => $images
		));
	}
}
