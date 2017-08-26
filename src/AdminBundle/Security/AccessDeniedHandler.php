<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.08.17
 * Time: 16:04
 */

namespace AdminBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return mixed
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $content = '403';
        // TODO: Implement handle() method.
        return new Response($content, 403);
    }

}