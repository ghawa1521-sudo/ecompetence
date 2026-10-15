<?php
namespace gbaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="gbaneBundle\Repository\FileAttachmentRepository")
 */
class FileAttachment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filepath;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadedAt;

    // Getters and Setters...
}
