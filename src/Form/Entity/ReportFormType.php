<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 8:32 AM
 */

namespace App\Form\Entity;

use App\Entity\Report;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReportFormType
 * @package App\Form\Entity
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ReportFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'summonerName'
            ])
            ->add('comment', TextType::class)
            ->add('motif', CollectionType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Report::class
        ]);
    }
}