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
        if ( $this->getSubject() && $imgId = $this->getSubject()->getId()) {
            $fileFieldOptions['help'] = '<img id = image_'. $imgId
                . ' src="' . $this->getSubject()->getUrl() . '" class="admin-preview" />';

        } else {
            $fileFieldOptions['help'] = '<img src="/images/no-photo.jpg" class="admin-preview" />';
        }


        $formMapper
            ->add('file', FileType::class, $fileFieldOptions)
        ;
    }

}