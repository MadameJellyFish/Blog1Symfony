<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_EDITOR')]
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'titre', 'category'])
            ->setDefaultSort(['createdAT' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            // ->add('id')
            ->add('titre')
            // ->add('category');
            ->add(EntityFilter::new('post'));
    }

    public function configureFields(string $pageName): iterable
    {
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];
        return
        [   yield AssociationField::new('category'),
            // yield IdField::new('id');
            yield TextField::new('titre'),
            yield TextField ::new('description'),
            yield TextEditorField::new('contenue'),
            yield DateTimeField::new('createdAt'), 
            yield ImageField::new('ImageFileName')->setBasePath('uploads/images')->setUploadDir('public/uploads/images')
        ];
      
        
        // $createdAt = yield DateTimeField::new('createdAT')->setFormTypeOptions([
        //     'html5' => true,
        //     'years' => range(date('Y'), date('Y') + 5),
        //     'widget' => 'single_text',
        // ]);
        // if (Crud::PAGE_EDIT === $pageName) {
        //     yield $createdAt->setFormTypeOption('disabled', true);
        // } else {
        //     yield $createdAt;
        // }
                 
}
}
