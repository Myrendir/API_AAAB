<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/16/20
 * Time: 9:04 AM
 */

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class LoginFormType
 * @package App\Form\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
        ;
    }
}