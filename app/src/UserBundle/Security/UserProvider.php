<?php

namespace UserBundle\Security;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider extends Controller implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        var_dump($username);die;
        // make a call to your webservice here
//        $userData = ...
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = '...';

            // ...

//            return new User($username, $password, $salt, $roles);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'UserBundle\Entity\User';
    }

}