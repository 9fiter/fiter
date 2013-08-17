<?php

namespace Fiter\MinecraftDonationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderNumber')
            ->add('amount')
            ->add('paymentInstruction', 'entity', array(
                'class' => 'JMSPaymentCoreBundle:PaymentInstruction',
                'property' => 'id'
            ))
            ->add('product', null //'hidden' 
                ,array(
                 'label'=> 'main.product',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftDonationBundle\Entity\Pedido'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftdonationbundle_pedidotype';
    }
}
