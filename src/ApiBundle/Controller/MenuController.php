<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class MenuController extends Controller
{
    /**
     * @Rest\View
     * @Rest\QueryParam(name="city", requirements="\d+", default="1")
     *
     * @param string $city
     */
    public function getMenuAction($city)
    {
        $categoriesRepository = $this->get('doctrine')->getRepository('AppBundle:Category');
        $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');
        $categories = $categoriesRepository->findAll();
        $allParentCategories = $categoriesRepository->findAllParentCategories();

        foreach ($allParentCategories as $category) {
           $relatedProduct = $productRepository->findRelatedProduct(
               $category->getId(), $city
           );
           if ($relatedProduct instanceof Product) {
               $category->setRelatedProduct($relatedProduct->getId());
           }
        }

        $serialize = $this->get('jms_serializer')->serialize($categories, 'json');

        return array('menu' => $serialize);
    }
}