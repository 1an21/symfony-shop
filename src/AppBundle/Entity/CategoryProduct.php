<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryProduct
 *
 * @ORM\Table(name="category_product", indexes={@ORM\Index(name="product", columns={"product"}), @ORM\Index(name="category", columns={"category"})})
 * @ORM\Entity
 */
class CategoryProduct
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
     * @var \Products
     *
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;



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
     * Set product
     *
     * @param \AppBundle\Entity\Products $product
     *
     * @return CategoryProduct
     */
    public function setProduct(\AppBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Products
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return CategoryProduct
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
