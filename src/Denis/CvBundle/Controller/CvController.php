<?php

namespace Denis\CvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Denis\CvBundle\Entity\Cv;
use Denis\CvBundle\Form\CvType;

/**
 * Cv controller.
 *
 */
class CvController extends Controller
{

    /**
     * Lists all Cv entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
		$user= $this->getUser();
        $entities = $em->getRepository('CvBundle:Cv')->getCvsForUser($user);
        //$entities = $em->getRepository('CvBundle:Cv')->findAll();
		
		//\Doctrine\Common\Util\Debug::dump($entities);die;
		$deleteForm = $this->createDeleteForm();
		
		$intentions = 'unknown';  
		$csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken($intentions);
        return $this->render('CvBundle:Cv:index.html.twig', array(
            'entities' => $entities,
			'delete_form' => $deleteForm->createView(),
			'csrfToken' => $csrfToken
        ));
    }
    /**
     * Creates a new Cv entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cv();
		
		/* ovo je dodano */
			$user = $this->getUser();
			$entity->setOwner($user);
		/* kraj */
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cv'));
            //return $this->redirect($this->generateUrl('cv_show', array('id' => $entity->getId())));
        }

        return $this->render('CvBundle:Cv:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cv entity.
     *
     * @param Cv $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cv $entity)
    {
        $form = $this->createForm(new CvType(), $entity, array(
            'action' => $this->generateUrl('cv_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cv entity.
     *
     */
    public function newAction()
    {
        $entity = new Cv();
        $form   = $this->createCreateForm($entity);

        return $this->render('CvBundle:Cv:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cv entity.
     *
     */
    public function showAction($id)
    {
	
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CvBundle:Cv')->find($id);
		
		//check if the user is the right one
		$this->checkUser($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cv entity.');
        }
		
		//Create the pdf from the cv object
		$this->generatePdf($entity);
		

    }

    /**
     * Displays a form to edit an existing Cv entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CvBundle:Cv')->find($id);
		
		//check if the user is the right one
		$this->checkUser($entity);
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cv entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('CvBundle:Cv:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cv entity.
    *
    * @param Cv $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cv $entity)
    {
        $form = $this->createForm(new CvType(), $entity, array(
            'action' => $this->generateUrl('cv_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cv entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CvBundle:Cv')->find($id);
		
		//check if the user is the right one
		$this->checkUser($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cv entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cv_edit', array('id' => $id)));
        }

        return $this->render('CvBundle:Cv:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cv entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
	
		
	
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CvBundle:Cv')->find($id);
			
			//check if the user is the right one
			$this->checkUser($entity);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cv entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cv'));
    }

    /**
     * Creates a form to delete a Cv entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm($id=null)
    {
        return $this->createFormBuilder()
            //->setAction($this->generateUrl('cv_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr' => array('class' => 'submit-delete')))
            ->getForm();
    }
	
	/**
	 * check if the user is the right one
	 *
	 */
	private function checkUser($entity)
	{
		$user = $this->getUser();
		if($user !== $entity->getOwner())
		{
			throw new AccessDeniedException('Access forbiden');
		}
	}
	
	private function generatePdf($entity)
	{
		
		$pdf = new \tFPDF();

		$pdf->AddPage();


		// Unicode font (UTF-8)
		$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$pdf->SetFont('DejaVu','',14);

		
		$pdf->SetTitle( "CV "); 


		/* set variables */
			$name_and_surname = 'Name and surname';
			$address = 'Address';
			$phone = 'Phone';
			$cell_phone = 'Cell phone';
			$email = 'Email';
			$date_of_birth = 'Date of birth';
			$birth_place = 'Birth place';
			$work_experience = 'Work experience';
			$education = 'Education';
			$foreign_languages = 'Foreign languages';
			$technical_capabilities = 'Technical capabilities';
			$driving_licence = 'Driving licence';
			$additional_information = 'Additional information';
					
		/* end set variables */


		/* Naslov sa linijom ispod */
		//$txt = 'èæžšðÈÆŽŠÐ';
		$pdf->SetFont('DejaVu','',24);
		$pdf->Cell(190,20, "CV", 0, 1, "C");
		// Linienfarbe auf Blau einstellen  
		$pdf->SetDrawColor(0, 0, 0); 
		// Linienbreite einstellen, 1 mm 
		$pdf->SetLineWidth(1); 
		// Linie zeichnen 
		$pdf->Line(11, 27, 199, 27); 
		$pdf->SetLineWidth(0); 
		/* Kraj naslov sa linijom ispod */

		/* Ime i prezime */
		$pdf->SetY(50);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$name_and_surname: ", 1, 1, "L");

		$pdf->SetY(50);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getNameAndSurname(), 1, 1, "L");
		/* Kraj Ime i prezime*/

		/* Adresa */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$address: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getAddress(), 1, 1, "L");
		/* Kraj adresa*/

		/* Telefon */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$phone: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getPhone(), 1, 1, "L");
		/* Kraj telefon*/

		/* Mobitel */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$cell_phone: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getCellPhone(), 1, 1, "L");
		/* Kraj mobitel*/

		/* Email */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$email: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getEmail(), 1, 1, "L");
		/* Kraj email*/

		/* Datum roðenja */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$date_of_birth: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getDateOfBirth(), 1, 1, "L");
		/* Kraj Datum roðenja*/


		/* Mjesto roðenja */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$birth_place: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getBirthPlace(), 1, 1, "L");
		/* Kraj Mjesto roðenja*/

		/* Radno iskustvo */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->MultiCell(135,6, $entity->getWorkExpirience(), 1, "L", 0);

		$y1 = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,$y1 - $y, "$work_experience: ", 1, 1, "L");
		/* Kraj Radno iskustvo*/

		/* Školovanje */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->MultiCell(135,6, $entity->getEducation(), 1, "L", 0);

		$y1 = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,$y1 - $y, "$education: ", 1, 1, "L");
		/* Kraj školovanje*/

		/* Strani jezici */
		$y = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$foreign_languages: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getForeignLanguages(), 1, 1, "L");
		/* Kraj Strani jezici*/


		/* Teh.sposobnosti */
		$y = $pdf->getY();

		if($y > 240){
			$pdf->AddPage();
			$y = 10;
		}

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->MultiCell(135,6, $entity->getTehnicalCapabilities(), 1, "L", 0);

		$y1 = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,$y1 - $y, "$technical_capabilities: ", 1, 1, "L");
		/* Kraj Teh.sposobnosti*/

		/* Vozaèka dozvola */
		$y = $pdf->getY();

		if($y > 240){
			$pdf->AddPage();
			$y = 10;
		}

		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,10, "$driving_licence: ", 1, 1, "L");

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->Cell(135,10, $entity->getDrivingLicense(), 1, 1, "L");
		/* Kraj Vozaèka dozvola*/
		//$pdf->AddPage();


		/* Dodatne info */
		$y = $pdf->getY();

		if($y > 240){
			$pdf->AddPage();
			$y = 10;
		}

		$pdf->SetY($y);
		$pdf->SetX(65);
		$pdf->MultiCell(135,6, $entity->getAdditionalInformation(), 1, "L", 0);

		$y1 = $pdf->getY();
		$pdf->SetY($y);
		$pdf->SetX(10); 
		$pdf->SetFont('DejaVu','',12);
		$pdf->Cell(55,$y1 - $y, "$additional_information: ", 1, 1, "L");
		/* Kraj Dodatne info */

		   
		return new Response($pdf->Output(), 200, array(
			'Content-Type' => 'application/pdf'));
		
	}
	
}
