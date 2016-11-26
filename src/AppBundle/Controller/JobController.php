<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        $job = new Job;

        $qc = $db->getRepository('AppBundle:JobCategory')->findByParent(null);
        $cats_lvl1 = array();
        //foreach($qc as $cat){ $cats_lvl1[] = $cat; }
        $form = $this->createFormBuilder($job)
            ->add('title', TextType::class, array('label' => 'Название', 'attr' => array('class' => 'field', 'style' => '')))
            ->add('text', TextareaType::class, array('label' => 'Опишите ваше задание', 'attr' => array('class' => 'field', 'style' => '')))
            ->add('type', ChoiceType::class, array('label' => 'Специализация задания','choices' => $qc , 'attr' => array('class' => 'field', 'style' => '')))
            ->add('submit', SubmitType::class, array('label' => 'Опубликовать', 'attr' => array('class' => 'button', 'style' => '')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            die('ok');
        }
        
        return $this->render('AppBundle:Job:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
