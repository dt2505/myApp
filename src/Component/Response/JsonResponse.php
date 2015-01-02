<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Component\Response;


class JsonResponse extends Response
{
    public function __toString()
    {
        return $this->toJSON();
    }
}
