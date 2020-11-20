<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/31/20
 * Time: 10:56 AM
 */

namespace App\Admin;

use App\Entity\Teams;
use App\Entity\Type;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TypeAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TypeAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     *
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof Type
            ? $object->getTitle()
            : 'Type : Title';
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title', TextType::class)
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('title')
            ->add('teams', null, [
                'associated_property' => 'name'
            ])
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('title')
        ;
    }
}