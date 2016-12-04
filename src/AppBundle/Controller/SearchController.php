<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;

class SearchController extends Controller{
	
	/**
	 * @Route("/search", name="search")
	 */
	public function searchAction(Request $request) {
		
		// create the search form to handle the search request
		$form = $this->createFormBuilder()
				->setAction($this->generateUrl('search'))
				->setMethod('GET')
				->add( 'input', TextType::class, array('label' => false, 'attr' => array('placeholder' => 'Search')) )
				->add ( 'submit', SubmitType::class, array('label' => 'Submit') )
				->getForm ();
		
		$form->handleRequest($request);	
		if ($form->isSubmitted()) {
			// grab the data from the form
			$data = $form->getData();
			$input = $data["input"];
			
			// need to access DB so we'll get the entity manager
			$em = $this->getDoctrine()->getManager();
			
			// create the query to search for the imageID's with the tag in DB
			// this about made me want to punch several items in my bedroom
			$rsm = new ResultSetMapping();
			$rsm->addEntityResult('AppBundle:Tag', 't');
			$rsm->addScalarResult('imageID', 'imageID');
			// create SQL query
			$query = $em->createNativeQuery('SELECT DISTINCT imageID FROM tag WHERE tag = :input', $rsm);
			$query->setParameter('input', $input);
			// retreive the results from query
			$ids = $query->getResult();
			
			// now we retrieve the images..
			$images = array();
			foreach ($ids as $id) {
				$images[] = $this->getDoctrine()->getRepository('AppBundle:Image')->find($id["imageID"]);
			}
			
			// redirect to proper area
			return $this->render ( 'default/gallery.html.twig', array (
					'images' => $images 
			) );
		} // end if
		
		// render search form
		return $this->render('default/search.html.twig', array(
			'form' => $form->createView()	
		));
	}
}