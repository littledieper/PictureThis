<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $imageID;
	
	/**
	 * @OneToMany(targetEntity="Tag", mappedBy="imageID")
	 */
	private $tags;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $fileType;
	
	/**
	 * @ORM\Column(type="bigint")
	 */
	private $fileSize;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $length;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $width;
	
	// required for one-to-many relationship with Tag
	public function __construct() {
		$this->tags = new ArrayCollection();
	}
	


	// ------------ GETTERS AND SETTERS -----------------
	
	
	
	public function getImageID() {
		return $this->imageID;
	}
	public function setImageID($imageID) {
		$this->imageID = $imageID;
		return $this;
	}
	public function getTags() {
		return $this->tags;
	}
	public function setTags($tags) {
		$this->tags = $tags;
		return $this;
	}
	public function getFileType() {
		return $this->fileType;
	}
	public function setFileType($fileType) {
		$this->fileType = $fileType;
		return $this;
	}
	public function getFileSize() {
		return $this->fileSize;
	}
	public function setFileSize($fileSize) {
		$this->fileSize = $fileSize;
		return $this;
	}
	public function getLength() {
		return $this->length;
	}
	public function setLength($length) {
		$this->length = $length;
		return $this;
	}
	public function getWidth() {
		return $this->width;
	}
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	
}