<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="product", columns={"id"}), @ORM\Index(name="manufacturer_id", columns={"manufacturer_id"}), @ORM\Index(name="currency", columns={"currency"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var \Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var integer
     *
     * @ORM\Column(name="availability", type="string", columnDefinition="enum('В наличии', 'Нет в наличии')")
     */
    private $availability;

    

    /**
     * @var integer
     *
     * @ORM\Column(name="viewed", type="integer", nullable=true)
     */
    private $viewed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var \Manufacturer
     *
     * @ORM\ManyToOne(targetEntity="Manufacturer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     * })
     */
    private $manufacturer;

    /**
     * @ORM\ManyToMany(targetEntity="Files", cascade={"persist"})
     */
    private $files;

    function __construct() {
        $this->files = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Products
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     *
     * @return Products
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * Set availability
     *
     * @param string $availability
     *
     * @return Products
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Get files
     *
     * @return ArrayCollection
     */
    function getFiles() {
        return $this->files;
    }

    /**
     * Set files
     * @param type $files
     */
    function setFiles($files) {
        $this->files = $files;
    }

    /**
     * Set viewed
     *
     * @param integer $viewed
     *
     * @return Products
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Products
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Products
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set manufacturer
     *
     * @param \AppBundle\Entity\Manufacturer $manufacturer
     *
     * @return Products
     */
    public function setManufacturer(\AppBundle\Entity\Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return \AppBundle\Entity\Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}
