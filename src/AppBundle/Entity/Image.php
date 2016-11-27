<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * 
 * @ORM\Table(name="image")
 */
class Image {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Tag", mappedBy="image")
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
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $length;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $width;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $uploadDate;
	
	/**
	 * This is the database entry of the file....
	 * @ORM\Column(type="string")
	 */
	private $fileName;
	
	/**
	 * This is the actual file to be uploaded....
	 * @Assert\Image(
	 * 		maxSize = "8M"
	 * )
	 * @Vich\UploadableField(mapping="image", fileNameProperty="fileName")
	 */
	private $image;
	
	
	// required for one-to-many relationship with Tag
	public function __construct() {
		
		$this->tags = new ArrayCollection();
	}
	
	/**
	 * Instantiates fileSize and fileType when ready to upload to DB
	 */
	public function fill() {
		if ($this->image != null) {
			$this->fileSize = $this->image->getClientSize();
			$this->fileType = $this->image->guessExtension();
			$dimensions = getimagesize($this->image);
			$this->length = $dimensions[0];
			$this->width = $dimensions[1];
		}
	}
	

	
	// ----------- FILE-SPECIFIC UPLOAD GET/SET --------------
	
	/**
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 * @return Image
	 */
	public function setImage(File $image = null){
		$this->image = $image;
		
		if ($image) {
			// It is required that at least one field changes if you are using Doctrine
			// otherwise the event listeners won't be called and the file is lost
			$this->uploadDate = new \DateTime('now');
		} // end if
	}
	public function getImage()
	{
		return $this->image;
	}
	public function getFileName() {
		return $this->fileName;
	}
	public function setFileName($fileName) {
		$this->fileName = $fileName;
		return $this;
	}
	
	
	// ------------ GENERIC GETTERS AND SETTERS -----------------
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
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
	public function getUploadDate() {
		return $this->uploadDate;
	}
	public function setUploadDate($uploadDate) {
		$this->uploadDate = $uploadDate;
		return $this;
	}

}
