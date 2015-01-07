<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class SuccessfulLogoutHandler implements LogoutSuccessHandlerInterface {
    /**
     * Creates a Response object to send upon a successful logout.
     *
     * @param Request $request
     *
     * @return RedirectResponse never null
     */
    public function onLogoutSuccess(Request $request)
    {
        // redirect user back to where they were before logging out by http referer
        $referer_url = $request->headers->get('referer');
        return new RedirectResponse($referer_url);
    }
}