<?php

namespace AdminBundle\Security;

use AdminBundle\Entity\AdminUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class AdminVoter extends Voter
{

    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @param TokenInterface $token
     * @param mixed $subject
     * @param array $attributes
     * @return mixed
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        // TODO: Implement vote() method.
    }

    /**
     * @param $attribute
     * @param $subject
     * @return mixed
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE, self::DELETE))) {
            return false;
        }

        // only vote on AdminUser objects inside this voter
        if (!$subject instanceof AdminUser) {
            return false;
        }

    }

    /**
     * @param $attribute
     * @param $subject
     * @param TokenInterface $token
     * @return mixed
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof AdminUser) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a AdminUser object, thanks to supports
        /** @var AdminUser $adminUser */
        $adminUser = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($adminUser, $user);
            case self::VIEW:
                return $this->canView($adminUser, $user);
            case self::EDIT:
                return $this->canEdit($adminUser, $user);
            case self::DELETE:
                return$this->canDelete($adminUser, $user);
        }

        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }

        throw new \LogicException('This code should not be reached!');
    }
    private function canView(AdminUser $adminUser, AdminUser $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($adminUser, $user)) {
            return true;
        }

        // the AdminUser object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$adminUser->isPrivate();
    }

    private function canEdit(AdminUser $adminUser, AdminUser $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $adminUser->getOwner();
    }

}