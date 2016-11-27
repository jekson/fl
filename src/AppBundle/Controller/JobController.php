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

        //$qc = $db->getRepository('AppBundle:JobCategory')->findByParent(null);
        $cats_lvl1 = array();
        //foreach($qc as $cat){ $cats_lvl1[] = $cat; }
        $form = $this->createFormBuilder($job)
            ->add('title', TextType::class, array('label' => 'Название', 'attr' => array('class' => 'field', 'style' => '')))
            ->add('price', TextType::class, array('label' => 'Бюджет', 'attr' => array('class' => 'field w50', 'style' => '')))
            ->add('pay_type', ChoiceType::class, array('label' => false,'choices' => array('В час' => 0, 'В день' => 1, 'В месяц' => 2, 'За проект' => 3) , 'attr' => array('class' => 'field w50', 'style' => '')))
            ->add('text', TextareaType::class, array('label' => 'Опишите ваше задание', 'attr' => array('class' => 'field', 'style' => '')))
            ->add('category', ChoiceType::class, array('label' => 'Специализация задания','choices' => $cats_lvl1 , 'attr' => array('class' => 'field', 'style' => '')))
            ->add('submit', SubmitType::class, array('label' => 'Опубликовать', 'attr' => array('class' => 'button', 'style' => '')))
            ->getForm();

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
