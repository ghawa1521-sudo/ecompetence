<?php

namespace gbaneBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FileAttachmentRepository extends EntityRepository
{
    /**
     * Récupère les fichiers uploadés récemment, limités par un nombre donné.
     *
     * @param int $limit
     * @return FileAttachment[]
     */
    public function findRecentFiles(int $limit = 10)
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.uploadedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
