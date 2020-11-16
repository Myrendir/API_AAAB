<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/16/20
 * Time: 9:59 AM
 */

namespace App\Security;

use App\Entity\Users;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserChecker
 * @package App\Security
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserChecker implements UserCheckerInterface
{
    /**
     * (@inheritdoc)
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }

        if (!$user->isEnabled()) {
            $ex = new DisabledException('This user is not enabled');
            $ex->setUser($user);
            throw $ex;
        }
    }

    /**
     * (@inheritdoc)
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof Users) {
            return;
        }
    }
}