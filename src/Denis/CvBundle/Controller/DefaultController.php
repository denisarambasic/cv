<?php

namespace Denis\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	//This method render the view for the homepage
    public function indexAction()
    {
        return $this->render('CvBundle:Default:index.html.twig');
    }
	
	//this method generates a login form
	public function loginAction()
	{
		die('Evo me u loginu idemo dalje');
	}
	
	//this method generates a register form
	public function registerAction()
	{
		die('Evo me u register idemo dalje');
	}
	
	
}
