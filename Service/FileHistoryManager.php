<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Jb\Bundle\FileUploaderBundle\Entity\FileHistory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;
use Jb\Bundle\FileUploaderBundle\Service\ResolverChain;

/**
 * FileHistoryManager
 *
 * @author jobou
 */
class FileHistoryManager implements FileHistoryManagerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\ResolverChain
     */
    protected $resolvers;

    /**
     * Constructor
     *
     * @param ObjectManager $em
     * @param SecurityContext $securityContext
     * @param \Jb\Bundle\FileUploaderBundle\Service\ResolverChain $imagine
     */
    public function __construct(ObjectManager $em, SecurityContext $securityContext, ResolverChain $resolvers)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->resolvers = $resolvers;
    }

    /**
     * {@inheritDoc}
     */
    public function createAndSave($fileName, $originalName, $type, $userId = null)
    {
        $fileHistory = $this->create($fileName, $originalName, $type, $userId);

        $this->em->persist($fileHistory);
        $this->em->flush();

        return $fileHistory;
    }

    /**
     * {@inheritDoc}
     */
    public function create($fileName, $originalName, $type, $userId)
    {
        $fileHistory = new FileHistory();
        $fileHistory->setFileName($fileName);
        $fileHistory->setOriginalName($originalName);
        $fileHistory->setType($type);
        if ($userId == null) {
            $fileHistory->setUserId($this->getAuthUserId());
        } else {
            $fileHistory->setUserId($userId);
        }

        return $fileHistory;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneByFileName($fileName)
    {
        return $this->em->getRepository('JbFileUploaderBundle:FileHistory')->findOneByFileName($fileName);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(FileHistory $fileHistory)
    {
        // Add file path to response
        $resolver = $this->resolvers->getResolver('assets');
        return $resolver->getUrl($fileHistory->getFilename());
    }

    /**
     * Get authenticated user id
     *
     * @return int
     */
    protected function getAuthUserId()
    {
        $token = $this->securityContext->getToken();
        if (null === $token) {
            return;
        }

        $user = $token->getUser();
        if (!is_object($user)) {
            return;
        }

        return $user->getId();
    }
}
