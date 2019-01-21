<?php

namespace AppBundle\Controller;


use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\Type\CommentType;
/**
 * Class MainController
 * @package AppBundle\Controller
 *
 * @RouteResource("Main")
 */
class MainController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @Route("/", name="all")
     * @Method("GET")
     */

    public function allGetAction(Request $request)
    {
        if($this->get('security.token_storage')->getToken()->getUser() =='anon.'){
            $username = $this->get('security.token_storage')->getToken()->getUser();
        }
        else
            $username = $this->get('security.token_storage')->getToken()->getUser()->getName();
        return $this->render('mainpage/index.html.twig', ['username'=>$username]);
    }







    /**
     * Add a new task
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     section="Task",
     *     output="AppBundle\Entity\Task",
     *     statusCodes={
     *         201 = "Returned when a new task has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     * @Route("/creates", name="create")
     * @Method({"POST", "GET"})
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(TaskType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task = $form->getData();
            if($task->getImage()!=null) {
                $file = $task->getImage();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                $task->setImage($fileName);
            }
            $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $userCreated = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->find( $userId);
            $task->setWhoCreate($userCreated);
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('all');
        }
        return $this->render('Task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @return TaskRepository
     */
    private function getTaskRepository()
    {
        return $this->get('crv.doctrine_entity_repository.task');
    }


    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }



}
