<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * FileOwnerValidator
 *
 * @author jobou
 */
class FileOwnerValidator extends ConstraintValidator
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(ObjectManager $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Validate that the submitted file is owned by the authenticated user
     *
     * @param string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $fileHistory = $this->em->getRepository('JbFileUploaderBundle:FileHistory')->find($value);
        if (!$fileHistory) {
            return;
        }

        // No userid associated with file. Every one can use it.
        if (!$fileHistory->getUserId()) {
            return;
        }

        // No token. Violation as there is a user id associate with file.
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return $this->createViolation($value, $constraint);
        }

        // No user. Violation as there is a user id associate with file.
        $user = $token->getUser();
        if (!$user) {
            return $this->createViolation($value, $constraint);
        }

        if ($user->getId() !== $fileHistory->getUserId()) {
            return $this->createViolation($value, $constraint);
        }

        return;
    }

    /**
     * Create violation for validator
     *
     * @param string $value
     * @param Constraint $constraint
     */
    protected function createViolation($value, Constraint $constraint)
    {
        $this
            ->context
            ->buildViolation($constraint->message)
            ->setParameter('%filename%', $value)
            ->addViolation();
    }
}
