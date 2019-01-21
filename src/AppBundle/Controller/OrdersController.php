<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Order controller.
 *
 * @Route("orders")
 */
class OrdersController extends Controller
{
    /**
     * Lists all order entities.
     *
     * @Route("/", name="orders_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('AppBundle:Orders')->findAll();

        return $this->render('orders/index.html.twig', array(
            'orders' => $orders,
        ));
    }

    /**
     * Creates a new order entity.
     *
     * @Route("/new", name="orders_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $order = new Orders();
        $form = $this->createForm('AppBundle\Form\OrdersType', $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('orders_show', array('id' => $order->getId()));
        }

        return $this->render('orders/new.html.twig', array(
            'order' => $order,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a order entity.
     *
     * @Route("/{id}", name="orders_show")
     * @Method("GET")
     */
    public function showAction(Orders $order)
    {
        $deleteForm = $this->createDeleteForm($order);

        return $this->render('orders/show.html.twig', array(
            'order' => $order,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing order entity.
     *
     * @Route("/{id}/edit", name="orders_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Orders $order)
    {
        $deleteForm = $this->createDeleteForm($order);
        $editForm = $this->createForm('AppBundle\Form\OrdersType', $order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_edit', array('id' => $order->getId()));
        }

        return $this->render('orders/edit.html.twig', array(
            'order' => $order,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a order entity.
     *
     * @Route("/{id}", name="orders_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Orders $order)
    {
        $form = $this->createDeleteForm($order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
        }

        return $this->redirectToRoute('orders_index');
    }

    /**
     * Creates a form to delete a order entity.
     *
     * @param Orders $order The order entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Orders $order)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orders_delete', array('id' => $order->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
