<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Debug\Debug;

Debug::enable();



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
     * @Route("/job/create/{type}", requirements={"type" = "\d+"}, name="jobCreate", defaults={"type" = "1"})
     */
    public function createAction(Request $request, $jobTypeId = 1)
    {
        $db = $this->getDoctrine()->getManager();
        $jobType = $db->getRepository('AppBundle:JobType')->find($jobTypeId);

        $job = new Job();
        $job->setType($jobType);

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $db->persist($job);
            $db->flush();

            

            $this->addFlash('notice', 'Job added');

            return $this->redirectToRoute('jobs');
        }
        
        return $this->render('AppBundle:Job:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
