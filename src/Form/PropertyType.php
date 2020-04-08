<?php
namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms', ChoiceType::class, [
              'choices' => $this->getRoomsChoices()
            ])
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
              'choices' => array_flip(Property::HEAT)
            ])
            ->add('options', EntityType::class, [
              'class' => Option::class,
              'choice_label' => 'name',
              'multiple' => true
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            // ->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getRoomsChoices()
    {
        $output = ['0','1','2','3','4','5','6','7','8','9','999'=>'10 ou plus'];
        return array_flip($output);
    }

}
