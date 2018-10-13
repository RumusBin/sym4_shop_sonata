<?php

namespace App\Admin;


use App\Entity\Category;
use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', ['class'=>'col-md-8'])
                ->add('title', TextType::class)
                ->add('description', TextareaType::class)
            ->end()
            ->with('MetaData', ['class' => 'col-md-4'])
                ->add('category', ModelType::class, [
                    'class' => Category::class,
                    'property' => 'title'
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }

    public function toString($object)
    {
        return $object instanceof Product
            ? $object->getTitle()
            : 'Product'; // shown in the breadcrumb on the create view
    }
}