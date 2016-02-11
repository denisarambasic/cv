<?php

namespace Denis\CvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CvType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cvName')
            ->add('nameAndSurname')
            ->add('address')
            ->add('phone')
            ->add('cellPhone')
            ->add('email')
            ->add('dateOfBirth')
            ->add('birthPlace')
            ->add('workExpirience')
            ->add('education')
            ->add('foreignLanguages')
            ->add('tehnicalCapabilities')
            ->add('drivingLicense')
            ->add('additionalInformation')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Denis\CvBundle\Entity\Cv'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'denis_cvbundle_cv';
    }
}
