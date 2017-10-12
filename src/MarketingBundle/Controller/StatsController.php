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

class StatsController extends Controller
{

    /**
     * @Route("/stats", name="stats_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statsAction(Request $request)
    {
//        $repository = $this->getDoctrine()->getRepository(':UserDevices', 'default');
//
//        $users = $repository->findAll();

        return $this->render('MarketingBundle:Stats:stats_reports.html.twig', [

        ]);
    }
}