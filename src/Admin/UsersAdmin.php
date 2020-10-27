<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/26/20
 * Time: 4:28 PM
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UsersAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UsersAdmin extends AbstractAdmin
{
    public function toString($object)
    {

    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('summonerName', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('summonerName')
            ->add('email')
            ->add('createdAt')
            ->add('createdBy')
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('summonerName')
            ->add('email')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('UpdatedBy')
        ;
    }
}