<?php

namespace CF\CentreBundle\Controller;

use CF\CentreBundle\Entity\Formateur;
use CF\CentreBundle\Form\FormateurType;
use CF\CentreBundle\Form\FormateurEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormateurController extends Controller
{
    // Récupération des formateurs
    public function indexAction()
    {
        $listFormateurs = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('CFCentreBundle:Formateur')
            ->findAll()
        ;

        return $this->render('CFCentreBundle:Formateur:index.html.twig', array(
            'listFormateurs' => $listFormateurs
        ));
    }
    // Ajout d'un formateur
    public function addAction(Request $request)
    {
        $formateur =  new Formateur();

        $form = $this->createForm(new FormateurType(), $formateur);

        // Si le formulaire est valide
        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formateur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Le formateur a bien été enregistré.');

            return $this->redirect($this->generateUrl('cf_centre_formateur'));
        }

        return $this->render('CFCentreBundle:Formateur:ajouter.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    // Suppression d'un formateur
    public function delAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $formateur = $em
            ->getRepository('CFCentreBundle:Formateur')
            ->findFormateur($slug);
        ;

        // Si le formateur n'existe pas
        if(null === $formateur)
            throw $this->createNotFoundException("Le formateur est inexistant.");

        $form = $this->createFormBuilder()->getForm();
        // Si la suppression a été confirmée
        if($form->handleRequest($request)->isValid())
        {
            $em->remove($formateur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Le formateur a bien été supprimé.');

            return $this->redirect($this->generateUrl('cf_centre_formateur'));
        }
        // Affichage du formulaire
        return $this->render('CFCentreBundle:Formateur:supprimer.html.twig', array(
            'formateur' => $formateur,
            'form' => $form->createView(),
        ));
    }
    // Modification d'un formateur
    public function modifAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formateur = $em->getRepository('CFCentreBundle:Formateur')
            ->findFormateur($slug);

        $form = $this->createForm(new FormateurEditType(), $formateur);

        // Si le formateur n'existe pas
        if(null === $formateur)
            throw $this->createNotFoundException("Le formateur est inexistant.");

        if($form->handleRequest($request)->isValid())
        {
            // Modification du formateur dans le bdd
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Les données ont bien été modifiées.');

            return $this->redirect($this->generateUrl('cf_centre_formateur'));
        }

        return $this->render('CFCentreBundle:Formateur:modifier.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
