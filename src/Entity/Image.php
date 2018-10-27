<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    const IMAGE_UPLOAD_PATH = '/home/rumus/projects/sym4_shop_sonata/sym4_shop_sonata/public/images';

    private $file;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Category", mappedBy="image")
     */
    private $categoryImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getUploadDir()
    {
        return self::IMAGE_UPLOAD_PATH;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $modFilename = md5(uniqid()).'.'.$this->getFile()->guessExtension();

        try {
            // move takes the target directory and target filename as params
            $this->getFile()->move(
                self::IMAGE_UPLOAD_PATH,
                $modFilename
            );
        } catch (FileException $e) {
            return $e->getMessage();
        }
        // set the path property to the filename where you've saved the file
        $this->filename = $modFilename;

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated(): self
    {
        $this->setUpdated(new \DateTime());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoryImage()
    {
        return $this->categoryImage;
    }

    /**
     * @param Category $categoryImage | null
     * @return self
     */
    public function setCategoryImage($categoryImage = null): self
    {
        $this->categoryImage = $categoryImage;
        return $this;
    }

}
