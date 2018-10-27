<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
       $formMapper
           ->add('title', TextType::class)
           ->add('description', TextType::class)
           ->add('image', AdminType::class)
       ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('title')
            ->add('description')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Category
            ? $object->getTitle()
            : 'Category';
    }

    public function preUpdate($category)
    {
        if ( $image = $category->getImage()) {
            $image->refreshUpdated();
        }
    }

}