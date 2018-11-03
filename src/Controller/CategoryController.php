<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/{slug}", name="category_show")
     * @param $slug
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, $slug)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy([
            'slug' => $slug
        ]);
        $categoryId = $category->getId();
        $em    = $this->getDoctrine()->getManager();
        $dql   = "SELECT p FROM App\Entity\Product p WHERE p.category=$categoryId";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 3)/*limit per page*/
        );
        return $this->render('/category/show.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
