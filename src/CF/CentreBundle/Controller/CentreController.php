<?php

namespace CF\CentreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CentreController extends Controller
{
    // Accueil
    public function indexAction()
    {
        return $this->render('CFCentreBundle:Centre:index.html.twig');
    }
    // calcul des rémunérations
    public function remunAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listFormateurs = $em->getRepository('CFCentreBundle:Formateur')->findAll();

        $remun =  array();

        foreach($listFormateurs as $key => $value)
        {
            $remun[$key] = 0;
            foreach($value->getFormations()->toArray() as $formation)
                $remun[$key] += $formation->getDuree()*45;
        }


        return $this->render('CFCentreBundle:Centre:remun.html.twig', array(
            'listFormateurs' => $listFormateurs,
            'remun' => $remun,
        ));
    }
}
