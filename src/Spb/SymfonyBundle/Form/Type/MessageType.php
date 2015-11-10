<?php
/**
 * MessageType
 *
 * @author Denis Manilo
 */

namespace Spb\SymfonyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType  extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('email', 'email');
        $builder->add('subject', 'text');
        $builder->add('msg', 'textarea');
    }

    public function getName()
    {
        return 'msg';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spb\SymfonyBundle\Entity\Message',
        ));
    }    
}

?>
