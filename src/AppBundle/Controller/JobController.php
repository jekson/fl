<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JobController extends Controller
{
    /**
     * @Route("/jobs", name="jobs")
     */
    public function jobsAction()
    {
        
        $db = $this->getDoctrine()->getManager();

        $jobs = $db->getRepository('AppBundle:Job')->findAll();

        return $this->render('AppBundle:Job:jobs.html.twig', array(
            'jobs' => $jobs,
        ));
    }

}
