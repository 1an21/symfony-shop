<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="category", columns={"id"})})
 * @ORM\Entity
 * @Gedmo\Tree(type="nested")
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
     * @Gedmo\TreeLeft
     * @ORM\Column(name="tree_left", type="integer")
     */
    private $treeLeft;
    /**
     * @var integer
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(name="tree_level", type="integer")
     */
    private $treeLevel;
    /**
     * @var integer
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="tree_right", type="integer")
     */
    private $treeRight;
    /**
     * @var Category
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     */
    private $parent;
    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"treeLeft" = "ASC"})
     */
    private $children;
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $level
     */
    public function setTreeLevel($level)
    {
        $this->treeLevel = $level;
    }
    /**
     * @return int
     */
    public function getTreeLevel()
    {
        return $this->treeLevel;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * @param int $treeLeft
     */
    public function setTreeLeft($treeLeft)
    {
        $this->treeLeft = $treeLeft;
    }
    /**
     * @return int
     */
    public function getTreeLeft()
    {
        return $this->treeLeft;
    }
    /**
     * @param int $treeRight
     */
    public function setTreeRight($treeRight)
    {
        $this->treeRight = $treeRight;
    }
    /**
     * @return int
     */
    public function getTreeRight()
    {
        return $this->treeRight;
    }
    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
