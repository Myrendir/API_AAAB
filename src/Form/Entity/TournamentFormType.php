<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 4:34 PM
 */

namespace App\Form\Entity;

use App\Entity\Teams;
use App\Entity\Tournament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TournamentFormType
 * @package App\Form\Entity
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TournamentFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Name team'
                ]
            ])
            ->add('map', CollectionType::class)
            ->add('format', CollectionType::class)
            ->add('slots', NumberType::class)
            ->add('teams', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'name'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class
        ]);
    }
}