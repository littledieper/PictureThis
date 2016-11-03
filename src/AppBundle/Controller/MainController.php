<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller {
	
	/**
	 * @Route("/", name="homepage")
	 */
	public function showAction(Request $request)
	{
		$image = new Image();
		$form = $this->createForm(ImageType::class, $image);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			// add necessary values for DB
			$image->fill();
			
			// persist the $image variable to DB
			$em = $this->getDoctrine()->getManager();
			$em->persist($image);
			$em->flush();
			
			// return $this->redirect($this->generateURL('app_image_display');
			// later: move to image link w/ details
			// flash message for success...
			$this->addFlash('success', 'Image successfully uploaded!');
			// code to redirect should look something like this.... research?
			// See route: AppBundle\Controller\DisplayController.php
			return $this->redirectToRoute('app_image_display', array(
					'id' => $image->getId()
			));
		}
		
		return $this->render('default/index.html.twig', array(
				'imageForm' => $form->createView(),
		));
	}
}
