<?php

namespace Gdr3625\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Gdr3625\BackofficeBundle\Entity\Publications;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }
    /**
     * @Route("/back")
     */
    public function backAction()
    {
        return $this->render('base_backoffice.html.twig');
    }

    /**
     * @Route("/equipes", name="equipes")
     */
    public function equipesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipes = $em->getRepository('Gdr3625BackofficeBundle:Equipe')->findAll();

        return $this->render('equipes.html.twig', array(
            'equipes' => $equipes,));
    }
    /**
     * @Route("/equipe/detail/{id}", name="equipe_detail")
     */
    public function equipeDetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $equipe = $em->getRepository('Gdr3625BackofficeBundle:Equipe')->findOneById($id);
        //$brevets = $em->getRepository('Gdr3625BackofficeBundle:Brevets')->findOneById($id);
        //$publications = $em->getRepository('Gdr3625BackofficeBundle:Publications')->findOneById($id);
        return $this->render('equipe_detail.html.twig', array(
            'equipe' => $equipe, ));//'brevets'=>$brevets, 'publications'=>$publications,));
    }

    /**
     * @Route("/flux/actus")
     */
    public function actusAction()
    {

        return $this->render('fluxActus.html.twig');
    }
    /**
     * @Route("/flux/jobs")
     */
    public function jobsAction()
    {

        return $this->render('fluxJobs.html.twig');
    }
    /**
     * @Route("/publications")
     */
    public function publicationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dois = $em->getRepository('Gdr3625BackofficeBundle:Publications')->findAll();
        foreach ($dois as $key=>$doi) {
                $json = file_get_contents('http://api.crossref.org/works/'.$dois[$key]->doi);
                $publications[]=json_decode($json,true);
        }
        return $this->render('publications.html.twig', array(
            'publications'=>$publications,));
    }
    /**
     * @Route("/brevets")
     */
    public function brevetsAction()
    {

        return $this->render('brevets.html.twig');
    }
}
