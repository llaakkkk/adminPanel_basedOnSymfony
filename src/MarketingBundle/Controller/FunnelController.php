<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.17
 * Time: 14:52
 */

namespace MarketingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FunnelController extends Controller
{

    /**
     * @Route("/funnel", name="funnel_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function funnelAction(Request $request)
    {
//        $repository = $this->getDoctrine()->getRepository(':UserDevices', 'default');
//
//        $users = $repository->findAll();

        return $this->render('MarketingBundle:Funnel:funnel_reports.html.twig', [

        ]);
    }
}