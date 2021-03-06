<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Claroline\CoreBundle\Form\GroupType;
use Claroline\CoreBundle\Entity\Role;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupSettingsType extends GroupType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add(
            'platformRole', 'entity', array(
                'class' => 'Claroline\CoreBundle\Entity\Role',
                'expanded' => false,
                'multiple' => false,
                'property' => 'translationKey',
                'disabled' => false,
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                            ->where("r.type != " . Role::WS_ROLE)
                            ->andWhere("r.name != 'ROLE_ANONYMOUS'");
                }
            )
        );
    }

    public function getName()
    {
        return 'group_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(
            array(
                'translation_domain' => 'platform'
                )
        );
    }
}
