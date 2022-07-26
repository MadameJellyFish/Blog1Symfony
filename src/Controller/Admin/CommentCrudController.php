<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            
            ->add('createdAt')
            ->add('post')
            ->add('user');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            yield AssociationField::new('post'),
            yield AssociationField::new('user'),
            yield DateTimeField::new('createdAt'),
            yield TextField::new('contenue')

            // IdField::new('id'),
            // TextField::new('title'),
            // TextEditorField::new('description'),
        ];
    }
    
}
