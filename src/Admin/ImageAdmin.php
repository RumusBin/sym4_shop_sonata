<?php


namespace App\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        if($this->hasParentFieldDescription()) {

            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                $image = $parent->$getter();
            } else {
                $image = null;
            }
        } else {
            $image = $this->getSubject();
        }

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => false];
        if ($image && !$image instanceof ArrayCollection && !$image instanceof PersistentCollection) {
            if ($webPath = $image->getUrl()) {
                // add a 'help' option containing the preview's img tag
                $fileFieldOptions['help'] = '<img src="'.$webPath.'" class="admin-preview" />';
            } else {
                foreach ($image as $i) {
                    $fileFieldOptions['help'][] = '<img src="'.$i->getUrl().'" class="admin-preview" />';
                }
            }

        }

        $formMapper
            ->add('file', FileType::class, $fileFieldOptions)
        ;
    }

}