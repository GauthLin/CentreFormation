<?php

namespace CF\CentreBundle\Controller;

use CF\CentreBundle\Entity\Formation;
use CF\CentreBundle\Form\FormationType;
use CF\CentreBundle\Form\FormationEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormationController extends Controller
{
   // Affichage de la liste des formations
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listFormations = $em->getRepository('CFCentreBundle:Formation')->findAll();

        return $this->render('CFCentreBundle:Formation:index.html.twig', array(
            'listFormations' => $listFormations,
        ));
    }

    // Ajout d'une nouvelle formation
    public function addAction(Request $request)
    {
        $formation = new Formation();

        $form = $this->createForm(new FormationType(), $formation);
        // Si les données du formulaire sont valides
        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'La formation a bien été créée.');

            return $this->redirect($this->generateUrl('cf_centre_formation'));
        }

        return $this->render('CFCentreBundle:Formation:ajouter.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    // Modification d'une formation
    public function modifAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('CFCentreBundle:Formation')
            ->findFormation($slug);
        // Si la formation n'existe pas
        if(null === $formation)
            return $this->createNotFoundException("La formation n'existe pas.");

        $form = $this->createForm(new FormationEditType(), $formation);
        // Si données correctes
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'La formation a bien été modifiée.');

            return $this->redirect($this->generateUrl('cf_centre_formation'));
        }

        return $this->render('CFCentreBundle:Formation:modifier.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // Suppression d'une formation
    public function delAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('CFCentreBundle:Formation')
            ->findFormation($slug);

        if(null === $formation)
            throw $this->createNotFoundException("Cette formation n'existe pas.");

        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        {
            $em->remove($formation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'La formation a bien été supprimée');

            return $this->redirect($this->generateUrl('cf_centre_formation'));
        }

        return $this->render('CFCentreBundle:Formation:supprimer.html.twig', array(
            'formation' => $formation,
            'form' => $form->createView(),
        ));
    }
}
