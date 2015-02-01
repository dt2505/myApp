<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Services\NoSQLStorage\IDocumentManager;

class CommentManager extends ODManager
{
    const ES_IDX_TYPE = "comments";

    public function __construct(IDocumentManager $dm)
    {
        parent::__construct($dm, self::ES_IDX_TYPE);
    }
}
