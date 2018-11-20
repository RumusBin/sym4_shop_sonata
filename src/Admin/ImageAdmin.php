<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fileFieldOptions = ['required' => false];
            $fileFieldOptions['help'] = '<div class="image-inner">';
                $fileFieldOptions['help'] .= '<img id = image_'. $this->getSubject()->getId()
                    . ' src="' . $this->getSubject()->getUrl() . '" class="admin-preview" />';
                $fileFieldOptions['help'] .= '</div>';

        $formMapper
            ->add('file', FileType::class, $fileFieldOptions)
        ;
    }

}