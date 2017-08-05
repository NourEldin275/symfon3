<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $newTask = new Task(); // Create new task object.

        $form = $this->createForm(TaskType::class, $newTask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($newTask);
            $em->flush();

            $this->addFlash('success', 'Task is saved successfully.');
        }

        $tasks = $em->getRepository('AppBundle:Task')->findAll(); // Retrieve all tasks created

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'tasks' => $tasks,
        ]);
    }
}
