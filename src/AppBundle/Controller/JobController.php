<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class JobController extends Controller
{
    /**
     * @Route("/jobs{trailingSlash}{category}", name="jobs", requirements={"category" = "[a-zA-Z\-]+","trailingSlash" = "[/]{0,1}"}, defaults={"category" = "","trailingSlash" = "/"})
     */
    public function jobsAction($category = null)
    {

        $db = $this->getDoctrine()->getManager();

        $categoryes = $db->getRepository('AppBundle:JobCategory')->findByParent(null);

        $category = $db->getRepository('AppBundle:JobCategory')->findByUrl($category);
        $jobs = $db->getRepository('AppBundle:Job')->findBy(
            array('user' => 1),
            array('created' => 'DESC')
        );

        return $this->render('AppBundle:Job:jobs.html.twig', array(
            'jobs' => $jobs,
            'category' => $category,
            'categoryes' => $categoryes,
        ));
    }

    /**
     * @Route("/job/{id}", requirements={"id" = "\d+"}, name="job")
     */
    public function jobAction($id = null)
    {

        $db = $this->getDoctrine()->getManager();

        $job = $db->getRepository('AppBundle:Job')->findById($id);

        return $this->render('AppBundle:Job:job.html.twig', array(
            'job' => $job[0],
        ));
    }

    /**
     * @Route("/job/create", name="jobCreate")
     */
    public function createAction(Request $request)
    {
        $db = $this->getDoctrine()->getManager();
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $title = $form['title']->getData();
            $price = $form['price']->getData();
            $text  = $form['text']->getData();
            $type  = $form['type']->getData();

            $job->setTitle($title);
            $job->setPrice($price);
            $job->setText($text);
            $job->setType($type);

            $em = $this->getDoctrine()->getManager();

            $em->persist($job);
            $em->flush();

            $this->addFlash('notice', 'Job added');

            return $this->redirectToRoute('jobs');
        }
        
        return $this->render('AppBundle:Job:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
