<?php

namespace Denis\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{

	/**
     * @Route("/login", name="login-form")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            );
    }
	
	/**
	 * @Route("/login-check", name="login_check")
	 */
	public function loginCheckAction()
	{
		//Ovo radi symfony za nas
	}
	
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction()
	{
		//Ovo radi symfony za nas
	}

	/**
     * @Route("/test", name="test")
	 */
	public function testAction()
	{
		die('evo ode privremeno dodjemo kada se logiramo');
	}	
}