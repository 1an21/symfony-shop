<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
/**
 * Product controller.
 *
 * @Route("products")
 */
class ProductsController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="products_index")
     * @Method("GET")
     */
    public function getAllProductsAction(Request $request)
    {
        $queryBuilder = $this->getProductsRepository()->searchQuery();
        if ($request->query->getAlnum('filter')) {
            $queryBuilder
                ->where('p.title LIKE :name')
                ->setParameter('name', '%' . $request->query->getAlnum('filter') . '%');
        }
        $query = $queryBuilder->getQuery();
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100)
        );
        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="products_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Products();
        $form = $this->createForm('AppBundle\Form\ProductsType', $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $product->getFiles();

            if ($attachments) {
                foreach($attachments as $attachment)
                {
                    $file = $attachment->getFile();

                    var_dump($attachment);
                    $filename = md5(uniqid()) . '.' .$file->guessExtension();

                    $file->move(
                        $this->getParameter('product_directory'), $filename
                    );
                    var_dump($filename);
                    $attachment->setFile($filename);
                }
            }
            $product->setDateCreated(new \DateTime());
            $product->setDateUpdated(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products_show', array('id' => $product->getId()));
        }

        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="products_show")
     * @Method("GET")
     */
    public function showAction(Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('products/show.html.twig', [
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="products_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Products $product)
    {

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductsType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $attachments = $product->getFiles();

            if ($attachments) {
                foreach($attachments as $attachment)
                {
                    $file = $attachment->getFile();
                    $filename = md5(uniqid()) . '.' .$file->guessExtension();
                    $file->move(
                        $this->getParameter('product_directory'), $filename
                    );
                    $attachment->setFile($filename);
                }
            }
            $product->setDateUpdated(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('products_index', array('id' => $product->getId()));
        }
        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="products_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Products $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('products_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Products $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Products $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('products_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getProductsRepository()
    {
        return $this->get('crv.doctrine_entity_repository.products');
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
