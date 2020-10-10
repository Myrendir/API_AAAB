<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 9/25/20
 * Time: 3:39 PM
 */

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegisterFormType
 * @package App\Form
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class RegisterFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summonerName', TextType::class, [
                'label' => 'Summoner Name'
            ])
            ->add('password', PasswordType::class, [
                'property_path' => 'plainPassword',
                'label' => 'Password'
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmation'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Users::class,
            ])
        ;
    }
}