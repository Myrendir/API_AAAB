<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/19/20
 * Time: 8:46 AM
 */

namespace App\Admin;

use App\Entity\Report;
use App\Entity\Users;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ReportAdmin
 * @package App\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ReportAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     *
     * @return int|string|null
     */
    public function toString($object)
    {
        return $object instanceof Report
            ? $object->getId()
            : 'Report : Id';
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
            ->add('date', DateType::class)
            ->add('comment', TextType::class)
            ->add('motif', ChoiceType::class, [
                'multiple' => true,
                'choices'  => [
                    'Insulting, harassing, or offensive language directed at other players' => 'Insulting, harassing, or offensive language directed at other players',
                    'Any kind of hate speech such as homophobia, sexism, racism, and ableism'     => 'Any kind of hate speech such as homophobia, sexism, racism, and ableism',
                    'Intentionally ruining the game for other players with in game actions such as griefing, feeding, or purposely playing in a way to make it harder for the rest of the team'    => 'Intentionally ruining the game for other players with in game actions such as griefing, feeding, or purposely playing in a way to make it harder for the rest of the team',
                    'Leaving or going AFK at any point during the match being played'    => 'Leaving or going AFK at any point during the match being played',
                    'Inappropriate Summoner Names' => 'Inappropriate Summoner Names',
                    'Unnecessarily disruptive language or behavior that derails the match for other players' => 'Unnecessarily disruptive language or behavior that derails the match for other players',
                ]
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
            ->addIdentifier('motif')
            ->add('comment')
            ->add('date')
            ->add('isEnabled')
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('motif')
            ->add('date')
        ;
    }
}