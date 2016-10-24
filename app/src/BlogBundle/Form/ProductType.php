<?php

namespace BlogBundle\Form;

use BlogBundle\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price', NumberType::class, [
                'attr' => [
                    'step' => '0.01'
                ]
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'by_reference' => true
            ]);
//        $builder->get('images')->addModelTransformer(new CallbackTransformer(
//            function ($imagesToRelative) {
//                var_dump($imagesToRelative->getSnapshot()->);die;
//                $images = [];
////                if (count($imagesToRelative) == 1){
//                    return new File('upload/' . $imagesToRelative->getSnapshot()[1]->getFile());
////                }
////                foreach ($imagesToRelative as $image){
////                    $file = new File('upload/' . $image->getFile());
////                    $images[] = $file;
////                }
//
////                return $images;
//            }
//            , function ($relativeToImages) {
//            return $relativeToImages;
//        }
//        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Product'
        ));
    }
}
