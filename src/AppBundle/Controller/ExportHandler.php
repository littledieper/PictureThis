<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Tag;

class ExportHandler extends Controller{

	/**
	 * @Route("/export", name="export")
	 */
	public function showAction(Request $request) {
		
		// retrieve AJAX
		$img = $_POST["image"];
		$input = $_POST["input"];
		
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
		$image->fill();
		
		//process the tag strings from input field and split by ,
		$tags = explode(",", $input);
		// add the tags to the image
		foreach ($tags as $tag) {
			$image->addTag(new Tag($image, $tag));
		} // end foreach
		
		//persist the $image variable to DB
		$em = $this->getDoctrine()->getManager();
		$em->persist($image);
		$em->flush();
		
		// add flash message for upload success
		$this->addFlash('success', 'Image successfully uploaded!');
		
		/* 
		 * Return json response for AJAX to receive and redirect
		 * See views\default\edit.html.twig for AJAX
		 */
		return new JsonResponse($this->generateUrl('display', array(
				'id' => $image->getId(),
				'tags' => $tags
		)));			
	}
}
