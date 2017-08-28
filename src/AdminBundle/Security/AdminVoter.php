<?php

namespace AdminBundle\Security;

use AdminBundle\Entity\AdminUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdminVoter extends Voter
{

    /**
     * @var EvilSecurityRobot
     */
    private $robot;
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {

        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $object)
    {
        if ($attribute != 'ROLE_ADMIN') {
            return false;
        }


        // only vote on AdminUser objects inside this voter
        if (!$object instanceof AdminUser) {
            return false;
        }

        return true;

    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        throw new \LogicException('This code should not be reached!');
    }


}

