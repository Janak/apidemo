<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Limenius\Liform\Resolver;
use Limenius\Liform\Liform;
use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;


class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     * authentication=true,
     * resource=true,
     * description="Registration",
     * )
     * 
     * @Route("/api/user/register", name="user_register")
     * 
     * @Method({"POST"})
     */
    public function registerAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $encoder = $this->container->get('security.password_encoder');

        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));

        $em->persist($user);
        $em->flush($user);

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

    /**
     * @ApiDoc(
     * authentication=true,
     * resource=true,
     * description="get user information by email",
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="user email"}
     *  }
     * )
     * 
     * @Route("/api/user/get", name="user_api")
     */
    public function getUserAction(Request $request, $email="rakesh@aspl.in")
    {
        
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        // the above is a shortcut for this
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $data = $user; // get data, in this case list of users.
        
        /*
        $task = new User('janak');
        $resolver = new Resolver();
        $liform = new Liform($resolver);
        
        $form = $this->createFormBuilder()
        ->add('task', TextType::class)
        ->add('dueDate', DateType::class, array('widget' => 'single_text'))
        ->add('save', SubmitType::class, array('label' => 'Create Task'))
        ->getForm();
        
        $schema = json_encode($liform->transform($form));
        
        //return var_dump($form->createView());
        
        */
        $view = $this->view($data);
        return $this->handleView( $view );
        
        /*
        $view = $this->view($data, 200)
        ->setTemplate("AppBundle:Users:getUsers.html.twig")
        ->setTemplateVar('users');
        */
        
        return $this->handleView($view);
        
        //return new Response(sprintf('Rakesh %s', $user->getUsername()));
    }
    
    /**
     * @ApiDoc(
     * authentication=true,
     * resource=true,
     * description="get token",
     *  parameters={
     *      {"name"="_username", "dataType"="string", "required"=true, "description"="username"},
     *      {"name"="_password", "dataType"="string", "required"=true, "description"="username"}
     *  }
     * )
     *
     * @Route("/login_check", name="user_login")
     * 
     * @Method({"POST"})
     */
    public function loginAction()
    {
    }
    
    /**
     * @ApiDoc(
     * )
     *
     * @Route("/api/search/", name="search_home")
     *
     * @Method({"Get"})
     */
    public function searchHomeAction()
    {
        return new Response();
    }
    
    
    /**
     * @ApiDoc()
     * 
     * @Route("/api/task/form", name="task form")
     * 
     */
    public function getTaskForm()
    {
        $task = new Task();
        
        $form = $this->createForm(TaskType::class, $task);
        $schema = $this->get('liform')->transform($form);
        $view = $this->view($schema);
        return $this->handleView( $view );
        
    }
    
    
}
