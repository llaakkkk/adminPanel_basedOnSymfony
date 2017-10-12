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

class MarketingController extends Controller
{

    /**
     * @Route("/marketing", name="marketing_all")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function marketingAction(Request $request)
    {
//        $repository = $this->getDoctrine()->getRepository(':UserDevices', 'default');
//
//        $users = $repository->findAll();

        return $this->render('MarketingBundle:Marketing:marketing_reports.html.twig', [

        ]);
    }
}