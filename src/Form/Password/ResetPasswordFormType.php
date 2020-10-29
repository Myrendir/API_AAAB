<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/29/20
 * Time: 12:29 PM
 */

namespace App\Form\Password;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResetPasswordFormType
 * @package App\Form\Password
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'property_path' => 'plainPassword'
            ])
            ->add('confirmPassword', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class
        ]);
    }
}