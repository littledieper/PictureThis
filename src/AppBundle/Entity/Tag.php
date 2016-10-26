<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */

class Tag {

	/**
	 * @ManyToOne(targetEntity="Image", inversedBy="tags")
	 * @JoinColumn(name="imageID", referencedColumnName="imageID")
	 */
	private $imageID;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $tag;
	
	
	
	// ---------- GETTERS AND SETTTERS -------------
	
	public function getImageID() {
		return $this->imageID;
	}
	public function setImageID($imageID) {
		$this->imageID = $imageID;
		return $this;
	}
	public function getTag() {
		return $this->tag;
	}
	public function setTag($tag) {
		$this->tag = $tag;
		return $this;
	}
	
	
	
}