<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * Category
 * @Serializer\AccessorOrder("custom", custom = {"id", "title" ,"children", "RelatedProduct"})
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @Serializer\Exclude()
     */
    private $parent;

    /**
     * @var string
     */
    private $title;

    private $relatedProduct;

    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Category
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

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Add child
     *
     * @param Category $category
     * @return Category
     */
    public function addChild(Category $category)
    {
        $this->children[] = $category;

        return $this;
    }

    /**
     * Remove child
     *
     * @param Category $category
     */
    public function removeChild(Category $category)
    {
        $this->children->removeElement($category);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get parent
     *
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add parent
     *
     * @param Category $category
     * @return Category
     */
    public function setParent(Category $category)
    {
        $this->parent = $category;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("relatedProduct")
     *
     * @return integer
     */
    public function getRelatedProduct()
    {
        return $this->relatedProduct;
    }

    /**
     * @param mixed $relatedProduct
     */
    public function setRelatedProduct($relatedProduct)
    {
        $this->relatedProduct = $relatedProduct;
    }
}
