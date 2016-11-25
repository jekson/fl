<?php

namespace AppBundle\Controller;

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
        $jobs = $db->getRepository('AppBundle:Job')->findAll();

        return $this->render('AppBundle:Job:jobs.html.twig', array(
            'jobs' => $jobs,
            'categoryes' => $categoryes,
        ));
    }

    /**
     * @Route("/job/{id}", name="job")
     */
    public function jobAction($id = null)
    {

        $db = $this->getDoctrine()->getManager();

        $job = $db->getRepository('AppBundle:Job')->findById($id);

        return $this->render('AppBundle:Job:job.html.twig', array(
            'job' => $job[0],
        ));
    }

}
