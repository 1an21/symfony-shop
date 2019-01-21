<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="category", columns={"id"})})
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_parent", type="integer", nullable=false)
     */
    private $isParent;



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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set isParent
     *
     * @param integer $isParent
     *
     * @return Category
     */
    public function setIsParent($isParent)
    {
        $this->isParent = $isParent;

        return $this;
    }

    /**
     * Get isParent
     *
     * @return integer
     */
    public function getIsParent()
    {
        return $this->isParent;
    }
}
