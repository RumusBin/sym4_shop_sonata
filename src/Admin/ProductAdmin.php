<?php

namespace App\Admin;


use App\Entity\Category;
use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\CoreBundle\Form\Type\CollectionType;
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
                ->add('images', CollectionType::class, [
                    'by_reference' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'id',
                    'limit' => 7
                ])
            ->end()
            ->with('MetaData', ['class' => 'col-md-4'])
                ->add('category', ModelType::class, [
                    'class' => Category::class,
                    'property' => 'title'
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('title')
            ->add('category', null, [], EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('category.title')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Product
            ? $object->getTitle()
            : 'Product'; // shown in the breadcrumb on the create view
    }

    public function prePersist($product)
    {
        $this->preUpdate($product);

    }

    public function preUpdate($product)
    {
        /** @var Product $product */
        $product->setImages($product->getImages());
    }
}