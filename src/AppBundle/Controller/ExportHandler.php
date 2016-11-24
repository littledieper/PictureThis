<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExportHandler extends Controller{

	/**
	 * @Route("/export", name="export")
	 */
	public function showAction(Request $request) {
		
		$img = $_POST["image"];
		
		//Remove leading meta information
		$img = str_replace("data:image/png;base64,", "", $img);
		$img = str_replace(" ", "+", $img);
		
		//Decode the data
		$data = base64_decode($img);
		
		//Write the data to a file in the local file system
		$filepath = "uploads/my-file.png";
		$success = file_put_contents($filepath, $data);
		
		$image = new Image();
		//kind of a hackjob? this takes the local file generated through file_put_contents and "uploads" that
		$file = new UploadedFile($filepath, "upload.png", 'image/png', filesize($filepath), null, true);
		$image->setImage($file);
		//$image = imagecreatefromstring($data);
		$image->fill();
		//persist the $image variable to DB
		$em = $this->getDoctrine()->getManager();
		$em->persist($image);
		$em->flush();
		
		return new JsonResponse($this->generateUrl('app_image_display', array(
				'id' => $image->getId()
		)));
		
		/*
		//this doesn't actually redirect
		return $this->redirectToRoute('app_image_display', array(
				'id' => $image->getId()
		));
		*/				
	}
}
