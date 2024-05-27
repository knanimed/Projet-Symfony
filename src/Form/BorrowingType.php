<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Student;
use App\Entity\Borrowing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class BorrowingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateborrowed', DateTimeType::class, ['widget'=> 'single_text','attr' => [
                'style' => 'width: 400px',
                'autofocus' => true,
                'class'=>"form-control mb-3 col-xs-4",
                'date_format' => 'dd-MM-yyyy',
                ]
            ])
            ->add('bookreturned'  , CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input ms-3',
                ]])
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'name',
                'attr'=>['class'=>'form-select','style' => 'width: 400px',]
                
            ])
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
                'attr'=>['class'=>'form-select','style' => 'width: 400px',]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrowing::class,
        ]);
    }
}
