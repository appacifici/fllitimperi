<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request;
        $requestMethod = $canonicalMethod = $context->getMethod();
        $scheme = $context->getScheme();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }


        if (0 === strpos($pathinfo, '/r')) {
            // robotstxt
            if ('/robots.txt' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\SitemapController::robotsTxtAction',  '_route' => 'robotstxt',);
            }

            // recirectUrlInfo
            if (0 === strpos($pathinfo, '/recirectUrlInfo') && preg_match('#^/recirectUrlInfo/(?P<code>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'recirectUrlInfo')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::recirectUrlInfoAction',));
            }

            if (0 === strpos($pathinfo, '/recensione')) {
                // detailNews3
                if (preg_match('#^/recensione/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'detailNews3')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
                }

                // listArticles2
                if (preg_match('#^/recensione(?:/(?P<section1>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'listArticles2')), array (  'section1' => false,  '_controller' => 'AppBundle\\Controller\\ArticleController::listArticlesAction',));
                }

            }

        }

        elseif (0 === strpos($pathinfo, '/s')) {
            // sitemapNewsGoogle
            if ('/sitemapnews' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\SitemapController::sitemapNewsGoogleAction',  '_route' => 'sitemapNewsGoogle',);
            }

            // sitemapNewsGoogleXml
            if ('/sitemap-news.xml' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\SitemapController::sitemapNewsGoogleAction',  '_route' => 'sitemapNewsGoogleXml',);
            }

            // suggestionModel
            if ('/suggestion/model' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\ModelController::suggestionModelAction',  '_route' => 'suggestionModel',);
            }

            // storeDatasheet
            if (0 === strpos($pathinfo, '/scheda_negozio_') && preg_match('#^/scheda_negozio_(?P<store>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'storeDatasheet')), array (  '_controller' => 'AppBundle\\Controller\\StoreController::storeDatasheetAction',));
            }

        }

        elseif (0 === strpos($pathinfo, '/house')) {
            // houseSave
            if ('/house/save' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\HouseController::houseSaveAction',  '_route' => 'houseSave',);
            }

            // houseList
            if ('/house' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\HouseController::houseListAction',  '_route' => 'houseList',);
            }

        }

        elseif (0 === strpos($pathinfo, '/c')) {
            if (0 === strpos($pathinfo, '/comparazione')) {
                // modelComparison
                if (preg_match('#^/comparazione/(?P<idModels>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'modelComparison')), array (  '_controller' => 'AppBundle\\Controller\\ModelController::modelComparisonAction',));
                }

                // listModelComparison
                if ('/comparazione' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\ModelController::listModelComparisonAction',  '_route' => 'listModelComparison',);
                }

            }

            // chat
            if ('/chat' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\AdminController::chatAction',  '_route' => 'chat',);
            }

            // app_callajax_widget
            if ('/call/ajax/widget' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::widgetAction',  '_route' => 'app_callajax_widget',);
            }

            // app_callajax_datawidget
            if ('/call/ajax/dataWidget' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataWidgetAction',  '_route' => 'app_callajax_datawidget',);
            }

        }

        // impressionLink
        if (0 === strpos($pathinfo, '/impressto') && preg_match('#^/impressto/(?P<impressionLink>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'impressionLink')), array (  '_controller' => 'AppBundle\\Controller\\ModelController::getImpressionLinkAction',));
        }

        // dinamycPage
        if (0 === strpos($pathinfo, '/info') && preg_match('#^/info/(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'dinamycPage')), array (  '_controller' => 'AppBundle\\Controller\\AA_InitRoutController::indexAction',));
        }

        // wgetInfo
        if (0 === strpos($pathinfo, '/wgetInfo') && preg_match('#^/wgetInfo/(?P<code>[^/]++)(?:/(?P<pathOutput>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'wgetInfo')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::wgetInfoAction',  'pathOutput' => 'wgetInfoPage',));
        }

        if (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/amp')) {
                // AMPsearch
                if ('/amp/aSearch' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\ModelController::ampSearchAction',  '_route' => 'AMPsearch',);
                }

                if (0 === strpos($pathinfo, '/amp/ajax')) {
                    // externalUserLoginAMP
                    if ('/amp/ajax/externalUser/Login' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::externalUserlogin',  '_route' => 'externalUserLoginAMP',);
                    }

                    if (0 === strpos($pathinfo, '/amp/ajax/sendRegistration/externalUser')) {
                        // sendRegistrationAMP
                        if ('/amp/ajax/sendRegistration/externalUser' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::sendRegistration',  '_route' => 'sendRegistrationAMP',);
                        }

                        // loginWithSocialAMP
                        if ('/amp/ajax/sendRegistration/externalUserSocial' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::loginWithSocial',  '_route' => 'loginWithSocialAMP',);
                        }

                    }

                    // sendNewslettersAMP
                    if ('/amp/ajax/sendNewsletters' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::sendNewslettersAMPAction',  '_route' => 'sendNewslettersAMP',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/amp/guida_acquisto')) {
                    // AMPdetailNews2
                    if (preg_match('#^/amp/guida_acquisto/(?P<baseArticle>[^/]++)/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPdetailNews2')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
                    }

                    // AMPdetailNews1
                    if (preg_match('#^/amp/guida_acquisto/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPdetailNews1')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
                    }

                    // AMPlistArticles1
                    if (preg_match('#^/amp/guida_acquisto(?:/(?P<section1>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPlistArticles1')), array (  'section1' => false,  '_controller' => 'AppBundle\\Controller\\ArticleController::listArticlesAction',));
                    }

                }

                // getFormLoginAMP
                if ('/amp/getFormLogin' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::getFormLoginAction',  '_route' => 'getFormLoginAMP',);
                }

                if (0 === strpos($pathinfo, '/amp/recensione')) {
                    // AMPdetailNews3
                    if (preg_match('#^/amp/recensione/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPdetailNews3')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
                    }

                    // AMPlistArticles2
                    if (preg_match('#^/amp/recensione(?:/(?P<section1>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPlistArticles2')), array (  'section1' => false,  '_controller' => 'AppBundle\\Controller\\ArticleController::listArticlesAction',));
                    }

                }

                // userlogoutAMP
                if ('/amp/extUser/logout' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::userLogoutAction',  '_route' => 'userlogoutAMP',);
                }

            }

            // amSearch
            if ('/aSearch' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\ModelController::ampSearchAction',  '_route' => 'amSearch',);
            }

            if (0 === strpos($pathinfo, '/admin')) {
                // admin
                if ('/admin' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AdminController::indexAction',  '_route' => 'admin',);
                }

                if (0 === strpos($pathinfo, '/admin/lo')) {
                    // login
                    if ('/admin/login' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::loginAction',  '_route' => 'login',);
                    }

                    // logout
                    if ('/admin/logout' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::logoutAction',  '_route' => 'logout',);
                    }

                    // loockupSubcategories
                    if ('/admin/lookupSubcategories' === $pathinfo) {
                        return array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::extraConfigAction',  '_route' => 'loockupSubcategories',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/list')) {
                    if (0 === strpos($pathinfo, '/admin/listT')) {
                        // listTypology
                        if ('/admin/listTypology' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::typologyAction',  '_route' => 'listTypology',);
                        }

                        // listTrademark
                        if ('/admin/listTrademark' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::trademarkAction',  '_route' => 'listTrademark',);
                        }

                        // listTopNewsImg
                        if ('/admin/listTopNewsImg' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listTopNewsImgAction',  '_route' => 'listTopNewsImg',);
                        }

                    }

                    // listMicroSection
                    if ('/admin/listMicroSection' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listMicroSectionAction',  '_route' => 'listMicroSection',);
                    }

                    // listModel
                    if ('/admin/listModel' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::modelAction',  '_route' => 'listModel',);
                    }

                    if (0 === strpos($pathinfo, '/admin/listS')) {
                        // listSearchTerms
                        if ('/admin/listSearchTerms' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listSearchTermsAction',  '_route' => 'listSearchTerms',);
                        }

                        // listSex
                        if ('/admin/listSex' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listSexAction',  '_route' => 'listSex',);
                        }

                        // listSizes
                        if ('/admin/listSizes' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listSizeAction',  '_route' => 'listSizes',);
                        }

                    }

                    // listColors
                    if ('/admin/listColors' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listColorsAction',  '_route' => 'listColors',);
                    }

                    // listComparison
                    if ('/admin/listComparison' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listComparisonAction',  '_route' => 'listComparison',);
                    }

                    if (0 === strpos($pathinfo, '/admin/listDi')) {
                        // listDisabledModel
                        if ('/admin/listDisabledModel' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listDisabledModelAction',  '_route' => 'listDisabledModel',);
                        }

                        // listDinamycPage
                        if ('/admin/listDinamycPage' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listDinamycPageAction',  '_route' => 'listDinamycPage',);
                        }

                        // listDictionary
                        if ('/admin/listDictionary' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listDictionaryAction',  '_route' => 'listDictionary',);
                        }

                    }

                    // listProductsAdmin
                    if ('/admin/listProduct' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::productAction',  '_route' => 'listProductsAdmin',);
                    }

                    // listPoll
                    if ('/admin/listPoll' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listPollAction',  '_route' => 'listPoll',);
                    }

                    // listAffiliation
                    if ('/admin/listAffiliation' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::affiliationAction',  '_route' => 'listAffiliation',);
                    }

                    // adminListArticles
                    if ('/admin/listArticles' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listArticlesAction',  '_route' => 'adminListArticles',);
                    }

                    // adminListRedirects
                    if ('/admin/listRedirects' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listRedirectsAction',  '_route' => 'adminListRedirects',);
                    }

                    // adminListQuestions
                    if ('/admin/listQuestions' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listQuestionsAction',  '_route' => 'adminListQuestions',);
                    }

                    // adminListGroupPermission
                    if ('/admin/listGroupPermission' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listGroupPermissionAction',  '_route' => 'adminListGroupPermission',);
                    }

                    // listFeedsImport
                    if ('/admin/listFeedsImport' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::listFeedsImportAction',  '_route' => 'listFeedsImport',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/u')) {
                    // userLogged
                    if ('/admin/userLogged' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::userLoggedAction',  '_route' => 'userLogged',);
                    }

                    // manageUser
                    if ('/admin/users' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::userAction',  '_route' => 'manageUser',);
                    }

                    if (0 === strpos($pathinfo, '/admin/up')) {
                        if (0 === strpos($pathinfo, '/admin/update')) {
                            // updateOrderMenu
                            if (0 === strpos($pathinfo, '/admin/updateOrderMenu') && preg_match('#^/admin/updateOrderMenu/(?P<ids>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateOrderMenu')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::updateOrderMenuAction',));
                            }

                            // updateOrderTopTrademarks
                            if ('/admin/updateOrderTopTrademarks' === $pathinfo) {
                                return array (  '_controller' => 'AppBundle\\Controller\\AdminController::updateOrderTopTrademarksAction',  '_route' => 'updateOrderTopTrademarks',);
                            }

                            // updateArticleDate
                            if (0 === strpos($pathinfo, '/admin/updateArticleDate') && preg_match('#^/admin/updateArticleDate/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateArticleDate')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::updateArticleDateAction',));
                            }

                            // updatePoll
                            if (0 === strpos($pathinfo, '/admin/updatePoll') && preg_match('#^/admin/updatePoll/(?P<id>[^/]++)/(?P<question>[^/]++)/(?P<answers>[^/]++)(?:/(?P<articleId>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updatePoll')), array (  'articleId' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::updatePollAction',));
                            }

                            // updateExtraConfigs
                            if ('/admin/updateExtraConfigs' === $trimmedPathinfo) {
                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($rawPathinfo.'/', 'updateExtraConfigs');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AdminController::updateExtraConfigAction',  '_route' => 'updateExtraConfigs',);
                            }

                        }

                        // uploadImgArticleIframe
                        if ('/admin/uploadImgArticleIframe' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::uploadImgArticleIframeAction',  '_route' => 'uploadImgArticleIframe',);
                        }

                        // adminUploadImages
                        if ('/admin/uploadImages' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::uploadImagesAction',  '_route' => 'adminUploadImages',);
                        }

                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/t')) {
                    // trading
                    if ('/admin/trading' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::tradingAction',  '_route' => 'trading',);
                    }

                    // topTrademarkSection
                    if ('/admin/topTrademarkSection' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::topTrademarkSectionAction',  '_route' => 'topTrademarkSection',);
                    }

                    // tecnicalTemplate
                    if ('/admin/tecnicalTemplate' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::tecnicalTemplateAction',  '_route' => 'tecnicalTemplate',);
                    }

                }

                // bestDiscount
                if ('/admin/bestDiscount' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AdminController::bestDiscountAction',  '_route' => 'bestDiscount',);
                }

                // manageBanners
                if ('/admin/banners' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AdminController::bannerAction',  '_route' => 'manageBanners',);
                }

                if (0 === strpos($pathinfo, '/admin/c')) {
                    // category
                    if ('/admin/category' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::categoryAction',  '_route' => 'category',);
                    }

                    // manageCategories
                    if ('/admin/categories' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::categoriesAction',  '_route' => 'manageCategories',);
                    }

                    // createProduct
                    if ('/admin/createProduct' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::createProductAction',  '_route' => 'createProduct',);
                    }

                    if (0 === strpos($pathinfo, '/admin/change')) {
                        // changeTableModels
                        if (0 === strpos($pathinfo, '/admin/changeTableModels') && preg_match('#^/admin/changeTableModels/(?P<newtable>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'changeTableModels')), array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::changeTableModelsAction',));
                        }

                        // changeProductSection
                        if ('/admin/changeProductSection' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::changeProductSection',  '_route' => 'changeProductSection',);
                        }

                        // changeProductModel
                        if ('/admin/changeProductModel' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::changeProductModel',  '_route' => 'changeProductModel',);
                        }

                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/e')) {
                    if (0 === strpos($pathinfo, '/admin/edit')) {
                        if (0 === strpos($pathinfo, '/admin/editC')) {
                            if (0 === strpos($pathinfo, '/admin/editCategory')) {
                                // editCategoryMP
                                if (0 === strpos($pathinfo, '/admin/editCategoryMP') && preg_match('#^/admin/editCategoryMP(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'editCategoryMP')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editCategoryMPAction',));
                                }

                                // editCategory
                                if (preg_match('#^/admin/editCategory(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'editCategory')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editCategoryAction',));
                                }

                            }

                            // editColor
                            if (0 === strpos($pathinfo, '/admin/editColor') && preg_match('#^/admin/editColor(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editColor')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editColorAction',));
                            }

                            // editComparison
                            if ('/admin/editComparison' === $pathinfo) {
                                return array (  '_controller' => 'AppBundle\\Controller\\AdminController::editComparisonAction',  '_route' => 'editComparison',);
                            }

                        }

                        elseif (0 === strpos($pathinfo, '/admin/editT')) {
                            // editTypology
                            if (0 === strpos($pathinfo, '/admin/editTypology') && preg_match('#^/admin/editTypology(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editTypology')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editTypologyAction',));
                            }

                            // editTrademark
                            if (0 === strpos($pathinfo, '/admin/editTrademark') && preg_match('#^/admin/editTrademark(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editTrademark')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editTrademarkAction',));
                            }

                            // editTournament
                            if (0 === strpos($pathinfo, '/admin/editTournament') && preg_match('#^/admin/editTournament(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editTournament')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editTournamentAction',));
                            }

                            // editTecnicalTemplate
                            if (0 === strpos($pathinfo, '/admin/editTecnicalTemplate') && preg_match('#^/admin/editTecnicalTemplate(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editTecnicalTemplate')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editTecnicalTemplateAction',));
                            }

                        }

                        // editMicroSection
                        if (0 === strpos($pathinfo, '/admin/editMicroSection') && preg_match('#^/admin/editMicroSection(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editMicroSection')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editMicroSectionAction',));
                        }

                        // editModel
                        if (0 === strpos($pathinfo, '/admin/editModel') && preg_match('#^/admin/editModel(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editModel')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editModelAction',));
                        }

                        if (0 === strpos($pathinfo, '/admin/editS')) {
                            // editSearchTerm
                            if (0 === strpos($pathinfo, '/admin/editSearchTerm') && preg_match('#^/admin/editSearchTerm(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editSearchTerm')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editSearchTermsAction',));
                            }

                            // editSex
                            if (0 === strpos($pathinfo, '/admin/editSex') && preg_match('#^/admin/editSex(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editSex')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editSexAction',));
                            }

                            // editSize
                            if (0 === strpos($pathinfo, '/admin/editSize') && preg_match('#^/admin/editSize(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editSize')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editSizeAction',));
                            }

                            // editSubcategory
                            if (0 === strpos($pathinfo, '/admin/editSubcategory') && preg_match('#^/admin/editSubcategory(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'editSubcategory')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editSubcategoryAction',));
                            }

                        }

                        // editProduct
                        if (0 === strpos($pathinfo, '/admin/editProduct') && preg_match('#^/admin/editProduct(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editProduct')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editProductAction',));
                        }

                        // editPoll
                        if (0 === strpos($pathinfo, '/admin/editPoll') && preg_match('#^/admin/editPoll(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editPoll')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editPollAction',));
                        }

                        // editAffiliation
                        if (0 === strpos($pathinfo, '/admin/editAffiliation') && preg_match('#^/admin/editAffiliation(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editAffiliation')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editAffiliationAction',));
                        }

                        // editDinamycPage
                        if (0 === strpos($pathinfo, '/admin/editDinamycPage') && preg_match('#^/admin/editDinamycPage(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editDinamycPage')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::dinamycPageAction',));
                        }

                        // editDictionary
                        if (0 === strpos($pathinfo, '/admin/editDictionary') && preg_match('#^/admin/editDictionary(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editDictionary')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editDictionaryAction',));
                        }

                        // editRedirect
                        if (0 === strpos($pathinfo, '/admin/editRedirect') && preg_match('#^/admin/editRedirect(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editRedirect')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editRedirectAction',));
                        }

                        // editQuestion
                        if (0 === strpos($pathinfo, '/admin/editQuestion') && preg_match('#^/admin/editQuestion(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editQuestion')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editQuestionAction',));
                        }

                        // editBanner
                        if (0 === strpos($pathinfo, '/admin/editBanner') && preg_match('#^/admin/editBanner(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editBanner')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editBannerAction',));
                        }

                        // editGroup
                        if (0 === strpos($pathinfo, '/admin/editGroup') && preg_match('#^/admin/editGroup(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editGroup')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editGroupAction',));
                        }

                        // editUser
                        if (0 === strpos($pathinfo, '/admin/editUser') && preg_match('#^/admin/editUser(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editUser')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editUserAction',));
                        }

                        // editExternalUser
                        if (0 === strpos($pathinfo, '/admin/editExternalUser') && preg_match('#^/admin/editExternalUser/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editExternalUser')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::editExternalUserAction',));
                        }

                        // editExtraConfig
                        if (0 === strpos($pathinfo, '/admin/editExtraConfig') && preg_match('#^/admin/editExtraConfig(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'editExtraConfig')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::editExtraConfigAction',));
                        }

                    }

                    // manageExternalUser
                    if ('/admin/externalusers' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::externalUserAction',  '_route' => 'manageExternalUser',);
                    }

                    // extraConfig
                    if ('/admin/extraConfigs' === $pathinfo) {
                        return array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::extraConfigAction',  '_route' => 'extraConfig',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/add')) {
                    // addTopTrademarkSection
                    if (0 === strpos($pathinfo, '/admin/addTopTrademarkSection') && preg_match('#^/admin/addTopTrademarkSection/(?P<trademarkId>[^/]++)/(?P<subcatId>[^/]++)/(?P<typoId>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'addTopTrademarkSection')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::addTopTrademarkSection',));
                    }

                    if (0 === strpos($pathinfo, '/admin/addI')) {
                        // addItem
                        if (0 === strpos($pathinfo, '/admin/addItem') && preg_match('#^/admin/addItem/(?P<menuType>[^/]++)/(?P<entity>[^/]++)/(?P<id>[^/]++)/?$#s', $pathinfo, $matches)) {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'addItem');
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addItem')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::addItemAction',));
                        }

                        // addImageArticle
                        if (0 === strpos($pathinfo, '/admin/addImageArticle') && preg_match('#^/admin/addImageArticle/(?P<ids>[^/]++)/(?P<articleId>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addImageArticle')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::addImageArticleAction',));
                        }

                        // addImg
                        if ('/admin/addImg' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::addImgAction',  '_route' => 'addImg',);
                        }

                    }

                    // addUser
                    if (0 === strpos($pathinfo, '/admin/addUser') && preg_match('#^/admin/addUser/(?P<data>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'addUser')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::addUserAction',));
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/d')) {
                    if (0 === strpos($pathinfo, '/admin/delete')) {
                        // deleteTopTrademarkSection
                        if (0 === strpos($pathinfo, '/admin/deleteTopTrademarkSection') && preg_match('#^/admin/deleteTopTrademarkSection/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteTopTrademarkSection')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::deleteTopTrademarkSection',));
                        }

                        // deleteTopNewsImg
                        if (0 === strpos($pathinfo, '/admin/deleteTopNewsImg') && preg_match('#^/admin/deleteTopNewsImg/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteTopNewsImg')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::deleteTopNewsImgAction',));
                        }

                        // deleteItemMenu
                        if (0 === strpos($pathinfo, '/admin/deleteItemMenu') && preg_match('#^/admin/deleteItemMenu(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteItemMenu')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::deleteItemMenuAction',));
                        }

                        // deleteItemEntity
                        if ('/admin/deleteItemEntity' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::deleteItemEntityAction',  '_route' => 'deleteItemEntity',);
                        }

                        // deleteArticles
                        if (0 === strpos($pathinfo, '/admin/deleteArticles') && preg_match('#^/admin/deleteArticles/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteArticles')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::deleteAction',));
                        }

                        // deleteBanner
                        if ('/admin/deleteBanner' === $trimmedPathinfo) {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'deleteBanner');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::deleteBannerAction',  '_route' => 'deleteBanner',);
                        }

                    }

                    // dashboard
                    if ('/admin/dashboard' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::dashboardAction',  '_route' => 'dashboard',);
                    }

                    // dubbioLoockupSubcategory
                    if (0 === strpos($pathinfo, '/admin/dubbioLoockupSubcategorySiteAffiliation') && preg_match('#^/admin/dubbioLoockupSubcategorySiteAffiliation(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'dubbioLoockupSubcategory')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::dubbioLoockupSubcategoryAction',));
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/s')) {
                    if (0 === strpos($pathinfo, '/admin/set')) {
                        // setTopNewsImg
                        if ('/admin/setTopNewsImg' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::setTopNewsImgAction',  '_route' => 'setTopNewsImg',);
                        }

                        // setPriorityImageArticle
                        if (0 === strpos($pathinfo, '/admin/setPriorityImageArticle') && preg_match('#^/admin/setPriorityImageArticle/(?P<id>[^/]++)/(?P<articleId>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'setPriorityImageArticle')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::setPriorityImageArticleAction',));
                        }

                        // setLoockupSubcategories
                        if (0 === strpos($pathinfo, '/admin/setLoockupSubcategories') && preg_match('#^/admin/setLoockupSubcategories/(?P<idSubcatAff>[^/]++)/(?P<category>[^/]++)/(?P<subcategory>[^/]++)(?:/(?P<typology>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'setLoockupSubcategories')), array (  'typology' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::setLoockupSubcategoriesAction',));
                        }

                    }

                    // scheduleArticleDate
                    if (0 === strpos($pathinfo, '/admin/scheduleArticleDate') && preg_match('#^/admin/scheduleArticleDate/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'scheduleArticleDate')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::scheduleArticleAction',));
                    }

                    // manageSubcategories
                    if ('/admin/subcategories' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::subcategoriesAction',  '_route' => 'manageSubcategories',);
                    }

                    // saveInlineForm
                    if ('/admin/saveInlineForm' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::saveInlineFormAction',  '_route' => 'saveInlineForm',);
                    }

                }

                // imageArticle
                if (0 === strpos($pathinfo, '/admin/imageArticle') && preg_match('#^/admin/imageArticle/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'imageArticle')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::imageArticleAction',));
                }

                if (0 === strpos($pathinfo, '/admin/insert')) {
                    // insertPoll
                    if (0 === strpos($pathinfo, '/admin/insertPoll') && preg_match('#^/admin/insertPoll/(?P<question>[^/]++)/(?P<answers>[^/]++)(?:/(?P<articleId>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'insertPoll')), array (  'articleId' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::insertPollAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/insertProduct')) {
                        // insertProductToModelIde
                        if ('/admin/insertProductToModelIde' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::insertProductToModelIde',  '_route' => 'insertProductToModelIde',);
                        }

                        // insertProductsKelkooModelBtn
                        if (0 === strpos($pathinfo, '/admin/insertProductsKelkooModelBtn') && preg_match('#^/admin/insertProductsKelkooModelBtn/(?P<affId>[^/]++)/(?P<modelId>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'insertProductsKelkooModelBtn')), array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::insertProductsKelkooModelBtn',));
                        }

                        // insertProductInFeedByName
                        if (0 === strpos($pathinfo, '/admin/insertProductInFeedByName') && preg_match('#^/admin/insertProductInFeedByName/(?P<affId>[^/]++)/(?P<modelId>[^/]++)/(?P<productsNumber>[^/]++)$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'insertProductInFeedByName')), array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::insertProductInFeedByName',));
                        }

                    }

                    // insertImagesGoogle
                    if ('/admin/insertImagesGoogle' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::insertImagesGoogle',  '_route' => 'insertImagesGoogle',);
                    }

                    // insertGalleryModelImages
                    if ('/admin/insertGalleryModelImages' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::insertGalleryModelImages',  '_route' => 'insertGalleryModelImages',);
                    }

                    // insertFakeProduct
                    if (0 === strpos($pathinfo, '/admin/insertFakeProduct') && preg_match('#^/admin/insertFakeProduct/(?P<affId>[^/]++)/(?P<modelId>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'insertFakeProduct')), array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::insertFakeProductAction',));
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/re')) {
                    // removeImageArticle
                    if (0 === strpos($pathinfo, '/admin/removeImageArticle') && preg_match('#^/admin/removeImageArticle/(?P<ids>[^/]++)/(?P<articleId>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'removeImageArticle')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::removeImageArticleAction',));
                    }

                    // redisflushall
                    if ('/admin/redisflushall' === $trimmedPathinfo) {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($rawPathinfo.'/', 'redisflushall');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::redisCliCOmmand',  '_route' => 'redisflushall',);
                    }

                    // rest
                    if ('/admin/restoremodel' === $pathinfo) {
                        return array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::restoremodel',  '_route' => 'rest',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/m')) {
                    // manageMenu
                    if ('/admin/manageMenu' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::menuAction',  '_route' => 'manageMenu',);
                    }

                    // manageArticle
                    if (0 === strpos($pathinfo, '/admin/manageArticle') && preg_match('#^/admin/manageArticle(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'manageArticle')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::manageArticleAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/modify')) {
                        // modifyBanner
                        if ('/admin/modifyBanner' === $trimmedPathinfo) {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'modifyBanner');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::modifyBannerAction',  '_route' => 'modifyBanner',);
                        }

                        // modifyUser
                        if ('/admin/modifyUser' === $trimmedPathinfo) {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'modifyUser');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::modifyUserAction',  '_route' => 'modifyUser',);
                        }

                        // modifyGalleryModelImages
                        if ('/admin/modifyGalleryModelImages' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::modifyGalleryModelImages',  '_route' => 'modifyGalleryModelImages',);
                        }

                    }

                }

                elseif (0 === strpos($pathinfo, '/admin/get')) {
                    // getSelectOptions
                    if ('/admin/getSelectOptions' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\AdminController::getSelectOptionsAction',  '_route' => 'getSelectOptions',);
                    }

                    // getYouTubeVideo
                    if ('/admin/getYouTubeVideo' === $pathinfo) {
                        return array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::getYouTubeVideoAction',  '_route' => 'getYouTubeVideo',);
                    }

                    if (0 === strpos($pathinfo, '/admin/getI')) {
                        // getImagesGoogleApi
                        if ('/admin/getImagesGoogleApi' === $pathinfo) {
                            return array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminController::getImagesGoogleApi',  '_route' => 'getImagesGoogleApi',);
                        }

                        // checkModelinfo
                        if ('/admin/getInfosModelExternalSite' === $trimmedPathinfo) {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'checkModelinfo');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::getInfosModelExternalSite',  '_route' => 'checkModelinfo',);
                        }

                        if (0 === strpos($pathinfo, '/admin/getInfiniteScroller')) {
                            // app_callajax_datainfinitescrollimg
                            if (0 === strpos($pathinfo, '/admin/getInfiniteScroller/page=') && preg_match('#^/admin/getInfiniteScroller/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrollimg')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollImgAction',));
                            }

                            // app_callajax_datainfinitescrolllistnews_1
                            if (0 === strpos($pathinfo, '/admin/getInfiniteScrollerListNews/page=') && preg_match('#^/admin/getInfiniteScrollerListNews/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrolllistnews_1')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollListNewsAction',));
                            }

                            // app_callajax_datainfinitescrolllistpolls_1
                            if (0 === strpos($pathinfo, '/admin/getInfiniteScrollerListPolls/page=') && preg_match('#^/admin/getInfiniteScrollerListPolls/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrolllistpolls_1')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollListPollsAction',));
                            }

                            // app_callajax_datainfinitescrollgettyimg
                            if (0 === strpos($pathinfo, '/admin/getInfiniteScrollerGetty/page=') && preg_match('#^/admin/getInfiniteScrollerGetty/page\\=(?P<page>[^/]++)(?:/(?P<searchString>[^/]++))?$#s', $pathinfo, $matches)) {
                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrollgettyimg')), array (  'searchString' => false,  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollGettyImgAction',));
                            }

                        }

                    }

                    elseif (0 === strpos($pathinfo, '/admin/getProduct')) {
                        // getProductsSubcategorySiteAffiliation
                        if (0 === strpos($pathinfo, '/admin/getProductsSubcategorySiteAffiliation') && preg_match('#^/admin/getProductsSubcategorySiteAffiliation(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getProductsSubcategorySiteAffiliation')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::getProductsSubcategorySiteAffiliationAction',));
                        }

                        // getProductInKelkooApi
                        if ('/admin/getProductInKelkooApi' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::getProductInKelkooApi',  '_route' => 'getProductInKelkooApi',);
                        }

                        // getProductInFeedByName
                        if ('/admin/getProductInFeedByName' === $pathinfo) {
                            return array (  '_controller' => 'AppBundle\\Controller\\AdminManageController::getProductInFeedByName',  '_route' => 'getProductInFeedByName',);
                        }

                    }

                    // getModelProductsFromIde
                    if ('/admin/getModelProductsFromIde' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::getModelProductsFromIde',  '_route' => 'getModelProductsFromIde',);
                    }

                }

                // offProduct
                if ('/admin/offProduct' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\AdminController::offProduct',  '_route' => 'offProduct',);
                }

                // offLoockupSubcategory
                if (0 === strpos($pathinfo, '/admin/offLoockupSubcategorySiteAffiliation') && preg_match('#^/admin/offLoockupSubcategorySiteAffiliation(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'offLoockupSubcategory')), array (  'id' => false,  '_controller' => 'AppBundle\\Controller\\AdminManageController::offLoockupSubcategoryAction',));
                }

            }

            // listPolls
            if ('/all/list/polls' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\ArticleController::listPollsAction',  '_route' => 'listPolls',);
            }

            if (0 === strpos($pathinfo, '/ajax')) {
                // votePoll
                if (0 === strpos($pathinfo, '/ajax/poll') && preg_match('#^/ajax/poll/(?P<id>[^/]++)/(?P<answerKey>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'votePoll')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::votePoll',));
                }

                // addLike
                if (0 === strpos($pathinfo, '/ajax/addLike') && preg_match('#^/ajax/addLike/(?P<articleId>[^/]++)/(?P<likes>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'addLike')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::addLike',));
                }

                // addComment
                if (0 === strpos($pathinfo, '/ajax/addComment') && preg_match('#^/ajax/addComment/(?P<articleId>[^/]++)/(?P<msg>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'addComment')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::addComment',));
                }

                // retrieveTeam
                if ('/ajax/retrieve/team' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::retrieveTeam',  '_route' => 'retrieveTeam',);
                }

                // forgotPassword
                if ('/ajax/forgot/password' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::forgotPwd',  '_route' => 'forgotPassword',);
                }

                // externalUserLogged
                if ('/ajax/externalUser/Logged' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::externalUserLogged',  '_route' => 'externalUserLogged',);
                }

                // externalUserLogin
                if ('/ajax/externalUser/Login' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::externalUserlogin',  '_route' => 'externalUserLogin',);
                }

                if (0 === strpos($pathinfo, '/ajax/sendRegistration/externalUser')) {
                    // sendRegistration
                    if ('/ajax/sendRegistration/externalUser' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::sendRegistration',  '_route' => 'sendRegistration',);
                    }

                    // loginWithSocial
                    if ('/ajax/sendRegistration/externalUserSocial' === $pathinfo) {
                        return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::loginWithSocial',  '_route' => 'loginWithSocial',);
                    }

                }

                // sendNewsletters
                if ('/ajax/sendNewsletters' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::sendNewslettersAction',  '_route' => 'sendNewsletters',);
                }

                // getLoginHtmlAction
                if ('/ajax/getLoginHtml' === $pathinfo) {
                    return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::getLoginHtmlAction',  '_route' => 'getLoginHtmlAction',);
                }

            }

        }

        elseif (0 === strpos($pathinfo, '/ne')) {
            // storeOpinions
            if (0 === strpos($pathinfo, '/negozio_') && preg_match('#^/negozio_(?P<store>[^/_]++)_opinioni$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'storeOpinions')), array (  '_controller' => 'AppBundle\\Controller\\StoreController::storeOpinionsAction',));
            }

            // app_callajax_datainfinitescrolllistnews
            if (0 === strpos($pathinfo, '/news/getInfiniteScrollerListNews/page=') && preg_match('#^/news/getInfiniteScrollerListNews/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrolllistnews')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollListNewsAction',));
            }

            // app_callajax_datainfinitescrolllistpolls
            if (0 === strpos($pathinfo, '/news/getInfiniteScrollerListPolls/page=') && preg_match('#^/news/getInfiniteScrollerListPolls/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrolllistpolls')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollListPollsAction',));
            }

        }

        // storeOffers
        if (0 === strpos($pathinfo, '/offerte_negozio_') && preg_match('#^/offerte_negozio_(?P<store>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'storeOffers')), array (  '_controller' => 'AppBundle\\Controller\\StoreController::storeOffersAction',));
        }

        // app_callajax_opencomparisonlistmodel
        if ('/openComparisonListModel' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::openComparisonListModelAction',  '_route' => 'app_callajax_opencomparisonlistmodel',);
        }

        // logoutExternalUser
        if ('/logoutExternalUser' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\AdminController::logoutExternalUserAction',  '_route' => 'logoutExternalUser',);
        }

        // getItemDictionary
        if (0 === strpos($pathinfo, '/dictionary/getItem') && preg_match('#^/dictionary/getItem/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getItemDictionary')), array (  '_controller' => 'AppBundle\\Controller\\AdminController::getItemDictionaryAction',));
        }

        if (0 === strpos($pathinfo, '/guida_acquisto')) {
            // detailNews2
            if (preg_match('#^/guida_acquisto/(?P<baseArticle>[^/]++)/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'detailNews2')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
            }

            // detailNews1
            if (preg_match('#^/guida_acquisto/(?P<title>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'detailNews1')), array (  '_controller' => 'AppBundle\\Controller\\ArticleController::indexAction',));
            }

            // listArticles1
            if (preg_match('#^/guida_acquisto(?:/(?P<section1>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'listArticles1')), array (  'section1' => false,  '_controller' => 'AppBundle\\Controller\\ArticleController::listArticlesAction',));
            }

        }

        // app_callajax_datainfinitescrolllistproducts
        if (0 === strpos($pathinfo, '/product/getInfiniteScrollerListNews/page=') && preg_match('#^/product/getInfiniteScrollerListNews/page\\=(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_callajax_datainfinitescrolllistproducts')), array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::dataInfiniteScrollListProductsAction',));
        }

        // app_callajax_userlogin
        if ('/user/login' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::userLogin',  '_route' => 'app_callajax_userlogin',);
        }

        // app_callajax_userregister
        if ('/user/register' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::userRegister',  '_route' => 'app_callajax_userregister',);
        }

        // userlogout
        if ('/extUser/logout' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\CallAjaxController::userLogoutAction',  '_route' => 'userlogout',);
        }

        // detailProduct
        if (preg_match('#^/(?P<section1>[^/]++)/(?P<section2>[^/]++)/prezzo_(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'detailProduct')), array (  'section2' => false,  '_controller' => 'AppBundle\\Controller\\CatSubcatTypologyController::detailProductAction',));
        }

        // app_catsubcattypology_detailproduct
        if (preg_match('#^/(?P<section1>[^/]++)/(?P<section2>[^/]++)/(?P<section3>[^/]++)/prezzo_(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_catsubcattypology_detailproduct')), array (  'section2' => false,  'section3' => false,  '_controller' => 'AppBundle\\Controller\\CatSubcatTypologyController::detailProductAction',));
        }

        // app_catsubcattypology_detailproduct_1
        if (preg_match('#^/(?P<section1>[^/]++)/(?P<section2>[^/]++)/(?P<section3>[^/]++)/(?P<section4>[^/]++)/prezzo_(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_catsubcattypology_detailproduct_1')), array (  'section2' => false,  'section3' => false,  'section4' => false,  '_controller' => 'AppBundle\\Controller\\CatSubcatTypologyController::detailProductAction',));
        }

        // catSubcatTypologyProduct
        if (preg_match('#^/(?P<section1>[^/]++)(?:/(?P<section2>[^/]++)(?:/(?P<section3>[^/]++)(?:/(?P<section4>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'catSubcatTypologyProduct')), array (  'section2' => false,  'section3' => false,  'section4' => false,  '_controller' => 'AppBundle\\Controller\\CatSubcatTypologyController::catSubcatTypologyProductAction',));
        }

        // homepage
        if ('' === $trimmedPathinfo) {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($rawPathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\HomeController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/amp')) {
            // AMPhomepage
            if ('/amp' === $trimmedPathinfo) {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($rawPathinfo.'/', 'AMPhomepage');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\HomeController::indexAction',  '_route' => 'AMPhomepage',);
            }

            // autosuggestamp2
            if ('/amp/advanced/autosuggest/search_list' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\ModelController::autosuggestampAction',  '_route' => 'autosuggestamp2',);
            }

            // AMPcustomRoute
            if (preg_match('#^/amp/(?P<path>.*)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'AMPcustomRoute')), array (  '_controller' => 'AppBundle\\Controller\\CustomController::customDetectAction',));
            }

        }

        // autosuggestamp
        if ('/advanced/autosuggest/search_list' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\ModelController::autosuggestampAction',  '_route' => 'autosuggestamp',);
        }

        if (0 === strpos($pathinfo, '/iframe')) {
            if (0 === strpos($pathinfo, '/iframe/livematch')) {
                // iframeLive
                if (0 === strpos($pathinfo, '/iframe/livematches') && preg_match('#^/iframe/livematches(?:/(?P<idsMatches>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'iframeLive')), array (  'idsMatches' => NULL,  '_controller' => 'AppBundle\\Controller\\WidgetController::indexAction',));
                }

                // iframeLiveMatch
                if (preg_match('#^/iframe/livematch/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'iframeLiveMatch')), array (  '_controller' => 'AppBundle\\Controller\\WidgetController::liveMatchAction',));
                }

            }

            // iframeLiveGoals
            if ('/iframe/goals' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\WidgetController::lastGoalsAction',  '_route' => 'iframeLiveGoals',);
            }

            // iframeOdds
            if ('/iframe/odds' === $pathinfo) {
                return array (  '_controller' => 'AppBundle\\Controller\\WidgetController::oddsAction',  '_route' => 'iframeOdds',);
            }

        }

        // customRoute
        if (preg_match('#^/(?P<path>.*)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'customRoute')), array (  '_controller' => 'AppBundle\\Controller\\CustomController::customDetectAction',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
