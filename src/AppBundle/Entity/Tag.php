<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */

class Tag {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\ManyToOne(targetEntity="Image", inversedBy="tags")
	 * @ORM\JoinColumn(name="imageID", referencedColumnName="id")
	 */
	private $image;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	private $tag;
	
	
	
	// ---------- GETTERS AND SETTTERS -------------
	
	public function getImage() {
		return $this->image;
	}
	public function setImage($image) {
		$this->image = $image;
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