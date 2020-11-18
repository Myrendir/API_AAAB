<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/18/20
 * Time: 10:14 AM
 */

namespace App\Form\Entity;

use App\Entity\Teams;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TeamFormType
 * @package App\Form\Entity
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TeamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('top', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
            ->add('mid', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
            ->add('jungle', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
            ->add('adc', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
            ->add('support', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teams::class
        ]);
    }
}