<?php

namespace Kunstmaan\AdminBundle\Form;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * UserType defines the form used for {@link User}
 */
class UserType extends AbstractType
{

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username')
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'required' => $options['password_required'],
                    'invalid_message' => "The passwords don't match!")
                )
                ->add('email')
                ->add('enabled', 'checkbox', array('required' => false))
                ->add('groups', 'entity', array(
                        'class' => 'KunstmaanAdminBundle:Group',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('g')
                                ->orderBy('g.name', 'ASC');
                        },
                        'multiple' => true,
                        'expanded' => false
                    )
                );
    }

    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'user';
    }

    /**
     * Sets the default options and allowed values for this type.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('password_required' => false));
        $resolver->addAllowedValues(array('password_required' => array(true, false)));
    }

}
