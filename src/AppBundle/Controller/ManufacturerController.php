<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
/**
 * Manufacturer controller.
 *
 * @Route("manufacturers")
 */
class ManufacturerController extends Controller
{
    /**
     * Lists all manufacturer entities.
     *
     * @Route("/", name="manufacturers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $manufacturers = $em->getRepository('AppBundle:Manufacturer')->findAll();

        return $this->render('manufacturer/index.html.twig', array(
            'manufacturers' => $manufacturers,
        ));
    }

    /**
     * Creates a new manufacturer entity.
     *
     * @Route("/new", name="manufacturers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $form = $this->createForm('AppBundle\Form\ManufacturerType', $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($manufacturer->getLogo()!=null) {
                $file = $manufacturer->getLogo();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('logo_directory'),
                    $fileName
                );

                $manufacturer->setLogo($fileName);
            }
            $em->persist($manufacturer);
            $em->flush();

            return $this->redirectToRoute('manufacturers_show', array('id' => $manufacturer->getId()));
        }

        return $this->render('manufacturer/new.html.twig', array(
            'manufacturer' => $manufacturer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a manufacturer entity.
     *
     * @Route("/{id}", name="manufacturers_show")
     * @Method("GET")
     */
    public function showAction(Manufacturer $manufacturer)
    {
        $deleteForm = $this->createDeleteForm($manufacturer);

        return $this->render('manufacturer/show.html.twig', array(
            'manufacturer' => $manufacturer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing manufacturer entity.
     *
     * @Route("/{id}/edit", name="manufacturers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Manufacturer $manufacturer)
    {
        $img=$manufacturer->getLogo();
        if($img!==null) {
            $manufacturer->setLogo(new File($this->getParameter('logo_directory') . '/' . $img));
        }
        $deleteForm = $this->createDeleteForm($manufacturer);
        $editForm = $this->createForm('AppBundle\Form\ManufacturerType', $manufacturer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $manufacturer->getLogo();
            if($file !== null) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('logo_directory'),
                    $fileName
                );
                $manufacturer->setLogo($fileName);
            }
            else {
                $manufacturer->setLogo($img);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manufacturers_edit', array('id' => $manufacturer->getId()));
        }

        return $this->render('manufacturer/edit.html.twig', array(
            'manufacturer' => $manufacturer, 'images' => $img,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a manufacturer entity.
     *
     * @Route("/{id}", name="manufacturers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Manufacturer $manufacturer)
    {
        $form = $this->createDeleteForm($manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($manufacturer);
            $em->flush();
        }

        return $this->redirectToRoute('manufacturers_index');
    }

    /**
     * Creates a form to delete a manufacturer entity.
     *
     * @param Manufacturer $manufacturer The manufacturer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Manufacturer $manufacturer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manufacturers_delete', array('id' => $manufacturer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
