<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller {
	
	/**
	 * @Route("/new", name="app_image_upload")
	 */
	public function showAction(Request $request)
	{
		$image = new Image();
		$form = $this->createForm(ImageType::class, $image);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			// add necessary values for DB
			$image->fill();
			
			/*
			$helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
			$path = $helper->asset($image, 'image');
			 */
			
			// persist the $image variable to DB
			$em = $this->getDoctrine()->getManager();
			$em->persist($image);
			$em->flush();
			
			
			//return $this->redirect($this->generateURL('app_image_display');
			// later: move to image link w/ details
			// flash message for success...
			$this->addFlash('success', 'Image successfully uploaded!');
			// code to redirect should look something like this.... research?
			// See route: AppBundle\Controller\DisplayController.php
			return $this->redirectToRoute('app_image_display', array(
					'id' => $image->getId()
			));
		}
		
		return $this->render('default/test.html.twig', array(
				'imageForm' => $form->createView(),
		));
	}
}

/*
 * 
 * // $file stores the uploaded image file 
			you should remember to comment this again... lul @var Symfony\Component\HttpFoundation\File\UploadedFile $file 
			$file = $image->getImage();
			
			// get image info...
			$image->setFileType($file->guessExtension());
			$image->setFileSize($file->getClientSize());
			$image->setLength(123);
			$image->setWidth(123);
			
			// generate a unique name for the file before saving it
			$fileName = md5(uniqid()).".".$file->guessExtension();
			
			// move the file to the directory where images are stored
			$file->move($this->getParameter('image_directory'), $fileName);
			
			// Update the 'image' property to store the image filename
			// instead of its contents
			$image->setImage($fileName);
			
