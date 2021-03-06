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
        $query = $request->query->all();

        $query['date-from'] = isset($query['date-from']) && !empty($query['date-from']) ? $query['date-from'] : date('Y-m-d',strtotime("-7 day"));
        $query['date-to'] = isset($query['date-to']) && !empty($query['date-to']) ? $query['date-to'] : date('Y-m-d', time());



        $em = $this->getDoctrine()->getManager('default');

        $result = [];
        if (isset($query['cdate'])){
            foreach ($query['cdate'] as $key => $item) {

                $result[$key] = [
                    'date_range' => $em->getRepository('UserBundle:UserDevices')->getFirstSubscriptionDate($item),
                    'clients_count' => $em->getRepository('UserBundle:UserDevices')->getUsersCountInDate($item),
                    'revenue' => $em->getRepository('MarketingBundle:BillingData')->getUserRevenueByDate($item)['revenue'],
                    'total_revenue' => $em->getRepository('MarketingBundle:BillingData')->getUserRevenueByDate($query)['revenue'],
                    'active_clients' => $em->getRepository('MarketingBundle:BillingData')->getUserCountByDate($item),
                ];

                $result[$key] = array_merge($result[$key], ['cdate' => $query['cdate'][$key]]);

            }
        }


        return $this->render('MarketingBundle:Marketing:marketing_reports.html.twig', [
            'query' => $query,
            'result' => $result

        ]);
    }
}