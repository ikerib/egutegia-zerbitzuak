<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Eskaera;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Document.
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 * @ExclusionPolicy("all")
 * @Vich\Uploadable
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filenamepath", type="string", length=255, nullable=true)
     * @Expose()
     */
    private $filenamepath;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     * @Expose()
     */
    private $filename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="uploadfile", fileNameProperty="filename", size="imageSize")
     *
     * @var File
     */
    private $uploadfile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * @var bool
     * @ORM\Column(name="egutegian", type="boolean", nullable=true, options={"default"=false})
     */
    private $egutegian=false;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var Calendar
     *
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="documents")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $calendar;

    /**
     * @var Eskaera
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Eskaera", inversedBy="documents")
     * @ORM\JoinColumn(name="eskaera_id", referencedColumnName="id",onDelete="CASCADE")
     * @Expose()
     */
    private $eskaera;



    public function __toString()
    {
        return $this->getFilename();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $uploadfile
     *
     * @return Document
     * @throws \Exception
     */
    public function setUploadfile(File $uploadfile = null)
    {
        $this->uploadfile = $uploadfile;

        if ($uploadfile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * @return File|null
     */
    public function getUploadfile()
    {
        return $this->uploadfile;
    }

    /**
     * @param string $filename
     *
     * @return Document
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Document
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Document
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set calendar.
     *
     * @param Calendar $calendar
     *
     * @return Document
     */
    public function setCalendar(Calendar $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar.
     *
     * @return Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Document
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set filenamepath
     *
     * @param string $filenamepath
     *
     * @return Document
     */
    public function setFilenamepath($filenamepath)
    {
        $this->filenamepath = $filenamepath;

        return $this;
    }

    /**
     * Get filenamepath
     *
     * @return string
     */
    public function getFilenamepath()
    {
        return $this->filenamepath;
    }

    /**
     * Set eskaera
     *
     * @param Eskaera $eskaera
     *
     * @return Document
     */
    public function setEskaera(Eskaera $eskaera = null)
    {
        $this->eskaera = $eskaera;

        return $this;
    }

    /**
     * Get eskaera
     *
     * @return Eskaera
     */
    public function getEskaera()
    {
        return $this->eskaera;
    }

    /**
     * Set egutegian
     *
     * @param boolean $egutegian
     *
     * @return Document
     */
    public function setEgutegian($egutegian)
    {
        $this->egutegian = $egutegian;

        return $this;
    }

    /**
     * Get egutegian
     *
     * @return boolean
     */
    public function getEgutegian()
    {
        return $this->egutegian;
    }
}
