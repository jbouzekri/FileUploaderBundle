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
use Symfony\Component\Security\Core\SecurityContext;

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
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * Constructor
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     * @param SecurityContext $securityContext
     */
    public function __construct(ObjectManager $em, SecurityContext $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
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

        $user = $this->getAuthUser($value, $constraint);

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

    /**
     * Get authenticated user id
     *
     * @return int
     */
    protected function getAuthUser($value, $constraint)
    {
        // No token. Violation as there is a user id associate with file.
        $token = $this->securityContext->getToken();
        if (null === $token) {
            return $this->createViolation($value, $constraint);
        }

        // No user. Violation as there is a user id associate with file.
        $user = $token->getUser();
        if (!is_object($user)) {
            return $this->createViolation($value, $constraint);
        }

        return $user;
    }
}
