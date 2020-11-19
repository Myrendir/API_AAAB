<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/29/20
 * Time: 10:01 AM
 */

namespace App\Admin;

use App\Entity\Sanction;
use App\Entity\Users;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class SanctionAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class SanctionAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     *
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof Sanction
            ? $object->getMotif()
            : 'Sanction : MOTIF';
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('user', ModelType::class, [
                'class' => Users::class,
                'property' => 'summonerName'
            ])
            ->add('startSanction', DateType::class)
            ->add('endSanction', DateType::class)
            ->add('motif', TextType::class)
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('user', null, [
                'associated_property' => 'summonerName'
            ])
            ->addIdentifier('motif')
            ->add('startSanction')
            ->add('endSanction')
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('startSanction')
            ->add('endSanction')
        ;
    }
}