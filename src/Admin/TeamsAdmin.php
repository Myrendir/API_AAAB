<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/31/20
 * Time: 10:42 AM
 */

namespace App\Admin;

use App\Entity\Teams;
use App\Entity\Type;
use App\Entity\Users;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TeamsAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TeamsAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     *
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof Teams
            ? $object->getName()
            : 'Team : Name';
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', TextType::class)
            ->add('type', ModelType::class, [
                'class' => Type::class,
                'property' => 'title'
            ])
            ->add('score', NumberType::class, [
                'required' => false
            ])
            ->add('status', CheckboxType::class)
            ->add('top', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName',
            ])
            ->add('mid', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName',
            ])
            ->add('jungle', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName',
            ])
            ->add('adc', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName',
            ])
            ->add('support', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName',
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
            ->add('type', null, [
                'associated_property' => 'title'
            ])
            ->add('score')
            ->add('status')
            ->add('top', null, [
                'associated_property' => 'summonerName'
            ])
            ->add('jungle', null, [
                'associated_property' => 'summonerName'
            ])
            ->add('mid', null, [
                'associated_property' => 'summonerName'
            ])
            ->add('adc', null, [
                'associated_property' => 'summonerName'
            ])
            ->add('support', null, [
                'associated_property' => 'summonerName'
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
        ;
    }
}