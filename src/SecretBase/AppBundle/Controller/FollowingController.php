<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowingController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getFollowersAction(Request $request)
    {
        $me = $this->getSecurityTokenStorage()->getToken()->getUser();
        $followers = $this->getFollowingHandler()->getFollowers($me);

        return new Response();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getFollowingsAction(Request $request)
    {
        $me = $this->getSecurityTokenStorage()->getToken()->getUser();
        $followings = $this->getFollowingHandler()->getFollowings($me);

        return new Response();
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Rest\Post()
     */
    public function followUserAction(Request $request, $id)
    {
        $me = $this->getSecurityTokenStorage()->getToken()->getUser();

        try {
            $this->getFollowingHandler()->followUser($me, $id);
            return new Response();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     *
     * @Rest\Put()
     */
    public function unfollowUserAction(Request $request, $id)
    {
        $me = $this->getSecurityTokenStorage()->getToken()->getUser();

        try {
            $this->getFollowingHandler()->unfollowUser($me, $id);
            return new Response();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
