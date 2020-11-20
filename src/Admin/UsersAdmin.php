<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/26/20
 * Time: 4:28 PM
 */

namespace App\Admin;

use App\Entity\Users;
use App\Manager\UserManager;
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
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * UsersAdmin constructor.
     * @param $code
     * @param $class
     * @param null $baseControllerName
     * @param UserManager $userManager
     */
    public function __construct($code, $class, $baseControllerName = null, UserManager $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->userManager = $userManager;
    }

    /**
     * @param object $user
     */
    public function preUpdate($user): void
    {
        $this->userManager->updatePassword($user);
    }

    /**
     * @param object $user
     */
    public function prePersist($user)
    {
        $this->userManager->updatePassword($user);
    }

    /**
     * @param object|null $object
     *
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof Users
            ? $object->getSummonerName()
            : 'User : SummonerName';
    }


    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('summonerName', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                'required' => false,
            ])
            ->add('confirmPassword', PasswordType::class, [
                'required' => false
            ])
            ->add('isEnabled')
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('summonerName')
            ->add('email')
            ->add('roles')
            ->add('createdAt')
            ->add('createdBy')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => []
                ]
            ])
            ->add('isEnabled')
        ;
    }

    /**
     * @param ShowMapper $show
     */
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