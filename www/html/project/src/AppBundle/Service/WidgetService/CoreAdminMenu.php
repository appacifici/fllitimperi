<?php

namespace AppBundle\Service\WidgetService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\FormService\FormManager;
use \AppBundle\Entity\DataArticle;
use \AppBundle\Entity\ContentArticle;
use \AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CoreAdminMenu extends Controller{
    
    public function __construct( WidgetManager $widgetManager, FormManager $formManager ) {
        $this->wm = $widgetManager;
        $this->fm = $formManager;        
    }
    
    public function processData( $options = false ) {
        if( !$this->wm->getPermissionCore() )
            return array();        
        
       
        return array();
    }     
}

//http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
//http://symfony.com/doc/current/forms.html
//http://api.symfony.com/3.2/Symfony/Component/Form/Extension/Core/Type/UrlType.html