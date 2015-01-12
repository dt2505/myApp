<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Album;


interface IAlbumManager
{
    public function create($name = null);
    public function delete($album, $flush = true);
    public function persist($album, $owner, $flush = true);

    public function findAll();
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function find($id);

    public function getCurrentAlbum();
    public function getClass();
}
 