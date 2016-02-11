<?php

namespace Denis\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Denis\UserBundle\Entity\User;
use tFPDF;

class RegisterController extends Controller
{
	
	/**
	 * @Route("/register", name="register-form")
	 * @Template()
	 */
	public function registerAction(Request $request)
	{

		$form = $this->createFormBuilder(null, array(
			'data_class' => 'Denis\UserBundle\Entity\User'
		))
				->add('username', 'text', array(
					'required'=>false
				))
				->add('email', 'email')
				->add('password', 'repeated', array(
					'type' => 'password',
					'invalid_message' => 'Lozinke se moraju podudarati.'
				))
				->getForm();
				
		$form->handleRequest($request);

		if ($form->isValid()) {
			$user = $form->getData();
			//\Doctrine\Common\Util\Debug::dump($user);die;
			$user->setPassword($this->encodePassword($user, $user->getPassword()));
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			$url = $this->generateUrl('cv_homepage');
			return $this->redirect($url);
			
		}
				
		return array('form' => $form->createView());
	}
	
	
	private function encodePassword(User $user, $plainPassword)
	{
		$encoder = $this->container->get('security.encoder_factory')
			->getEncoder($user);
		
		return $encoder->encodePassword($plainPassword, $user->getSalt());
	}
	
	/**
	 * @Route("/test_pdf", name="test-pdf")
	 */
	 
	public function testAction()
	{
	   $pdf = new \tFPDF;
		
	   $pdf->AddPage();
       $pdf->SetFont('Arial','B',16);
	   $pdf->Cell(40,10,'Hello World!');
	   
	   return new Response($pdf->Output(), 200, array(
        'Content-Type' => 'application/pdf'));
	   
	}
	
}