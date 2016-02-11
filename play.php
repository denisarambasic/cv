<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

//config
$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

//dohvatit view
/*
$templating = $container->get('templating');
echo $templating->render(
	'EventBundle:Default:index.html.twig',
	array('name'=>'Denis', 'count' => 5)
);
*/
//Pisati u bazu:

use Denis\UserBundle\Entity\User;

$user = new User();

$user->setUsername('denis');
$user->setPassword(encodePassword($user, 'denispass'));


$em = $container->get('doctrine')->getManager();
$em->persist($user);
$em->flush();

function encodePassword(User $user, $plainPassword)
{
	
	global $container;
	
	$factory = $container->get('security.encoder_factory');
	
	$encoder = $factory->getEncoder($user);
	$password = $encoder->encodePassword($plainPassword, $user->getSalt());

	return $password;
}
