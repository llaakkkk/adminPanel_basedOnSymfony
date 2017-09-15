<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.08.17
 * Time: 15:52
 */

namespace AuthBundle\EventListener;

use AdminBundle\Entity\AdminUser;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationListener implements ListenerInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var string Uniquely identifies the secured area
     */
    private $providerKey;


    /**
     * @param GetResponseEvent $event
     * @return mixed
     */



    public function handle(GetResponseEvent $event)
    {
        $adminUser = new AdminUser();

        $request = $event->getRequest();

        $username = $adminUser->getUsername();
        $password = $adminUser->getPassword();

        $unauthenticatedToken = new UsernamePasswordToken(
            $username,
            $password,
            $this->providerKey
        );

        // instances of Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface
        //@TODO providers
        $providers = [];

        $this->authenticationManager = new AuthenticationProviderManager($providers);

        try {
            $authenticatedToken = $this
                ->authenticationManager
                ->authenticate($unauthenticatedToken);

            $this->tokenStorage->setToken($authenticatedToken);

        } catch (AuthenticationException $failed) {
            // authentication failed
        }


    }
}