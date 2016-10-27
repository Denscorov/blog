<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.10.16
 * Time: 21:46
 */

namespace BlogBundle\Security;


use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PassEncoder implements PasswordEncoderInterface
{
    public function encodePassword($raw, $salt)
    {
        return hash('sha1', $salt . $raw);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }

}