<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/31/20
 * Time: 10:27 AM
 */

namespace App\Admin;

use App\Entity\Teams;
use App\Entity\Tournament;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TournamentAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TournamentAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof Tournament
            ? $object->getName()
            : 'Tournament ; Name';
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', TextType::class)
            ->add('slots', NumberType::class)
            ->add('format', ChoiceType::class, [
                'multiple' => true,
                'placeholder' => 'Choice the format ...' ,
                'choices' => [
                    '1vs1' => '1vs1',
                    '5vs5' => '5vs5'
                ]
            ])
            ->add('map', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Summoner\'s Rift' => 'Summoner\'s Rift',
                    'The Proving grounds' => 'The Proving grounds'
                ]
            ])
            ->add('teams', ModelType::class, [
                'class' => Teams::class,
                'property' => 'name',
                'multiple' => true
            ])
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('slots')
            ->add('format')
            ->add('map')
            ->add('teams', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'name']
            ])
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('map')
            ->add('slots')
            ->add('format')
        ;
    }
}