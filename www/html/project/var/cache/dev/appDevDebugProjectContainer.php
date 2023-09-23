<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class appDevDebugProjectContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    public function __construct()
    {
        $dir = __DIR__;
        for ($i = 1; $i <= 5; ++$i) {
            $this->targetDirs[$i] = $dir = dirname($dir);
        }
        $this->parameters = $this->getDefaultParameters();

        $this->services = array();
        $this->normalizedIds = array(
            'app.amazonapi' => 'app.amazonApi',
            'app.apigettyimageservice' => 'app.apiGettyImageService',
            'app.bannersconfigmanager' => 'app.bannersConfigManager',
            'app.browserutility' => 'app.browserUtility',
            'app.cacheutility' => 'app.cacheUtility',
            'app.cacheutilitysecondlevelcache' => 'app.cacheUtilitySecondLevelCache',
            'app.coreadminarticle' => 'app.coreAdminArticle',
            'app.coreadminbestdiscountedprices' => 'app.coreAdminBestDiscountedPrices',
            'app.coreadmindashboard' => 'app.coreAdminDashboard',
            'app.coreadmineditaffiliation' => 'app.coreAdminEditAffiliation',
            'app.coreadmineditbanner' => 'app.coreAdminEditBanner',
            'app.coreadmineditcategory' => 'app.coreAdminEditCategory',
            'app.coreadmineditcolor' => 'app.coreAdminEditColor',
            'app.coreadmineditcomparison' => 'app.coreAdminEditComparison',
            'app.coreadmineditdictionary' => 'app.coreAdminEditDictionary',
            'app.coreadmineditdinamycpage' => 'app.coreAdminEditDinamycPage',
            'app.coreadmineditextraconfig' => 'app.coreAdminEditExtraConfig',
            'app.coreadmineditgrouppermission' => 'app.coreAdminEditGroupPermission',
            'app.coreadmineditmicrosection' => 'app.coreAdminEditMicroSection',
            'app.coreadmineditmodel' => 'app.coreAdminEditModel',
            'app.coreadmineditpoll' => 'app.coreAdminEditPoll',
            'app.coreadmineditproduct' => 'app.coreAdminEditProduct',
            'app.coreadmineditquestion' => 'app.coreAdminEditQuestion',
            'app.coreadmineditredirect' => 'app.coreAdminEditRedirect',
            'app.coreadmineditsearchterm' => 'app.coreAdminEditSearchTerm',
            'app.coreadmineditsex' => 'app.coreAdminEditSex',
            'app.coreadmineditsize' => 'app.coreAdminEditSize',
            'app.coreadmineditsubcategory' => 'app.coreAdminEditSubcategory',
            'app.coreadminedittecnicaltemplate' => 'app.coreAdminEditTecnicalTemplate',
            'app.coreadminedittrademark' => 'app.coreAdminEditTrademark',
            'app.coreadminedittypology' => 'app.coreAdminEditTypology',
            'app.coreadminedituser' => 'app.coreAdminEditUser',
            'app.coreadminextraconfigs' => 'app.coreAdminExtraConfigs',
            'app.coreadminimagearticle' => 'app.coreAdminImageArticle',
            'app.coreadminimagearticlegetty' => 'app.coreAdminImageArticleGetty',
            'app.coreadminlistaffiliations' => 'app.coreAdminListAffiliations',
            'app.coreadminlistarticles' => 'app.coreAdminListArticles',
            'app.coreadminlistbanners' => 'app.coreAdminListBanners',
            'app.coreadminlistcategories' => 'app.coreAdminListCategories',
            'app.coreadminlistcolors' => 'app.coreAdminListColors',
            'app.coreadminlistcomparison' => 'app.coreAdminListComparison',
            'app.coreadminlistdictionaries' => 'app.coreAdminListDictionaries',
            'app.coreadminlistdinamycpages' => 'app.coreAdminListDinamycPages',
            'app.coreadminlistdisabledmodels' => 'app.coreAdminListDisabledModels',
            'app.coreadminlistfeedsimport' => 'app.coreAdminListFeedsImport',
            'app.coreadminlistgrouppermission' => 'app.coreAdminListGroupPermission',
            'app.coreadminlistmicrosection' => 'app.coreAdminListMicroSection',
            'app.coreadminlistmodels' => 'app.coreAdminListModels',
            'app.coreadminlistpolls' => 'app.coreAdminListPolls',
            'app.coreadminlistproducts' => 'app.coreAdminListProducts',
            'app.coreadminlistquestion' => 'app.coreAdminListQuestion',
            'app.coreadminlistredirects' => 'app.coreAdminListRedirects',
            'app.coreadminlistsearchterms' => 'app.coreAdminListSearchTerms',
            'app.coreadminlistsex' => 'app.coreAdminListSex',
            'app.coreadminlistsizes' => 'app.coreAdminListSizes',
            'app.coreadminlistsubcategories' => 'app.coreAdminListSubcategories',
            'app.coreadminlisttecnicaltemplate' => 'app.coreAdminListTecnicalTemplate',
            'app.coreadminlisttrademarks' => 'app.coreAdminListTrademarks',
            'app.coreadminlisttypology' => 'app.coreAdminListTypology',
            'app.coreadminlookupsubcategories' => 'app.coreAdminLookupSubcategories',
            'app.coreadminmanagermenus' => 'app.coreAdminManagerMenus',
            'app.coreadminmenu' => 'app.coreAdminMenu',
            'app.coreadmintoptrademarksection' => 'app.coreAdminTopTrademarkSection',
            'app.coreadminuploadimage' => 'app.coreAdminUploadImage',
            'app.coreadminusers' => 'app.coreAdminUsers',
            'app.coreallcategories' => 'app.coreAllCategories',
            'app.corebannermenu' => 'app.coreBannerMenu',
            'app.corebestseller' => 'app.coreBestseller',
            'app.corebestsellermodels' => 'app.coreBestsellerModels',
            'app.corebestsellerrelatedmodels' => 'app.coreBestsellerRelatedModels',
            'app.corebreadcrumbs' => 'app.coreBreadcrumbs',
            'app.corebreakingnews' => 'app.coreBreakingNews',
            'app.corecatsubcattypology' => 'app.coreCatSubcatTypology',
            'app.corecatsubcattypologylist' => 'app.coreCatSubcatTypologyList',
            'app.corecatsubcattypologylistacquistigiusti' => 'app.coreCatSubcatTypologyListAcquistiGiusti',
            'app.corechatmessages' => 'app.coreChatMessages',
            'app.corecomments' => 'app.coreComments',
            'app.coredetailarticle' => 'app.coreDetailArticle',
            'app.coredetailproduct' => 'app.coreDetailProduct',
            'app.coredinamycpage' => 'app.coreDinamycPage',
            'app.corefiltersproducts' => 'app.coreFiltersProducts',
            'app.corefollowus' => 'app.coreFollowUs',
            'app.coregetsearchterms' => 'app.coreGetSearchTerms',
            'app.corehouse' => 'app.coreHouse',
            'app.corelistmodelscomparison' => 'app.coreListModelsComparison',
            'app.corelistmodelstrademark' => 'app.coreListModelsTrademark',
            'app.corelistnews' => 'app.coreListNews',
            'app.corelistnews_template' => 'app.coreListNews_Template',
            'app.corelistnewsop' => 'app.coreListNewsOP',
            'app.corelistpolls' => 'app.coreListPolls',
            'app.corelistproducts' => 'app.coreListProducts',
            'app.corelistrelatednews' => 'app.coreListRelatedNews',
            'app.coremodelbyids' => 'app.coreModelByIds',
            'app.coremodelscomparison' => 'app.coreModelsComparison',
            'app.corepagefunebri' => 'app.corePageFunebri',
            'app.corepoll' => 'app.corePoll',
            'app.coreproductsale' => 'app.coreProductSale',
            'app.corereplacewidgetajax' => 'app.coreReplaceWidgetAjax',
            'app.coresalemodels' => 'app.coreSaleModels',
            'app.coreseoh1listarticles' => 'app.coreSeoH1ListArticles',
            'app.coreseoh1listarticles_template' => 'app.coreSeoH1ListArticles_Template',
            'app.coresliders' => 'app.coreSliders',
            'app.coretopaffiliations' => 'app.coreTopAffiliations',
            'app.coretopnews' => 'app.coreTopNews',
            'app.coretoporrelatedmodels' => 'app.coreTopOrRelatedModels',
            'app.coretoptrademarks' => 'app.coreTopTrademarks',
            'app.coretreading' => 'app.coreTreading',
            'app.corewidgetmenu' => 'app.coreWidgetmenu',
            'app.deamonaffiliation' => 'app.deamonAffiliation',
            'app.dependencymanager' => 'app.dependencyManager',
            'app.dependencymanageradmin' => 'app.dependencyManagerAdmin',
            'app.dependencymanagercalciomercato' => 'app.dependencyManagerCalciomercato',
            'app.dependencymanagertemplate' => 'app.dependencyManagerTemplate',
            'app.dictionaryutility' => 'app.dictionaryUtility',
            'app.ebayapi' => 'app.ebayApi',
            'app.fileutility' => 'app.fileUtility',
            'app.formmanager' => 'app.formManager',
            'app.globalconfigmanager' => 'app.globalConfigManager',
            'app.globalqueryutility' => 'app.globalQueryUtility',
            'app.globaltwigextension' => 'app.globalTwigExtension',
            'app.globalutility' => 'app.globalUtility',
            'app.imageutility' => 'app.imageUtility',
            'app.managearticle' => 'app.manageArticle',
            'app.managedb' => 'app.manageDb',
            'app.paginationutility' => 'app.paginationUtility',
            'app.queryutilitymanager' => 'app.queryUtilityManager',
            'app.redirectservice' => 'app.redirectService',
            'app.removetopnewsimg' => 'app.removeTopNewsImg',
            'app.routermanager' => 'app.routerManager',
            'app.seoconfigmanager' => 'app.seoConfigManager',
            'app.spideramazon' => 'app.spiderAmazon',
            'app.spiderebay' => 'app.spiderEbay',
            'app.spideridealo' => 'app.spiderIdealo',
            'app.spiderpagomeno' => 'app.spiderPagomeno',
            'app.spidertrovaprezzi' => 'app.spiderTrovaprezzi',
            'app.usermanager' => 'app.userManager',
            'app.web365managerrepository' => 'app.web365ManagerRepository',
            'app.widgetmanager' => 'app.widgetManager',
            'app.wordpressimportdb' => 'app.wordpressImportDb',
            'livescoreservices.compressfilesservice' => 'livescoreServices.compressFilesService',
            'livescoreservices.senddatatoapp' => 'livescoreServices.sendDataToApp',
            'livescoreservices.utilityapp' => 'livescoreServices.utilityApp',
            'livescoreservices.videoapi' => 'livescoreServices.videoapi',
            'snc_redis.secondlevelcache' => 'snc_redis.secondLevelCache',
            'snc_redis.secondlevelcache_client' => 'snc_redis.secondLevelCache_client',
            'snc_redis.sncredisdoctrinemetadata' => 'snc_redis.sncredisDoctrinemetadata',
            'snc_redis.sncredisdoctrinemetadata_client' => 'snc_redis.sncredisDoctrinemetadata_client',
            'snc_redis.sncredisdoctrinequerycache' => 'snc_redis.sncredisDoctrineQueryCache',
            'snc_redis.sncredisdoctrinequerycache_client' => 'snc_redis.sncredisDoctrineQueryCache_client',
            'snc_redis.sncredisdoctrineresult' => 'snc_redis.sncredisDoctrineResult',
            'snc_redis.sncredisdoctrineresult_client' => 'snc_redis.sncredisDoctrineResult_client',
            'snc_redis.sncredissessionphp' => 'snc_redis.sncredisSessionPhp',
            'snc_redis.sncredissessionphp_client' => 'snc_redis.sncredisSessionPhp_client',
        );
        $this->methodMap = array(
            '1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' => 'get1Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService',
            '2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' => 'get2Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService',
            'annotation_reader' => 'getAnnotationReaderService',
            'annotations.cache' => 'getAnnotations_CacheService',
            'annotations.reader' => 'getAnnotations_ReaderService',
            'app.amazonApi' => 'getApp_AmazonApiService',
            'app.apiGettyImageService' => 'getApp_ApiGettyImageServiceService',
            'app.bannersConfigManager' => 'getApp_BannersConfigManagerService',
            'app.browserUtility' => 'getApp_BrowserUtilityService',
            'app.cacheUtility' => 'getApp_CacheUtilityService',
            'app.cacheUtilitySecondLevelCache' => 'getApp_CacheUtilitySecondLevelCacheService',
            'app.chat' => 'getApp_ChatService',
            'app.coreAdminArticle' => 'getApp_CoreAdminArticleService',
            'app.coreAdminBestDiscountedPrices' => 'getApp_CoreAdminBestDiscountedPricesService',
            'app.coreAdminDashboard' => 'getApp_CoreAdminDashboardService',
            'app.coreAdminEditAffiliation' => 'getApp_CoreAdminEditAffiliationService',
            'app.coreAdminEditBanner' => 'getApp_CoreAdminEditBannerService',
            'app.coreAdminEditCategory' => 'getApp_CoreAdminEditCategoryService',
            'app.coreAdminEditColor' => 'getApp_CoreAdminEditColorService',
            'app.coreAdminEditComparison' => 'getApp_CoreAdminEditComparisonService',
            'app.coreAdminEditDictionary' => 'getApp_CoreAdminEditDictionaryService',
            'app.coreAdminEditDinamycPage' => 'getApp_CoreAdminEditDinamycPageService',
            'app.coreAdminEditExtraConfig' => 'getApp_CoreAdminEditExtraConfigService',
            'app.coreAdminEditGroupPermission' => 'getApp_CoreAdminEditGroupPermissionService',
            'app.coreAdminEditMicroSection' => 'getApp_CoreAdminEditMicroSectionService',
            'app.coreAdminEditModel' => 'getApp_CoreAdminEditModelService',
            'app.coreAdminEditPoll' => 'getApp_CoreAdminEditPollService',
            'app.coreAdminEditProduct' => 'getApp_CoreAdminEditProductService',
            'app.coreAdminEditQuestion' => 'getApp_CoreAdminEditQuestionService',
            'app.coreAdminEditRedirect' => 'getApp_CoreAdminEditRedirectService',
            'app.coreAdminEditSearchTerm' => 'getApp_CoreAdminEditSearchTermService',
            'app.coreAdminEditSex' => 'getApp_CoreAdminEditSexService',
            'app.coreAdminEditSize' => 'getApp_CoreAdminEditSizeService',
            'app.coreAdminEditSubcategory' => 'getApp_CoreAdminEditSubcategoryService',
            'app.coreAdminEditTecnicalTemplate' => 'getApp_CoreAdminEditTecnicalTemplateService',
            'app.coreAdminEditTrademark' => 'getApp_CoreAdminEditTrademarkService',
            'app.coreAdminEditTypology' => 'getApp_CoreAdminEditTypologyService',
            'app.coreAdminEditUser' => 'getApp_CoreAdminEditUserService',
            'app.coreAdminExtraConfigs' => 'getApp_CoreAdminExtraConfigsService',
            'app.coreAdminImageArticle' => 'getApp_CoreAdminImageArticleService',
            'app.coreAdminImageArticleGetty' => 'getApp_CoreAdminImageArticleGettyService',
            'app.coreAdminListAffiliations' => 'getApp_CoreAdminListAffiliationsService',
            'app.coreAdminListArticles' => 'getApp_CoreAdminListArticlesService',
            'app.coreAdminListBanners' => 'getApp_CoreAdminListBannersService',
            'app.coreAdminListCategories' => 'getApp_CoreAdminListCategoriesService',
            'app.coreAdminListColors' => 'getApp_CoreAdminListColorsService',
            'app.coreAdminListComparison' => 'getApp_CoreAdminListComparisonService',
            'app.coreAdminListDictionaries' => 'getApp_CoreAdminListDictionariesService',
            'app.coreAdminListDinamycPages' => 'getApp_CoreAdminListDinamycPagesService',
            'app.coreAdminListDisabledModels' => 'getApp_CoreAdminListDisabledModelsService',
            'app.coreAdminListFeedsImport' => 'getApp_CoreAdminListFeedsImportService',
            'app.coreAdminListGroupPermission' => 'getApp_CoreAdminListGroupPermissionService',
            'app.coreAdminListMicroSection' => 'getApp_CoreAdminListMicroSectionService',
            'app.coreAdminListModels' => 'getApp_CoreAdminListModelsService',
            'app.coreAdminListPolls' => 'getApp_CoreAdminListPollsService',
            'app.coreAdminListProducts' => 'getApp_CoreAdminListProductsService',
            'app.coreAdminListQuestion' => 'getApp_CoreAdminListQuestionService',
            'app.coreAdminListRedirects' => 'getApp_CoreAdminListRedirectsService',
            'app.coreAdminListSearchTerms' => 'getApp_CoreAdminListSearchTermsService',
            'app.coreAdminListSex' => 'getApp_CoreAdminListSexService',
            'app.coreAdminListSizes' => 'getApp_CoreAdminListSizesService',
            'app.coreAdminListSubcategories' => 'getApp_CoreAdminListSubcategoriesService',
            'app.coreAdminListTecnicalTemplate' => 'getApp_CoreAdminListTecnicalTemplateService',
            'app.coreAdminListTrademarks' => 'getApp_CoreAdminListTrademarksService',
            'app.coreAdminListTypology' => 'getApp_CoreAdminListTypologyService',
            'app.coreAdminLookupSubcategories' => 'getApp_CoreAdminLookupSubcategoriesService',
            'app.coreAdminManagerMenus' => 'getApp_CoreAdminManagerMenusService',
            'app.coreAdminMenu' => 'getApp_CoreAdminMenuService',
            'app.coreAdminTopTrademarkSection' => 'getApp_CoreAdminTopTrademarkSectionService',
            'app.coreAdminUploadImage' => 'getApp_CoreAdminUploadImageService',
            'app.coreAdminUsers' => 'getApp_CoreAdminUsersService',
            'app.coreAllCategories' => 'getApp_CoreAllCategoriesService',
            'app.coreBannerMenu' => 'getApp_CoreBannerMenuService',
            'app.coreBestseller' => 'getApp_CoreBestsellerService',
            'app.coreBestsellerModels' => 'getApp_CoreBestsellerModelsService',
            'app.coreBestsellerRelatedModels' => 'getApp_CoreBestsellerRelatedModelsService',
            'app.coreBreadcrumbs' => 'getApp_CoreBreadcrumbsService',
            'app.coreBreakingNews' => 'getApp_CoreBreakingNewsService',
            'app.coreCatSubcatTypology' => 'getApp_CoreCatSubcatTypologyService',
            'app.coreCatSubcatTypologyList' => 'getApp_CoreCatSubcatTypologyListService',
            'app.coreCatSubcatTypologyListAcquistiGiusti' => 'getApp_CoreCatSubcatTypologyListAcquistiGiustiService',
            'app.coreChatMessages' => 'getApp_CoreChatMessagesService',
            'app.coreComments' => 'getApp_CoreCommentsService',
            'app.coreDetailArticle' => 'getApp_CoreDetailArticleService',
            'app.coreDetailProduct' => 'getApp_CoreDetailProductService',
            'app.coreDinamycPage' => 'getApp_CoreDinamycPageService',
            'app.coreFiltersProducts' => 'getApp_CoreFiltersProductsService',
            'app.coreFollowUs' => 'getApp_CoreFollowUsService',
            'app.coreGetSearchTerms' => 'getApp_CoreGetSearchTermsService',
            'app.coreHouse' => 'getApp_CoreHouseService',
            'app.coreListModelsComparison' => 'getApp_CoreListModelsComparisonService',
            'app.coreListModelsTrademark' => 'getApp_CoreListModelsTrademarkService',
            'app.coreListNews' => 'getApp_CoreListNewsService',
            'app.coreListNewsOP' => 'getApp_CoreListNewsOPService',
            'app.coreListNews_Template' => 'getApp_CoreListNewsTemplateService',
            'app.coreListPolls' => 'getApp_CoreListPollsService',
            'app.coreListProducts' => 'getApp_CoreListProductsService',
            'app.coreListRelatedNews' => 'getApp_CoreListRelatedNewsService',
            'app.coreModelByIds' => 'getApp_CoreModelByIdsService',
            'app.coreModelsComparison' => 'getApp_CoreModelsComparisonService',
            'app.corePageFunebri' => 'getApp_CorePageFunebriService',
            'app.corePoll' => 'getApp_CorePollService',
            'app.coreProductSale' => 'getApp_CoreProductSaleService',
            'app.coreReplaceWidgetAjax' => 'getApp_CoreReplaceWidgetAjaxService',
            'app.coreSaleModels' => 'getApp_CoreSaleModelsService',
            'app.coreSeoH1ListArticles' => 'getApp_CoreSeoH1ListArticlesService',
            'app.coreSeoH1ListArticles_Template' => 'getApp_CoreSeoH1ListArticlesTemplateService',
            'app.coreSliders' => 'getApp_CoreSlidersService',
            'app.coreTopAffiliations' => 'getApp_CoreTopAffiliationsService',
            'app.coreTopNews' => 'getApp_CoreTopNewsService',
            'app.coreTopOrRelatedModels' => 'getApp_CoreTopOrRelatedModelsService',
            'app.coreTopTrademarks' => 'getApp_CoreTopTrademarksService',
            'app.coreTreading' => 'getApp_CoreTreadingService',
            'app.coreWidgetmenu' => 'getApp_CoreWidgetmenuService',
            'app.coreprova' => 'getApp_CoreprovaService',
            'app.deamonAffiliation' => 'getApp_DeamonAffiliationService',
            'app.dependencyManager' => 'getApp_DependencyManagerService',
            'app.dependencyManagerAdmin' => 'getApp_DependencyManagerAdminService',
            'app.dependencyManagerCalciomercato' => 'getApp_DependencyManagerCalciomercatoService',
            'app.dependencyManagerTemplate' => 'getApp_DependencyManagerTemplateService',
            'app.dictionaryUtility' => 'getApp_DictionaryUtilityService',
            'app.ebayApi' => 'getApp_EbayApiService',
            'app.fileUtility' => 'getApp_FileUtilityService',
            'app.formManager' => 'getApp_FormManagerService',
            'app.globalConfigManager' => 'getApp_GlobalConfigManagerService',
            'app.globalQueryUtility' => 'getApp_GlobalQueryUtilityService',
            'app.globalTwigExtension' => 'getApp_GlobalTwigExtensionService',
            'app.globalUtility' => 'getApp_GlobalUtilityService',
            'app.imageUtility' => 'getApp_ImageUtilityService',
            'app.manageArticle' => 'getApp_ManageArticleService',
            'app.manageDb' => 'getApp_ManageDbService',
            'app.paginationUtility' => 'getApp_PaginationUtilityService',
            'app.queryUtilityManager' => 'getApp_QueryUtilityManagerService',
            'app.redirectService' => 'getApp_RedirectServiceService',
            'app.removeTopNewsImg' => 'getApp_RemoveTopNewsImgService',
            'app.routerManager' => 'getApp_RouterManagerService',
            'app.seoConfigManager' => 'getApp_SeoConfigManagerService',
            'app.sitemap' => 'getApp_SitemapService',
            'app.spiderAmazon' => 'getApp_SpiderAmazonService',
            'app.spiderEbay' => 'getApp_SpiderEbayService',
            'app.spiderIdealo' => 'getApp_SpiderIdealoService',
            'app.spiderPagomeno' => 'getApp_SpiderPagomenoService',
            'app.spiderTrovaprezzi' => 'getApp_SpiderTrovaprezziService',
            'app.userManager' => 'getApp_UserManagerService',
            'app.web365ManagerRepository' => 'getApp_Web365ManagerRepositoryService',
            'app.widgetManager' => 'getApp_WidgetManagerService',
            'app.wordpressImportDb' => 'getApp_WordpressImportDbService',
            'argument_resolver.default' => 'getArgumentResolver_DefaultService',
            'argument_resolver.request' => 'getArgumentResolver_RequestService',
            'argument_resolver.request_attribute' => 'getArgumentResolver_RequestAttributeService',
            'argument_resolver.service' => 'getArgumentResolver_ServiceService',
            'argument_resolver.session' => 'getArgumentResolver_SessionService',
            'argument_resolver.variadic' => 'getArgumentResolver_VariadicService',
            'assets.context' => 'getAssets_ContextService',
            'assets.packages' => 'getAssets_PackagesService',
            'cache.annotations' => 'getCache_AnnotationsService',
            'cache.annotations.recorder_inner' => 'getCache_Annotations_RecorderInnerService',
            'cache.app' => 'getCache_AppService',
            'cache.app.recorder_inner' => 'getCache_App_RecorderInnerService',
            'cache.default_clearer' => 'getCache_DefaultClearerService',
            'cache.global_clearer' => 'getCache_GlobalClearerService',
            'cache.serializer.recorder_inner' => 'getCache_Serializer_RecorderInnerService',
            'cache.system' => 'getCache_SystemService',
            'cache.system.recorder_inner' => 'getCache_System_RecorderInnerService',
            'cache.validator' => 'getCache_ValidatorService',
            'cache.validator.recorder_inner' => 'getCache_Validator_RecorderInnerService',
            'cache_clearer' => 'getCacheClearerService',
            'cache_warmer' => 'getCacheWarmerService',
            'config_cache_factory' => 'getConfigCacheFactoryService',
            'console.command.symfony_bundle_securitybundle_command_userpasswordencodercommand' => 'getConsole_Command_SymfonyBundleSecuritybundleCommandUserpasswordencodercommandService',
            'console.error_listener' => 'getConsole_ErrorListenerService',
            'controller_name_converter' => 'getControllerNameConverterService',
            'data_collector.dump' => 'getDataCollector_DumpService',
            'data_collector.form' => 'getDataCollector_FormService',
            'data_collector.form.extractor' => 'getDataCollector_Form_ExtractorService',
            'data_collector.request' => 'getDataCollector_RequestService',
            'data_collector.router' => 'getDataCollector_RouterService',
            'data_collector.translation' => 'getDataCollector_TranslationService',
            'debug.argument_resolver' => 'getDebug_ArgumentResolverService',
            'debug.controller_resolver' => 'getDebug_ControllerResolverService',
            'debug.debug_handlers_listener' => 'getDebug_DebugHandlersListenerService',
            'debug.dump_listener' => 'getDebug_DumpListenerService',
            'debug.event_dispatcher' => 'getDebug_EventDispatcherService',
            'debug.file_link_formatter' => 'getDebug_FileLinkFormatterService',
            'debug.log_processor' => 'getDebug_LogProcessorService',
            'debug.security.access.decision_manager' => 'getDebug_Security_Access_DecisionManagerService',
            'debug.stopwatch' => 'getDebug_StopwatchService',
            'deprecated.form.registry' => 'getDeprecated_Form_RegistryService',
            'deprecated.form.registry.csrf' => 'getDeprecated_Form_Registry_CsrfService',
            'doctrine' => 'getDoctrineService',
            'doctrine.cache_clear_metadata_command' => 'getDoctrine_CacheClearMetadataCommandService',
            'doctrine.cache_clear_query_cache_command' => 'getDoctrine_CacheClearQueryCacheCommandService',
            'doctrine.cache_clear_result_command' => 'getDoctrine_CacheClearResultCommandService',
            'doctrine.cache_collection_region_command' => 'getDoctrine_CacheCollectionRegionCommandService',
            'doctrine.clear_entity_region_command' => 'getDoctrine_ClearEntityRegionCommandService',
            'doctrine.clear_query_region_command' => 'getDoctrine_ClearQueryRegionCommandService',
            'doctrine.database_create_command' => 'getDoctrine_DatabaseCreateCommandService',
            'doctrine.database_drop_command' => 'getDoctrine_DatabaseDropCommandService',
            'doctrine.database_import_command' => 'getDoctrine_DatabaseImportCommandService',
            'doctrine.dbal.connection_factory' => 'getDoctrine_Dbal_ConnectionFactoryService',
            'doctrine.dbal.default_connection' => 'getDoctrine_Dbal_DefaultConnectionService',
            'doctrine.dbal.logger.profiling.default' => 'getDoctrine_Dbal_Logger_Profiling_DefaultService',
            'doctrine.ensure_production_settings_command' => 'getDoctrine_EnsureProductionSettingsCommandService',
            'doctrine.generate_entities_command' => 'getDoctrine_GenerateEntitiesCommandService',
            'doctrine.mapping_convert_command' => 'getDoctrine_MappingConvertCommandService',
            'doctrine.mapping_import_command' => 'getDoctrine_MappingImportCommandService',
            'doctrine.mapping_info_command' => 'getDoctrine_MappingInfoCommandService',
            'doctrine.orm.default_entity_listener_resolver' => 'getDoctrine_Orm_DefaultEntityListenerResolverService',
            'doctrine.orm.default_entity_manager' => 'getDoctrine_Orm_DefaultEntityManagerService',
            'doctrine.orm.default_entity_manager.property_info_extractor' => 'getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService',
            'doctrine.orm.default_listeners.attach_entity_listeners' => 'getDoctrine_Orm_DefaultListeners_AttachEntityListenersService',
            'doctrine.orm.default_manager_configurator' => 'getDoctrine_Orm_DefaultManagerConfiguratorService',
            'doctrine.orm.default_metadata_cache' => 'getDoctrine_Orm_DefaultMetadataCacheService',
            'doctrine.orm.default_query_cache' => 'getDoctrine_Orm_DefaultQueryCacheService',
            'doctrine.orm.default_result_cache' => 'getDoctrine_Orm_DefaultResultCacheService',
            'doctrine.orm.default_second_level_cache.cache_configuration' => 'getDoctrine_Orm_DefaultSecondLevelCache_CacheConfigurationService',
            'doctrine.orm.default_second_level_cache.default_cache_factory' => 'getDoctrine_Orm_DefaultSecondLevelCache_DefaultCacheFactoryService',
            'doctrine.orm.default_second_level_cache.logger_chain' => 'getDoctrine_Orm_DefaultSecondLevelCache_LoggerChainService',
            'doctrine.orm.default_second_level_cache.logger_statistics' => 'getDoctrine_Orm_DefaultSecondLevelCache_LoggerStatisticsService',
            'doctrine.orm.default_second_level_cache.region_cache_driver' => 'getDoctrine_Orm_DefaultSecondLevelCache_RegionCacheDriverService',
            'doctrine.orm.default_second_level_cache.regions_configuration' => 'getDoctrine_Orm_DefaultSecondLevelCache_RegionsConfigurationService',
            'doctrine.orm.validator.unique' => 'getDoctrine_Orm_Validator_UniqueService',
            'doctrine.orm.validator_initializer' => 'getDoctrine_Orm_ValidatorInitializerService',
            'doctrine.query_dql_command' => 'getDoctrine_QueryDqlCommandService',
            'doctrine.query_sql_command' => 'getDoctrine_QuerySqlCommandService',
            'doctrine.schema_create_command' => 'getDoctrine_SchemaCreateCommandService',
            'doctrine.schema_drop_command' => 'getDoctrine_SchemaDropCommandService',
            'doctrine.schema_update_command' => 'getDoctrine_SchemaUpdateCommandService',
            'doctrine.schema_validate_command' => 'getDoctrine_SchemaValidateCommandService',
            'doctrine_cache.contains_command' => 'getDoctrineCache_ContainsCommandService',
            'doctrine_cache.delete_command' => 'getDoctrineCache_DeleteCommandService',
            'doctrine_cache.flush_command' => 'getDoctrineCache_FlushCommandService',
            'doctrine_cache.providers.doctrine.orm.default_metadata_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultMetadataCacheService',
            'doctrine_cache.providers.doctrine.orm.default_query_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultQueryCacheService',
            'doctrine_cache.providers.doctrine.orm.default_result_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultResultCacheService',
            'doctrine_cache.providers.doctrine.orm.default_second_level_cache.region_cache_driver' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultSecondLevelCache_RegionCacheDriverService',
            'doctrine_cache.stats_command' => 'getDoctrineCache_StatsCommandService',
            'esi' => 'getEsiService',
            'esi_listener' => 'getEsiListenerService',
            'file_locator' => 'getFileLocatorService',
            'filesystem' => 'getFilesystemService',
            'form.factory' => 'getForm_FactoryService',
            'form.registry' => 'getForm_RegistryService',
            'form.resolved_type_factory' => 'getForm_ResolvedTypeFactoryService',
            'form.server_params' => 'getForm_ServerParamsService',
            'form.type.birthday' => 'getForm_Type_BirthdayService',
            'form.type.button' => 'getForm_Type_ButtonService',
            'form.type.checkbox' => 'getForm_Type_CheckboxService',
            'form.type.choice' => 'getForm_Type_ChoiceService',
            'form.type.collection' => 'getForm_Type_CollectionService',
            'form.type.country' => 'getForm_Type_CountryService',
            'form.type.currency' => 'getForm_Type_CurrencyService',
            'form.type.date' => 'getForm_Type_DateService',
            'form.type.datetime' => 'getForm_Type_DatetimeService',
            'form.type.email' => 'getForm_Type_EmailService',
            'form.type.entity' => 'getForm_Type_EntityService',
            'form.type.file' => 'getForm_Type_FileService',
            'form.type.form' => 'getForm_Type_FormService',
            'form.type.hidden' => 'getForm_Type_HiddenService',
            'form.type.integer' => 'getForm_Type_IntegerService',
            'form.type.language' => 'getForm_Type_LanguageService',
            'form.type.locale' => 'getForm_Type_LocaleService',
            'form.type.money' => 'getForm_Type_MoneyService',
            'form.type.number' => 'getForm_Type_NumberService',
            'form.type.password' => 'getForm_Type_PasswordService',
            'form.type.percent' => 'getForm_Type_PercentService',
            'form.type.radio' => 'getForm_Type_RadioService',
            'form.type.range' => 'getForm_Type_RangeService',
            'form.type.repeated' => 'getForm_Type_RepeatedService',
            'form.type.reset' => 'getForm_Type_ResetService',
            'form.type.search' => 'getForm_Type_SearchService',
            'form.type.submit' => 'getForm_Type_SubmitService',
            'form.type.text' => 'getForm_Type_TextService',
            'form.type.textarea' => 'getForm_Type_TextareaService',
            'form.type.time' => 'getForm_Type_TimeService',
            'form.type.timezone' => 'getForm_Type_TimezoneService',
            'form.type.url' => 'getForm_Type_UrlService',
            'form.type_extension.csrf' => 'getForm_TypeExtension_CsrfService',
            'form.type_extension.form.data_collector' => 'getForm_TypeExtension_Form_DataCollectorService',
            'form.type_extension.form.http_foundation' => 'getForm_TypeExtension_Form_HttpFoundationService',
            'form.type_extension.form.validator' => 'getForm_TypeExtension_Form_ValidatorService',
            'form.type_extension.repeated.validator' => 'getForm_TypeExtension_Repeated_ValidatorService',
            'form.type_extension.submit.validator' => 'getForm_TypeExtension_Submit_ValidatorService',
            'form.type_extension.upload.validator' => 'getForm_TypeExtension_Upload_ValidatorService',
            'form.type_guesser.doctrine' => 'getForm_TypeGuesser_DoctrineService',
            'form.type_guesser.validator' => 'getForm_TypeGuesser_ValidatorService',
            'fos_elastica.alias_processor' => 'getFosElastica_AliasProcessorService',
            'fos_elastica.client.default' => 'getFosElastica_Client_DefaultService',
            'fos_elastica.config_manager' => 'getFosElastica_ConfigManagerService',
            'fos_elastica.data_collector' => 'getFosElastica_DataCollectorService',
            'fos_elastica.doctrine.register_listeners' => 'getFosElastica_Doctrine_RegisterListenersService',
            'fos_elastica.elastica_to_model_transformer.cmsmodel.model' => 'getFosElastica_ElasticaToModelTransformer_Cmsmodel_ModelService',
            'fos_elastica.elastica_to_model_transformer.cmsproduct.product' => 'getFosElastica_ElasticaToModelTransformer_Cmsproduct_ProductService',
            'fos_elastica.elastica_to_model_transformer.cmstypologies.model' => 'getFosElastica_ElasticaToModelTransformer_Cmstypologies_ModelService',
            'fos_elastica.elastica_to_model_transformer.collection.cmsmodel' => 'getFosElastica_ElasticaToModelTransformer_Collection_CmsmodelService',
            'fos_elastica.elastica_to_model_transformer.collection.cmsproduct' => 'getFosElastica_ElasticaToModelTransformer_Collection_CmsproductService',
            'fos_elastica.elastica_to_model_transformer.collection.cmstypologies' => 'getFosElastica_ElasticaToModelTransformer_Collection_CmstypologiesService',
            'fos_elastica.filter_objects_listener' => 'getFosElastica_FilterObjectsListenerService',
            'fos_elastica.finder.cmsmodel' => 'getFosElastica_Finder_CmsmodelService',
            'fos_elastica.finder.cmsmodel.model' => 'getFosElastica_Finder_Cmsmodel_ModelService',
            'fos_elastica.finder.cmsproduct' => 'getFosElastica_Finder_CmsproductService',
            'fos_elastica.finder.cmsproduct.product' => 'getFosElastica_Finder_Cmsproduct_ProductService',
            'fos_elastica.finder.cmstypologies' => 'getFosElastica_Finder_CmstypologiesService',
            'fos_elastica.finder.cmstypologies.model' => 'getFosElastica_Finder_Cmstypologies_ModelService',
            'fos_elastica.in_place_pager_persister' => 'getFosElastica_InPlacePagerPersisterService',
            'fos_elastica.index.cmsmodel' => 'getFosElastica_Index_CmsmodelService',
            'fos_elastica.index.cmsmodel.model' => 'getFosElastica_Index_Cmsmodel_ModelService',
            'fos_elastica.index.cmsproduct' => 'getFosElastica_Index_CmsproductService',
            'fos_elastica.index.cmsproduct.product' => 'getFosElastica_Index_Cmsproduct_ProductService',
            'fos_elastica.index.cmstypologies' => 'getFosElastica_Index_CmstypologiesService',
            'fos_elastica.index.cmstypologies.model' => 'getFosElastica_Index_Cmstypologies_ModelService',
            'fos_elastica.index_manager' => 'getFosElastica_IndexManagerService',
            'fos_elastica.indexable' => 'getFosElastica_IndexableService',
            'fos_elastica.logger' => 'getFosElastica_LoggerService',
            'fos_elastica.manager.orm' => 'getFosElastica_Manager_OrmService',
            'fos_elastica.mapping_builder' => 'getFosElastica_MappingBuilderService',
            'fos_elastica.object_persister.cmsmodel.model' => 'getFosElastica_ObjectPersister_Cmsmodel_ModelService',
            'fos_elastica.object_persister.cmsproduct.product' => 'getFosElastica_ObjectPersister_Cmsproduct_ProductService',
            'fos_elastica.object_persister.cmstypologies.model' => 'getFosElastica_ObjectPersister_Cmstypologies_ModelService',
            'fos_elastica.pager_persister_registry' => 'getFosElastica_PagerPersisterRegistryService',
            'fos_elastica.pager_provider_registry' => 'getFosElastica_PagerProviderRegistryService',
            'fos_elastica.paginator.subscriber' => 'getFosElastica_Paginator_SubscriberService',
            'fos_elastica.persister_registry' => 'getFosElastica_PersisterRegistryService',
            'fos_elastica.property_accessor' => 'getFosElastica_PropertyAccessorService',
            'fos_elastica.provider.cmsmodel.model' => 'getFosElastica_Provider_Cmsmodel_ModelService',
            'fos_elastica.provider.cmsproduct.product' => 'getFosElastica_Provider_Cmsproduct_ProductService',
            'fos_elastica.provider.cmstypologies.model' => 'getFosElastica_Provider_Cmstypologies_ModelService',
            'fos_elastica.provider_registry' => 'getFosElastica_ProviderRegistryService',
            'fos_elastica.repository_manager' => 'getFosElastica_RepositoryManagerService',
            'fos_elastica.resetter' => 'getFosElastica_ResetterService',
            'fos_elastica.slice_fetcher.orm' => 'getFosElastica_SliceFetcher_OrmService',
            'fragment.handler' => 'getFragment_HandlerService',
            'fragment.listener' => 'getFragment_ListenerService',
            'fragment.renderer.esi' => 'getFragment_Renderer_EsiService',
            'fragment.renderer.hinclude' => 'getFragment_Renderer_HincludeService',
            'fragment.renderer.inline' => 'getFragment_Renderer_InlineService',
            'http_kernel' => 'getHttpKernelService',
            'jms_serializer' => 'getJmsSerializerService',
            'jms_serializer.accessor_strategy' => 'getJmsSerializer_AccessorStrategyService',
            'jms_serializer.array_collection_handler' => 'getJmsSerializer_ArrayCollectionHandlerService',
            'jms_serializer.constraint_violation_handler' => 'getJmsSerializer_ConstraintViolationHandlerService',
            'jms_serializer.datetime_handler' => 'getJmsSerializer_DatetimeHandlerService',
            'jms_serializer.deserialization_context_factory' => 'getJmsSerializer_DeserializationContextFactoryService',
            'jms_serializer.doctrine_proxy_subscriber' => 'getJmsSerializer_DoctrineProxySubscriberService',
            'jms_serializer.expression_evaluator' => 'getJmsSerializer_ExpressionEvaluatorService',
            'jms_serializer.form_error_handler' => 'getJmsSerializer_FormErrorHandlerService',
            'jms_serializer.handler_registry' => 'getJmsSerializer_HandlerRegistryService',
            'jms_serializer.json_deserialization_visitor' => 'getJmsSerializer_JsonDeserializationVisitorService',
            'jms_serializer.json_serialization_visitor' => 'getJmsSerializer_JsonSerializationVisitorService',
            'jms_serializer.metadata_driver' => 'getJmsSerializer_MetadataDriverService',
            'jms_serializer.naming_strategy' => 'getJmsSerializer_NamingStrategyService',
            'jms_serializer.object_constructor' => 'getJmsSerializer_ObjectConstructorService',
            'jms_serializer.php_collection_handler' => 'getJmsSerializer_PhpCollectionHandlerService',
            'jms_serializer.serialization_context_factory' => 'getJmsSerializer_SerializationContextFactoryService',
            'jms_serializer.stopwatch_subscriber' => 'getJmsSerializer_StopwatchSubscriberService',
            'jms_serializer.templating.helper.serializer' => 'getJmsSerializer_Templating_Helper_SerializerService',
            'jms_serializer.twig_extension.serializer_runtime_helper' => 'getJmsSerializer_TwigExtension_SerializerRuntimeHelperService',
            'jms_serializer.unserialize_object_constructor' => 'getJmsSerializer_UnserializeObjectConstructorService',
            'jms_serializer.xml_deserialization_visitor' => 'getJmsSerializer_XmlDeserializationVisitorService',
            'jms_serializer.xml_serialization_visitor' => 'getJmsSerializer_XmlSerializationVisitorService',
            'jms_serializer.yaml_serialization_visitor' => 'getJmsSerializer_YamlSerializationVisitorService',
            'kernel.class_cache.cache_warmer' => 'getKernel_ClassCache_CacheWarmerService',
            'livescoreServices.compressFilesService' => 'getLivescoreServices_CompressFilesServiceService',
            'livescoreServices.sendDataToApp' => 'getLivescoreServices_SendDataToAppService',
            'livescoreServices.utilityApp' => 'getLivescoreServices_UtilityAppService',
            'livescoreServices.videoapi' => 'getLivescoreServices_VideoapiService',
            'locale_listener' => 'getLocaleListenerService',
            'logger' => 'getLoggerService',
            'mobile_detect.device_view' => 'getMobileDetect_DeviceViewService',
            'mobile_detect.mobile_detector.default' => 'getMobileDetect_MobileDetector_DefaultService',
            'mobile_detect.request_listener' => 'getMobileDetect_RequestListenerService',
            'mobile_detect.twig.extension' => 'getMobileDetect_Twig_ExtensionService',
            'mobile_detect_bundle.device.collector' => 'getMobileDetectBundle_Device_CollectorService',
            'monolog.handler.console' => 'getMonolog_Handler_ConsoleService',
            'monolog.handler.console_very_verbose' => 'getMonolog_Handler_ConsoleVeryVerboseService',
            'monolog.handler.main' => 'getMonolog_Handler_MainService',
            'monolog.handler.null_internal' => 'getMonolog_Handler_NullInternalService',
            'monolog.logger.cache' => 'getMonolog_Logger_CacheService',
            'monolog.logger.console' => 'getMonolog_Logger_ConsoleService',
            'monolog.logger.doctrine' => 'getMonolog_Logger_DoctrineService',
            'monolog.logger.elastica' => 'getMonolog_Logger_ElasticaService',
            'monolog.logger.event' => 'getMonolog_Logger_EventService',
            'monolog.logger.php' => 'getMonolog_Logger_PhpService',
            'monolog.logger.profiler' => 'getMonolog_Logger_ProfilerService',
            'monolog.logger.request' => 'getMonolog_Logger_RequestService',
            'monolog.logger.security' => 'getMonolog_Logger_SecurityService',
            'monolog.logger.snc_redis' => 'getMonolog_Logger_SncRedisService',
            'monolog.logger.templating' => 'getMonolog_Logger_TemplatingService',
            'monolog.logger.translation' => 'getMonolog_Logger_TranslationService',
            'monolog.processor.psr_log_message' => 'getMonolog_Processor_PsrLogMessageService',
            'profiler' => 'getProfilerService',
            'profiler.storage' => 'getProfiler_StorageService',
            'profiler_listener' => 'getProfilerListenerService',
            'property_accessor' => 'getPropertyAccessorService',
            'request_stack' => 'getRequestStackService',
            'resolve_controller_name_subscriber' => 'getResolveControllerNameSubscriberService',
            'response_listener' => 'getResponseListenerService',
            'router' => 'getRouterService',
            'router.request_context' => 'getRouter_RequestContextService',
            'router_listener' => 'getRouterListenerService',
            'routing.loader' => 'getRouting_LoaderService',
            'security.access.authenticated_voter' => 'getSecurity_Access_AuthenticatedVoterService',
            'security.access.expression_voter' => 'getSecurity_Access_ExpressionVoterService',
            'security.access.simple_role_voter' => 'getSecurity_Access_SimpleRoleVoterService',
            'security.authentication.guard_handler' => 'getSecurity_Authentication_GuardHandlerService',
            'security.authentication.manager' => 'getSecurity_Authentication_ManagerService',
            'security.authentication.provider.anonymous.main' => 'getSecurity_Authentication_Provider_Anonymous_MainService',
            'security.authentication.trust_resolver' => 'getSecurity_Authentication_TrustResolverService',
            'security.authentication_utils' => 'getSecurity_AuthenticationUtilsService',
            'security.authorization_checker' => 'getSecurity_AuthorizationCheckerService',
            'security.csrf.token_manager' => 'getSecurity_Csrf_TokenManagerService',
            'security.encoder_factory' => 'getSecurity_EncoderFactoryService',
            'security.firewall' => 'getSecurity_FirewallService',
            'security.firewall.map' => 'getSecurity_Firewall_MapService',
            'security.firewall.map.context.dev' => 'getSecurity_Firewall_Map_Context_DevService',
            'security.firewall.map.context.main' => 'getSecurity_Firewall_Map_Context_MainService',
            'security.logout_url_generator' => 'getSecurity_LogoutUrlGeneratorService',
            'security.password_encoder' => 'getSecurity_PasswordEncoderService',
            'security.rememberme.response_listener' => 'getSecurity_Rememberme_ResponseListenerService',
            'security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d' => 'getSecurity_RequestMatcher_5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1dService',
            'security.role_hierarchy' => 'getSecurity_RoleHierarchyService',
            'security.token_storage' => 'getSecurity_TokenStorageService',
            'security.user_value_resolver' => 'getSecurity_UserValueResolverService',
            'security.validator.user_password' => 'getSecurity_Validator_UserPasswordService',
            'sensio_distribution.security_checker' => 'getSensioDistribution_SecurityCheckerService',
            'sensio_distribution.security_checker.command' => 'getSensioDistribution_SecurityChecker_CommandService',
            'sensio_framework_extra.cache.listener' => 'getSensioFrameworkExtra_Cache_ListenerService',
            'sensio_framework_extra.controller.listener' => 'getSensioFrameworkExtra_Controller_ListenerService',
            'sensio_framework_extra.converter.datetime' => 'getSensioFrameworkExtra_Converter_DatetimeService',
            'sensio_framework_extra.converter.doctrine.orm' => 'getSensioFrameworkExtra_Converter_Doctrine_OrmService',
            'sensio_framework_extra.converter.listener' => 'getSensioFrameworkExtra_Converter_ListenerService',
            'sensio_framework_extra.converter.manager' => 'getSensioFrameworkExtra_Converter_ManagerService',
            'sensio_framework_extra.security.listener' => 'getSensioFrameworkExtra_Security_ListenerService',
            'sensio_framework_extra.view.guesser' => 'getSensioFrameworkExtra_View_GuesserService',
            'sensio_framework_extra.view.listener' => 'getSensioFrameworkExtra_View_ListenerService',
            'service_locator.3368f0f4075960b08010e4ebdaedef01' => 'getServiceLocator_3368f0f4075960b08010e4ebdaedef01Service',
            'service_locator.6f24348b77840ec12a20c22a3f985cf7' => 'getServiceLocator_6f24348b77840ec12a20c22a3f985cf7Service',
            'session' => 'getSessionService',
            'session.save_listener' => 'getSession_SaveListenerService',
            'session.storage.filesystem' => 'getSession_Storage_FilesystemService',
            'session.storage.metadata_bag' => 'getSession_Storage_MetadataBagService',
            'session.storage.native' => 'getSession_Storage_NativeService',
            'session.storage.php_bridge' => 'getSession_Storage_PhpBridgeService',
            'session_listener' => 'getSessionListenerService',
            'snc_redis.command.flush_all' => 'getSncRedis_Command_FlushAllService',
            'snc_redis.command.flush_db' => 'getSncRedis_Command_FlushDbService',
            'snc_redis.logger' => 'getSncRedis_LoggerService',
            'snc_redis.monolog' => 'getSncRedis_MonologService',
            'snc_redis.profiler_storage' => 'getSncRedis_ProfilerStorageService',
            'snc_redis.secondLevelCache' => 'getSncRedis_SecondLevelCacheService',
            'snc_redis.sncredis' => 'getSncRedis_SncredisService',
            'snc_redis.sncredisDoctrineQueryCache' => 'getSncRedis_SncredisDoctrineQueryCacheService',
            'snc_redis.sncredisDoctrineResult' => 'getSncRedis_SncredisDoctrineResultService',
            'snc_redis.sncredisDoctrinemetadata' => 'getSncRedis_SncredisDoctrinemetadataService',
            'snc_redis.sncredisSessionPhp' => 'getSncRedis_SncredisSessionPhpService',
            'streamed_response_listener' => 'getStreamedResponseListenerService',
            'swiftmailer.email_sender.listener' => 'getSwiftmailer_EmailSender_ListenerService',
            'swiftmailer.mailer.default' => 'getSwiftmailer_Mailer_DefaultService',
            'swiftmailer.mailer.default.plugin.messagelogger' => 'getSwiftmailer_Mailer_Default_Plugin_MessageloggerService',
            'swiftmailer.mailer.default.spool' => 'getSwiftmailer_Mailer_Default_SpoolService',
            'swiftmailer.mailer.default.transport' => 'getSwiftmailer_Mailer_Default_TransportService',
            'swiftmailer.mailer.default.transport.eventdispatcher' => 'getSwiftmailer_Mailer_Default_Transport_EventdispatcherService',
            'swiftmailer.mailer.default.transport.real' => 'getSwiftmailer_Mailer_Default_Transport_RealService',
            'templating' => 'getTemplatingService',
            'templating.filename_parser' => 'getTemplating_FilenameParserService',
            'templating.helper.logout_url' => 'getTemplating_Helper_LogoutUrlService',
            'templating.helper.security' => 'getTemplating_Helper_SecurityService',
            'templating.loader' => 'getTemplating_LoaderService',
            'templating.locator' => 'getTemplating_LocatorService',
            'templating.name_parser' => 'getTemplating_NameParserService',
            'translation.dumper.csv' => 'getTranslation_Dumper_CsvService',
            'translation.dumper.ini' => 'getTranslation_Dumper_IniService',
            'translation.dumper.json' => 'getTranslation_Dumper_JsonService',
            'translation.dumper.mo' => 'getTranslation_Dumper_MoService',
            'translation.dumper.php' => 'getTranslation_Dumper_PhpService',
            'translation.dumper.po' => 'getTranslation_Dumper_PoService',
            'translation.dumper.qt' => 'getTranslation_Dumper_QtService',
            'translation.dumper.res' => 'getTranslation_Dumper_ResService',
            'translation.dumper.xliff' => 'getTranslation_Dumper_XliffService',
            'translation.dumper.yml' => 'getTranslation_Dumper_YmlService',
            'translation.extractor' => 'getTranslation_ExtractorService',
            'translation.extractor.php' => 'getTranslation_Extractor_PhpService',
            'translation.loader' => 'getTranslation_LoaderService',
            'translation.loader.csv' => 'getTranslation_Loader_CsvService',
            'translation.loader.dat' => 'getTranslation_Loader_DatService',
            'translation.loader.ini' => 'getTranslation_Loader_IniService',
            'translation.loader.json' => 'getTranslation_Loader_JsonService',
            'translation.loader.mo' => 'getTranslation_Loader_MoService',
            'translation.loader.php' => 'getTranslation_Loader_PhpService',
            'translation.loader.po' => 'getTranslation_Loader_PoService',
            'translation.loader.qt' => 'getTranslation_Loader_QtService',
            'translation.loader.res' => 'getTranslation_Loader_ResService',
            'translation.loader.xliff' => 'getTranslation_Loader_XliffService',
            'translation.loader.yml' => 'getTranslation_Loader_YmlService',
            'translation.writer' => 'getTranslation_WriterService',
            'translator' => 'getTranslatorService',
            'translator.default' => 'getTranslator_DefaultService',
            'translator_listener' => 'getTranslatorListenerService',
            'twig' => 'getTwigService',
            'twig.controller.exception' => 'getTwig_Controller_ExceptionService',
            'twig.controller.preview_error' => 'getTwig_Controller_PreviewErrorService',
            'twig.exception_listener' => 'getTwig_ExceptionListenerService',
            'twig.form.renderer' => 'getTwig_Form_RendererService',
            'twig.loader' => 'getTwig_LoaderService',
            'twig.profile' => 'getTwig_ProfileService',
            'twig.runtime.httpkernel' => 'getTwig_Runtime_HttpkernelService',
            'twig.translation.extractor' => 'getTwig_Translation_ExtractorService',
            'uri_signer' => 'getUriSignerService',
            'validate_request_listener' => 'getValidateRequestListenerService',
            'validator' => 'getValidatorService',
            'validator.builder' => 'getValidator_BuilderService',
            'validator.email' => 'getValidator_EmailService',
            'validator.expression' => 'getValidator_ExpressionService',
            'var_dumper.cli_dumper' => 'getVarDumper_CliDumperService',
            'var_dumper.cloner' => 'getVarDumper_ClonerService',
            'web_profiler.controller.exception' => 'getWebProfiler_Controller_ExceptionService',
            'web_profiler.controller.profiler' => 'getWebProfiler_Controller_ProfilerService',
            'web_profiler.controller.router' => 'getWebProfiler_Controller_RouterService',
        );
        $this->privates = array(
            '1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' => true,
            '2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' => true,
            'annotations.cache' => true,
            'annotations.reader' => true,
            'argument_resolver.default' => true,
            'argument_resolver.request' => true,
            'argument_resolver.request_attribute' => true,
            'argument_resolver.service' => true,
            'argument_resolver.session' => true,
            'argument_resolver.variadic' => true,
            'cache.annotations' => true,
            'cache.annotations.recorder_inner' => true,
            'cache.app.recorder_inner' => true,
            'cache.serializer.recorder_inner' => true,
            'cache.system.recorder_inner' => true,
            'cache.validator' => true,
            'cache.validator.recorder_inner' => true,
            'console.error_listener' => true,
            'controller_name_converter' => true,
            'debug.file_link_formatter' => true,
            'debug.log_processor' => true,
            'debug.security.access.decision_manager' => true,
            'doctrine.dbal.logger.profiling.default' => true,
            'form.server_params' => true,
            'form.type.choice' => true,
            'form.type.form' => true,
            'form.type_extension.csrf' => true,
            'form.type_extension.form.data_collector' => true,
            'form.type_extension.form.http_foundation' => true,
            'form.type_extension.form.validator' => true,
            'form.type_extension.repeated.validator' => true,
            'form.type_extension.submit.validator' => true,
            'form.type_extension.upload.validator' => true,
            'form.type_guesser.validator' => true,
            'fos_elastica.elastica_to_model_transformer.cmsmodel.model' => true,
            'fos_elastica.elastica_to_model_transformer.cmsproduct.product' => true,
            'fos_elastica.elastica_to_model_transformer.cmstypologies.model' => true,
            'jms_serializer.unserialize_object_constructor' => true,
            'monolog.processor.psr_log_message' => true,
            'resolve_controller_name_subscriber' => true,
            'router.request_context' => true,
            'security.access.authenticated_voter' => true,
            'security.access.expression_voter' => true,
            'security.access.simple_role_voter' => true,
            'security.authentication.manager' => true,
            'security.authentication.provider.anonymous.main' => true,
            'security.authentication.trust_resolver' => true,
            'security.firewall.map' => true,
            'security.logout_url_generator' => true,
            'security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d' => true,
            'security.role_hierarchy' => true,
            'security.user_value_resolver' => true,
            'service_locator.3368f0f4075960b08010e4ebdaedef01' => true,
            'service_locator.6f24348b77840ec12a20c22a3f985cf7' => true,
            'session.storage.metadata_bag' => true,
            'swiftmailer.mailer.default.transport.eventdispatcher' => true,
            'templating.locator' => true,
        );
        $this->aliases = array(
            'cache.app_clearer' => 'cache.default_clearer',
            'database_connection' => 'doctrine.dbal.default_connection',
            'doctrine.orm.entity_manager' => 'doctrine.orm.default_entity_manager',
            'event_dispatcher' => 'debug.event_dispatcher',
            'fos_elastica.client' => 'fos_elastica.client.default',
            'fos_elastica.index' => 'fos_elastica.index.cmsproduct',
            'fos_elastica.manager' => 'fos_elastica.manager.orm',
            'mailer' => 'swiftmailer.mailer.default',
            'mobile_detect.mobile_detector' => 'mobile_detect.mobile_detector.default',
            'session.storage' => 'session.storage.native',
            'snc_redis.monolog_client' => 'snc_redis.monolog',
            'snc_redis.profiler_storage.client' => 'snc_redis.profiler_storage',
            'snc_redis.profiler_storage_client' => 'snc_redis.profiler_storage',
            'snc_redis.secondLevelCache_client' => 'snc_redis.secondLevelCache',
            'snc_redis.sncredisDoctrineQueryCache_client' => 'snc_redis.sncredisDoctrineQueryCache',
            'snc_redis.sncredisDoctrineResult_client' => 'snc_redis.sncredisDoctrineResult',
            'snc_redis.sncredisDoctrinemetadata_client' => 'snc_redis.sncredisDoctrinemetadata',
            'snc_redis.sncredisSessionPhp_client' => 'snc_redis.sncredisSessionPhp',
            'snc_redis.sncredis_client' => 'snc_redis.sncredis',
            'swiftmailer.mailer' => 'swiftmailer.mailer.default',
            'swiftmailer.plugin.messagelogger' => 'swiftmailer.mailer.default.plugin.messagelogger',
            'swiftmailer.spool' => 'swiftmailer.mailer.default.spool',
            'swiftmailer.transport' => 'swiftmailer.mailer.default.transport',
            'swiftmailer.transport.real' => 'swiftmailer.mailer.default.transport.real',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    /**
     * {@inheritdoc}
     */
    public function isCompiled()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isFrozen()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Use the isCompiled() method instead.', __METHOD__), E_USER_DEPRECATED);

        return true;
    }

    /**
     * Gets the public 'annotation_reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\CachedReader
     */
    protected function getAnnotationReaderService()
    {
        $this->services['annotation_reader'] = $instance = new \Doctrine\Common\Annotations\CachedReader(${($_ = isset($this->services['annotations.reader']) ? $this->services['annotations.reader'] : $this->getAnnotations_ReaderService()) && false ?: '_'}, new \Doctrine\Common\Cache\ArrayCache(), true);

        $instance->cacheProviderBackup = function () {
            return ${($_ = isset($this->services['annotations.cache']) ? $this->services['annotations.cache'] : $this->getAnnotations_CacheService()) && false ?: '_'};
        };

        return $instance;
    }

    /**
     * Gets the public 'app.amazonApi' shared service.
     *
     * @return \AppBundle\Service\AmazonService\AmazonApi
     */
    protected function getApp_AmazonApiService()
    {
        return $this->services['app.amazonApi'] = new \AppBundle\Service\AmazonService\AmazonApi(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.apiGettyImageService' shared service.
     *
     * @return \AppBundle\Service\ApiGettyImageService\ApiGettyImageService
     */
    protected function getApp_ApiGettyImageServiceService()
    {
        return $this->services['app.apiGettyImageService'] = new \AppBundle\Service\ApiGettyImageService\ApiGettyImageService();
    }

    /**
     * Gets the public 'app.bannersConfigManager' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\BannersConfigManager
     */
    protected function getApp_BannersConfigManagerService()
    {
        return $this->services['app.bannersConfigManager'] = new \AppBundle\Service\GlobalConfigService\BannersConfigManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.browserUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\BrowserUtility
     */
    protected function getApp_BrowserUtilityService()
    {
        return $this->services['app.browserUtility'] = new \AppBundle\Service\UtilityService\BrowserUtility(${($_ = isset($this->services['mobile_detect.mobile_detector.default']) ? $this->services['mobile_detect.mobile_detector.default'] : $this->get('mobile_detect.mobile_detector.default')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.cacheUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\CacheUtility
     */
    protected function getApp_CacheUtilityService()
    {
        return $this->services['app.cacheUtility'] = new \AppBundle\Service\UtilityService\CacheUtility($this);
    }

    /**
     * Gets the public 'app.cacheUtilitySecondLevelCache' shared service.
     *
     * @return \AppBundle\Service\UtilityService\CacheUtility
     */
    protected function getApp_CacheUtilitySecondLevelCacheService()
    {
        $this->services['app.cacheUtilitySecondLevelCache'] = $instance = new \AppBundle\Service\UtilityService\CacheUtility($this);

        $instance->initPhpCache('secondLevelCache');

        return $instance;
    }

    /**
     * Gets the public 'app.chat' shared service.
     *
     * @return \AppBundle\Sockets\Chat
     */
    protected function getApp_ChatService()
    {
        return $this->services['app.chat'] = new \AppBundle\Sockets\Chat($this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminArticle' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminArticle
     */
    protected function getApp_CoreAdminArticleService()
    {
        return $this->services['app.coreAdminArticle'] = new \AppBundle\Service\WidgetService\CoreAdminArticle(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminBestDiscountedPrices' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminBestDiscountedPrices
     */
    protected function getApp_CoreAdminBestDiscountedPricesService()
    {
        return $this->services['app.coreAdminBestDiscountedPrices'] = new \AppBundle\Service\WidgetService\CoreAdminBestDiscountedPrices(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminDashboard' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminDashboard
     */
    protected function getApp_CoreAdminDashboardService()
    {
        return $this->services['app.coreAdminDashboard'] = new \AppBundle\Service\WidgetService\CoreAdminDashboard(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditAffiliation' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditAffiliation
     */
    protected function getApp_CoreAdminEditAffiliationService()
    {
        return $this->services['app.coreAdminEditAffiliation'] = new \AppBundle\Service\WidgetService\CoreAdminEditAffiliation(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditBanner' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditBanner
     */
    protected function getApp_CoreAdminEditBannerService()
    {
        return $this->services['app.coreAdminEditBanner'] = new \AppBundle\Service\WidgetService\CoreAdminEditBanner(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditCategory' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditCategory
     */
    protected function getApp_CoreAdminEditCategoryService()
    {
        return $this->services['app.coreAdminEditCategory'] = new \AppBundle\Service\WidgetService\CoreAdminEditCategory(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditColor' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditColor
     */
    protected function getApp_CoreAdminEditColorService()
    {
        return $this->services['app.coreAdminEditColor'] = new \AppBundle\Service\WidgetService\CoreAdminEditColor(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditComparison' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditComparison
     */
    protected function getApp_CoreAdminEditComparisonService()
    {
        return $this->services['app.coreAdminEditComparison'] = new \AppBundle\Service\WidgetService\CoreAdminEditComparison(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditDictionary' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditDictionary
     */
    protected function getApp_CoreAdminEditDictionaryService()
    {
        return $this->services['app.coreAdminEditDictionary'] = new \AppBundle\Service\WidgetService\CoreAdminEditDictionary(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditDinamycPage' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditDinamycPage
     */
    protected function getApp_CoreAdminEditDinamycPageService()
    {
        return $this->services['app.coreAdminEditDinamycPage'] = new \AppBundle\Service\WidgetService\CoreAdminEditDinamycPage(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditExtraConfig' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditExtraConfig
     */
    protected function getApp_CoreAdminEditExtraConfigService()
    {
        return $this->services['app.coreAdminEditExtraConfig'] = new \AppBundle\Service\WidgetService\CoreAdminEditExtraConfig(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditGroupPermission' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditGroupPermission
     */
    protected function getApp_CoreAdminEditGroupPermissionService()
    {
        return $this->services['app.coreAdminEditGroupPermission'] = new \AppBundle\Service\WidgetService\CoreAdminEditGroupPermission(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditMicroSection' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditMicroSection
     */
    protected function getApp_CoreAdminEditMicroSectionService()
    {
        return $this->services['app.coreAdminEditMicroSection'] = new \AppBundle\Service\WidgetService\CoreAdminEditMicroSection(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditModel' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditModel
     */
    protected function getApp_CoreAdminEditModelService()
    {
        return $this->services['app.coreAdminEditModel'] = new \AppBundle\Service\WidgetService\CoreAdminEditModel(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditPoll' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditPoll
     */
    protected function getApp_CoreAdminEditPollService()
    {
        return $this->services['app.coreAdminEditPoll'] = new \AppBundle\Service\WidgetService\CoreAdminEditPoll(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditProduct' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditProduct
     */
    protected function getApp_CoreAdminEditProductService()
    {
        return $this->services['app.coreAdminEditProduct'] = new \AppBundle\Service\WidgetService\CoreAdminEditProduct(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditQuestion' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditQuestion
     */
    protected function getApp_CoreAdminEditQuestionService()
    {
        return $this->services['app.coreAdminEditQuestion'] = new \AppBundle\Service\WidgetService\CoreAdminEditQuestion(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditRedirect' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditRedirect
     */
    protected function getApp_CoreAdminEditRedirectService()
    {
        return $this->services['app.coreAdminEditRedirect'] = new \AppBundle\Service\WidgetService\CoreAdminEditRedirect(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditSearchTerm' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditSearchTerm
     */
    protected function getApp_CoreAdminEditSearchTermService()
    {
        return $this->services['app.coreAdminEditSearchTerm'] = new \AppBundle\Service\WidgetService\CoreAdminEditSearchTerm(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditSex' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditSex
     */
    protected function getApp_CoreAdminEditSexService()
    {
        return $this->services['app.coreAdminEditSex'] = new \AppBundle\Service\WidgetService\CoreAdminEditSex(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditSize' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditSize
     */
    protected function getApp_CoreAdminEditSizeService()
    {
        return $this->services['app.coreAdminEditSize'] = new \AppBundle\Service\WidgetService\CoreAdminEditSize(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditSubcategory' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditSubcategory
     */
    protected function getApp_CoreAdminEditSubcategoryService()
    {
        return $this->services['app.coreAdminEditSubcategory'] = new \AppBundle\Service\WidgetService\CoreAdminEditSubcategory(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditTecnicalTemplate' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditTecnicalTemplate
     */
    protected function getApp_CoreAdminEditTecnicalTemplateService()
    {
        return $this->services['app.coreAdminEditTecnicalTemplate'] = new \AppBundle\Service\WidgetService\CoreAdminEditTecnicalTemplate(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditTrademark' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditTrademark
     */
    protected function getApp_CoreAdminEditTrademarkService()
    {
        return $this->services['app.coreAdminEditTrademark'] = new \AppBundle\Service\WidgetService\CoreAdminEditTrademark(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditTypology' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditTypology
     */
    protected function getApp_CoreAdminEditTypologyService()
    {
        return $this->services['app.coreAdminEditTypology'] = new \AppBundle\Service\WidgetService\CoreAdminEditTypology(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminEditUser' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminEditUser
     */
    protected function getApp_CoreAdminEditUserService()
    {
        return $this->services['app.coreAdminEditUser'] = new \AppBundle\Service\WidgetService\CoreAdminEditUser(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminExtraConfigs' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminExtraConfigs
     */
    protected function getApp_CoreAdminExtraConfigsService()
    {
        return $this->services['app.coreAdminExtraConfigs'] = new \AppBundle\Service\WidgetService\CoreAdminExtraConfigs(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminImageArticle' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminImageArticle
     */
    protected function getApp_CoreAdminImageArticleService()
    {
        return $this->services['app.coreAdminImageArticle'] = new \AppBundle\Service\WidgetService\CoreAdminImageArticle(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminImageArticleGetty' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminImageArticleGetty
     */
    protected function getApp_CoreAdminImageArticleGettyService()
    {
        return $this->services['app.coreAdminImageArticleGetty'] = new \AppBundle\Service\WidgetService\CoreAdminImageArticleGetty(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.apiGettyImageService']) ? $this->services['app.apiGettyImageService'] : $this->get('app.apiGettyImageService')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListAffiliations' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListAffiliations
     */
    protected function getApp_CoreAdminListAffiliationsService()
    {
        return $this->services['app.coreAdminListAffiliations'] = new \AppBundle\Service\WidgetService\CoreAdminListAffiliations(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListArticles' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListArticles
     */
    protected function getApp_CoreAdminListArticlesService()
    {
        return $this->services['app.coreAdminListArticles'] = new \AppBundle\Service\WidgetService\CoreAdminListArticles(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListBanners' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListBanners
     */
    protected function getApp_CoreAdminListBannersService()
    {
        return $this->services['app.coreAdminListBanners'] = new \AppBundle\Service\WidgetService\CoreAdminListBanners(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListCategories' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListCategories
     */
    protected function getApp_CoreAdminListCategoriesService()
    {
        return $this->services['app.coreAdminListCategories'] = new \AppBundle\Service\WidgetService\CoreAdminListCategories(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListColors' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListColors
     */
    protected function getApp_CoreAdminListColorsService()
    {
        return $this->services['app.coreAdminListColors'] = new \AppBundle\Service\WidgetService\CoreAdminListColors(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListComparison' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListComparison
     */
    protected function getApp_CoreAdminListComparisonService()
    {
        return $this->services['app.coreAdminListComparison'] = new \AppBundle\Service\WidgetService\CoreAdminListComparison(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListDictionaries' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListDictionaries
     */
    protected function getApp_CoreAdminListDictionariesService()
    {
        return $this->services['app.coreAdminListDictionaries'] = new \AppBundle\Service\WidgetService\CoreAdminListDictionaries(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListDinamycPages' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListDinamycPages
     */
    protected function getApp_CoreAdminListDinamycPagesService()
    {
        return $this->services['app.coreAdminListDinamycPages'] = new \AppBundle\Service\WidgetService\CoreAdminListDinamycPages(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListDisabledModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListDisabledModels
     */
    protected function getApp_CoreAdminListDisabledModelsService()
    {
        return $this->services['app.coreAdminListDisabledModels'] = new \AppBundle\Service\WidgetService\CoreAdminListDisabledModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListFeedsImport' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListFeedsImport
     */
    protected function getApp_CoreAdminListFeedsImportService()
    {
        return $this->services['app.coreAdminListFeedsImport'] = new \AppBundle\Service\WidgetService\CoreAdminListFeedsImport(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListGroupPermission' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListGroupPermission
     */
    protected function getApp_CoreAdminListGroupPermissionService()
    {
        return $this->services['app.coreAdminListGroupPermission'] = new \AppBundle\Service\WidgetService\CoreAdminListGroupPermission(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListMicroSection' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListMicroSection
     */
    protected function getApp_CoreAdminListMicroSectionService()
    {
        return $this->services['app.coreAdminListMicroSection'] = new \AppBundle\Service\WidgetService\CoreAdminListMicroSection(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListModels
     */
    protected function getApp_CoreAdminListModelsService()
    {
        return $this->services['app.coreAdminListModels'] = new \AppBundle\Service\WidgetService\CoreAdminListModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListPolls' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListPolls
     */
    protected function getApp_CoreAdminListPollsService()
    {
        return $this->services['app.coreAdminListPolls'] = new \AppBundle\Service\WidgetService\CoreAdminListPolls(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListProducts' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListProducts
     */
    protected function getApp_CoreAdminListProductsService()
    {
        return $this->services['app.coreAdminListProducts'] = new \AppBundle\Service\WidgetService\CoreAdminListProducts(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListQuestion' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListQuestion
     */
    protected function getApp_CoreAdminListQuestionService()
    {
        return $this->services['app.coreAdminListQuestion'] = new \AppBundle\Service\WidgetService\CoreAdminListQuestion(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListRedirects' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListRedirects
     */
    protected function getApp_CoreAdminListRedirectsService()
    {
        return $this->services['app.coreAdminListRedirects'] = new \AppBundle\Service\WidgetService\CoreAdminListRedirects(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListSearchTerms' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListSearchTerms
     */
    protected function getApp_CoreAdminListSearchTermsService()
    {
        return $this->services['app.coreAdminListSearchTerms'] = new \AppBundle\Service\WidgetService\CoreAdminListSearchTerms(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListSex' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListSex
     */
    protected function getApp_CoreAdminListSexService()
    {
        return $this->services['app.coreAdminListSex'] = new \AppBundle\Service\WidgetService\CoreAdminListSex(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListSizes' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListSizes
     */
    protected function getApp_CoreAdminListSizesService()
    {
        return $this->services['app.coreAdminListSizes'] = new \AppBundle\Service\WidgetService\CoreAdminListSizes(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListSubcategories' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListSubcategories
     */
    protected function getApp_CoreAdminListSubcategoriesService()
    {
        return $this->services['app.coreAdminListSubcategories'] = new \AppBundle\Service\WidgetService\CoreAdminListSubcategories(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListTecnicalTemplate' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListTecnicalTemplate
     */
    protected function getApp_CoreAdminListTecnicalTemplateService()
    {
        return $this->services['app.coreAdminListTecnicalTemplate'] = new \AppBundle\Service\WidgetService\CoreAdminListTecnicalTemplate(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListTrademarks' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListTrademarks
     */
    protected function getApp_CoreAdminListTrademarksService()
    {
        return $this->services['app.coreAdminListTrademarks'] = new \AppBundle\Service\WidgetService\CoreAdminListTrademarks(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminListTypology' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminListTypology
     */
    protected function getApp_CoreAdminListTypologyService()
    {
        return $this->services['app.coreAdminListTypology'] = new \AppBundle\Service\WidgetService\CoreAdminListTypology(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminLookupSubcategories' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminLookupSubcategories
     */
    protected function getApp_CoreAdminLookupSubcategoriesService()
    {
        return $this->services['app.coreAdminLookupSubcategories'] = new \AppBundle\Service\WidgetService\CoreAdminLookupSubcategories(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminManagerMenus' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminManagerMenus
     */
    protected function getApp_CoreAdminManagerMenusService()
    {
        return $this->services['app.coreAdminManagerMenus'] = new \AppBundle\Service\WidgetService\CoreAdminManagerMenus(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminMenu' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminMenu
     */
    protected function getApp_CoreAdminMenuService()
    {
        return $this->services['app.coreAdminMenu'] = new \AppBundle\Service\WidgetService\CoreAdminMenu(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminTopTrademarkSection' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminTopTrademarkSection
     */
    protected function getApp_CoreAdminTopTrademarkSectionService()
    {
        return $this->services['app.coreAdminTopTrademarkSection'] = new \AppBundle\Service\WidgetService\CoreAdminTopTrademarkSection(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminUploadImage' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminUploadImage
     */
    protected function getApp_CoreAdminUploadImageService()
    {
        return $this->services['app.coreAdminUploadImage'] = new \AppBundle\Service\WidgetService\CoreAdminUploadImage(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAdminUsers' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAdminUsers
     */
    protected function getApp_CoreAdminUsersService()
    {
        return $this->services['app.coreAdminUsers'] = new \AppBundle\Service\WidgetService\CoreAdminUsers(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'}, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreAllCategories' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreAllCategories
     */
    protected function getApp_CoreAllCategoriesService()
    {
        return $this->services['app.coreAllCategories'] = new \AppBundle\Service\WidgetService\CoreAllCategories(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBannerMenu' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBannerMenu
     */
    protected function getApp_CoreBannerMenuService()
    {
        return $this->services['app.coreBannerMenu'] = new \AppBundle\Service\WidgetService\CoreBannerMenu(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBestseller' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBestseller
     */
    protected function getApp_CoreBestsellerService()
    {
        return $this->services['app.coreBestseller'] = new \AppBundle\Service\WidgetService\CoreBestseller(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBestsellerModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBestsellerModels
     */
    protected function getApp_CoreBestsellerModelsService()
    {
        return $this->services['app.coreBestsellerModels'] = new \AppBundle\Service\WidgetService\CoreBestsellerModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBestsellerRelatedModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBestsellerRelatedModels
     */
    protected function getApp_CoreBestsellerRelatedModelsService()
    {
        return $this->services['app.coreBestsellerRelatedModels'] = new \AppBundle\Service\WidgetService\CoreBestsellerRelatedModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBreadcrumbs' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBreadCrumbs
     */
    protected function getApp_CoreBreadcrumbsService()
    {
        return $this->services['app.coreBreadcrumbs'] = new \AppBundle\Service\WidgetService\CoreBreadCrumbs(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreBreakingNews' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreBreakingNews
     */
    protected function getApp_CoreBreakingNewsService()
    {
        return $this->services['app.coreBreakingNews'] = new \AppBundle\Service\WidgetService\CoreBreakingNews(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreCatSubcatTypology' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreCatSubcatTypology
     */
    protected function getApp_CoreCatSubcatTypologyService()
    {
        return $this->services['app.coreCatSubcatTypology'] = new \AppBundle\Service\WidgetService\CoreCatSubcatTypology(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreCatSubcatTypologyList' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreCatSubcatTypologyList
     */
    protected function getApp_CoreCatSubcatTypologyListService()
    {
        return $this->services['app.coreCatSubcatTypologyList'] = new \AppBundle\Service\WidgetService\CoreCatSubcatTypologyList(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreCatSubcatTypologyListAcquistiGiusti' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreCatSubcatTypologyListAcquistiGiusti
     */
    protected function getApp_CoreCatSubcatTypologyListAcquistiGiustiService()
    {
        return $this->services['app.coreCatSubcatTypologyListAcquistiGiusti'] = new \AppBundle\Service\WidgetService\CoreCatSubcatTypologyListAcquistiGiusti(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreChatMessages' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreChatMessages
     */
    protected function getApp_CoreChatMessagesService()
    {
        return $this->services['app.coreChatMessages'] = new \AppBundle\Service\WidgetService\CoreChatMessages(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreComments' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreComments
     */
    protected function getApp_CoreCommentsService()
    {
        return $this->services['app.coreComments'] = new \AppBundle\Service\WidgetService\CoreComments(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreDetailArticle' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreDetailArticle
     */
    protected function getApp_CoreDetailArticleService()
    {
        return $this->services['app.coreDetailArticle'] = new \AppBundle\Service\WidgetService\CoreDetailArticle(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreDetailProduct' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreDetailProduct
     */
    protected function getApp_CoreDetailProductService()
    {
        return $this->services['app.coreDetailProduct'] = new \AppBundle\Service\WidgetService\CoreDetailProduct(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreDinamycPage' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreDinamycPage
     */
    protected function getApp_CoreDinamycPageService()
    {
        return $this->services['app.coreDinamycPage'] = new \AppBundle\Service\WidgetService\CoreDinamycPage(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreFiltersProducts' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreFiltersProducts
     */
    protected function getApp_CoreFiltersProductsService()
    {
        return $this->services['app.coreFiltersProducts'] = new \AppBundle\Service\WidgetService\CoreFiltersProducts(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreFollowUs' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreFollowUs
     */
    protected function getApp_CoreFollowUsService()
    {
        return $this->services['app.coreFollowUs'] = new \AppBundle\Service\WidgetService\CoreFollowUs(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreGetSearchTerms' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreGetSearchTerms
     */
    protected function getApp_CoreGetSearchTermsService()
    {
        return $this->services['app.coreGetSearchTerms'] = new \AppBundle\Service\WidgetService\CoreGetSearchTerms(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreHouse' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreHouse
     */
    protected function getApp_CoreHouseService()
    {
        return $this->services['app.coreHouse'] = new \AppBundle\Service\WidgetService\CoreHouse(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListModelsComparison' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListModelsComparison
     */
    protected function getApp_CoreListModelsComparisonService()
    {
        return $this->services['app.coreListModelsComparison'] = new \AppBundle\Service\WidgetService\CoreListModelsComparison(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListModelsTrademark' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListModelsTrademark
     */
    protected function getApp_CoreListModelsTrademarkService()
    {
        return $this->services['app.coreListModelsTrademark'] = new \AppBundle\Service\WidgetService\CoreListModelsTrademark(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListNews' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListNews
     */
    protected function getApp_CoreListNewsService()
    {
        return $this->services['app.coreListNews'] = new \AppBundle\Service\WidgetService\CoreListNews(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListNewsOP' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListNewsOP
     */
    protected function getApp_CoreListNewsOPService()
    {
        return $this->services['app.coreListNewsOP'] = new \AppBundle\Service\WidgetService\CoreListNewsOP(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListNews_Template' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListNews_Template
     */
    protected function getApp_CoreListNewsTemplateService()
    {
        return $this->services['app.coreListNews_Template'] = new \AppBundle\Service\WidgetService\CoreListNews_Template(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListPolls' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListPolls
     */
    protected function getApp_CoreListPollsService()
    {
        return $this->services['app.coreListPolls'] = new \AppBundle\Service\WidgetService\CoreListPolls(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListProducts' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListProducts
     */
    protected function getApp_CoreListProductsService()
    {
        return $this->services['app.coreListProducts'] = new \AppBundle\Service\WidgetService\CoreListProducts(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreListRelatedNews' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreListRelatedNews
     */
    protected function getApp_CoreListRelatedNewsService()
    {
        return $this->services['app.coreListRelatedNews'] = new \AppBundle\Service\WidgetService\CoreListRelatedNews(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreModelByIds' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreModelByIds
     */
    protected function getApp_CoreModelByIdsService()
    {
        return $this->services['app.coreModelByIds'] = new \AppBundle\Service\WidgetService\CoreModelByIds(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreModelsComparison' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreModelsComparison
     */
    protected function getApp_CoreModelsComparisonService()
    {
        return $this->services['app.coreModelsComparison'] = new \AppBundle\Service\WidgetService\CoreModelsComparison(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.corePageFunebri' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CorePageFunebri
     */
    protected function getApp_CorePageFunebriService()
    {
        return $this->services['app.corePageFunebri'] = new \AppBundle\Service\WidgetService\CorePageFunebri(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.corePoll' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CorePoll
     */
    protected function getApp_CorePollService()
    {
        return $this->services['app.corePoll'] = new \AppBundle\Service\WidgetService\CorePoll(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreProductSale' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreProductSale
     */
    protected function getApp_CoreProductSaleService()
    {
        return $this->services['app.coreProductSale'] = new \AppBundle\Service\WidgetService\CoreProductSale(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreReplaceWidgetAjax' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreReplaceWidgetAjax
     */
    protected function getApp_CoreReplaceWidgetAjaxService()
    {
        return $this->services['app.coreReplaceWidgetAjax'] = new \AppBundle\Service\WidgetService\CoreReplaceWidgetAjax(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreSaleModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreSaleModels
     */
    protected function getApp_CoreSaleModelsService()
    {
        return $this->services['app.coreSaleModels'] = new \AppBundle\Service\WidgetService\CoreSaleModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreSeoH1ListArticles' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreSeoH1ListArticles
     */
    protected function getApp_CoreSeoH1ListArticlesService()
    {
        return $this->services['app.coreSeoH1ListArticles'] = new \AppBundle\Service\WidgetService\CoreSeoH1ListArticles(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreSeoH1ListArticles_Template' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreSeoH1ListArticles_Template
     */
    protected function getApp_CoreSeoH1ListArticlesTemplateService()
    {
        return $this->services['app.coreSeoH1ListArticles_Template'] = new \AppBundle\Service\WidgetService\CoreSeoH1ListArticles_Template(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreSliders' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreSliders
     */
    protected function getApp_CoreSlidersService()
    {
        return $this->services['app.coreSliders'] = new \AppBundle\Service\WidgetService\CoreSliders(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreTopAffiliations' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreTopAffiliations
     */
    protected function getApp_CoreTopAffiliationsService()
    {
        return $this->services['app.coreTopAffiliations'] = new \AppBundle\Service\WidgetService\CoreTopAffiliations(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreTopNews' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreTopNews
     */
    protected function getApp_CoreTopNewsService()
    {
        return $this->services['app.coreTopNews'] = new \AppBundle\Service\WidgetService\CoreTopNews(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreTopOrRelatedModels' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreTopOrRelatedModels
     */
    protected function getApp_CoreTopOrRelatedModelsService()
    {
        return $this->services['app.coreTopOrRelatedModels'] = new \AppBundle\Service\WidgetService\CoreTopOrRelatedModels(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreTopTrademarks' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreTopTrademarks
     */
    protected function getApp_CoreTopTrademarksService()
    {
        return $this->services['app.coreTopTrademarks'] = new \AppBundle\Service\WidgetService\CoreTopTrademarks(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreTreading' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreTreading
     */
    protected function getApp_CoreTreadingService()
    {
        return $this->services['app.coreTreading'] = new \AppBundle\Service\WidgetService\CoreTreading(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreWidgetmenu' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreWidgetMenu
     */
    protected function getApp_CoreWidgetmenuService()
    {
        return $this->services['app.coreWidgetmenu'] = new \AppBundle\Service\WidgetService\CoreWidgetMenu(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.coreprova' shared service.
     *
     * @return \AppBundle\Service\WidgetService\CoreProva
     */
    protected function getApp_CoreprovaService()
    {
        return $this->services['app.coreprova'] = new \AppBundle\Service\WidgetService\CoreProva(${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.deamonAffiliation' shared service.
     *
     * @return \AppBundle\Service\AffiliationService\DeamonAffiliation
     */
    protected function getApp_DeamonAffiliationService()
    {
        return $this->services['app.deamonAffiliation'] = new \AppBundle\Service\AffiliationService\DeamonAffiliation(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.dependencyManager' shared service.
     *
     * @return \AppBundle\Service\DependencyService\DependencyManager
     */
    protected function getApp_DependencyManagerService()
    {
        return $this->services['app.dependencyManager'] = new \AppBundle\Service\DependencyService\DependencyManager(array('commonPath' => '/php/assets/', 'extensionsJsPath' => '/js/', 'commonCSSPath' => '/php/assets/', 'extensionCssPath' => '/css/template/', 'extensionsJsAdminPath' => '/js/admin', 'extensionsTemplates' => '/templates/', 'catalogsPath' => '/home/prod/catalogs/'), ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.dependencyManagerAdmin' shared service.
     *
     * @return \AppBundle\Service\DependencyService\DependencyManagerAdmin
     */
    protected function getApp_DependencyManagerAdminService()
    {
        return $this->services['app.dependencyManagerAdmin'] = new \AppBundle\Service\DependencyService\DependencyManagerAdmin(array('commonPath' => '/php/assets/', 'extensionsJsPath' => '/js/', 'commonCSSPath' => '/php/assets/', 'extensionCssPath' => '/css/template/', 'extensionsJsAdminPath' => '/js/admin', 'extensionsTemplates' => '/templates/', 'catalogsPath' => '/home/prod/catalogs/'), ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.dependencyManagerCalciomercato' shared service.
     *
     * @return \AppBundle\Service\DependencyService\DependencyManagerCalciomercato
     */
    protected function getApp_DependencyManagerCalciomercatoService()
    {
        return $this->services['app.dependencyManagerCalciomercato'] = new \AppBundle\Service\DependencyService\DependencyManagerCalciomercato(array('commonPath' => '/php/assets/', 'extensionsJsPath' => '/js/', 'commonCSSPath' => '/php/assets/', 'extensionCssPath' => '/css/template/', 'extensionsJsAdminPath' => '/js/admin', 'extensionsTemplates' => '/templates/', 'catalogsPath' => '/home/prod/catalogs/'), ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.dependencyManagerTemplate' shared service.
     *
     * @return \AppBundle\Service\DependencyService\DependencyManagerTemplate
     */
    protected function getApp_DependencyManagerTemplateService()
    {
        return $this->services['app.dependencyManagerTemplate'] = new \AppBundle\Service\DependencyService\DependencyManagerTemplate(array('commonPath' => '/php/assets/', 'extensionsJsPath' => '/js/', 'commonCSSPath' => '/php/assets/', 'extensionCssPath' => '/css/template/', 'extensionsJsAdminPath' => '/js/admin', 'extensionsTemplates' => '/templates/', 'catalogsPath' => '/home/prod/catalogs/'), ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.dictionaryUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\DictionaryUtility
     */
    protected function getApp_DictionaryUtilityService()
    {
        return $this->services['app.dictionaryUtility'] = new \AppBundle\Service\UtilityService\DictionaryUtility($this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.cacheUtility']) ? $this->services['app.cacheUtility'] : $this->get('app.cacheUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.ebayApi' shared service.
     *
     * @return \AppBundle\Service\EbayService\EbayApi
     */
    protected function getApp_EbayApiService()
    {
        return $this->services['app.ebayApi'] = new \AppBundle\Service\EbayService\EbayApi(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.fileUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\FileUtility
     */
    protected function getApp_FileUtilityService()
    {
        return $this->services['app.fileUtility'] = new \AppBundle\Service\UtilityService\FileUtility($this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.formManager' shared service.
     *
     * @return \AppBundle\Service\FormService\FormManager
     */
    protected function getApp_FormManagerService()
    {
        return $this->services['app.formManager'] = new \AppBundle\Service\FormService\FormManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'app.globalConfigManager' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\GlobalConfigManager
     */
    protected function getApp_GlobalConfigManagerService()
    {
        return $this->services['app.globalConfigManager'] = new \AppBundle\Service\GlobalConfigService\GlobalConfigManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.cacheUtility']) ? $this->services['app.cacheUtility'] : $this->get('app.cacheUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.globalQueryUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\GlobalQueryUtility
     */
    protected function getApp_GlobalQueryUtilityService()
    {
        return $this->services['app.globalQueryUtility'] = new \AppBundle\Service\UtilityService\GlobalQueryUtility($this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.cacheUtility']) ? $this->services['app.cacheUtility'] : $this->get('app.cacheUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.globalTwigExtension' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\GlobalTwigExtension
     */
    protected function getApp_GlobalTwigExtensionService()
    {
        return $this->services['app.globalTwigExtension'] = new \AppBundle\Service\GlobalConfigService\GlobalTwigExtension(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['app.routerManager']) ? $this->services['app.routerManager'] : $this->get('app.routerManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.globalUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\GlobalUtility
     */
    protected function getApp_GlobalUtilityService()
    {
        return $this->services['app.globalUtility'] = new \AppBundle\Service\UtilityService\GlobalUtility(${($_ = isset($this->services['app.browserUtility']) ? $this->services['app.browserUtility'] : $this->get('app.browserUtility')) && false ?: '_'}, ${($_ = isset($this->services['app.cacheUtility']) ? $this->services['app.cacheUtility'] : $this->get('app.cacheUtility')) && false ?: '_'}, ${($_ = isset($this->services['app.imageUtility']) ? $this->services['app.imageUtility'] : $this->get('app.imageUtility')) && false ?: '_'}, ${($_ = isset($this->services['app.fileUtility']) ? $this->services['app.fileUtility'] : $this->get('app.fileUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.imageUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\ImageUtility
     */
    protected function getApp_ImageUtilityService()
    {
        return $this->services['app.imageUtility'] = new \AppBundle\Service\UtilityService\ImageUtility($this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.manageArticle' shared service.
     *
     * @return \AppBundle\Service\MaintenanceService\ManageArticle
     */
    protected function getApp_ManageArticleService()
    {
        return $this->services['app.manageArticle'] = new \AppBundle\Service\MaintenanceService\ManageArticle(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.manageDb' shared service.
     *
     * @return \AppBundle\Service\MaintenanceService\ManageDb
     */
    protected function getApp_ManageDbService()
    {
        return $this->services['app.manageDb'] = new \AppBundle\Service\MaintenanceService\ManageDb(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.paginationUtility' shared service.
     *
     * @return \AppBundle\Service\UtilityService\PaginationUtility
     */
    protected function getApp_PaginationUtilityService()
    {
        return $this->services['app.paginationUtility'] = new \AppBundle\Service\UtilityService\PaginationUtility($this, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, ${($_ = isset($this->services['app.widgetManager']) ? $this->services['app.widgetManager'] : $this->get('app.widgetManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.queryUtilityManager' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\queryUtilityManager
     */
    protected function getApp_QueryUtilityManagerService()
    {
        return $this->services['app.queryUtilityManager'] = new \AppBundle\Service\GlobalConfigService\queryUtilityManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.cacheUtility']) ? $this->services['app.cacheUtility'] : $this->get('app.cacheUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.redirectService' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\RedirectService
     */
    protected function getApp_RedirectServiceService()
    {
        return $this->services['app.redirectService'] = new \AppBundle\Service\GlobalConfigService\RedirectService(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.removeTopNewsImg' shared service.
     *
     * @return \AppBundle\Service\MaintenanceService\RemoveTopNewsImg
     */
    protected function getApp_RemoveTopNewsImgService()
    {
        return $this->services['app.removeTopNewsImg'] = new \AppBundle\Service\MaintenanceService\RemoveTopNewsImg(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'app.routerManager' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\RouterManager
     */
    protected function getApp_RouterManagerService()
    {
        return $this->services['app.routerManager'] = new \AppBundle\Service\GlobalConfigService\RouterManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'app.seoConfigManager' shared service.
     *
     * @return \AppBundle\Service\GlobalConfigService\SeoConfigManager
     */
    protected function getApp_SeoConfigManagerService()
    {
        return $this->services['app.seoConfigManager'] = new \AppBundle\Service\GlobalConfigService\SeoConfigManager(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'app.sitemap' shared service.
     *
     * @return \AppBundle\Service\SitemapService\Sitemap
     */
    protected function getApp_SitemapService()
    {
        return $this->services['app.sitemap'] = new \AppBundle\Service\SitemapService\Sitemap(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.spiderAmazon' shared service.
     *
     * @return \AppBundle\Service\SpiderService\SpiderAmazon
     */
    protected function getApp_SpiderAmazonService()
    {
        return $this->services['app.spiderAmazon'] = new \AppBundle\Service\SpiderService\SpiderAmazon(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.spiderEbay' shared service.
     *
     * @return \AppBundle\Service\SpiderService\SpiderEbay
     */
    protected function getApp_SpiderEbayService()
    {
        return $this->services['app.spiderEbay'] = new \AppBundle\Service\SpiderService\SpiderEbay(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.spiderIdealo' shared service.
     *
     * @return \AppBundle\Service\SpiderService\SpiderIdealo
     */
    protected function getApp_SpiderIdealoService()
    {
        return $this->services['app.spiderIdealo'] = new \AppBundle\Service\SpiderService\SpiderIdealo(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.spiderPagomeno' shared service.
     *
     * @return \AppBundle\Service\SpiderService\SpiderPagomeno
     */
    protected function getApp_SpiderPagomenoService()
    {
        return $this->services['app.spiderPagomeno'] = new \AppBundle\Service\SpiderService\SpiderPagomeno(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.spiderTrovaprezzi' shared service.
     *
     * @return \AppBundle\Service\SpiderService\SpiderTrovaprezzi
     */
    protected function getApp_SpiderTrovaprezziService()
    {
        return $this->services['app.spiderTrovaprezzi'] = new \AppBundle\Service\SpiderService\SpiderTrovaprezzi(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.userManager' shared service.
     *
     * @return \AppBundle\Service\UserUtility\UserManager
     */
    protected function getApp_UserManagerService()
    {
        return $this->services['app.userManager'] = new \AppBundle\Service\UserUtility\UserManager(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'app.web365ManagerRepository' shared service.
     *
     * @return \AppBundle\Repository\Web365ManagerRepository
     */
    protected function getApp_Web365ManagerRepositoryService()
    {
        $this->services['app.web365ManagerRepository'] = $instance = new \AppBundle\Repository\Web365ManagerRepository(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});

        $instance->setCacheUtility(false);

        return $instance;
    }

    /**
     * Gets the public 'app.widgetManager' shared service.
     *
     * @return \AppBundle\Service\WidgetService\WidgetManager
     */
    protected function getApp_WidgetManagerService()
    {
        return $this->services['app.widgetManager'] = new \AppBundle\Service\WidgetService\WidgetManager(${($_ = isset($this->services['app.routerManager']) ? $this->services['app.routerManager'] : $this->get('app.routerManager')) && false ?: '_'}, ${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'}, $this, ${($_ = isset($this->services['app.formManager']) ? $this->services['app.formManager'] : $this->get('app.formManager')) && false ?: '_'}, ${($_ = isset($this->services['app.userManager']) ? $this->services['app.userManager'] : $this->get('app.userManager')) && false ?: '_'}, ${($_ = isset($this->services['app.globalConfigManager']) ? $this->services['app.globalConfigManager'] : $this->get('app.globalConfigManager')) && false ?: '_'});
    }

    /**
     * Gets the public 'app.wordpressImportDb' shared service.
     *
     * @return \AppBundle\Service\WordpressService\ImportDb
     */
    protected function getApp_WordpressImportDbService()
    {
        return $this->services['app.wordpressImportDb'] = new \AppBundle\Service\WordpressService\ImportDb(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, $this, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'assets.context' shared service.
     *
     * @return \Symfony\Component\Asset\Context\RequestStackContext
     */
    protected function getAssets_ContextService()
    {
        return $this->services['assets.context'] = new \Symfony\Component\Asset\Context\RequestStackContext(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'});
    }

    /**
     * Gets the public 'assets.packages' shared service.
     *
     * @return \Symfony\Component\Asset\Packages
     */
    protected function getAssets_PackagesService()
    {
        return $this->services['assets.packages'] = new \Symfony\Component\Asset\Packages(new \Symfony\Component\Asset\PathPackage('', new \Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy(), ${($_ = isset($this->services['assets.context']) ? $this->services['assets.context'] : $this->get('assets.context')) && false ?: '_'}), array());
    }

    /**
     * Gets the public 'cache.app' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_AppService()
    {
        return $this->services['cache.app'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(${($_ = isset($this->services['cache.app.recorder_inner']) ? $this->services['cache.app.recorder_inner'] : $this->getCache_App_RecorderInnerService()) && false ?: '_'});
    }

    /**
     * Gets the public 'cache.default_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer
     */
    protected function getCache_DefaultClearerService()
    {
        return $this->services['cache.default_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer(array('cache.app' => ${($_ = isset($this->services['cache.app']) ? $this->services['cache.app'] : $this->get('cache.app')) && false ?: '_'}, 'cache.system' => ${($_ = isset($this->services['cache.system']) ? $this->services['cache.system'] : $this->get('cache.system')) && false ?: '_'}, 'cache.validator' => ${($_ = isset($this->services['cache.validator']) ? $this->services['cache.validator'] : $this->getCache_ValidatorService()) && false ?: '_'}, 'cache.annotations' => ${($_ = isset($this->services['cache.annotations']) ? $this->services['cache.annotations'] : $this->getCache_AnnotationsService()) && false ?: '_'}));
    }

    /**
     * Gets the public 'cache.global_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer
     */
    protected function getCache_GlobalClearerService()
    {
        return $this->services['cache.global_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer(array('cache.app' => ${($_ = isset($this->services['cache.app']) ? $this->services['cache.app'] : $this->get('cache.app')) && false ?: '_'}, 'cache.system' => ${($_ = isset($this->services['cache.system']) ? $this->services['cache.system'] : $this->get('cache.system')) && false ?: '_'}, 'cache.validator' => ${($_ = isset($this->services['cache.validator']) ? $this->services['cache.validator'] : $this->getCache_ValidatorService()) && false ?: '_'}, 'cache.annotations' => ${($_ = isset($this->services['cache.annotations']) ? $this->services['cache.annotations'] : $this->getCache_AnnotationsService()) && false ?: '_'}));
    }

    /**
     * Gets the public 'cache.system' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_SystemService()
    {
        return $this->services['cache.system'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(${($_ = isset($this->services['cache.system.recorder_inner']) ? $this->services['cache.system.recorder_inner'] : $this->getCache_System_RecorderInnerService()) && false ?: '_'});
    }

    /**
     * Gets the public 'cache_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer
     */
    protected function getCacheClearerService()
    {
        return $this->services['cache_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer(array(0 => ${($_ = isset($this->services['cache.default_clearer']) ? $this->services['cache.default_clearer'] : $this->get('cache.default_clearer')) && false ?: '_'}));
    }

    /**
     * Gets the public 'cache_warmer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerAggregate
     */
    protected function getCacheWarmerService()
    {
        $a = ${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel')) && false ?: '_'};
        $b = ${($_ = isset($this->services['templating.filename_parser']) ? $this->services['templating.filename_parser'] : $this->get('templating.filename_parser')) && false ?: '_'};

        $c = new \Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinder($a, $b, ($this->targetDirs[3].'/app/Resources'));

        return $this->services['cache_warmer'] = new \Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerAggregate(array(0 => new \Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplatePathsCacheWarmer($c, ${($_ = isset($this->services['templating.locator']) ? $this->services['templating.locator'] : $this->getTemplating_LocatorService()) && false ?: '_'}), 1 => new \Symfony\Bundle\FrameworkBundle\CacheWarmer\ValidatorCacheWarmer(${($_ = isset($this->services['validator.builder']) ? $this->services['validator.builder'] : $this->get('validator.builder')) && false ?: '_'}, (__DIR__.'/validation.php'), ${($_ = isset($this->services['cache.validator']) ? $this->services['cache.validator'] : $this->getCache_ValidatorService()) && false ?: '_'}), 2 => new \Symfony\Bundle\FrameworkBundle\CacheWarmer\TranslationsCacheWarmer(${($_ = isset($this->services['translator.default']) ? $this->services['translator.default'] : $this->get('translator.default')) && false ?: '_'}), 3 => new \Symfony\Bundle\FrameworkBundle\CacheWarmer\RouterCacheWarmer(${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router')) && false ?: '_'}), 4 => new \Symfony\Bundle\FrameworkBundle\CacheWarmer\AnnotationsCacheWarmer(${($_ = isset($this->services['annotations.reader']) ? $this->services['annotations.reader'] : $this->getAnnotations_ReaderService()) && false ?: '_'}, (__DIR__.'/annotations.php'), ${($_ = isset($this->services['cache.annotations']) ? $this->services['cache.annotations'] : $this->getCache_AnnotationsService()) && false ?: '_'}), 5 => new \Symfony\Bundle\TwigBundle\CacheWarmer\TemplateCacheCacheWarmer(new \Symfony\Component\DependencyInjection\ServiceLocator(array('twig' => function () {
            $f = function (\Twig\Environment $v) { return $v; }; return $f(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'});
        })), $c, array(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form') => NULL)), 6 => new \Symfony\Bundle\TwigBundle\CacheWarmer\TemplateCacheWarmer($this, new \Symfony\Bundle\TwigBundle\TemplateIterator($a, ($this->targetDirs[3].'/app'), array(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form') => NULL))), 7 => new \Symfony\Bridge\Doctrine\CacheWarmer\ProxyCacheWarmer(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'})));
    }

    /**
     * Gets the public 'config_cache_factory' shared service.
     *
     * @return \Symfony\Component\Config\ResourceCheckerConfigCacheFactory
     */
    protected function getConfigCacheFactoryService()
    {
        return $this->services['config_cache_factory'] = new \Symfony\Component\Config\ResourceCheckerConfigCacheFactory(new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a']) ? $this->services['1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a'] : $this->get1Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService()) && false ?: '_'};
            yield 1 => ${($_ = isset($this->services['2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a']) ? $this->services['2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a'] : $this->get2Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService()) && false ?: '_'};
        }, 2));
    }

    /**
     * Gets the public 'console.command.symfony_bundle_securitybundle_command_userpasswordencodercommand' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Command\UserPasswordEncoderCommand
     */
    protected function getConsole_Command_SymfonyBundleSecuritybundleCommandUserpasswordencodercommandService()
    {
        return $this->services['console.command.symfony_bundle_securitybundle_command_userpasswordencodercommand'] = new \Symfony\Bundle\SecurityBundle\Command\UserPasswordEncoderCommand(${($_ = isset($this->services['security.encoder_factory']) ? $this->services['security.encoder_factory'] : $this->get('security.encoder_factory')) && false ?: '_'}, array());
    }

    /**
     * Gets the public 'data_collector.dump' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\DumpDataCollector
     */
    protected function getDataCollector_DumpService()
    {
        return $this->services['data_collector.dump'] = new \Symfony\Component\HttpKernel\DataCollector\DumpDataCollector(${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['debug.file_link_formatter']) ? $this->services['debug.file_link_formatter'] : $this->getDebug_FileLinkFormatterService()) && false ?: '_'}, 'UTF-8', NULL, NULL);
    }

    /**
     * Gets the public 'data_collector.form' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\FormDataCollector
     */
    protected function getDataCollector_FormService()
    {
        return $this->services['data_collector.form'] = new \Symfony\Component\Form\Extension\DataCollector\FormDataCollector(${($_ = isset($this->services['data_collector.form.extractor']) ? $this->services['data_collector.form.extractor'] : $this->get('data_collector.form.extractor')) && false ?: '_'});
    }

    /**
     * Gets the public 'data_collector.form.extractor' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\FormDataExtractor
     */
    protected function getDataCollector_Form_ExtractorService()
    {
        return $this->services['data_collector.form.extractor'] = new \Symfony\Component\Form\Extension\DataCollector\FormDataExtractor();
    }

    /**
     * Gets the public 'data_collector.request' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\DataCollector\RequestDataCollector
     */
    protected function getDataCollector_RequestService()
    {
        return $this->services['data_collector.request'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RequestDataCollector();
    }

    /**
     * Gets the public 'data_collector.router' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector
     */
    protected function getDataCollector_RouterService()
    {
        return $this->services['data_collector.router'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector();
    }

    /**
     * Gets the public 'data_collector.translation' shared service.
     *
     * @return \Symfony\Component\Translation\DataCollector\TranslationDataCollector
     */
    protected function getDataCollector_TranslationService()
    {
        return $this->services['data_collector.translation'] = new \Symfony\Component\Translation\DataCollector\TranslationDataCollector(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'});
    }

    /**
     * Gets the public 'debug.argument_resolver' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\TraceableArgumentResolver
     */
    protected function getDebug_ArgumentResolverService()
    {
        return $this->services['debug.argument_resolver'] = new \Symfony\Component\HttpKernel\Controller\TraceableArgumentResolver(new \Symfony\Component\HttpKernel\Controller\ArgumentResolver(new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory(), new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['argument_resolver.request_attribute']) ? $this->services['argument_resolver.request_attribute'] : $this->getArgumentResolver_RequestAttributeService()) && false ?: '_'};
            yield 1 => ${($_ = isset($this->services['argument_resolver.request']) ? $this->services['argument_resolver.request'] : $this->getArgumentResolver_RequestService()) && false ?: '_'};
            yield 2 => ${($_ = isset($this->services['argument_resolver.session']) ? $this->services['argument_resolver.session'] : $this->getArgumentResolver_SessionService()) && false ?: '_'};
            yield 3 => ${($_ = isset($this->services['security.user_value_resolver']) ? $this->services['security.user_value_resolver'] : $this->getSecurity_UserValueResolverService()) && false ?: '_'};
            yield 4 => ${($_ = isset($this->services['argument_resolver.service']) ? $this->services['argument_resolver.service'] : $this->getArgumentResolver_ServiceService()) && false ?: '_'};
            yield 5 => ${($_ = isset($this->services['argument_resolver.default']) ? $this->services['argument_resolver.default'] : $this->getArgumentResolver_DefaultService()) && false ?: '_'};
            yield 6 => ${($_ = isset($this->services['argument_resolver.variadic']) ? $this->services['argument_resolver.variadic'] : $this->getArgumentResolver_VariadicService()) && false ?: '_'};
        }, 7)), ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch')) && false ?: '_'});
    }

    /**
     * Gets the public 'debug.controller_resolver' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\TraceableControllerResolver
     */
    protected function getDebug_ControllerResolverService()
    {
        return $this->services['debug.controller_resolver'] = new \Symfony\Component\HttpKernel\Controller\TraceableControllerResolver(new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, ${($_ = isset($this->services['controller_name_converter']) ? $this->services['controller_name_converter'] : $this->getControllerNameConverterService()) && false ?: '_'}, ${($_ = isset($this->services['monolog.logger.request']) ? $this->services['monolog.logger.request'] : $this->get('monolog.logger.request', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}), ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch')) && false ?: '_'}, ${($_ = isset($this->services['debug.argument_resolver']) ? $this->services['debug.argument_resolver'] : $this->get('debug.argument_resolver')) && false ?: '_'});
    }

    /**
     * Gets the public 'debug.debug_handlers_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener
     */
    protected function getDebug_DebugHandlersListenerService()
    {
        return $this->services['debug.debug_handlers_listener'] = new \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener(NULL, ${($_ = isset($this->services['monolog.logger.php']) ? $this->services['monolog.logger.php'] : $this->get('monolog.logger.php', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, -1, -1, true, ${($_ = isset($this->services['debug.file_link_formatter']) ? $this->services['debug.file_link_formatter'] : $this->getDebug_FileLinkFormatterService()) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'debug.dump_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DumpListener
     */
    protected function getDebug_DumpListenerService()
    {
        return $this->services['debug.dump_listener'] = new \Symfony\Component\HttpKernel\EventListener\DumpListener(${($_ = isset($this->services['var_dumper.cloner']) ? $this->services['var_dumper.cloner'] : $this->get('var_dumper.cloner')) && false ?: '_'}, ${($_ = isset($this->services['var_dumper.cli_dumper']) ? $this->services['var_dumper.cli_dumper'] : $this->get('var_dumper.cli_dumper')) && false ?: '_'});
    }

    /**
     * Gets the public 'debug.event_dispatcher' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher
     */
    protected function getDebug_EventDispatcherService()
    {
        $this->services['debug.event_dispatcher'] = $instance = new \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher(new \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher($this), ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch')) && false ?: '_'}, ${($_ = isset($this->services['monolog.logger.event']) ? $this->services['monolog.logger.event'] : $this->get('monolog.logger.event', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});

        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['data_collector.router']) ? $this->services['data_collector.router'] : $this->get('data_collector.router')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['mobile_detect.request_listener']) ? $this->services['mobile_detect.request_listener'] : $this->get('mobile_detect.request_listener')) && false ?: '_'};
        }, 1 => 'handleRequest'), 1);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['mobile_detect.request_listener']) ? $this->services['mobile_detect.request_listener'] : $this->get('mobile_detect.request_listener')) && false ?: '_'};
        }, 1 => 'handleResponse'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['response_listener']) ? $this->services['response_listener'] : $this->get('response_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['streamed_response_listener']) ? $this->services['streamed_response_listener'] : $this->get('streamed_response_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), -1024);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['locale_listener']) ? $this->services['locale_listener'] : $this->get('locale_listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 16);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ${($_ = isset($this->services['locale_listener']) ? $this->services['locale_listener'] : $this->get('locale_listener')) && false ?: '_'};
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['validate_request_listener']) ? $this->services['validate_request_listener'] : $this->get('validate_request_listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 256);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['resolve_controller_name_subscriber']) ? $this->services['resolve_controller_name_subscriber'] : $this->getResolveControllerNameSubscriberService()) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 24);
        $instance->addListener('console.error', array(0 => function () {
            return ${($_ = isset($this->services['console.error_listener']) ? $this->services['console.error_listener'] : $this->getConsole_ErrorListenerService()) && false ?: '_'};
        }, 1 => 'onConsoleError'), -128);
        $instance->addListener('console.terminate', array(0 => function () {
            return ${($_ = isset($this->services['console.error_listener']) ? $this->services['console.error_listener'] : $this->getConsole_ErrorListenerService()) && false ?: '_'};
        }, 1 => 'onConsoleTerminate'), -128);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['session_listener']) ? $this->services['session_listener'] : $this->get('session_listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 128);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['session.save_listener']) ? $this->services['session.save_listener'] : $this->get('session.save_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), -1000);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['esi_listener']) ? $this->services['esi_listener'] : $this->get('esi_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['fragment.listener']) ? $this->services['fragment.listener'] : $this->get('fragment.listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 48);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['translator_listener']) ? $this->services['translator_listener'] : $this->get('translator_listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 10);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ${($_ = isset($this->services['translator_listener']) ? $this->services['translator_listener'] : $this->get('translator_listener')) && false ?: '_'};
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['profiler_listener']) ? $this->services['profiler_listener'] : $this->get('profiler_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), -100);
        $instance->addListener('kernel.exception', array(0 => function () {
            return ${($_ = isset($this->services['profiler_listener']) ? $this->services['profiler_listener'] : $this->get('profiler_listener')) && false ?: '_'};
        }, 1 => 'onKernelException'), 0);
        $instance->addListener('kernel.terminate', array(0 => function () {
            return ${($_ = isset($this->services['profiler_listener']) ? $this->services['profiler_listener'] : $this->get('profiler_listener')) && false ?: '_'};
        }, 1 => 'onKernelTerminate'), -1024);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['data_collector.request']) ? $this->services['data_collector.request'] : $this->get('data_collector.request')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['data_collector.request']) ? $this->services['data_collector.request'] : $this->get('data_collector.request')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['debug.debug_handlers_listener']) ? $this->services['debug.debug_handlers_listener'] : $this->get('debug.debug_handlers_listener')) && false ?: '_'};
        }, 1 => 'configure'), 2048);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['router_listener']) ? $this->services['router_listener'] : $this->get('router_listener')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 32);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ${($_ = isset($this->services['router_listener']) ? $this->services['router_listener'] : $this->get('router_listener')) && false ?: '_'};
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ${($_ = isset($this->services['security.firewall']) ? $this->services['security.firewall'] : $this->get('security.firewall')) && false ?: '_'};
        }, 1 => 'onKernelRequest'), 8);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ${($_ = isset($this->services['security.firewall']) ? $this->services['security.firewall'] : $this->get('security.firewall')) && false ?: '_'};
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['security.rememberme.response_listener']) ? $this->services['security.rememberme.response_listener'] : $this->get('security.rememberme.response_listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.exception', array(0 => function () {
            return ${($_ = isset($this->services['twig.exception_listener']) ? $this->services['twig.exception_listener'] : $this->get('twig.exception_listener')) && false ?: '_'};
        }, 1 => 'onKernelException'), -128);
        $instance->addListener('console.command', array(0 => function () {
            return ${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'};
        }, 1 => 'onCommand'), 255);
        $instance->addListener('console.terminate', array(0 => function () {
            return ${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'};
        }, 1 => 'onTerminate'), -255);
        $instance->addListener('console.command', array(0 => function () {
            return ${($_ = isset($this->services['monolog.handler.console_very_verbose']) ? $this->services['monolog.handler.console_very_verbose'] : $this->get('monolog.handler.console_very_verbose')) && false ?: '_'};
        }, 1 => 'onCommand'), 255);
        $instance->addListener('console.terminate', array(0 => function () {
            return ${($_ = isset($this->services['monolog.handler.console_very_verbose']) ? $this->services['monolog.handler.console_very_verbose'] : $this->get('monolog.handler.console_very_verbose')) && false ?: '_'};
        }, 1 => 'onTerminate'), -255);
        $instance->addListener('kernel.exception', array(0 => function () {
            return ${($_ = isset($this->services['swiftmailer.email_sender.listener']) ? $this->services['swiftmailer.email_sender.listener'] : $this->get('swiftmailer.email_sender.listener')) && false ?: '_'};
        }, 1 => 'onException'), 0);
        $instance->addListener('kernel.terminate', array(0 => function () {
            return ${($_ = isset($this->services['swiftmailer.email_sender.listener']) ? $this->services['swiftmailer.email_sender.listener'] : $this->get('swiftmailer.email_sender.listener')) && false ?: '_'};
        }, 1 => 'onTerminate'), 0);
        $instance->addListener('console.error', array(0 => function () {
            return ${($_ = isset($this->services['swiftmailer.email_sender.listener']) ? $this->services['swiftmailer.email_sender.listener'] : $this->get('swiftmailer.email_sender.listener')) && false ?: '_'};
        }, 1 => 'onException'), 0);
        $instance->addListener('console.terminate', array(0 => function () {
            return ${($_ = isset($this->services['swiftmailer.email_sender.listener']) ? $this->services['swiftmailer.email_sender.listener'] : $this->get('swiftmailer.email_sender.listener')) && false ?: '_'};
        }, 1 => 'onTerminate'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.controller.listener']) ? $this->services['sensio_framework_extra.controller.listener'] : $this->get('sensio_framework_extra.controller.listener')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.converter.listener']) ? $this->services['sensio_framework_extra.converter.listener'] : $this->get('sensio_framework_extra.converter.listener')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.view.listener']) ? $this->services['sensio_framework_extra.view.listener'] : $this->get('sensio_framework_extra.view.listener')) && false ?: '_'};
        }, 1 => 'onKernelController'), -128);
        $instance->addListener('kernel.view', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.view.listener']) ? $this->services['sensio_framework_extra.view.listener'] : $this->get('sensio_framework_extra.view.listener')) && false ?: '_'};
        }, 1 => 'onKernelView'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.cache.listener']) ? $this->services['sensio_framework_extra.cache.listener'] : $this->get('sensio_framework_extra.cache.listener')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.cache.listener']) ? $this->services['sensio_framework_extra.cache.listener'] : $this->get('sensio_framework_extra.cache.listener')) && false ?: '_'};
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ${($_ = isset($this->services['sensio_framework_extra.security.listener']) ? $this->services['sensio_framework_extra.security.listener'] : $this->get('sensio_framework_extra.security.listener')) && false ?: '_'};
        }, 1 => 'onKernelController'), 0);
        $instance->addListener('elastica.pager_persister.pre_insert_objects', array(0 => function () {
            return ${($_ = isset($this->services['fos_elastica.filter_objects_listener']) ? $this->services['fos_elastica.filter_objects_listener'] : $this->get('fos_elastica.filter_objects_listener')) && false ?: '_'};
        }, 1 => 'filterObjects'), 0);
        $instance->addListener('console.command', array(0 => function () {
            return ${($_ = isset($this->services['debug.dump_listener']) ? $this->services['debug.dump_listener'] : $this->get('debug.dump_listener')) && false ?: '_'};
        }, 1 => 'configure'), 1024);

        return $instance;
    }

    /**
     * Gets the public 'debug.stopwatch' shared service.
     *
     * @return \Symfony\Component\Stopwatch\Stopwatch
     */
    protected function getDebug_StopwatchService()
    {
        return $this->services['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch();
    }

    /**
     * Gets the public 'deprecated.form.registry' shared service.
     *
     * @return \stdClass
     *
     * @deprecated The service "deprecated.form.registry" is internal and deprecated since Symfony 3.3 and will be removed in Symfony 4.0
     */
    protected function getDeprecated_Form_RegistryService()
    {
        @trigger_error('The service "deprecated.form.registry" is internal and deprecated since Symfony 3.3 and will be removed in Symfony 4.0', E_USER_DEPRECATED);

        $this->services['deprecated.form.registry'] = $instance = new \stdClass();

        $instance->registry = array(0 => ${($_ = isset($this->services['form.type_guesser.validator']) ? $this->services['form.type_guesser.validator'] : $this->getForm_TypeGuesser_ValidatorService()) && false ?: '_'}, 1 => ${($_ = isset($this->services['form.type.choice']) ? $this->services['form.type.choice'] : $this->getForm_Type_ChoiceService()) && false ?: '_'}, 2 => ${($_ = isset($this->services['form.type.form']) ? $this->services['form.type.form'] : $this->getForm_Type_FormService()) && false ?: '_'}, 3 => ${($_ = isset($this->services['form.type_extension.form.http_foundation']) ? $this->services['form.type_extension.form.http_foundation'] : $this->getForm_TypeExtension_Form_HttpFoundationService()) && false ?: '_'}, 4 => ${($_ = isset($this->services['form.type_extension.form.validator']) ? $this->services['form.type_extension.form.validator'] : $this->getForm_TypeExtension_Form_ValidatorService()) && false ?: '_'}, 5 => ${($_ = isset($this->services['form.type_extension.repeated.validator']) ? $this->services['form.type_extension.repeated.validator'] : $this->getForm_TypeExtension_Repeated_ValidatorService()) && false ?: '_'}, 6 => ${($_ = isset($this->services['form.type_extension.submit.validator']) ? $this->services['form.type_extension.submit.validator'] : $this->getForm_TypeExtension_Submit_ValidatorService()) && false ?: '_'}, 7 => ${($_ = isset($this->services['form.type_extension.upload.validator']) ? $this->services['form.type_extension.upload.validator'] : $this->getForm_TypeExtension_Upload_ValidatorService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'deprecated.form.registry.csrf' shared service.
     *
     * @return \stdClass
     *
     * @deprecated The service "deprecated.form.registry.csrf" is internal and deprecated since Symfony 3.3 and will be removed in Symfony 4.0
     */
    protected function getDeprecated_Form_Registry_CsrfService()
    {
        @trigger_error('The service "deprecated.form.registry.csrf" is internal and deprecated since Symfony 3.3 and will be removed in Symfony 4.0', E_USER_DEPRECATED);

        $this->services['deprecated.form.registry.csrf'] = $instance = new \stdClass();

        $instance->registry = array(0 => ${($_ = isset($this->services['form.type_extension.csrf']) ? $this->services['form.type_extension.csrf'] : $this->getForm_TypeExtension_CsrfService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'doctrine' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrineService()
    {
        return $this->services['doctrine'] = new \Doctrine\Bundle\DoctrineBundle\Registry($this, array('default' => 'doctrine.dbal.default_connection'), array('default' => 'doctrine.orm.default_entity_manager'), 'default', 'default');
    }

    /**
     * Gets the public 'doctrine.cache_clear_metadata_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearMetadataCacheDoctrineCommand
     */
    protected function getDoctrine_CacheClearMetadataCommandService()
    {
        return $this->services['doctrine.cache_clear_metadata_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearMetadataCacheDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.cache_clear_query_cache_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearQueryCacheDoctrineCommand
     */
    protected function getDoctrine_CacheClearQueryCacheCommandService()
    {
        return $this->services['doctrine.cache_clear_query_cache_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearQueryCacheDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.cache_clear_result_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearResultCacheDoctrineCommand
     */
    protected function getDoctrine_CacheClearResultCommandService()
    {
        return $this->services['doctrine.cache_clear_result_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ClearResultCacheDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.cache_collection_region_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\CollectionRegionDoctrineCommand
     */
    protected function getDoctrine_CacheCollectionRegionCommandService()
    {
        return $this->services['doctrine.cache_collection_region_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\CollectionRegionDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.clear_entity_region_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\EntityRegionCacheDoctrineCommand
     */
    protected function getDoctrine_ClearEntityRegionCommandService()
    {
        return $this->services['doctrine.clear_entity_region_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\EntityRegionCacheDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.clear_query_region_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\QueryRegionCacheDoctrineCommand
     */
    protected function getDoctrine_ClearQueryRegionCommandService()
    {
        return $this->services['doctrine.clear_query_region_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\QueryRegionCacheDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.database_create_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand
     */
    protected function getDoctrine_DatabaseCreateCommandService()
    {
        return $this->services['doctrine.database_create_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.database_drop_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand
     */
    protected function getDoctrine_DatabaseDropCommandService()
    {
        return $this->services['doctrine.database_drop_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.database_import_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ImportDoctrineCommand
     */
    protected function getDoctrine_DatabaseImportCommandService()
    {
        return $this->services['doctrine.database_import_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ImportDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.dbal.connection_factory' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\ConnectionFactory
     */
    protected function getDoctrine_Dbal_ConnectionFactoryService()
    {
        return $this->services['doctrine.dbal.connection_factory'] = new \Doctrine\Bundle\DoctrineBundle\ConnectionFactory(array());
    }

    /**
     * Gets the public 'doctrine.dbal.default_connection' shared service.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrine_Dbal_DefaultConnectionService()
    {
        $a = ${($_ = isset($this->services['fos_elastica.indexable']) ? $this->services['fos_elastica.indexable'] : $this->get('fos_elastica.indexable')) && false ?: '_'};

        $b = new \Doctrine\DBAL\Logging\LoggerChain();
        $b->addLogger(new \Symfony\Bridge\Doctrine\Logger\DbalLogger(${($_ = isset($this->services['monolog.logger.doctrine']) ? $this->services['monolog.logger.doctrine'] : $this->get('monolog.logger.doctrine', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}));
        $b->addLogger(${($_ = isset($this->services['doctrine.dbal.logger.profiling.default']) ? $this->services['doctrine.dbal.logger.profiling.default'] : $this->getDoctrine_Dbal_Logger_Profiling_DefaultService()) && false ?: '_'});

        $c = new \Doctrine\DBAL\Configuration();
        $c->setSQLLogger($b);

        $d = new \Symfony\Bridge\Doctrine\ContainerAwareEventManager($this);
        $d->addEventListener(array(0 => 'postUpdate', 1 => 'preRemove', 2 => 'postFlush'), new \FOS\ElasticaBundle\Doctrine\Listener(${($_ = isset($this->services['fos_elastica.object_persister.cmstypologies.model']) ? $this->services['fos_elastica.object_persister.cmstypologies.model'] : $this->get('fos_elastica.object_persister.cmstypologies.model')) && false ?: '_'}, $a, array('identifier' => 'id', 'indexName' => 'cmstypologies', 'typeName' => 'model'), NULL));
        $d->addEventListener(array(0 => 'postUpdate', 1 => 'preRemove', 2 => 'postFlush'), new \FOS\ElasticaBundle\Doctrine\Listener(${($_ = isset($this->services['fos_elastica.object_persister.cmsproduct.product']) ? $this->services['fos_elastica.object_persister.cmsproduct.product'] : $this->get('fos_elastica.object_persister.cmsproduct.product')) && false ?: '_'}, $a, array('identifier' => 'id', 'indexName' => 'cmsproduct', 'typeName' => 'product'), NULL));
        $d->addEventListener(array(0 => 'postUpdate', 1 => 'preRemove', 2 => 'postFlush'), new \FOS\ElasticaBundle\Doctrine\Listener(${($_ = isset($this->services['fos_elastica.object_persister.cmsmodel.model']) ? $this->services['fos_elastica.object_persister.cmsmodel.model'] : $this->get('fos_elastica.object_persister.cmsmodel.model')) && false ?: '_'}, $a, array('identifier' => 'id', 'indexName' => 'cmsmodel', 'typeName' => 'model'), NULL));
        $d->addEventListener(array(0 => 'loadClassMetadata'), ${($_ = isset($this->services['doctrine.orm.default_listeners.attach_entity_listeners']) ? $this->services['doctrine.orm.default_listeners.attach_entity_listeners'] : $this->get('doctrine.orm.default_listeners.attach_entity_listeners')) && false ?: '_'});

        return $this->services['doctrine.dbal.default_connection'] = ${($_ = isset($this->services['doctrine.dbal.connection_factory']) ? $this->services['doctrine.dbal.connection_factory'] : $this->get('doctrine.dbal.connection_factory')) && false ?: '_'}->createConnection(array('driver' => 'pdo_mysql', 'host' => 'mysql', 'port' => 3306, 'dbname' => 'acquistigiusti', 'user' => 'root', 'password' => 'secret', 'charset' => 'UTF8', 'driverOptions' => array(), 'defaultTableOptions' => array()), $c, $d, array());
    }

    /**
     * Gets the public 'doctrine.ensure_production_settings_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\EnsureProductionSettingsDoctrineCommand
     */
    protected function getDoctrine_EnsureProductionSettingsCommandService()
    {
        return $this->services['doctrine.ensure_production_settings_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\EnsureProductionSettingsDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.generate_entities_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\GenerateEntitiesDoctrineCommand
     */
    protected function getDoctrine_GenerateEntitiesCommandService()
    {
        return $this->services['doctrine.generate_entities_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\GenerateEntitiesDoctrineCommand(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.mapping_convert_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ConvertMappingDoctrineCommand
     */
    protected function getDoctrine_MappingConvertCommandService()
    {
        return $this->services['doctrine.mapping_convert_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ConvertMappingDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.mapping_import_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\ImportMappingDoctrineCommand
     */
    protected function getDoctrine_MappingImportCommandService()
    {
        return $this->services['doctrine.mapping_import_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\ImportMappingDoctrineCommand(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, array('FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle', 'SecurityBundle' => 'Symfony\\Bundle\\SecurityBundle\\SecurityBundle', 'TwigBundle' => 'Symfony\\Bundle\\TwigBundle\\TwigBundle', 'MonologBundle' => 'Symfony\\Bundle\\MonologBundle\\MonologBundle', 'SwiftmailerBundle' => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle', 'DoctrineBundle' => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle', 'SensioFrameworkExtraBundle' => 'Sensio\\Bundle\\FrameworkExtraBundle\\SensioFrameworkExtraBundle', 'MobileDetectBundle' => 'SunCat\\MobileDetectBundle\\MobileDetectBundle', 'AppBundle' => 'AppBundle\\AppBundle', 'SncRedisBundle' => 'Snc\\RedisBundle\\SncRedisBundle', 'FOSElasticaBundle' => 'FOS\\ElasticaBundle\\FOSElasticaBundle', 'JMSSerializerBundle' => 'JMS\\SerializerBundle\\JMSSerializerBundle', 'DebugBundle' => 'Symfony\\Bundle\\DebugBundle\\DebugBundle', 'WebProfilerBundle' => 'Symfony\\Bundle\\WebProfilerBundle\\WebProfilerBundle', 'SensioDistributionBundle' => 'Sensio\\Bundle\\DistributionBundle\\SensioDistributionBundle', 'SensioGeneratorBundle' => 'Sensio\\Bundle\\GeneratorBundle\\SensioGeneratorBundle'));
    }

    /**
     * Gets the public 'doctrine.mapping_info_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\InfoDoctrineCommand
     */
    protected function getDoctrine_MappingInfoCommandService()
    {
        return $this->services['doctrine.mapping_info_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\InfoDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.orm.default_entity_listener_resolver' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerAwareEntityListenerResolver
     */
    protected function getDoctrine_Orm_DefaultEntityListenerResolverService()
    {
        return $this->services['doctrine.orm.default_entity_listener_resolver'] = new \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerAwareEntityListenerResolver($this);
    }

    /**
     * Gets the public 'doctrine.orm.default_entity_manager' shared service.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getDoctrine_Orm_DefaultEntityManagerService($lazyLoad = true)
    {
        $a = new \Doctrine\ORM\Cache\Logging\CacheLoggerChain();
        $a->setLogger('statistics', new \Doctrine\ORM\Cache\Logging\StatisticsCacheLogger());

        $b = new \Doctrine\ORM\Cache\CacheConfiguration();
        $b->setCacheLogger($a);
        $b->setCacheFactory(new \Doctrine\ORM\Cache\DefaultCacheFactory(${($_ = isset($this->services['doctrine.orm.default_second_level_cache.regions_configuration']) ? $this->services['doctrine.orm.default_second_level_cache.regions_configuration'] : $this->get('doctrine.orm.default_second_level_cache.regions_configuration')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_second_level_cache.region_cache_driver']) ? $this->services['doctrine.orm.default_second_level_cache.region_cache_driver'] : $this->get('doctrine.orm.default_second_level_cache.region_cache_driver')) && false ?: '_'}));
        $b->setRegionsConfiguration(new \Doctrine\ORM\Cache\RegionsConfiguration());

        $c = new \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain();
        $c->addDriver(new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(${($_ = isset($this->services['annotation_reader']) ? $this->services['annotation_reader'] : $this->get('annotation_reader')) && false ?: '_'}, array(0 => ($this->targetDirs[3].'/src/AppBundle/Entity'))), 'AppBundle\\Entity');

        $d = new \Doctrine\ORM\Configuration();
        $d->setEntityNamespaces(array('AppBundle' => 'AppBundle\\Entity'));
        $d->setSecondLevelCacheEnabled(false);
        $d->setSecondLevelCacheConfiguration($b);
        $d->setMetadataCacheImpl(${($_ = isset($this->services['doctrine.orm.default_metadata_cache']) ? $this->services['doctrine.orm.default_metadata_cache'] : $this->get('doctrine.orm.default_metadata_cache')) && false ?: '_'});
        $d->setQueryCacheImpl(${($_ = isset($this->services['doctrine.orm.default_query_cache']) ? $this->services['doctrine.orm.default_query_cache'] : $this->get('doctrine.orm.default_query_cache')) && false ?: '_'});
        $d->setResultCacheImpl(${($_ = isset($this->services['doctrine.orm.default_result_cache']) ? $this->services['doctrine.orm.default_result_cache'] : $this->get('doctrine.orm.default_result_cache')) && false ?: '_'});
        $d->setMetadataDriverImpl($c);
        $d->setProxyDir((__DIR__.'/doctrine/orm/Proxies'));
        $d->setProxyNamespace('Proxies');
        $d->setAutoGenerateProxyClasses(true);
        $d->setClassMetadataFactoryName('Doctrine\\ORM\\Mapping\\ClassMetadataFactory');
        $d->setDefaultRepositoryClassName('Doctrine\\ORM\\EntityRepository');
        $d->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());
        $d->setQuoteStrategy(new \Doctrine\ORM\Mapping\DefaultQuoteStrategy());
        $d->setEntityListenerResolver(${($_ = isset($this->services['doctrine.orm.default_entity_listener_resolver']) ? $this->services['doctrine.orm.default_entity_listener_resolver'] : $this->get('doctrine.orm.default_entity_listener_resolver')) && false ?: '_'});
        $d->setRepositoryFactory(new \Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory(${($_ = isset($this->services['service_locator.6f24348b77840ec12a20c22a3f985cf7']) ? $this->services['service_locator.6f24348b77840ec12a20c22a3f985cf7'] : $this->getServiceLocator_6f24348b77840ec12a20c22a3f985cf7Service()) && false ?: '_'}));

        $this->services['doctrine.orm.default_entity_manager'] = $instance = \Doctrine\ORM\EntityManager::create(${($_ = isset($this->services['doctrine.dbal.default_connection']) ? $this->services['doctrine.dbal.default_connection'] : $this->get('doctrine.dbal.default_connection')) && false ?: '_'}, $d);

        ${($_ = isset($this->services['doctrine.orm.default_manager_configurator']) ? $this->services['doctrine.orm.default_manager_configurator'] : $this->get('doctrine.orm.default_manager_configurator')) && false ?: '_'}->configure($instance);

        return $instance;
    }

    /**
     * Gets the public 'doctrine.orm.default_entity_manager.property_info_extractor' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor
     */
    protected function getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService()
    {
        return $this->services['doctrine.orm.default_entity_manager.property_info_extractor'] = new \Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor(${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}->getMetadataFactory());
    }

    /**
     * Gets the public 'doctrine.orm.default_listeners.attach_entity_listeners' shared service.
     *
     * @return \Doctrine\ORM\Tools\AttachEntityListenersListener
     */
    protected function getDoctrine_Orm_DefaultListeners_AttachEntityListenersService()
    {
        return $this->services['doctrine.orm.default_listeners.attach_entity_listeners'] = new \Doctrine\ORM\Tools\AttachEntityListenersListener();
    }

    /**
     * Gets the public 'doctrine.orm.default_manager_configurator' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator
     */
    protected function getDoctrine_Orm_DefaultManagerConfiguratorService()
    {
        return $this->services['doctrine.orm.default_manager_configurator'] = new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator(array(), array());
    }

    /**
     * Gets the public 'doctrine.orm.default_metadata_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\PredisCache
     */
    protected function getDoctrine_Orm_DefaultMetadataCacheService()
    {
        return $this->services['doctrine.orm.default_metadata_cache'] = new \Doctrine\Common\Cache\PredisCache(${($_ = isset($this->services['snc_redis.sncredisDoctrinemetadata']) ? $this->services['snc_redis.sncredisDoctrinemetadata'] : $this->get('snc_redis.sncredisDoctrinemetadata')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.default_query_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\PredisCache
     */
    protected function getDoctrine_Orm_DefaultQueryCacheService()
    {
        return $this->services['doctrine.orm.default_query_cache'] = new \Doctrine\Common\Cache\PredisCache(${($_ = isset($this->services['snc_redis.sncredisDoctrineQueryCache']) ? $this->services['snc_redis.sncredisDoctrineQueryCache'] : $this->get('snc_redis.sncredisDoctrineQueryCache')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.default_result_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\PredisCache
     */
    protected function getDoctrine_Orm_DefaultResultCacheService()
    {
        return $this->services['doctrine.orm.default_result_cache'] = new \Doctrine\Common\Cache\PredisCache(${($_ = isset($this->services['snc_redis.sncredisDoctrineResult']) ? $this->services['snc_redis.sncredisDoctrineResult'] : $this->get('snc_redis.sncredisDoctrineResult')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.cache_configuration' shared service.
     *
     * @return \Doctrine\ORM\Cache\CacheConfiguration
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_CacheConfigurationService()
    {
        $a = new \Doctrine\ORM\Cache\Logging\CacheLoggerChain();
        $a->setLogger('statistics', new \Doctrine\ORM\Cache\Logging\StatisticsCacheLogger());

        $this->services['doctrine.orm.default_second_level_cache.cache_configuration'] = $instance = new \Doctrine\ORM\Cache\CacheConfiguration();

        $instance->setCacheLogger($a);
        $instance->setCacheFactory(new \Doctrine\ORM\Cache\DefaultCacheFactory(${($_ = isset($this->services['doctrine.orm.default_second_level_cache.regions_configuration']) ? $this->services['doctrine.orm.default_second_level_cache.regions_configuration'] : $this->get('doctrine.orm.default_second_level_cache.regions_configuration')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_second_level_cache.region_cache_driver']) ? $this->services['doctrine.orm.default_second_level_cache.region_cache_driver'] : $this->get('doctrine.orm.default_second_level_cache.region_cache_driver')) && false ?: '_'}));
        $instance->setRegionsConfiguration(new \Doctrine\ORM\Cache\RegionsConfiguration());

        return $instance;
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.default_cache_factory' shared service.
     *
     * @return \Doctrine\ORM\Cache\DefaultCacheFactory
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_DefaultCacheFactoryService()
    {
        return $this->services['doctrine.orm.default_second_level_cache.default_cache_factory'] = new \Doctrine\ORM\Cache\DefaultCacheFactory(${($_ = isset($this->services['doctrine.orm.default_second_level_cache.regions_configuration']) ? $this->services['doctrine.orm.default_second_level_cache.regions_configuration'] : $this->get('doctrine.orm.default_second_level_cache.regions_configuration')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_second_level_cache.region_cache_driver']) ? $this->services['doctrine.orm.default_second_level_cache.region_cache_driver'] : $this->get('doctrine.orm.default_second_level_cache.region_cache_driver')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.logger_chain' shared service.
     *
     * @return \Doctrine\ORM\Cache\Logging\CacheLoggerChain
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_LoggerChainService()
    {
        $this->services['doctrine.orm.default_second_level_cache.logger_chain'] = $instance = new \Doctrine\ORM\Cache\Logging\CacheLoggerChain();

        $instance->setLogger('statistics', new \Doctrine\ORM\Cache\Logging\StatisticsCacheLogger());

        return $instance;
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.logger_statistics' shared service.
     *
     * @return \Doctrine\ORM\Cache\Logging\StatisticsCacheLogger
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_LoggerStatisticsService()
    {
        return $this->services['doctrine.orm.default_second_level_cache.logger_statistics'] = new \Doctrine\ORM\Cache\Logging\StatisticsCacheLogger();
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.region_cache_driver' shared service.
     *
     * @return \Doctrine\Common\Cache\PredisCache
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_RegionCacheDriverService()
    {
        return $this->services['doctrine.orm.default_second_level_cache.region_cache_driver'] = new \Doctrine\Common\Cache\PredisCache(${($_ = isset($this->services['snc_redis.secondLevelCache']) ? $this->services['snc_redis.secondLevelCache'] : $this->get('snc_redis.secondLevelCache')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.default_second_level_cache.regions_configuration' shared service.
     *
     * @return \Doctrine\ORM\Cache\RegionsConfiguration
     */
    protected function getDoctrine_Orm_DefaultSecondLevelCache_RegionsConfigurationService()
    {
        return $this->services['doctrine.orm.default_second_level_cache.regions_configuration'] = new \Doctrine\ORM\Cache\RegionsConfiguration();
    }

    /**
     * Gets the public 'doctrine.orm.validator.unique' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator
     */
    protected function getDoctrine_Orm_Validator_UniqueService()
    {
        return $this->services['doctrine.orm.validator.unique'] = new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.orm.validator_initializer' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Validator\DoctrineInitializer
     */
    protected function getDoctrine_Orm_ValidatorInitializerService()
    {
        return $this->services['doctrine.orm.validator_initializer'] = new \Symfony\Bridge\Doctrine\Validator\DoctrineInitializer(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'doctrine.query_dql_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\RunDqlDoctrineCommand
     */
    protected function getDoctrine_QueryDqlCommandService()
    {
        return $this->services['doctrine.query_dql_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\RunDqlDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.query_sql_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\RunSqlDoctrineCommand
     */
    protected function getDoctrine_QuerySqlCommandService()
    {
        return $this->services['doctrine.query_sql_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\RunSqlDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.schema_create_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand
     */
    protected function getDoctrine_SchemaCreateCommandService()
    {
        return $this->services['doctrine.schema_create_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.schema_drop_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\DropSchemaDoctrineCommand
     */
    protected function getDoctrine_SchemaDropCommandService()
    {
        return $this->services['doctrine.schema_drop_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\DropSchemaDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.schema_update_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand
     */
    protected function getDoctrine_SchemaUpdateCommandService()
    {
        return $this->services['doctrine.schema_update_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand();
    }

    /**
     * Gets the public 'doctrine.schema_validate_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ValidateSchemaCommand
     */
    protected function getDoctrine_SchemaValidateCommandService()
    {
        return $this->services['doctrine.schema_validate_command'] = new \Doctrine\Bundle\DoctrineBundle\Command\Proxy\ValidateSchemaCommand();
    }

    /**
     * Gets the public 'doctrine_cache.contains_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineCacheBundle\Command\ContainsCommand
     */
    protected function getDoctrineCache_ContainsCommandService()
    {
        return $this->services['doctrine_cache.contains_command'] = new \Doctrine\Bundle\DoctrineCacheBundle\Command\ContainsCommand();
    }

    /**
     * Gets the public 'doctrine_cache.delete_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineCacheBundle\Command\DeleteCommand
     */
    protected function getDoctrineCache_DeleteCommandService()
    {
        return $this->services['doctrine_cache.delete_command'] = new \Doctrine\Bundle\DoctrineCacheBundle\Command\DeleteCommand();
    }

    /**
     * Gets the public 'doctrine_cache.flush_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineCacheBundle\Command\FlushCommand
     */
    protected function getDoctrineCache_FlushCommandService()
    {
        return $this->services['doctrine_cache.flush_command'] = new \Doctrine\Bundle\DoctrineCacheBundle\Command\FlushCommand();
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_metadata_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultMetadataCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_metadata_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_2400e2c517f9d2e27697f682aea5cf6aa95c94c9f7868c0686019b840e408b19');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_query_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultQueryCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_query_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_2400e2c517f9d2e27697f682aea5cf6aa95c94c9f7868c0686019b840e408b19');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_result_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultResultCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_result_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_2400e2c517f9d2e27697f682aea5cf6aa95c94c9f7868c0686019b840e408b19');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_second_level_cache.region_cache_driver' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultSecondLevelCache_RegionCacheDriverService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_second_level_cache.region_cache_driver'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_2400e2c517f9d2e27697f682aea5cf6aa95c94c9f7868c0686019b840e408b19');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.stats_command' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineCacheBundle\Command\StatsCommand
     */
    protected function getDoctrineCache_StatsCommandService()
    {
        return $this->services['doctrine_cache.stats_command'] = new \Doctrine\Bundle\DoctrineCacheBundle\Command\StatsCommand();
    }

    /**
     * Gets the public 'esi' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpCache\Esi
     */
    protected function getEsiService()
    {
        return $this->services['esi'] = new \Symfony\Component\HttpKernel\HttpCache\Esi();
    }

    /**
     * Gets the public 'esi_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SurrogateListener
     */
    protected function getEsiListenerService()
    {
        return $this->services['esi_listener'] = new \Symfony\Component\HttpKernel\EventListener\SurrogateListener(${($_ = isset($this->services['esi']) ? $this->services['esi'] : $this->get('esi', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'file_locator' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Config\FileLocator
     */
    protected function getFileLocatorService()
    {
        return $this->services['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel')) && false ?: '_'}, ($this->targetDirs[3].'/app/Resources'), array(0 => ($this->targetDirs[3].'/app')));
    }

    /**
     * Gets the public 'filesystem' shared service.
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    protected function getFilesystemService()
    {
        return $this->services['filesystem'] = new \Symfony\Component\Filesystem\Filesystem();
    }

    /**
     * Gets the public 'form.factory' shared service.
     *
     * @return \Symfony\Component\Form\FormFactory
     */
    protected function getForm_FactoryService()
    {
        return $this->services['form.factory'] = new \Symfony\Component\Form\FormFactory(${($_ = isset($this->services['form.registry']) ? $this->services['form.registry'] : $this->get('form.registry')) && false ?: '_'}, ${($_ = isset($this->services['form.resolved_type_factory']) ? $this->services['form.resolved_type_factory'] : $this->get('form.resolved_type_factory')) && false ?: '_'});
    }

    /**
     * Gets the public 'form.registry' shared service.
     *
     * @return \Symfony\Component\Form\FormRegistry
     */
    protected function getForm_RegistryService()
    {
        return $this->services['form.registry'] = new \Symfony\Component\Form\FormRegistry(array(0 => new \Symfony\Component\Form\Extension\DependencyInjection\DependencyInjectionExtension(new \Symfony\Component\DependencyInjection\ServiceLocator(array('Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType' => function () {
            return ${($_ = isset($this->services['form.type.entity']) ? $this->services['form.type.entity'] : $this->get('form.type.entity')) && false ?: '_'};
        }, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType' => function () {
            return ${($_ = isset($this->services['form.type.choice']) ? $this->services['form.type.choice'] : $this->getForm_Type_ChoiceService()) && false ?: '_'};
        }, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType' => function () {
            return ${($_ = isset($this->services['form.type.form']) ? $this->services['form.type.form'] : $this->getForm_Type_FormService()) && false ?: '_'};
        })), array('Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType' => new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['form.type_extension.form.http_foundation']) ? $this->services['form.type_extension.form.http_foundation'] : $this->getForm_TypeExtension_Form_HttpFoundationService()) && false ?: '_'};
            yield 1 => ${($_ = isset($this->services['form.type_extension.form.validator']) ? $this->services['form.type_extension.form.validator'] : $this->getForm_TypeExtension_Form_ValidatorService()) && false ?: '_'};
            yield 2 => ${($_ = isset($this->services['form.type_extension.upload.validator']) ? $this->services['form.type_extension.upload.validator'] : $this->getForm_TypeExtension_Upload_ValidatorService()) && false ?: '_'};
            yield 3 => ${($_ = isset($this->services['form.type_extension.csrf']) ? $this->services['form.type_extension.csrf'] : $this->getForm_TypeExtension_CsrfService()) && false ?: '_'};
            yield 4 => ${($_ = isset($this->services['form.type_extension.form.data_collector']) ? $this->services['form.type_extension.form.data_collector'] : $this->getForm_TypeExtension_Form_DataCollectorService()) && false ?: '_'};
        }, 5), 'Symfony\\Component\\Form\\Extension\\Core\\Type\\RepeatedType' => new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['form.type_extension.repeated.validator']) ? $this->services['form.type_extension.repeated.validator'] : $this->getForm_TypeExtension_Repeated_ValidatorService()) && false ?: '_'};
        }, 1), 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType' => new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['form.type_extension.submit.validator']) ? $this->services['form.type_extension.submit.validator'] : $this->getForm_TypeExtension_Submit_ValidatorService()) && false ?: '_'};
        }, 1)), new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['form.type_guesser.validator']) ? $this->services['form.type_guesser.validator'] : $this->getForm_TypeGuesser_ValidatorService()) && false ?: '_'};
            yield 1 => ${($_ = isset($this->services['form.type_guesser.doctrine']) ? $this->services['form.type_guesser.doctrine'] : $this->get('form.type_guesser.doctrine')) && false ?: '_'};
        }, 2), NULL)), ${($_ = isset($this->services['form.resolved_type_factory']) ? $this->services['form.resolved_type_factory'] : $this->get('form.resolved_type_factory')) && false ?: '_'});
    }

    /**
     * Gets the public 'form.resolved_type_factory' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\Proxy\ResolvedTypeFactoryDataCollectorProxy
     */
    protected function getForm_ResolvedTypeFactoryService()
    {
        return $this->services['form.resolved_type_factory'] = new \Symfony\Component\Form\Extension\DataCollector\Proxy\ResolvedTypeFactoryDataCollectorProxy(new \Symfony\Component\Form\ResolvedFormTypeFactory(), ${($_ = isset($this->services['data_collector.form']) ? $this->services['data_collector.form'] : $this->get('data_collector.form')) && false ?: '_'});
    }

    /**
     * Gets the public 'form.type.birthday' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\BirthdayType
     *
     * @deprecated The "form.type.birthday" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_BirthdayService()
    {
        @trigger_error('The "form.type.birthday" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.birthday'] = new \Symfony\Component\Form\Extension\Core\Type\BirthdayType();
    }

    /**
     * Gets the public 'form.type.button' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\ButtonType
     *
     * @deprecated The "form.type.button" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_ButtonService()
    {
        @trigger_error('The "form.type.button" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.button'] = new \Symfony\Component\Form\Extension\Core\Type\ButtonType();
    }

    /**
     * Gets the public 'form.type.checkbox' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\CheckboxType
     *
     * @deprecated The "form.type.checkbox" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_CheckboxService()
    {
        @trigger_error('The "form.type.checkbox" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.checkbox'] = new \Symfony\Component\Form\Extension\Core\Type\CheckboxType();
    }

    /**
     * Gets the public 'form.type.collection' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\CollectionType
     *
     * @deprecated The "form.type.collection" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_CollectionService()
    {
        @trigger_error('The "form.type.collection" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.collection'] = new \Symfony\Component\Form\Extension\Core\Type\CollectionType();
    }

    /**
     * Gets the public 'form.type.country' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\CountryType
     *
     * @deprecated The "form.type.country" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_CountryService()
    {
        @trigger_error('The "form.type.country" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.country'] = new \Symfony\Component\Form\Extension\Core\Type\CountryType();
    }

    /**
     * Gets the public 'form.type.currency' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\CurrencyType
     *
     * @deprecated The "form.type.currency" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_CurrencyService()
    {
        @trigger_error('The "form.type.currency" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.currency'] = new \Symfony\Component\Form\Extension\Core\Type\CurrencyType();
    }

    /**
     * Gets the public 'form.type.date' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\DateType
     *
     * @deprecated The "form.type.date" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_DateService()
    {
        @trigger_error('The "form.type.date" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.date'] = new \Symfony\Component\Form\Extension\Core\Type\DateType();
    }

    /**
     * Gets the public 'form.type.datetime' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\DateTimeType
     *
     * @deprecated The "form.type.datetime" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_DatetimeService()
    {
        @trigger_error('The "form.type.datetime" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.datetime'] = new \Symfony\Component\Form\Extension\Core\Type\DateTimeType();
    }

    /**
     * Gets the public 'form.type.email' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\EmailType
     *
     * @deprecated The "form.type.email" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_EmailService()
    {
        @trigger_error('The "form.type.email" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.email'] = new \Symfony\Component\Form\Extension\Core\Type\EmailType();
    }

    /**
     * Gets the public 'form.type.entity' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Form\Type\EntityType
     */
    protected function getForm_Type_EntityService()
    {
        return $this->services['form.type.entity'] = new \Symfony\Bridge\Doctrine\Form\Type\EntityType(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'form.type.file' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\FileType
     *
     * @deprecated The "form.type.file" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_FileService()
    {
        @trigger_error('The "form.type.file" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.file'] = new \Symfony\Component\Form\Extension\Core\Type\FileType();
    }

    /**
     * Gets the public 'form.type.hidden' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\HiddenType
     *
     * @deprecated The "form.type.hidden" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_HiddenService()
    {
        @trigger_error('The "form.type.hidden" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.hidden'] = new \Symfony\Component\Form\Extension\Core\Type\HiddenType();
    }

    /**
     * Gets the public 'form.type.integer' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\IntegerType
     *
     * @deprecated The "form.type.integer" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_IntegerService()
    {
        @trigger_error('The "form.type.integer" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.integer'] = new \Symfony\Component\Form\Extension\Core\Type\IntegerType();
    }

    /**
     * Gets the public 'form.type.language' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\LanguageType
     *
     * @deprecated The "form.type.language" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_LanguageService()
    {
        @trigger_error('The "form.type.language" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.language'] = new \Symfony\Component\Form\Extension\Core\Type\LanguageType();
    }

    /**
     * Gets the public 'form.type.locale' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\LocaleType
     *
     * @deprecated The "form.type.locale" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_LocaleService()
    {
        @trigger_error('The "form.type.locale" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.locale'] = new \Symfony\Component\Form\Extension\Core\Type\LocaleType();
    }

    /**
     * Gets the public 'form.type.money' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\MoneyType
     *
     * @deprecated The "form.type.money" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_MoneyService()
    {
        @trigger_error('The "form.type.money" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.money'] = new \Symfony\Component\Form\Extension\Core\Type\MoneyType();
    }

    /**
     * Gets the public 'form.type.number' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\NumberType
     *
     * @deprecated The "form.type.number" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_NumberService()
    {
        @trigger_error('The "form.type.number" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.number'] = new \Symfony\Component\Form\Extension\Core\Type\NumberType();
    }

    /**
     * Gets the public 'form.type.password' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\PasswordType
     *
     * @deprecated The "form.type.password" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_PasswordService()
    {
        @trigger_error('The "form.type.password" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.password'] = new \Symfony\Component\Form\Extension\Core\Type\PasswordType();
    }

    /**
     * Gets the public 'form.type.percent' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\PercentType
     *
     * @deprecated The "form.type.percent" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_PercentService()
    {
        @trigger_error('The "form.type.percent" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.percent'] = new \Symfony\Component\Form\Extension\Core\Type\PercentType();
    }

    /**
     * Gets the public 'form.type.radio' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\RadioType
     *
     * @deprecated The "form.type.radio" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_RadioService()
    {
        @trigger_error('The "form.type.radio" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.radio'] = new \Symfony\Component\Form\Extension\Core\Type\RadioType();
    }

    /**
     * Gets the public 'form.type.range' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\RangeType
     *
     * @deprecated The "form.type.range" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_RangeService()
    {
        @trigger_error('The "form.type.range" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.range'] = new \Symfony\Component\Form\Extension\Core\Type\RangeType();
    }

    /**
     * Gets the public 'form.type.repeated' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\RepeatedType
     *
     * @deprecated The "form.type.repeated" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_RepeatedService()
    {
        @trigger_error('The "form.type.repeated" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.repeated'] = new \Symfony\Component\Form\Extension\Core\Type\RepeatedType();
    }

    /**
     * Gets the public 'form.type.reset' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\ResetType
     *
     * @deprecated The "form.type.reset" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_ResetService()
    {
        @trigger_error('The "form.type.reset" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.reset'] = new \Symfony\Component\Form\Extension\Core\Type\ResetType();
    }

    /**
     * Gets the public 'form.type.search' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\SearchType
     *
     * @deprecated The "form.type.search" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_SearchService()
    {
        @trigger_error('The "form.type.search" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.search'] = new \Symfony\Component\Form\Extension\Core\Type\SearchType();
    }

    /**
     * Gets the public 'form.type.submit' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\SubmitType
     *
     * @deprecated The "form.type.submit" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_SubmitService()
    {
        @trigger_error('The "form.type.submit" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.submit'] = new \Symfony\Component\Form\Extension\Core\Type\SubmitType();
    }

    /**
     * Gets the public 'form.type.text' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\TextType
     *
     * @deprecated The "form.type.text" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_TextService()
    {
        @trigger_error('The "form.type.text" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.text'] = new \Symfony\Component\Form\Extension\Core\Type\TextType();
    }

    /**
     * Gets the public 'form.type.textarea' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\TextareaType
     *
     * @deprecated The "form.type.textarea" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_TextareaService()
    {
        @trigger_error('The "form.type.textarea" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.textarea'] = new \Symfony\Component\Form\Extension\Core\Type\TextareaType();
    }

    /**
     * Gets the public 'form.type.time' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\TimeType
     *
     * @deprecated The "form.type.time" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_TimeService()
    {
        @trigger_error('The "form.type.time" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.time'] = new \Symfony\Component\Form\Extension\Core\Type\TimeType();
    }

    /**
     * Gets the public 'form.type.timezone' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\TimezoneType
     *
     * @deprecated The "form.type.timezone" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_TimezoneService()
    {
        @trigger_error('The "form.type.timezone" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.timezone'] = new \Symfony\Component\Form\Extension\Core\Type\TimezoneType();
    }

    /**
     * Gets the public 'form.type.url' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\UrlType
     *
     * @deprecated The "form.type.url" service is deprecated since Symfony 3.1 and will be removed in 4.0.
     */
    protected function getForm_Type_UrlService()
    {
        @trigger_error('The "form.type.url" service is deprecated since Symfony 3.1 and will be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['form.type.url'] = new \Symfony\Component\Form\Extension\Core\Type\UrlType();
    }

    /**
     * Gets the public 'form.type_guesser.doctrine' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser
     */
    protected function getForm_TypeGuesser_DoctrineService()
    {
        return $this->services['form.type_guesser.doctrine'] = new \Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.alias_processor' shared service.
     *
     * @return \FOS\ElasticaBundle\Index\AliasProcessor
     */
    protected function getFosElastica_AliasProcessorService()
    {
        return $this->services['fos_elastica.alias_processor'] = new \FOS\ElasticaBundle\Index\AliasProcessor();
    }

    /**
     * Gets the public 'fos_elastica.client.default' shared service.
     *
     * @return \FOS\ElasticaBundle\Elastica\Client
     */
    protected function getFosElastica_Client_DefaultService()
    {
        $this->services['fos_elastica.client.default'] = $instance = new \FOS\ElasticaBundle\Elastica\Client(array('connections' => array(0 => array('host' => 'localhost', 'port' => 9200, 'logger' => 'fos_elastica.logger', 'compression' => true, 'headers' => array(), 'retryOnConflict' => 0)), 'connectionStrategy' => 'Simple'), '');

        $instance->setStopwatch(${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
        $instance->setLogger(${($_ = isset($this->services['fos_elastica.logger']) ? $this->services['fos_elastica.logger'] : $this->get('fos_elastica.logger')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.config_manager' shared service.
     *
     * @return \FOS\ElasticaBundle\Configuration\ConfigManager
     */
    protected function getFosElastica_ConfigManagerService()
    {
        return $this->services['fos_elastica.config_manager'] = new \FOS\ElasticaBundle\Configuration\ConfigManager(array(0 => new \FOS\ElasticaBundle\Configuration\Source\ContainerSource(array('cmsproduct' => array('elasticsearch_name' => 'cmsproduct', 'reference' => ${($_ = isset($this->services['fos_elastica.index.cmsproduct']) ? $this->services['fos_elastica.index.cmsproduct'] : $this->get('fos_elastica.index.cmsproduct')) && false ?: '_'}, 'name' => 'cmsproduct', 'settings' => array('index' => array('refresh_interval' => '1s', 'number_of_replicas' => 0, 'analysis' => array('analyzer' => array('my_analyzer' => array('tokenizer' => 'standard', 'char_filter' => array(0 => 'my_char_filter'), 'filter' => array(0 => 'asciifolding', 1 => 'lowercase', 2 => 'snowball', 3 => 'worddelimiter'))), 'char_filter' => array('my_char_filter' => array('type' => 'mapping', 'mappings' => array(0 => ': => ', 1 => '? => ', 2 => '- => ', 3 => '_ => ', 4 => '" => '))), 'filter' => array('snowball' => array('type' => 'snowball', 'language' => 'Italian'), 'stopwords' => array('type' => 'stop', 'stopwords' => array(0 => '_italian_'), 'ignore_case' => true), 'worddelimiter' => array('type' => 'word_delimiter'))))), 'type_prototype' => array(), 'use_alias' => false, 'types' => array('product' => array('name' => 'product', 'mapping' => array('dynamic_templates' => array(), 'properties' => array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'price' => array('type' => 'float'), 'colors' => array('type' => 'string'), 'sizes' => array('type' => 'string'), 'dataImport' => array('type' => 'date'), 'sex.id' => array('type' => 'integer', 'property_path' => 'getSexOrNull'), 'category.id' => array('type' => 'integer', 'property_path' => 'getCategoryOrNull'), 'subcategory.id' => array('type' => 'integer', 'property_path' => 'getSubcategoryOrNull'), 'subcategory.isTop' => array('type' => 'integer', 'property_path' => 'getSubcategoryIsTopOrNull'), 'typology.id' => array('property_path' => 'getTypologyOrNull'), 'trademark.id' => array('property_path' => 'getTrademarkOrNull'), 'priorityImg.img' => array('type' => 'string', 'property_path' => 'getPriorityImgOrNull'), 'priorityImg.widthSmall' => array('type' => 'integer', 'property_path' => 'getPriorityImgWidthSmallOrNull'), 'priorityImg.heightSmall' => array('type' => 'integer', 'property_path' => 'getPriorityImgHeightSmallOrNull'), 'subcategory.name' => array('type' => 'string', 'property_path' => 'getSubcategoryNameOrNull'), 'subcategory.singularNameUrl' => array('type' => 'string', 'property_path' => 'getSubcategorySingularNameOrNull'), 'typology.name' => array('type' => 'string', 'property_path' => 'getTypologyNameOrNull'), 'typology.singularNameUrl' => array('type' => 'string', 'property_path' => 'getTypologySingularNameOrNull'), 'typology.synonyms' => array('type' => 'string', 'property_path' => 'getTypologySynonymsNameOrNull'))), 'config' => array('persistence' => array('driver' => 'orm', 'model' => 'AppBundle\\Entity\\Product', 'finder' => array(), 'identifier' => 'id', 'elastica_to_model_transformer' => array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder'), 'provider' => array('query_builder_method' => 'getAllProductsFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false), 'listener' => array('insert' => false, 'update' => true, 'delete' => true, 'logger' => false, 'enabled' => true, 'flush' => true), 'model_to_elastica_transformer' => array(), 'persister' => array()), 'serializer' => array('groups' => array(), 'serialize_null' => false), 'analyzer' => NULL, 'search_analyzer' => NULL, 'dynamic' => NULL, 'date_detection' => NULL, 'dynamic_date_formats' => array(), 'numeric_detection' => NULL)))), 'cmsmodel' => array('elasticsearch_name' => 'cmsmodel', 'reference' => ${($_ = isset($this->services['fos_elastica.index.cmsmodel']) ? $this->services['fos_elastica.index.cmsmodel'] : $this->get('fos_elastica.index.cmsmodel')) && false ?: '_'}, 'name' => 'cmsmodel', 'settings' => array('index' => array('refresh_interval' => '1s', 'number_of_replicas' => 0, 'analysis' => array('analyzer' => array('my_analyzer' => array('tokenizer' => 'standard', 'char_filter' => array(0 => 'my_char_filter'), 'filter' => array(0 => 'asciifolding', 1 => 'lowercase', 2 => 'snowball', 3 => 'worddelimiter'))), 'char_filter' => array('my_char_filter' => array('type' => 'mapping', 'mappings' => array(0 => ': => ', 1 => '? => ', 2 => '- => ', 3 => '_ => ', 4 => '" => '))), 'filter' => array('snowball' => array('type' => 'snowball', 'language' => 'Italian'), 'stopwords' => array('type' => 'stop', 'stopwords' => array(0 => '_italian_'), 'ignore_case' => true), 'worddelimiter' => array('type' => 'word_delimiter'))))), 'type_prototype' => array(), 'use_alias' => false, 'types' => array('model' => array('name' => 'model', 'mapping' => array('dynamic_templates' => array(), 'properties' => array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'bulletPoints' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'longDescription' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'technicalSpecifications' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'synonyms' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'alphaCheckModel' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'searchTagTerms' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'price' => array('type' => 'float'), 'dateImport' => array('type' => 'date'), 'dateRelease' => array('type' => 'date'), 'isTop' => array('type' => 'integer'), 'subcategory.id' => array('type' => 'integer', 'property_path' => 'getSubcategoryOrNull'), 'trademark.id' => array('property_path' => 'getTrademarkOrNull'), 'trademark.name' => array('type' => 'string', 'property_path' => 'getTrademarkNameOrNull'), 'subcategory.name' => array('type' => 'string', 'property_path' => 'getSubcategoryNameOrNull'), 'subcategory.singularNameUrl' => array('type' => 'string', 'property_path' => 'getSubcategorySingularNameOrNull'), 'typology.id' => array('property_path' => 'getTypologyOrNull'), 'typology.name' => array('type' => 'string', 'property_path' => 'getTypologyNameOrNull'), 'typology.singularNameUrl' => array('type' => 'string', 'property_path' => 'getTypologySingularNameOrNull'), 'typology.synonyms' => array('type' => 'string', 'property_path' => 'getTypologySynonymsNameOrNull'), 'externalTecnicalTemplate.tecnicalIde' => array('type' => 'string', 'property_path' => 'getExternalTecnicalTemplateIde'), 'externalTecnicalTemplate.tecnicalPm' => array('type' => 'string', 'property_path' => 'getExternalTecnicalTemplatePm'))), 'config' => array('persistence' => array('driver' => 'orm', 'model' => 'AppBundle\\Entity\\Model', 'finder' => array(), 'identifier' => 'id', 'elastica_to_model_transformer' => array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder'), 'provider' => array('query_builder_method' => 'getAllModelsFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false), 'listener' => array('insert' => false, 'update' => true, 'delete' => true, 'logger' => false, 'enabled' => true, 'flush' => true), 'model_to_elastica_transformer' => array(), 'persister' => array()), 'serializer' => array('groups' => array(), 'serialize_null' => false), 'analyzer' => NULL, 'search_analyzer' => NULL, 'dynamic' => NULL, 'date_detection' => NULL, 'dynamic_date_formats' => array(), 'numeric_detection' => NULL)))), 'cmstypologies' => array('elasticsearch_name' => 'cmstypologies', 'reference' => ${($_ = isset($this->services['fos_elastica.index.cmstypologies']) ? $this->services['fos_elastica.index.cmstypologies'] : $this->get('fos_elastica.index.cmstypologies')) && false ?: '_'}, 'name' => 'cmstypologies', 'settings' => array('index' => array('refresh_interval' => '1s', 'number_of_replicas' => 0, 'analysis' => array('analyzer' => array('my_analyzer' => array('tokenizer' => 'standard', 'char_filter' => array(0 => 'my_char_filter'), 'filter' => array(0 => 'asciifolding', 1 => 'lowercase', 2 => 'snowball', 3 => 'worddelimiter'))), 'char_filter' => array('my_char_filter' => array('type' => 'mapping', 'mappings' => array(0 => ': => ', 1 => '? => ', 2 => '- => ', 3 => '_ => ', 4 => '" => '))), 'filter' => array('snowball' => array('type' => 'snowball', 'language' => 'Italian'), 'stopwords' => array('type' => 'stop', 'stopwords' => array(0 => '_italian_'), 'ignore_case' => true), 'worddelimiter' => array('type' => 'word_delimiter'))))), 'type_prototype' => array(), 'use_alias' => false, 'types' => array('model' => array('name' => 'model', 'mapping' => array('dynamic_templates' => array(), 'properties' => array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'))), 'config' => array('persistence' => array('driver' => 'orm', 'model' => 'AppBundle\\Entity\\Typology', 'finder' => array(), 'identifier' => 'id', 'elastica_to_model_transformer' => array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder'), 'provider' => array('query_builder_method' => 'getAllTypologiesFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false), 'listener' => array('insert' => false, 'update' => true, 'delete' => true, 'logger' => false, 'enabled' => true, 'flush' => true), 'model_to_elastica_transformer' => array(), 'persister' => array()), 'serializer' => array('groups' => array(), 'serialize_null' => false), 'analyzer' => NULL, 'search_analyzer' => NULL, 'dynamic' => NULL, 'date_detection' => NULL, 'dynamic_date_formats' => array(), 'numeric_detection' => NULL))))))));
    }

    /**
     * Gets the public 'fos_elastica.data_collector' shared service.
     *
     * @return \FOS\ElasticaBundle\DataCollector\ElasticaDataCollector
     */
    protected function getFosElastica_DataCollectorService()
    {
        return $this->services['fos_elastica.data_collector'] = new \FOS\ElasticaBundle\DataCollector\ElasticaDataCollector(${($_ = isset($this->services['fos_elastica.logger']) ? $this->services['fos_elastica.logger'] : $this->get('fos_elastica.logger')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.doctrine.register_listeners' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\RegisterListenersService
     */
    protected function getFosElastica_Doctrine_RegisterListenersService()
    {
        return $this->services['fos_elastica.doctrine.register_listeners'] = new \FOS\ElasticaBundle\Doctrine\RegisterListenersService(${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.elastica_to_model_transformer.collection.cmsmodel' shared service.
     *
     * @return \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection
     */
    protected function getFosElastica_ElasticaToModelTransformer_Collection_CmsmodelService()
    {
        return $this->services['fos_elastica.elastica_to_model_transformer.collection.cmsmodel'] = new \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection(array('model' => ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmsmodel.model']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmsmodel.model'] : $this->getFosElastica_ElasticaToModelTransformer_Cmsmodel_ModelService()) && false ?: '_'}));
    }

    /**
     * Gets the public 'fos_elastica.elastica_to_model_transformer.collection.cmsproduct' shared service.
     *
     * @return \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection
     */
    protected function getFosElastica_ElasticaToModelTransformer_Collection_CmsproductService()
    {
        return $this->services['fos_elastica.elastica_to_model_transformer.collection.cmsproduct'] = new \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection(array('product' => ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmsproduct.product']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmsproduct.product'] : $this->getFosElastica_ElasticaToModelTransformer_Cmsproduct_ProductService()) && false ?: '_'}));
    }

    /**
     * Gets the public 'fos_elastica.elastica_to_model_transformer.collection.cmstypologies' shared service.
     *
     * @return \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection
     */
    protected function getFosElastica_ElasticaToModelTransformer_Collection_CmstypologiesService()
    {
        return $this->services['fos_elastica.elastica_to_model_transformer.collection.cmstypologies'] = new \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerCollection(array('model' => ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmstypologies.model']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmstypologies.model'] : $this->getFosElastica_ElasticaToModelTransformer_Cmstypologies_ModelService()) && false ?: '_'}));
    }

    /**
     * Gets the public 'fos_elastica.filter_objects_listener' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\Listener\FilterObjectsListener
     */
    protected function getFosElastica_FilterObjectsListenerService()
    {
        return $this->services['fos_elastica.filter_objects_listener'] = new \FOS\ElasticaBundle\Persister\Listener\FilterObjectsListener(${($_ = isset($this->services['fos_elastica.indexable']) ? $this->services['fos_elastica.indexable'] : $this->get('fos_elastica.indexable')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmsmodel' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_CmsmodelService()
    {
        return $this->services['fos_elastica.finder.cmsmodel'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmsmodel']) ? $this->services['fos_elastica.index.cmsmodel'] : $this->get('fos_elastica.index.cmsmodel')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.collection.cmsmodel']) ? $this->services['fos_elastica.elastica_to_model_transformer.collection.cmsmodel'] : $this->get('fos_elastica.elastica_to_model_transformer.collection.cmsmodel')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmsmodel.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_Cmsmodel_ModelService()
    {
        return $this->services['fos_elastica.finder.cmsmodel.model'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmsmodel.model']) ? $this->services['fos_elastica.index.cmsmodel.model'] : $this->get('fos_elastica.index.cmsmodel.model')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmsmodel.model']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmsmodel.model'] : $this->getFosElastica_ElasticaToModelTransformer_Cmsmodel_ModelService()) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmsproduct' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_CmsproductService()
    {
        return $this->services['fos_elastica.finder.cmsproduct'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmsproduct']) ? $this->services['fos_elastica.index.cmsproduct'] : $this->get('fos_elastica.index.cmsproduct')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.collection.cmsproduct']) ? $this->services['fos_elastica.elastica_to_model_transformer.collection.cmsproduct'] : $this->get('fos_elastica.elastica_to_model_transformer.collection.cmsproduct')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmsproduct.product' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_Cmsproduct_ProductService()
    {
        return $this->services['fos_elastica.finder.cmsproduct.product'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmsproduct.product']) ? $this->services['fos_elastica.index.cmsproduct.product'] : $this->get('fos_elastica.index.cmsproduct.product')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmsproduct.product']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmsproduct.product'] : $this->getFosElastica_ElasticaToModelTransformer_Cmsproduct_ProductService()) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmstypologies' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_CmstypologiesService()
    {
        return $this->services['fos_elastica.finder.cmstypologies'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmstypologies']) ? $this->services['fos_elastica.index.cmstypologies'] : $this->get('fos_elastica.index.cmstypologies')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.collection.cmstypologies']) ? $this->services['fos_elastica.elastica_to_model_transformer.collection.cmstypologies'] : $this->get('fos_elastica.elastica_to_model_transformer.collection.cmstypologies')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.finder.cmstypologies.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFosElastica_Finder_Cmstypologies_ModelService()
    {
        return $this->services['fos_elastica.finder.cmstypologies.model'] = new \FOS\ElasticaBundle\Finder\TransformedFinder(${($_ = isset($this->services['fos_elastica.index.cmstypologies.model']) ? $this->services['fos_elastica.index.cmstypologies.model'] : $this->get('fos_elastica.index.cmstypologies.model')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.elastica_to_model_transformer.cmstypologies.model']) ? $this->services['fos_elastica.elastica_to_model_transformer.cmstypologies.model'] : $this->getFosElastica_ElasticaToModelTransformer_Cmstypologies_ModelService()) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.in_place_pager_persister' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\InPlacePagerPersister
     */
    protected function getFosElastica_InPlacePagerPersisterService()
    {
        return $this->services['fos_elastica.in_place_pager_persister'] = new \FOS\ElasticaBundle\Persister\InPlacePagerPersister(${($_ = isset($this->services['fos_elastica.persister_registry']) ? $this->services['fos_elastica.persister_registry'] : $this->get('fos_elastica.persister_registry')) && false ?: '_'}, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.index.cmsmodel' shared service.
     *
     * @return \FOS\ElasticaBundle\Elastica\Index
     */
    protected function getFosElastica_Index_CmsmodelService()
    {
        return $this->services['fos_elastica.index.cmsmodel'] = ${($_ = isset($this->services['fos_elastica.client.default']) ? $this->services['fos_elastica.client.default'] : $this->get('fos_elastica.client.default')) && false ?: '_'}->getIndex('cmsmodel');
    }

    /**
     * Gets the public 'fos_elastica.index.cmsmodel.model' shared service.
     *
     * @return \Elastica\Type
     */
    protected function getFosElastica_Index_Cmsmodel_ModelService()
    {
        return $this->services['fos_elastica.index.cmsmodel.model'] = ${($_ = isset($this->services['fos_elastica.index.cmsmodel']) ? $this->services['fos_elastica.index.cmsmodel'] : $this->get('fos_elastica.index.cmsmodel')) && false ?: '_'}->getType('model');
    }

    /**
     * Gets the public 'fos_elastica.index.cmsproduct' shared service.
     *
     * @return \FOS\ElasticaBundle\Elastica\Index
     */
    protected function getFosElastica_Index_CmsproductService()
    {
        return $this->services['fos_elastica.index.cmsproduct'] = ${($_ = isset($this->services['fos_elastica.client.default']) ? $this->services['fos_elastica.client.default'] : $this->get('fos_elastica.client.default')) && false ?: '_'}->getIndex('cmsproduct');
    }

    /**
     * Gets the public 'fos_elastica.index.cmsproduct.product' shared service.
     *
     * @return \Elastica\Type
     */
    protected function getFosElastica_Index_Cmsproduct_ProductService()
    {
        return $this->services['fos_elastica.index.cmsproduct.product'] = ${($_ = isset($this->services['fos_elastica.index.cmsproduct']) ? $this->services['fos_elastica.index.cmsproduct'] : $this->get('fos_elastica.index.cmsproduct')) && false ?: '_'}->getType('product');
    }

    /**
     * Gets the public 'fos_elastica.index.cmstypologies' shared service.
     *
     * @return \FOS\ElasticaBundle\Elastica\Index
     */
    protected function getFosElastica_Index_CmstypologiesService()
    {
        return $this->services['fos_elastica.index.cmstypologies'] = ${($_ = isset($this->services['fos_elastica.client.default']) ? $this->services['fos_elastica.client.default'] : $this->get('fos_elastica.client.default')) && false ?: '_'}->getIndex('cmstypologies');
    }

    /**
     * Gets the public 'fos_elastica.index.cmstypologies.model' shared service.
     *
     * @return \Elastica\Type
     */
    protected function getFosElastica_Index_Cmstypologies_ModelService()
    {
        return $this->services['fos_elastica.index.cmstypologies.model'] = ${($_ = isset($this->services['fos_elastica.index.cmstypologies']) ? $this->services['fos_elastica.index.cmstypologies'] : $this->get('fos_elastica.index.cmstypologies')) && false ?: '_'}->getType('model');
    }

    /**
     * Gets the public 'fos_elastica.index_manager' shared service.
     *
     * @return \FOS\ElasticaBundle\Index\IndexManager
     */
    protected function getFosElastica_IndexManagerService()
    {
        $a = ${($_ = isset($this->services['fos_elastica.index.cmsproduct']) ? $this->services['fos_elastica.index.cmsproduct'] : $this->get('fos_elastica.index.cmsproduct')) && false ?: '_'};

        return $this->services['fos_elastica.index_manager'] = new \FOS\ElasticaBundle\Index\IndexManager(array('cmsproduct' => $a, 'cmsmodel' => ${($_ = isset($this->services['fos_elastica.index.cmsmodel']) ? $this->services['fos_elastica.index.cmsmodel'] : $this->get('fos_elastica.index.cmsmodel')) && false ?: '_'}, 'cmstypologies' => ${($_ = isset($this->services['fos_elastica.index.cmstypologies']) ? $this->services['fos_elastica.index.cmstypologies'] : $this->get('fos_elastica.index.cmstypologies')) && false ?: '_'}), $a);
    }

    /**
     * Gets the public 'fos_elastica.indexable' shared service.
     *
     * @return \FOS\ElasticaBundle\Provider\Indexable
     */
    protected function getFosElastica_IndexableService()
    {
        $this->services['fos_elastica.indexable'] = $instance = new \FOS\ElasticaBundle\Provider\Indexable(array());

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.logger' shared service.
     *
     * @return \FOS\ElasticaBundle\Logger\ElasticaLogger
     */
    protected function getFosElastica_LoggerService()
    {
        return $this->services['fos_elastica.logger'] = new \FOS\ElasticaBundle\Logger\ElasticaLogger(${($_ = isset($this->services['monolog.logger.elastica']) ? $this->services['monolog.logger.elastica'] : $this->get('monolog.logger.elastica', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'fos_elastica.manager.orm' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\RepositoryManager
     */
    protected function getFosElastica_Manager_OrmService()
    {
        $this->services['fos_elastica.manager.orm'] = $instance = new \FOS\ElasticaBundle\Doctrine\RepositoryManager(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.repository_manager']) ? $this->services['fos_elastica.repository_manager'] : $this->get('fos_elastica.repository_manager')) && false ?: '_'});

        $instance->addEntity('AppBundle\\Entity\\Product', 'cmsproduct/product');
        $instance->addEntity('AppBundle\\Entity\\Model', 'cmsmodel/model');
        $instance->addEntity('AppBundle\\Entity\\Typology', 'cmstypologies/model');

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.mapping_builder' shared service.
     *
     * @return \FOS\ElasticaBundle\Index\MappingBuilder
     */
    protected function getFosElastica_MappingBuilderService()
    {
        return $this->services['fos_elastica.mapping_builder'] = new \FOS\ElasticaBundle\Index\MappingBuilder();
    }

    /**
     * Gets the public 'fos_elastica.object_persister.cmsmodel.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\ObjectPersister
     */
    protected function getFosElastica_ObjectPersister_Cmsmodel_ModelService()
    {
        $a = new \FOS\ElasticaBundle\Transformer\ModelToElasticaAutoTransformer(array('identifier' => 'id'), ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
        $a->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $this->services['fos_elastica.object_persister.cmsmodel.model'] = new \FOS\ElasticaBundle\Persister\ObjectPersister(${($_ = isset($this->services['fos_elastica.index.cmsmodel.model']) ? $this->services['fos_elastica.index.cmsmodel.model'] : $this->get('fos_elastica.index.cmsmodel.model')) && false ?: '_'}, $a, 'AppBundle\\Entity\\Model', array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'bulletPoints' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'longDescription' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'technicalSpecifications' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'synonyms' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'alphaCheckModel' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'searchTagTerms' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'price' => array('type' => 'float'), 'dateImport' => array('type' => 'date'), 'dateRelease' => array('type' => 'date'), 'isTop' => array('type' => 'integer'), 'subcategory.id' => array('type' => 'integer', 'property_path' => 'getSubcategoryOrNull'), 'trademark.id' => array('property_path' => 'getTrademarkOrNull'), 'trademark.name' => array('type' => 'string', 'property_path' => 'getTrademarkNameOrNull'), 'subcategory.name' => array('type' => 'string', 'property_path' => 'getSubcategoryNameOrNull'), 'subcategory.singularNameUrl' => array('type' => 'string', 'property_path' => 'getSubcategorySingularNameOrNull'), 'typology.id' => array('property_path' => 'getTypologyOrNull'), 'typology.name' => array('type' => 'string', 'property_path' => 'getTypologyNameOrNull'), 'typology.singularNameUrl' => array('type' => 'string', 'property_path' => 'getTypologySingularNameOrNull'), 'typology.synonyms' => array('type' => 'string', 'property_path' => 'getTypologySynonymsNameOrNull'), 'externalTecnicalTemplate.tecnicalIde' => array('type' => 'string', 'property_path' => 'getExternalTecnicalTemplateIde'), 'externalTecnicalTemplate.tecnicalPm' => array('type' => 'string', 'property_path' => 'getExternalTecnicalTemplatePm')));
    }

    /**
     * Gets the public 'fos_elastica.object_persister.cmsproduct.product' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\ObjectPersister
     */
    protected function getFosElastica_ObjectPersister_Cmsproduct_ProductService()
    {
        $a = new \FOS\ElasticaBundle\Transformer\ModelToElasticaAutoTransformer(array('identifier' => 'id'), ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
        $a->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $this->services['fos_elastica.object_persister.cmsproduct.product'] = new \FOS\ElasticaBundle\Persister\ObjectPersister(${($_ = isset($this->services['fos_elastica.index.cmsproduct.product']) ? $this->services['fos_elastica.index.cmsproduct.product'] : $this->get('fos_elastica.index.cmsproduct.product')) && false ?: '_'}, $a, 'AppBundle\\Entity\\Product', array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions'), 'price' => array('type' => 'float'), 'colors' => array('type' => 'string'), 'sizes' => array('type' => 'string'), 'dataImport' => array('type' => 'date'), 'sex.id' => array('type' => 'integer', 'property_path' => 'getSexOrNull'), 'category.id' => array('type' => 'integer', 'property_path' => 'getCategoryOrNull'), 'subcategory.id' => array('type' => 'integer', 'property_path' => 'getSubcategoryOrNull'), 'subcategory.isTop' => array('type' => 'integer', 'property_path' => 'getSubcategoryIsTopOrNull'), 'typology.id' => array('property_path' => 'getTypologyOrNull'), 'trademark.id' => array('property_path' => 'getTrademarkOrNull'), 'priorityImg.img' => array('type' => 'string', 'property_path' => 'getPriorityImgOrNull'), 'priorityImg.widthSmall' => array('type' => 'integer', 'property_path' => 'getPriorityImgWidthSmallOrNull'), 'priorityImg.heightSmall' => array('type' => 'integer', 'property_path' => 'getPriorityImgHeightSmallOrNull'), 'subcategory.name' => array('type' => 'string', 'property_path' => 'getSubcategoryNameOrNull'), 'subcategory.singularNameUrl' => array('type' => 'string', 'property_path' => 'getSubcategorySingularNameOrNull'), 'typology.name' => array('type' => 'string', 'property_path' => 'getTypologyNameOrNull'), 'typology.singularNameUrl' => array('type' => 'string', 'property_path' => 'getTypologySingularNameOrNull'), 'typology.synonyms' => array('type' => 'string', 'property_path' => 'getTypologySynonymsNameOrNull')));
    }

    /**
     * Gets the public 'fos_elastica.object_persister.cmstypologies.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\ObjectPersister
     */
    protected function getFosElastica_ObjectPersister_Cmstypologies_ModelService()
    {
        $a = new \FOS\ElasticaBundle\Transformer\ModelToElasticaAutoTransformer(array('identifier' => 'id'), ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
        $a->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $this->services['fos_elastica.object_persister.cmstypologies.model'] = new \FOS\ElasticaBundle\Persister\ObjectPersister(${($_ = isset($this->services['fos_elastica.index.cmstypologies.model']) ? $this->services['fos_elastica.index.cmstypologies.model'] : $this->get('fos_elastica.index.cmstypologies.model')) && false ?: '_'}, $a, 'AppBundle\\Entity\\Typology', array('name' => array('type' => 'string', 'analyzer' => 'my_analyzer', 'index_options' => 'positions')));
    }

    /**
     * Gets the public 'fos_elastica.pager_persister_registry' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\PagerPersisterRegistry
     */
    protected function getFosElastica_PagerPersisterRegistryService()
    {
        $this->services['fos_elastica.pager_persister_registry'] = $instance = new \FOS\ElasticaBundle\Persister\PagerPersisterRegistry(array('in_place' => 'fos_elastica.in_place_pager_persister'));

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.pager_provider_registry' shared service.
     *
     * @return \FOS\ElasticaBundle\Provider\PagerProviderRegistry
     */
    protected function getFosElastica_PagerProviderRegistryService()
    {
        $this->services['fos_elastica.pager_provider_registry'] = $instance = new \FOS\ElasticaBundle\Provider\PagerProviderRegistry(array());

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.paginator.subscriber' shared service.
     *
     * @return \FOS\ElasticaBundle\Subscriber\PaginateElasticaQuerySubscriber
     */
    protected function getFosElastica_Paginator_SubscriberService()
    {
        $this->services['fos_elastica.paginator.subscriber'] = $instance = new \FOS\ElasticaBundle\Subscriber\PaginateElasticaQuerySubscriber();

        $instance->setRequest(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.persister_registry' shared service.
     *
     * @return \FOS\ElasticaBundle\Persister\PersisterRegistry
     */
    protected function getFosElastica_PersisterRegistryService()
    {
        $this->services['fos_elastica.persister_registry'] = $instance = new \FOS\ElasticaBundle\Persister\PersisterRegistry(array('cmsproduct' => array('product' => 'fos_elastica.object_persister.cmsproduct.product'), 'cmsmodel' => array('model' => 'fos_elastica.object_persister.cmsmodel.model'), 'cmstypologies' => array('model' => 'fos_elastica.object_persister.cmstypologies.model')));

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.property_accessor' shared service.
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getFosElastica_PropertyAccessorService()
    {
        return $this->services['fos_elastica.property_accessor'] = new \Symfony\Component\PropertyAccess\PropertyAccessor(false, false);
    }

    /**
     * Gets the public 'fos_elastica.provider.cmsmodel.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\Provider
     */
    protected function getFosElastica_Provider_Cmsmodel_ModelService()
    {
        return $this->services['fos_elastica.provider.cmsmodel.model'] = new \FOS\ElasticaBundle\Doctrine\ORM\Provider(${($_ = isset($this->services['fos_elastica.object_persister.cmsmodel.model']) ? $this->services['fos_elastica.object_persister.cmsmodel.model'] : $this->get('fos_elastica.object_persister.cmsmodel.model')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.indexable']) ? $this->services['fos_elastica.indexable'] : $this->get('fos_elastica.indexable')) && false ?: '_'}, 'AppBundle\\Entity\\Model', array('query_builder_method' => 'getAllModelsFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false, 'indexName' => 'cmsmodel', 'typeName' => 'model'), ${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.slice_fetcher.orm']) ? $this->services['fos_elastica.slice_fetcher.orm'] : $this->get('fos_elastica.slice_fetcher.orm')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.provider.cmsproduct.product' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\Provider
     */
    protected function getFosElastica_Provider_Cmsproduct_ProductService()
    {
        return $this->services['fos_elastica.provider.cmsproduct.product'] = new \FOS\ElasticaBundle\Doctrine\ORM\Provider(${($_ = isset($this->services['fos_elastica.object_persister.cmsproduct.product']) ? $this->services['fos_elastica.object_persister.cmsproduct.product'] : $this->get('fos_elastica.object_persister.cmsproduct.product')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.indexable']) ? $this->services['fos_elastica.indexable'] : $this->get('fos_elastica.indexable')) && false ?: '_'}, 'AppBundle\\Entity\\Product', array('query_builder_method' => 'getAllProductsFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false, 'indexName' => 'cmsproduct', 'typeName' => 'product'), ${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.slice_fetcher.orm']) ? $this->services['fos_elastica.slice_fetcher.orm'] : $this->get('fos_elastica.slice_fetcher.orm')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.provider.cmstypologies.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\Provider
     */
    protected function getFosElastica_Provider_Cmstypologies_ModelService()
    {
        return $this->services['fos_elastica.provider.cmstypologies.model'] = new \FOS\ElasticaBundle\Doctrine\ORM\Provider(${($_ = isset($this->services['fos_elastica.object_persister.cmstypologies.model']) ? $this->services['fos_elastica.object_persister.cmstypologies.model'] : $this->get('fos_elastica.object_persister.cmstypologies.model')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.indexable']) ? $this->services['fos_elastica.indexable'] : $this->get('fos_elastica.indexable')) && false ?: '_'}, 'AppBundle\\Entity\\Typology', array('query_builder_method' => 'getAllTypologiesFosElastica', 'batch_size' => 5000, 'debug_logging' => true, 'clear_object_manager' => true, 'pager_provider' => false, 'indexName' => 'cmstypologies', 'typeName' => 'model'), ${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.slice_fetcher.orm']) ? $this->services['fos_elastica.slice_fetcher.orm'] : $this->get('fos_elastica.slice_fetcher.orm')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.provider_registry' shared service.
     *
     * @return \FOS\ElasticaBundle\Provider\ProviderRegistry
     */
    protected function getFosElastica_ProviderRegistryService()
    {
        $this->services['fos_elastica.provider_registry'] = $instance = new \FOS\ElasticaBundle\Provider\ProviderRegistry();

        $instance->setContainer($this);
        $instance->addProvider('cmsproduct', 'product', 'fos_elastica.provider.cmsproduct.product');
        $instance->addProvider('cmsmodel', 'model', 'fos_elastica.provider.cmsmodel.model');
        $instance->addProvider('cmstypologies', 'model', 'fos_elastica.provider.cmstypologies.model');

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.repository_manager' shared service.
     *
     * @return \FOS\ElasticaBundle\Manager\RepositoryManager
     */
    protected function getFosElastica_RepositoryManagerService()
    {
        $this->services['fos_elastica.repository_manager'] = $instance = new \FOS\ElasticaBundle\Manager\RepositoryManager();

        $instance->addType('cmsproduct/product', ${($_ = isset($this->services['fos_elastica.finder.cmsproduct.product']) ? $this->services['fos_elastica.finder.cmsproduct.product'] : $this->get('fos_elastica.finder.cmsproduct.product')) && false ?: '_'});
        $instance->addType('cmsmodel/model', ${($_ = isset($this->services['fos_elastica.finder.cmsmodel.model']) ? $this->services['fos_elastica.finder.cmsmodel.model'] : $this->get('fos_elastica.finder.cmsmodel.model')) && false ?: '_'});
        $instance->addType('cmstypologies/model', ${($_ = isset($this->services['fos_elastica.finder.cmstypologies.model']) ? $this->services['fos_elastica.finder.cmstypologies.model'] : $this->get('fos_elastica.finder.cmstypologies.model')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'fos_elastica.resetter' shared service.
     *
     * @return \FOS\ElasticaBundle\Index\Resetter
     */
    protected function getFosElastica_ResetterService()
    {
        return $this->services['fos_elastica.resetter'] = new \FOS\ElasticaBundle\Index\Resetter(${($_ = isset($this->services['fos_elastica.config_manager']) ? $this->services['fos_elastica.config_manager'] : $this->get('fos_elastica.config_manager')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.index_manager']) ? $this->services['fos_elastica.index_manager'] : $this->get('fos_elastica.index_manager')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.alias_processor']) ? $this->services['fos_elastica.alias_processor'] : $this->get('fos_elastica.alias_processor')) && false ?: '_'}, ${($_ = isset($this->services['fos_elastica.mapping_builder']) ? $this->services['fos_elastica.mapping_builder'] : $this->get('fos_elastica.mapping_builder')) && false ?: '_'}, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});
    }

    /**
     * Gets the public 'fos_elastica.slice_fetcher.orm' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\SliceFetcher
     */
    protected function getFosElastica_SliceFetcher_OrmService()
    {
        return $this->services['fos_elastica.slice_fetcher.orm'] = new \FOS\ElasticaBundle\Doctrine\ORM\SliceFetcher();
    }

    /**
     * Gets the public 'fragment.handler' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DependencyInjection\LazyLoadingFragmentHandler
     */
    protected function getFragment_HandlerService()
    {
        return $this->services['fragment.handler'] = new \Symfony\Component\HttpKernel\DependencyInjection\LazyLoadingFragmentHandler(${($_ = isset($this->services['service_locator.3368f0f4075960b08010e4ebdaedef01']) ? $this->services['service_locator.3368f0f4075960b08010e4ebdaedef01'] : $this->getServiceLocator_3368f0f4075960b08010e4ebdaedef01Service()) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'fragment.listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\FragmentListener
     */
    protected function getFragment_ListenerService()
    {
        return $this->services['fragment.listener'] = new \Symfony\Component\HttpKernel\EventListener\FragmentListener(${($_ = isset($this->services['uri_signer']) ? $this->services['uri_signer'] : $this->get('uri_signer')) && false ?: '_'}, '/_fragment');
    }

    /**
     * Gets the public 'fragment.renderer.esi' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Fragment\EsiFragmentRenderer
     */
    protected function getFragment_Renderer_EsiService()
    {
        $this->services['fragment.renderer.esi'] = $instance = new \Symfony\Component\HttpKernel\Fragment\EsiFragmentRenderer(${($_ = isset($this->services['esi']) ? $this->services['esi'] : $this->get('esi', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['fragment.renderer.inline']) ? $this->services['fragment.renderer.inline'] : $this->get('fragment.renderer.inline')) && false ?: '_'}, ${($_ = isset($this->services['uri_signer']) ? $this->services['uri_signer'] : $this->get('uri_signer')) && false ?: '_'});

        $instance->setFragmentPath('/_fragment');

        return $instance;
    }

    /**
     * Gets the public 'fragment.renderer.hinclude' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Fragment\HIncludeFragmentRenderer
     */
    protected function getFragment_Renderer_HincludeService()
    {
        $this->services['fragment.renderer.hinclude'] = $instance = new \Symfony\Component\HttpKernel\Fragment\HIncludeFragmentRenderer(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['uri_signer']) ? $this->services['uri_signer'] : $this->get('uri_signer')) && false ?: '_'}, NULL);

        $instance->setFragmentPath('/_fragment');

        return $instance;
    }

    /**
     * Gets the public 'fragment.renderer.inline' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Fragment\InlineFragmentRenderer
     */
    protected function getFragment_Renderer_InlineService()
    {
        $this->services['fragment.renderer.inline'] = $instance = new \Symfony\Component\HttpKernel\Fragment\InlineFragmentRenderer(${($_ = isset($this->services['http_kernel']) ? $this->services['http_kernel'] : $this->get('http_kernel')) && false ?: '_'}, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});

        $instance->setFragmentPath('/_fragment');

        return $instance;
    }

    /**
     * Gets the public 'http_kernel' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    protected function getHttpKernelService()
    {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel(${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'}, ${($_ = isset($this->services['debug.controller_resolver']) ? $this->services['debug.controller_resolver'] : $this->get('debug.controller_resolver')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, ${($_ = isset($this->services['debug.argument_resolver']) ? $this->services['debug.argument_resolver'] : $this->get('debug.argument_resolver')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer' shared service.
     *
     * @return \JMS\Serializer\Serializer
     */
    protected function getJmsSerializerService()
    {
        $a = new \Metadata\MetadataFactory(new \Metadata\Driver\LazyLoadingDriver($this, 'jms_serializer.metadata_driver'), 'Metadata\\ClassHierarchyMetadata', true);
        $a->setCache(new \Metadata\Cache\FileCache((__DIR__.'/jms_serializer')));

        $b = new \JMS\Serializer\EventDispatcher\LazyEventDispatcher(new \Symfony\Component\DependencyInjection\ServiceLocator(array('jms_serializer.doctrine_proxy_subscriber' => function () {
            return ${($_ = isset($this->services['jms_serializer.doctrine_proxy_subscriber']) ? $this->services['jms_serializer.doctrine_proxy_subscriber'] : $this->get('jms_serializer.doctrine_proxy_subscriber')) && false ?: '_'};
        }, 'jms_serializer.stopwatch_subscriber' => function () {
            return ${($_ = isset($this->services['jms_serializer.stopwatch_subscriber']) ? $this->services['jms_serializer.stopwatch_subscriber'] : $this->get('jms_serializer.stopwatch_subscriber')) && false ?: '_'};
        })));
        $b->setListeners(array('serializer.pre_serialize' => array(0 => array(0 => array(0 => 'jms_serializer.stopwatch_subscriber', 1 => 'onPreSerialize'), 1 => NULL, 2 => NULL), 1 => array(0 => array(0 => 'jms_serializer.doctrine_proxy_subscriber', 1 => 'onPreSerializeTypedProxy'), 1 => NULL, 2 => NULL), 2 => array(0 => array(0 => 'jms_serializer.doctrine_proxy_subscriber', 1 => 'onPreSerialize'), 1 => NULL, 2 => NULL)), 'serializer.post_serialize' => array(0 => array(0 => array(0 => 'jms_serializer.stopwatch_subscriber', 1 => 'onPostSerialize'), 1 => NULL, 2 => NULL))));

        $this->services['jms_serializer'] = $instance = new \JMS\Serializer\Serializer($a, ${($_ = isset($this->services['jms_serializer.handler_registry']) ? $this->services['jms_serializer.handler_registry'] : $this->get('jms_serializer.handler_registry')) && false ?: '_'}, ${($_ = isset($this->services['jms_serializer.unserialize_object_constructor']) ? $this->services['jms_serializer.unserialize_object_constructor'] : $this->getJmsSerializer_UnserializeObjectConstructorService()) && false ?: '_'}, new \PhpCollection\Map(array('json' => ${($_ = isset($this->services['jms_serializer.json_serialization_visitor']) ? $this->services['jms_serializer.json_serialization_visitor'] : $this->get('jms_serializer.json_serialization_visitor')) && false ?: '_'}, 'xml' => ${($_ = isset($this->services['jms_serializer.xml_serialization_visitor']) ? $this->services['jms_serializer.xml_serialization_visitor'] : $this->get('jms_serializer.xml_serialization_visitor')) && false ?: '_'}, 'yml' => ${($_ = isset($this->services['jms_serializer.yaml_serialization_visitor']) ? $this->services['jms_serializer.yaml_serialization_visitor'] : $this->get('jms_serializer.yaml_serialization_visitor')) && false ?: '_'})), new \PhpCollection\Map(array('json' => ${($_ = isset($this->services['jms_serializer.json_deserialization_visitor']) ? $this->services['jms_serializer.json_deserialization_visitor'] : $this->get('jms_serializer.json_deserialization_visitor')) && false ?: '_'}, 'xml' => ${($_ = isset($this->services['jms_serializer.xml_deserialization_visitor']) ? $this->services['jms_serializer.xml_deserialization_visitor'] : $this->get('jms_serializer.xml_deserialization_visitor')) && false ?: '_'})), $b, NULL, ${($_ = isset($this->services['jms_serializer.expression_evaluator']) ? $this->services['jms_serializer.expression_evaluator'] : $this->get('jms_serializer.expression_evaluator')) && false ?: '_'});

        $instance->setSerializationContextFactory(${($_ = isset($this->services['jms_serializer.serialization_context_factory']) ? $this->services['jms_serializer.serialization_context_factory'] : $this->get('jms_serializer.serialization_context_factory')) && false ?: '_'});
        $instance->setDeserializationContextFactory(${($_ = isset($this->services['jms_serializer.deserialization_context_factory']) ? $this->services['jms_serializer.deserialization_context_factory'] : $this->get('jms_serializer.deserialization_context_factory')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.accessor_strategy' shared service.
     *
     * @return \JMS\Serializer\Accessor\ExpressionAccessorStrategy
     */
    protected function getJmsSerializer_AccessorStrategyService()
    {
        return $this->services['jms_serializer.accessor_strategy'] = new \JMS\Serializer\Accessor\ExpressionAccessorStrategy(${($_ = isset($this->services['jms_serializer.expression_evaluator']) ? $this->services['jms_serializer.expression_evaluator'] : $this->get('jms_serializer.expression_evaluator')) && false ?: '_'}, new \JMS\Serializer\Accessor\DefaultAccessorStrategy());
    }

    /**
     * Gets the public 'jms_serializer.array_collection_handler' shared service.
     *
     * @return \JMS\Serializer\Handler\ArrayCollectionHandler
     */
    protected function getJmsSerializer_ArrayCollectionHandlerService()
    {
        return $this->services['jms_serializer.array_collection_handler'] = new \JMS\Serializer\Handler\ArrayCollectionHandler(false);
    }

    /**
     * Gets the public 'jms_serializer.constraint_violation_handler' shared service.
     *
     * @return \JMS\Serializer\Handler\ConstraintViolationHandler
     */
    protected function getJmsSerializer_ConstraintViolationHandlerService()
    {
        return $this->services['jms_serializer.constraint_violation_handler'] = new \JMS\Serializer\Handler\ConstraintViolationHandler();
    }

    /**
     * Gets the public 'jms_serializer.datetime_handler' shared service.
     *
     * @return \JMS\Serializer\Handler\DateHandler
     */
    protected function getJmsSerializer_DatetimeHandlerService()
    {
        return $this->services['jms_serializer.datetime_handler'] = new \JMS\Serializer\Handler\DateHandler('Y-m-d\\TH:i:sP', 'UTC', true);
    }

    /**
     * Gets the public 'jms_serializer.deserialization_context_factory' shared service.
     *
     * @return \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory
     */
    protected function getJmsSerializer_DeserializationContextFactoryService()
    {
        return $this->services['jms_serializer.deserialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory();
    }

    /**
     * Gets the public 'jms_serializer.doctrine_proxy_subscriber' shared service.
     *
     * @return \JMS\Serializer\EventDispatcher\Subscriber\DoctrineProxySubscriber
     */
    protected function getJmsSerializer_DoctrineProxySubscriberService()
    {
        return $this->services['jms_serializer.doctrine_proxy_subscriber'] = new \JMS\Serializer\EventDispatcher\Subscriber\DoctrineProxySubscriber(true, false);
    }

    /**
     * Gets the public 'jms_serializer.expression_evaluator' shared service.
     *
     * @return \JMS\Serializer\Expression\ExpressionEvaluator
     */
    protected function getJmsSerializer_ExpressionEvaluatorService()
    {
        $a = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage();
        $a->registerProvider(new \JMS\SerializerBundle\ExpressionLanguage\BasicSerializerFunctionsProvider());

        return $this->services['jms_serializer.expression_evaluator'] = new \JMS\Serializer\Expression\ExpressionEvaluator($a, array('container' => $this));
    }

    /**
     * Gets the public 'jms_serializer.form_error_handler' shared service.
     *
     * @return \JMS\Serializer\Handler\FormErrorHandler
     */
    protected function getJmsSerializer_FormErrorHandlerService()
    {
        return $this->services['jms_serializer.form_error_handler'] = new \JMS\Serializer\Handler\FormErrorHandler(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, 'validators');
    }

    /**
     * Gets the public 'jms_serializer.handler_registry' shared service.
     *
     * @return \JMS\Serializer\Handler\LazyHandlerRegistry
     */
    protected function getJmsSerializer_HandlerRegistryService()
    {
        return $this->services['jms_serializer.handler_registry'] = new \JMS\Serializer\Handler\LazyHandlerRegistry(new \Symfony\Component\DependencyInjection\ServiceLocator(array('jms_serializer.array_collection_handler' => function () {
            return ${($_ = isset($this->services['jms_serializer.array_collection_handler']) ? $this->services['jms_serializer.array_collection_handler'] : $this->get('jms_serializer.array_collection_handler')) && false ?: '_'};
        }, 'jms_serializer.constraint_violation_handler' => function () {
            return ${($_ = isset($this->services['jms_serializer.constraint_violation_handler']) ? $this->services['jms_serializer.constraint_violation_handler'] : $this->get('jms_serializer.constraint_violation_handler')) && false ?: '_'};
        }, 'jms_serializer.datetime_handler' => function () {
            return ${($_ = isset($this->services['jms_serializer.datetime_handler']) ? $this->services['jms_serializer.datetime_handler'] : $this->get('jms_serializer.datetime_handler')) && false ?: '_'};
        }, 'jms_serializer.form_error_handler' => function () {
            return ${($_ = isset($this->services['jms_serializer.form_error_handler']) ? $this->services['jms_serializer.form_error_handler'] : $this->get('jms_serializer.form_error_handler')) && false ?: '_'};
        }, 'jms_serializer.php_collection_handler' => function () {
            return ${($_ = isset($this->services['jms_serializer.php_collection_handler']) ? $this->services['jms_serializer.php_collection_handler'] : $this->get('jms_serializer.php_collection_handler')) && false ?: '_'};
        })), array(2 => array('DateTime' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromjson'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromxml'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromyml')), 'DateTimeImmutable' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromjson'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromxml'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromyml')), 'DateInterval' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromjson'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromxml'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromyml')), 'ArrayCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection')), 'Doctrine\\Common\\Collections\\ArrayCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection')), 'Doctrine\\ORM\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection')), 'Doctrine\\ODM\\MongoDB\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection')), 'Doctrine\\ODM\\PHPCR\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection')), 'PhpCollection\\Sequence' => array('json' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence'), 'xml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence'), 'yml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence')), 'PhpCollection\\Map' => array('json' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap'), 'xml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap'), 'yml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap'))), 1 => array('DateTime' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime')), 'DateTimeImmutable' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable')), 'DateInterval' => array('json' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval'), 'xml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval'), 'yml' => array(0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval')), 'ArrayCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection')), 'Doctrine\\Common\\Collections\\ArrayCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection')), 'Doctrine\\ORM\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection')), 'Doctrine\\ODM\\MongoDB\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection')), 'Doctrine\\ODM\\PHPCR\\PersistentCollection' => array('json' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'xml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'), 'yml' => array(0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection')), 'PhpCollection\\Sequence' => array('json' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence'), 'xml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence'), 'yml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence')), 'PhpCollection\\Map' => array('json' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap'), 'xml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap'), 'yml' => array(0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap')), 'Symfony\\Component\\Form\\Form' => array('xml' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormToxml'), 'json' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormTojson'), 'yml' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormToyml')), 'Symfony\\Component\\Form\\FormError' => array('xml' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormErrorToxml'), 'json' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormErrorTojson'), 'yml' => array(0 => 'jms_serializer.form_error_handler', 1 => 'serializeFormErrorToyml')), 'Symfony\\Component\\Validator\\ConstraintViolationList' => array('xml' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListToxml'), 'json' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListTojson'), 'yml' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListToyml')), 'Symfony\\Component\\Validator\\ConstraintViolation' => array('xml' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationToxml'), 'json' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationTojson'), 'yml' => array(0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationToyml')))));
    }

    /**
     * Gets the public 'jms_serializer.json_deserialization_visitor' shared service.
     *
     * @return \JMS\Serializer\JsonDeserializationVisitor
     */
    protected function getJmsSerializer_JsonDeserializationVisitorService()
    {
        return $this->services['jms_serializer.json_deserialization_visitor'] = new \JMS\Serializer\JsonDeserializationVisitor(${($_ = isset($this->services['jms_serializer.naming_strategy']) ? $this->services['jms_serializer.naming_strategy'] : $this->get('jms_serializer.naming_strategy')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer.json_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\JsonSerializationVisitor
     */
    protected function getJmsSerializer_JsonSerializationVisitorService()
    {
        $this->services['jms_serializer.json_serialization_visitor'] = $instance = new \JMS\Serializer\JsonSerializationVisitor(${($_ = isset($this->services['jms_serializer.naming_strategy']) ? $this->services['jms_serializer.naming_strategy'] : $this->get('jms_serializer.naming_strategy')) && false ?: '_'}, ${($_ = isset($this->services['jms_serializer.accessor_strategy']) ? $this->services['jms_serializer.accessor_strategy'] : $this->get('jms_serializer.accessor_strategy')) && false ?: '_'});

        $instance->setOptions(0);

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.metadata_driver' shared service.
     *
     * @return \JMS\Serializer\Metadata\Driver\DoctrineTypeDriver
     */
    protected function getJmsSerializer_MetadataDriverService()
    {
        $a = new \Metadata\Driver\FileLocator(array());

        return $this->services['jms_serializer.metadata_driver'] = new \JMS\Serializer\Metadata\Driver\DoctrineTypeDriver(new \Metadata\Driver\DriverChain(array(0 => new \JMS\Serializer\Metadata\Driver\YamlDriver($a), 1 => new \JMS\Serializer\Metadata\Driver\XmlDriver($a), 2 => new \JMS\Serializer\Metadata\Driver\PhpDriver($a), 3 => new \JMS\Serializer\Metadata\Driver\AnnotationDriver(${($_ = isset($this->services['annotation_reader']) ? $this->services['annotation_reader'] : $this->get('annotation_reader')) && false ?: '_'}))), ${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer.naming_strategy' shared service.
     *
     * @return \JMS\Serializer\Naming\CacheNamingStrategy
     */
    protected function getJmsSerializer_NamingStrategyService()
    {
        return $this->services['jms_serializer.naming_strategy'] = new \JMS\Serializer\Naming\CacheNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\CamelCaseNamingStrategy('_', true)));
    }

    /**
     * Gets the public 'jms_serializer.object_constructor' shared service.
     *
     * @return \JMS\Serializer\Construction\DoctrineObjectConstructor
     */
    protected function getJmsSerializer_ObjectConstructorService()
    {
        return $this->services['jms_serializer.object_constructor'] = new \JMS\Serializer\Construction\DoctrineObjectConstructor(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, ${($_ = isset($this->services['jms_serializer.unserialize_object_constructor']) ? $this->services['jms_serializer.unserialize_object_constructor'] : $this->getJmsSerializer_UnserializeObjectConstructorService()) && false ?: '_'}, 'null');
    }

    /**
     * Gets the public 'jms_serializer.php_collection_handler' shared service.
     *
     * @return \JMS\Serializer\Handler\PhpCollectionHandler
     */
    protected function getJmsSerializer_PhpCollectionHandlerService()
    {
        return $this->services['jms_serializer.php_collection_handler'] = new \JMS\Serializer\Handler\PhpCollectionHandler();
    }

    /**
     * Gets the public 'jms_serializer.serialization_context_factory' shared service.
     *
     * @return \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory
     */
    protected function getJmsSerializer_SerializationContextFactoryService()
    {
        return $this->services['jms_serializer.serialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory();
    }

    /**
     * Gets the public 'jms_serializer.stopwatch_subscriber' shared service.
     *
     * @return \JMS\SerializerBundle\Serializer\StopwatchEventSubscriber
     */
    protected function getJmsSerializer_StopwatchSubscriberService()
    {
        return $this->services['jms_serializer.stopwatch_subscriber'] = new \JMS\SerializerBundle\Serializer\StopwatchEventSubscriber(${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer.templating.helper.serializer' shared service.
     *
     * @return \JMS\SerializerBundle\Templating\SerializerHelper
     */
    protected function getJmsSerializer_Templating_Helper_SerializerService()
    {
        return $this->services['jms_serializer.templating.helper.serializer'] = new \JMS\SerializerBundle\Templating\SerializerHelper(${($_ = isset($this->services['jms_serializer']) ? $this->services['jms_serializer'] : $this->get('jms_serializer')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer.twig_extension.serializer_runtime_helper' shared service.
     *
     * @return \JMS\Serializer\Twig\SerializerRuntimeHelper
     */
    protected function getJmsSerializer_TwigExtension_SerializerRuntimeHelperService()
    {
        return $this->services['jms_serializer.twig_extension.serializer_runtime_helper'] = new \JMS\Serializer\Twig\SerializerRuntimeHelper(${($_ = isset($this->services['jms_serializer']) ? $this->services['jms_serializer'] : $this->get('jms_serializer')) && false ?: '_'});
    }

    /**
     * Gets the public 'jms_serializer.xml_deserialization_visitor' shared service.
     *
     * @return \JMS\Serializer\XmlDeserializationVisitor
     */
    protected function getJmsSerializer_XmlDeserializationVisitorService()
    {
        $this->services['jms_serializer.xml_deserialization_visitor'] = $instance = new \JMS\Serializer\XmlDeserializationVisitor(${($_ = isset($this->services['jms_serializer.naming_strategy']) ? $this->services['jms_serializer.naming_strategy'] : $this->get('jms_serializer.naming_strategy')) && false ?: '_'});

        $instance->setDoctypeWhitelist(array());

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.xml_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\XmlSerializationVisitor
     */
    protected function getJmsSerializer_XmlSerializationVisitorService()
    {
        $this->services['jms_serializer.xml_serialization_visitor'] = $instance = new \JMS\Serializer\XmlSerializationVisitor(${($_ = isset($this->services['jms_serializer.naming_strategy']) ? $this->services['jms_serializer.naming_strategy'] : $this->get('jms_serializer.naming_strategy')) && false ?: '_'}, ${($_ = isset($this->services['jms_serializer.accessor_strategy']) ? $this->services['jms_serializer.accessor_strategy'] : $this->get('jms_serializer.accessor_strategy')) && false ?: '_'});

        $instance->setFormatOutput(true);

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.yaml_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\YamlSerializationVisitor
     */
    protected function getJmsSerializer_YamlSerializationVisitorService()
    {
        return $this->services['jms_serializer.yaml_serialization_visitor'] = new \JMS\Serializer\YamlSerializationVisitor(${($_ = isset($this->services['jms_serializer.naming_strategy']) ? $this->services['jms_serializer.naming_strategy'] : $this->get('jms_serializer.naming_strategy')) && false ?: '_'}, ${($_ = isset($this->services['jms_serializer.accessor_strategy']) ? $this->services['jms_serializer.accessor_strategy'] : $this->get('jms_serializer.accessor_strategy')) && false ?: '_'});
    }

    /**
     * Gets the public 'kernel.class_cache.cache_warmer' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\CacheWarmer\ClassCacheCacheWarmer
     *
     * @deprecated The "kernel.class_cache.cache_warmer" option is deprecated since version 3.3, to be removed in 4.0.
     */
    protected function getKernel_ClassCache_CacheWarmerService()
    {
        @trigger_error('The "kernel.class_cache.cache_warmer" option is deprecated since version 3.3, to be removed in 4.0.', E_USER_DEPRECATED);

        return $this->services['kernel.class_cache.cache_warmer'] = new \Symfony\Bundle\FrameworkBundle\CacheWarmer\ClassCacheCacheWarmer(array(0 => 'Symfony\\Component\\HttpFoundation\\ParameterBag', 1 => 'Symfony\\Component\\HttpFoundation\\HeaderBag', 2 => 'Symfony\\Component\\HttpFoundation\\FileBag', 3 => 'Symfony\\Component\\HttpFoundation\\ServerBag', 4 => 'Symfony\\Component\\HttpFoundation\\Request', 5 => 'Symfony\\Component\\HttpKernel\\Kernel'));
    }

    /**
     * Gets the public 'livescoreServices.compressFilesService' shared service.
     *
     * @return \AppBundle\Service\CompressFilesService\CompressFilesService
     */
    protected function getLivescoreServices_CompressFilesServiceService()
    {
        return $this->services['livescoreServices.compressFilesService'] = new \AppBundle\Service\CompressFilesService\CompressFilesService($this, ${($_ = isset($this->services['app.dependencyManager']) ? $this->services['app.dependencyManager'] : $this->get('app.dependencyManager')) && false ?: '_'}, ${($_ = isset($this->services['app.globalUtility']) ? $this->services['app.globalUtility'] : $this->get('app.globalUtility')) && false ?: '_'});
    }

    /**
     * Gets the public 'livescoreServices.sendDataToApp' shared service.
     *
     * @return \AppBundle\Service\AppService\ParseRestClient
     */
    protected function getLivescoreServices_SendDataToAppService()
    {
        return $this->services['livescoreServices.sendDataToApp'] = new \AppBundle\Service\AppService\ParseRestClient(${($_ = isset($this->services['logger']) ? $this->services['logger'] : $this->get('logger')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'livescoreServices.utilityApp' shared service.
     *
     * @return \AppBundle\Service\AppService\UtilityApp
     */
    protected function getLivescoreServices_UtilityAppService()
    {
        return $this->services['livescoreServices.utilityApp'] = new \AppBundle\Service\AppService\UtilityApp(${($_ = isset($this->services['logger']) ? $this->services['logger'] : $this->get('logger')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'});
    }

    /**
     * Gets the public 'livescoreServices.videoapi' shared service.
     *
     * @return \AppBundle\Service\VideoApiService\VideoApiService
     */
    protected function getLivescoreServices_VideoapiService()
    {
        return $this->services['livescoreServices.videoapi'] = new \AppBundle\Service\VideoApiService\VideoApiService(${($_ = isset($this->services['logger']) ? $this->services['logger'] : $this->get('logger')) && false ?: '_'}, ${($_ = isset($this->services['doctrine.orm.default_entity_manager']) ? $this->services['doctrine.orm.default_entity_manager'] : $this->get('doctrine.orm.default_entity_manager')) && false ?: '_'}, $this);
    }

    /**
     * Gets the public 'locale_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleListener
     */
    protected function getLocaleListenerService()
    {
        return $this->services['locale_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleListener(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, 'it', ${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'logger' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getLoggerService()
    {
        $this->services['logger'] = $instance = new \Symfony\Bridge\Monolog\Logger('app');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->useMicrosecondTimestamps(true);
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'mobile_detect.device_view' shared service.
     *
     * @return \SunCat\MobileDetectBundle\Helper\DeviceView
     */
    protected function getMobileDetect_DeviceViewService()
    {
        $this->services['mobile_detect.device_view'] = $instance = new \SunCat\MobileDetectBundle\Helper\DeviceView(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});

        $instance->setCookieKey('device_view');
        $instance->setCookiePath('/');
        $instance->setCookieDomain('');
        $instance->setCookieSecure(false);
        $instance->setCookieHttpOnly(true);
        $instance->setSwitchParam('device_view');
        $instance->setCookieExpireDatetimeModifier('1 month');
        $instance->setRedirectConfig(array('mobile' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'tablet' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'full' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'detect_tablet_as_mobile' => false));

        return $instance;
    }

    /**
     * Gets the public 'mobile_detect.mobile_detector.default' shared service.
     *
     * @return \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector
     */
    protected function getMobileDetect_MobileDetector_DefaultService()
    {
        return $this->services['mobile_detect.mobile_detector.default'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector();
    }

    /**
     * Gets the public 'mobile_detect.request_listener' shared service.
     *
     * @return \SunCat\MobileDetectBundle\EventListener\RequestResponseListener
     */
    protected function getMobileDetect_RequestListenerService()
    {
        return $this->services['mobile_detect.request_listener'] = new \SunCat\MobileDetectBundle\EventListener\RequestResponseListener(${($_ = isset($this->services['mobile_detect.mobile_detector.default']) ? $this->services['mobile_detect.mobile_detector.default'] : $this->get('mobile_detect.mobile_detector.default')) && false ?: '_'}, ${($_ = isset($this->services['mobile_detect.device_view']) ? $this->services['mobile_detect.device_view'] : $this->get('mobile_detect.device_view')) && false ?: '_'}, ${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router')) && false ?: '_'}, array('mobile' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'tablet' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'full' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'detect_tablet_as_mobile' => false), true);
    }

    /**
     * Gets the public 'mobile_detect.twig.extension' shared service.
     *
     * @return \SunCat\MobileDetectBundle\Twig\Extension\MobileDetectExtension
     */
    protected function getMobileDetect_Twig_ExtensionService()
    {
        $this->services['mobile_detect.twig.extension'] = $instance = new \SunCat\MobileDetectBundle\Twig\Extension\MobileDetectExtension(${($_ = isset($this->services['mobile_detect.mobile_detector.default']) ? $this->services['mobile_detect.mobile_detector.default'] : $this->get('mobile_detect.mobile_detector.default')) && false ?: '_'}, ${($_ = isset($this->services['mobile_detect.device_view']) ? $this->services['mobile_detect.device_view'] : $this->get('mobile_detect.device_view')) && false ?: '_'}, array('mobile' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'tablet' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'full' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'detect_tablet_as_mobile' => false));

        $instance->setRequestByRequestStack(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'mobile_detect_bundle.device.collector' shared service.
     *
     * @return \SunCat\MobileDetectBundle\DataCollector\DeviceDataCollector
     */
    protected function getMobileDetectBundle_Device_CollectorService()
    {
        $this->services['mobile_detect_bundle.device.collector'] = $instance = new \SunCat\MobileDetectBundle\DataCollector\DeviceDataCollector(${($_ = isset($this->services['mobile_detect.device_view']) ? $this->services['mobile_detect.device_view'] : $this->get('mobile_detect.device_view')) && false ?: '_'});

        $instance->setRedirectConfig(array('mobile' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'tablet' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'full' => array('is_enabled' => false, 'host' => NULL, 'status_code' => 302, 'action' => 'redirect'), 'detect_tablet_as_mobile' => false));

        return $instance;
    }

    /**
     * Gets the public 'monolog.handler.console' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Handler\ConsoleHandler
     */
    protected function getMonolog_Handler_ConsoleService()
    {
        $this->services['monolog.handler.console'] = $instance = new \Symfony\Bridge\Monolog\Handler\ConsoleHandler(NULL, false, array(64 => 200, 128 => 100, 32 => 300, 256 => 100));

        $instance->pushProcessor(${($_ = isset($this->services['monolog.processor.psr_log_message']) ? $this->services['monolog.processor.psr_log_message'] : $this->getMonolog_Processor_PsrLogMessageService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.handler.console_very_verbose' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Handler\ConsoleHandler
     */
    protected function getMonolog_Handler_ConsoleVeryVerboseService()
    {
        $this->services['monolog.handler.console_very_verbose'] = $instance = new \Symfony\Bridge\Monolog\Handler\ConsoleHandler(NULL, false, array(64 => 250, 128 => 250, 256 => 100, 32 => 300));

        $instance->pushProcessor(${($_ = isset($this->services['monolog.processor.psr_log_message']) ? $this->services['monolog.processor.psr_log_message'] : $this->getMonolog_Processor_PsrLogMessageService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.handler.main' shared service.
     *
     * @return \Monolog\Handler\StreamHandler
     */
    protected function getMonolog_Handler_MainService()
    {
        $this->services['monolog.handler.main'] = $instance = new \Monolog\Handler\StreamHandler(($this->targetDirs[2].'/logs/dev.log'), 400, true, NULL);

        $instance->pushProcessor(${($_ = isset($this->services['monolog.processor.psr_log_message']) ? $this->services['monolog.processor.psr_log_message'] : $this->getMonolog_Processor_PsrLogMessageService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.handler.null_internal' shared service.
     *
     * @return \Monolog\Handler\NullHandler
     */
    protected function getMonolog_Handler_NullInternalService()
    {
        return $this->services['monolog.handler.null_internal'] = new \Monolog\Handler\NullHandler();
    }

    /**
     * Gets the public 'monolog.logger.cache' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_CacheService()
    {
        $this->services['monolog.logger.cache'] = $instance = new \Symfony\Bridge\Monolog\Logger('cache');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.console' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_ConsoleService()
    {
        $this->services['monolog.logger.console'] = $instance = new \Symfony\Bridge\Monolog\Logger('console');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.doctrine' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_DoctrineService()
    {
        $this->services['monolog.logger.doctrine'] = $instance = new \Symfony\Bridge\Monolog\Logger('doctrine');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console_very_verbose']) ? $this->services['monolog.handler.console_very_verbose'] : $this->get('monolog.handler.console_very_verbose')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.elastica' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_ElasticaService()
    {
        $this->services['monolog.logger.elastica'] = $instance = new \Symfony\Bridge\Monolog\Logger('elastica');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.event' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_EventService()
    {
        $this->services['monolog.logger.event'] = $instance = new \Symfony\Bridge\Monolog\Logger('event');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.php' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_PhpService()
    {
        $this->services['monolog.logger.php'] = $instance = new \Symfony\Bridge\Monolog\Logger('php');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.profiler' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_ProfilerService()
    {
        $this->services['monolog.logger.profiler'] = $instance = new \Symfony\Bridge\Monolog\Logger('profiler');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.request' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_RequestService()
    {
        $this->services['monolog.logger.request'] = $instance = new \Symfony\Bridge\Monolog\Logger('request');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.security' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_SecurityService()
    {
        $this->services['monolog.logger.security'] = $instance = new \Symfony\Bridge\Monolog\Logger('security');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.snc_redis' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_SncRedisService()
    {
        $this->services['monolog.logger.snc_redis'] = $instance = new \Symfony\Bridge\Monolog\Logger('snc_redis');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.templating' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_TemplatingService()
    {
        $this->services['monolog.logger.templating'] = $instance = new \Symfony\Bridge\Monolog\Logger('templating');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'monolog.logger.translation' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_TranslationService()
    {
        $this->services['monolog.logger.translation'] = $instance = new \Symfony\Bridge\Monolog\Logger('translation');

        $instance->pushProcessor(${($_ = isset($this->services['debug.log_processor']) ? $this->services['debug.log_processor'] : $this->getDebug_LogProcessorService()) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.console']) ? $this->services['monolog.handler.console'] : $this->get('monolog.handler.console')) && false ?: '_'});
        $instance->pushHandler(${($_ = isset($this->services['monolog.handler.main']) ? $this->services['monolog.handler.main'] : $this->get('monolog.handler.main')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'profiler' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    protected function getProfilerService()
    {
        $a = ${($_ = isset($this->services['monolog.logger.profiler']) ? $this->services['monolog.logger.profiler'] : $this->get('monolog.logger.profiler', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};
        $b = ${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};

        $c = new \Symfony\Component\Cache\DataCollector\CacheDataCollector();
        $c->addInstance('cache.app', ${($_ = isset($this->services['cache.app']) ? $this->services['cache.app'] : $this->get('cache.app')) && false ?: '_'});
        $c->addInstance('cache.system', ${($_ = isset($this->services['cache.system']) ? $this->services['cache.system'] : $this->get('cache.system')) && false ?: '_'});
        $c->addInstance('cache.validator', ${($_ = isset($this->services['cache.validator']) ? $this->services['cache.validator'] : $this->getCache_ValidatorService()) && false ?: '_'});
        $c->addInstance('cache.serializer', new \Symfony\Component\Cache\Adapter\TraceableAdapter(${($_ = isset($this->services['cache.serializer.recorder_inner']) ? $this->services['cache.serializer.recorder_inner'] : $this->getCache_Serializer_RecorderInnerService()) && false ?: '_'}));
        $c->addInstance('cache.annotations', ${($_ = isset($this->services['cache.annotations']) ? $this->services['cache.annotations'] : $this->getCache_AnnotationsService()) && false ?: '_'});

        $d = new \Doctrine\Bundle\DoctrineBundle\DataCollector\DoctrineDataCollector(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'});
        $d->addLogger('default', ${($_ = isset($this->services['doctrine.dbal.logger.profiling.default']) ? $this->services['doctrine.dbal.logger.profiling.default'] : $this->getDoctrine_Dbal_Logger_Profiling_DefaultService()) && false ?: '_'});

        $e = new \Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector();
        if ($this->has('kernel')) {
            $e->setKernel($b);
        }

        $this->services['profiler'] = $instance = new \Symfony\Component\HttpKernel\Profiler\Profiler(${($_ = isset($this->services['profiler.storage']) ? $this->services['profiler.storage'] : $this->get('profiler.storage')) && false ?: '_'}, $a);

        $instance->add(${($_ = isset($this->services['data_collector.request']) ? $this->services['data_collector.request'] : $this->get('data_collector.request')) && false ?: '_'});
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\TimeDataCollector($b, ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}));
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector());
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector());
        $instance->add(${($_ = isset($this->services['data_collector.form']) ? $this->services['data_collector.form'] : $this->get('data_collector.form')) && false ?: '_'});
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector());
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector($a, (__DIR__.'/appDevDebugProjectContainer')));
        $instance->add(new \Symfony\Component\HttpKernel\DataCollector\EventDataCollector(${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}));
        $instance->add(${($_ = isset($this->services['data_collector.router']) ? $this->services['data_collector.router'] : $this->get('data_collector.router')) && false ?: '_'});
        $instance->add($c);
        $instance->add(${($_ = isset($this->services['data_collector.translation']) ? $this->services['data_collector.translation'] : $this->get('data_collector.translation')) && false ?: '_'});
        $instance->add(new \Symfony\Bundle\SecurityBundle\DataCollector\SecurityDataCollector(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['security.role_hierarchy']) ? $this->services['security.role_hierarchy'] : $this->getSecurity_RoleHierarchyService()) && false ?: '_'}, ${($_ = isset($this->services['security.logout_url_generator']) ? $this->services['security.logout_url_generator'] : $this->getSecurity_LogoutUrlGeneratorService()) && false ?: '_'}, ${($_ = isset($this->services['debug.security.access.decision_manager']) ? $this->services['debug.security.access.decision_manager'] : $this->getDebug_Security_Access_DecisionManagerService()) && false ?: '_'}, ${($_ = isset($this->services['security.firewall.map']) ? $this->services['security.firewall.map'] : $this->getSecurity_Firewall_MapService()) && false ?: '_'}));
        $instance->add(new \Symfony\Bridge\Twig\DataCollector\TwigDataCollector(${($_ = isset($this->services['twig.profile']) ? $this->services['twig.profile'] : $this->get('twig.profile')) && false ?: '_'}));
        $instance->add($d);
        $instance->add(new \Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector($this));
        $instance->add(${($_ = isset($this->services['data_collector.dump']) ? $this->services['data_collector.dump'] : $this->get('data_collector.dump')) && false ?: '_'});
        $instance->add(${($_ = isset($this->services['mobile_detect_bundle.device.collector']) ? $this->services['mobile_detect_bundle.device.collector'] : $this->get('mobile_detect_bundle.device.collector')) && false ?: '_'});
        $instance->add(new \Snc\RedisBundle\DataCollector\RedisDataCollector(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'}));
        $instance->add(${($_ = isset($this->services['fos_elastica.data_collector']) ? $this->services['fos_elastica.data_collector'] : $this->get('fos_elastica.data_collector')) && false ?: '_'});
        $instance->add($e);

        return $instance;
    }

    /**
     * Gets the public 'profiler.storage' shared service.
     *
     * @return \Snc\RedisBundle\Profiler\Storage\RedisProfilerStorage
     */
    protected function getProfiler_StorageService()
    {
        return $this->services['profiler.storage'] = new \Snc\RedisBundle\Profiler\Storage\RedisProfilerStorage(${($_ = isset($this->services['snc_redis.profiler_storage']) ? $this->services['snc_redis.profiler_storage'] : $this->get('snc_redis.profiler_storage')) && false ?: '_'}, 3600);
    }

    /**
     * Gets the public 'profiler_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ProfilerListener
     */
    protected function getProfilerListenerService()
    {
        return $this->services['profiler_listener'] = new \Symfony\Component\HttpKernel\EventListener\ProfilerListener(${($_ = isset($this->services['profiler']) ? $this->services['profiler'] : $this->get('profiler')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, NULL, false, false);
    }

    /**
     * Gets the public 'property_accessor' shared service.
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessorService()
    {
        return $this->services['property_accessor'] = new \Symfony\Component\PropertyAccess\PropertyAccessor(false, false, new \Symfony\Component\Cache\Adapter\ArrayAdapter(0, false));
    }

    /**
     * Gets the public 'request_stack' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getRequestStackService()
    {
        return $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack();
    }

    /**
     * Gets the public 'response_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ResponseListener
     */
    protected function getResponseListenerService()
    {
        return $this->services['response_listener'] = new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8');
    }

    /**
     * Gets the public 'router' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected function getRouterService()
    {
        $this->services['router'] = $instance = new \Symfony\Bundle\FrameworkBundle\Routing\Router($this, ($this->targetDirs[3].'/app/config/routing_dev.yml'), array('cache_dir' => __DIR__, 'debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'appDevDebugProjectContainerUrlGenerator', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_base_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'appDevDebugProjectContainerUrlMatcher', 'strict_requirements' => true), ${($_ = isset($this->services['router.request_context']) ? $this->services['router.request_context'] : $this->getRouter_RequestContextService()) && false ?: '_'});

        $instance->setConfigCacheFactory(${($_ = isset($this->services['config_cache_factory']) ? $this->services['config_cache_factory'] : $this->get('config_cache_factory')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'router_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\RouterListener
     */
    protected function getRouterListenerService()
    {
        return $this->services['router_listener'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener(${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'}, ${($_ = isset($this->services['router.request_context']) ? $this->services['router.request_context'] : $this->getRouter_RequestContextService()) && false ?: '_'}, ${($_ = isset($this->services['monolog.logger.request']) ? $this->services['monolog.logger.request'] : $this->get('monolog.logger.request', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'routing.loader' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader
     */
    protected function getRouting_LoaderService()
    {
        $a = ${($_ = isset($this->services['file_locator']) ? $this->services['file_locator'] : $this->get('file_locator')) && false ?: '_'};
        $b = ${($_ = isset($this->services['annotation_reader']) ? $this->services['annotation_reader'] : $this->get('annotation_reader')) && false ?: '_'};

        $c = new \Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader($b);

        $d = new \Symfony\Component\Config\Loader\LoaderResolver();
        $d->addLoader(new \Symfony\Component\Routing\Loader\XmlFileLoader($a));
        $d->addLoader(new \Symfony\Component\Routing\Loader\YamlFileLoader($a));
        $d->addLoader(new \Symfony\Component\Routing\Loader\PhpFileLoader($a));
        $d->addLoader(new \Symfony\Component\Config\Loader\GlobFileLoader($a));
        $d->addLoader(new \Symfony\Component\Routing\Loader\DirectoryLoader($a));
        $d->addLoader(new \Symfony\Component\Routing\Loader\DependencyInjection\ServiceRouterLoader($this));
        $d->addLoader($c);
        $d->addLoader(new \Symfony\Component\Routing\Loader\AnnotationDirectoryLoader($a, $c));
        $d->addLoader(new \Symfony\Component\Routing\Loader\AnnotationFileLoader($a, $c));

        return $this->services['routing.loader'] = new \Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader(${($_ = isset($this->services['controller_name_converter']) ? $this->services['controller_name_converter'] : $this->getControllerNameConverterService()) && false ?: '_'}, $d);
    }

    /**
     * Gets the public 'security.authentication.guard_handler' shared service.
     *
     * @return \Symfony\Component\Security\Guard\GuardAuthenticatorHandler
     */
    protected function getSecurity_Authentication_GuardHandlerService()
    {
        return $this->services['security.authentication.guard_handler'] = new \Symfony\Component\Security\Guard\GuardAuthenticatorHandler(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage')) && false ?: '_'}, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'security.authentication_utils' shared service.
     *
     * @return \Symfony\Component\Security\Http\Authentication\AuthenticationUtils
     */
    protected function getSecurity_AuthenticationUtilsService()
    {
        return $this->services['security.authentication_utils'] = new \Symfony\Component\Security\Http\Authentication\AuthenticationUtils(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'});
    }

    /**
     * Gets the public 'security.authorization_checker' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected function getSecurity_AuthorizationCheckerService()
    {
        return $this->services['security.authorization_checker'] = new \Symfony\Component\Security\Core\Authorization\AuthorizationChecker(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage')) && false ?: '_'}, ${($_ = isset($this->services['security.authentication.manager']) ? $this->services['security.authentication.manager'] : $this->getSecurity_Authentication_ManagerService()) && false ?: '_'}, ${($_ = isset($this->services['debug.security.access.decision_manager']) ? $this->services['debug.security.access.decision_manager'] : $this->getDebug_Security_Access_DecisionManagerService()) && false ?: '_'}, false);
    }

    /**
     * Gets the public 'security.csrf.token_manager' shared service.
     *
     * @return \Symfony\Component\Security\Csrf\CsrfTokenManager
     */
    protected function getSecurity_Csrf_TokenManagerService()
    {
        return $this->services['security.csrf.token_manager'] = new \Symfony\Component\Security\Csrf\CsrfTokenManager(new \Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator(), new \Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage(${($_ = isset($this->services['session']) ? $this->services['session'] : $this->get('session')) && false ?: '_'}), ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'security.encoder_factory' shared service.
     *
     * @return \Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    protected function getSecurity_EncoderFactoryService()
    {
        return $this->services['security.encoder_factory'] = new \Symfony\Component\Security\Core\Encoder\EncoderFactory(array());
    }

    /**
     * Gets the public 'security.firewall' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\EventListener\FirewallListener
     */
    protected function getSecurity_FirewallService()
    {
        return $this->services['security.firewall'] = new \Symfony\Bundle\SecurityBundle\EventListener\FirewallListener(${($_ = isset($this->services['security.firewall.map']) ? $this->services['security.firewall.map'] : $this->getSecurity_Firewall_MapService()) && false ?: '_'}, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'}, ${($_ = isset($this->services['security.logout_url_generator']) ? $this->services['security.logout_url_generator'] : $this->getSecurity_LogoutUrlGeneratorService()) && false ?: '_'});
    }

    /**
     * Gets the public 'security.firewall.map.context.dev' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallContext
     */
    protected function getSecurity_Firewall_Map_Context_DevService()
    {
        return $this->services['security.firewall.map.context.dev'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallContext(array(), NULL, new \Symfony\Bundle\SecurityBundle\Security\FirewallConfig('dev', 'security.user_checker', 'security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d', false, '', '', '', '', '', '', array()));
    }

    /**
     * Gets the public 'security.firewall.map.context.main' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallContext
     */
    protected function getSecurity_Firewall_Map_Context_MainService()
    {
        $a = ${($_ = isset($this->services['monolog.logger.security']) ? $this->services['monolog.logger.security'] : $this->get('monolog.logger.security', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};
        $b = ${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage')) && false ?: '_'};
        $c = ${($_ = isset($this->services['security.authentication.trust_resolver']) ? $this->services['security.authentication.trust_resolver'] : $this->getSecurity_Authentication_TrustResolverService()) && false ?: '_'};
        $d = ${($_ = isset($this->services['security.authentication.manager']) ? $this->services['security.authentication.manager'] : $this->getSecurity_Authentication_ManagerService()) && false ?: '_'};
        $e = ${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};

        $f = new \Symfony\Component\Security\Http\AccessMap();

        return $this->services['security.firewall.map.context.main'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallContext(array(0 => new \Symfony\Component\Security\Http\Firewall\ChannelListener($f, new \Symfony\Component\Security\Http\EntryPoint\RetryAuthenticationEntryPoint(80, 443), $a), 1 => new \Symfony\Component\Security\Http\Firewall\ContextListener($b, array(0 => new \Symfony\Component\Security\Core\User\InMemoryUserProvider(array())), 'main', $a, ${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, $c), 2 => new \Symfony\Component\Security\Http\Firewall\AnonymousAuthenticationListener($b, '650f49e0e6f707.35449910', $a, $d), 3 => new \Symfony\Component\Security\Http\Firewall\AccessListener($b, ${($_ = isset($this->services['debug.security.access.decision_manager']) ? $this->services['debug.security.access.decision_manager'] : $this->getDebug_Security_Access_DecisionManagerService()) && false ?: '_'}, $f, $d)), new \Symfony\Component\Security\Http\Firewall\ExceptionListener($b, $c, new \Symfony\Component\Security\Http\HttpUtils($e, $e, '{^https?://%s$}i'), 'main', NULL, NULL, NULL, $a, false), new \Symfony\Bundle\SecurityBundle\Security\FirewallConfig('main', 'security.user_checker', NULL, true, false, 'security.user.provider.concrete.in_memory', 'main', NULL, NULL, NULL, array(0 => 'anonymous')));
    }

    /**
     * Gets the public 'security.password_encoder' shared service.
     *
     * @return \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
     */
    protected function getSecurity_PasswordEncoderService()
    {
        return $this->services['security.password_encoder'] = new \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder(${($_ = isset($this->services['security.encoder_factory']) ? $this->services['security.encoder_factory'] : $this->get('security.encoder_factory')) && false ?: '_'});
    }

    /**
     * Gets the public 'security.rememberme.response_listener' shared service.
     *
     * @return \Symfony\Component\Security\Http\RememberMe\ResponseListener
     */
    protected function getSecurity_Rememberme_ResponseListenerService()
    {
        return $this->services['security.rememberme.response_listener'] = new \Symfony\Component\Security\Http\RememberMe\ResponseListener();
    }

    /**
     * Gets the public 'security.token_storage' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    protected function getSecurity_TokenStorageService()
    {
        return $this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage();
    }

    /**
     * Gets the public 'security.validator.user_password' shared service.
     *
     * @return \Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator
     */
    protected function getSecurity_Validator_UserPasswordService()
    {
        return $this->services['security.validator.user_password'] = new \Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage')) && false ?: '_'}, ${($_ = isset($this->services['security.encoder_factory']) ? $this->services['security.encoder_factory'] : $this->get('security.encoder_factory')) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_distribution.security_checker' shared service.
     *
     * @return \SensioLabs\Security\SecurityChecker
     */
    protected function getSensioDistribution_SecurityCheckerService()
    {
        return $this->services['sensio_distribution.security_checker'] = new \SensioLabs\Security\SecurityChecker();
    }

    /**
     * Gets the public 'sensio_distribution.security_checker.command' shared service.
     *
     * @return \SensioLabs\Security\Command\SecurityCheckerCommand
     */
    protected function getSensioDistribution_SecurityChecker_CommandService()
    {
        return $this->services['sensio_distribution.security_checker.command'] = new \SensioLabs\Security\Command\SecurityCheckerCommand(${($_ = isset($this->services['sensio_distribution.security_checker']) ? $this->services['sensio_distribution.security_checker'] : $this->get('sensio_distribution.security_checker')) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_framework_extra.cache.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener
     */
    protected function getSensioFrameworkExtra_Cache_ListenerService()
    {
        return $this->services['sensio_framework_extra.cache.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener();
    }

    /**
     * Gets the public 'sensio_framework_extra.controller.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener
     */
    protected function getSensioFrameworkExtra_Controller_ListenerService()
    {
        return $this->services['sensio_framework_extra.controller.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener(${($_ = isset($this->services['annotation_reader']) ? $this->services['annotation_reader'] : $this->get('annotation_reader')) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_framework_extra.converter.datetime' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter
     */
    protected function getSensioFrameworkExtra_Converter_DatetimeService()
    {
        return $this->services['sensio_framework_extra.converter.datetime'] = new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter();
    }

    /**
     * Gets the public 'sensio_framework_extra.converter.doctrine.orm' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter
     */
    protected function getSensioFrameworkExtra_Converter_Doctrine_OrmService()
    {
        return $this->services['sensio_framework_extra.converter.doctrine.orm'] = new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_framework_extra.converter.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener
     */
    protected function getSensioFrameworkExtra_Converter_ListenerService()
    {
        return $this->services['sensio_framework_extra.converter.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener(${($_ = isset($this->services['sensio_framework_extra.converter.manager']) ? $this->services['sensio_framework_extra.converter.manager'] : $this->get('sensio_framework_extra.converter.manager')) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'sensio_framework_extra.converter.manager' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager
     */
    protected function getSensioFrameworkExtra_Converter_ManagerService()
    {
        $this->services['sensio_framework_extra.converter.manager'] = $instance = new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager();

        $instance->add(${($_ = isset($this->services['sensio_framework_extra.converter.doctrine.orm']) ? $this->services['sensio_framework_extra.converter.doctrine.orm'] : $this->get('sensio_framework_extra.converter.doctrine.orm')) && false ?: '_'}, 0, 'doctrine.orm');
        $instance->add(${($_ = isset($this->services['sensio_framework_extra.converter.datetime']) ? $this->services['sensio_framework_extra.converter.datetime'] : $this->get('sensio_framework_extra.converter.datetime')) && false ?: '_'}, 0, 'datetime');

        return $instance;
    }

    /**
     * Gets the public 'sensio_framework_extra.security.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener
     */
    protected function getSensioFrameworkExtra_Security_ListenerService()
    {
        return $this->services['sensio_framework_extra.security.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener(NULL, new \Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage(), ${($_ = isset($this->services['security.authentication.trust_resolver']) ? $this->services['security.authentication.trust_resolver'] : $this->getSecurity_Authentication_TrustResolverService()) && false ?: '_'}, ${($_ = isset($this->services['security.role_hierarchy']) ? $this->services['security.role_hierarchy'] : $this->getSecurity_RoleHierarchyService()) && false ?: '_'}, ${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['security.authorization_checker']) ? $this->services['security.authorization_checker'] : $this->get('security.authorization_checker', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_framework_extra.view.guesser' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser
     */
    protected function getSensioFrameworkExtra_View_GuesserService()
    {
        return $this->services['sensio_framework_extra.view.guesser'] = new \Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser(${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel')) && false ?: '_'});
    }

    /**
     * Gets the public 'sensio_framework_extra.view.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener
     */
    protected function getSensioFrameworkExtra_View_ListenerService()
    {
        return $this->services['sensio_framework_extra.view.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener($this);
    }

    /**
     * Gets the public 'session' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSessionService()
    {
        return $this->services['session'] = new \Symfony\Component\HttpFoundation\Session\Session(${($_ = isset($this->services['session.storage.native']) ? $this->services['session.storage.native'] : $this->get('session.storage.native')) && false ?: '_'}, new \Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag(), new \Symfony\Component\HttpFoundation\Session\Flash\FlashBag());
    }

    /**
     * Gets the public 'session.save_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SaveSessionListener
     */
    protected function getSession_SaveListenerService()
    {
        return $this->services['session.save_listener'] = new \Symfony\Component\HttpKernel\EventListener\SaveSessionListener();
    }

    /**
     * Gets the public 'session.storage.filesystem' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage
     */
    protected function getSession_Storage_FilesystemService()
    {
        return $this->services['session.storage.filesystem'] = new \Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage((__DIR__.'/sessions'), 'MOCKSESSID', ${($_ = isset($this->services['session.storage.metadata_bag']) ? $this->services['session.storage.metadata_bag'] : $this->getSession_Storage_MetadataBagService()) && false ?: '_'});
    }

    /**
     * Gets the public 'session.storage.native' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage
     */
    protected function getSession_Storage_NativeService()
    {
        return $this->services['session.storage.native'] = new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage(array('cookie_httponly' => true, 'gc_probability' => 1), NULL, ${($_ = isset($this->services['session.storage.metadata_bag']) ? $this->services['session.storage.metadata_bag'] : $this->getSession_Storage_MetadataBagService()) && false ?: '_'});
    }

    /**
     * Gets the public 'session.storage.php_bridge' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage
     */
    protected function getSession_Storage_PhpBridgeService()
    {
        return $this->services['session.storage.php_bridge'] = new \Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage(NULL, ${($_ = isset($this->services['session.storage.metadata_bag']) ? $this->services['session.storage.metadata_bag'] : $this->getSession_Storage_MetadataBagService()) && false ?: '_'});
    }

    /**
     * Gets the public 'session_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SessionListener
     */
    protected function getSessionListenerService()
    {
        return $this->services['session_listener'] = new \Symfony\Component\HttpKernel\EventListener\SessionListener(new \Symfony\Component\DependencyInjection\ServiceLocator(array('session' => function () {
            return ${($_ = isset($this->services['session']) ? $this->services['session'] : $this->get('session', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};
        })));
    }

    /**
     * Gets the public 'snc_redis.command.flush_all' shared service.
     *
     * @return \Snc\RedisBundle\Command\RedisFlushallCommand
     */
    protected function getSncRedis_Command_FlushAllService()
    {
        return $this->services['snc_redis.command.flush_all'] = new \Snc\RedisBundle\Command\RedisFlushallCommand();
    }

    /**
     * Gets the public 'snc_redis.command.flush_db' shared service.
     *
     * @return \Snc\RedisBundle\Command\RedisFlushdbCommand
     */
    protected function getSncRedis_Command_FlushDbService()
    {
        return $this->services['snc_redis.command.flush_db'] = new \Snc\RedisBundle\Command\RedisFlushdbCommand();
    }

    /**
     * Gets the public 'snc_redis.logger' shared service.
     *
     * @return \Snc\RedisBundle\Logger\RedisLogger
     */
    protected function getSncRedis_LoggerService()
    {
        return $this->services['snc_redis.logger'] = new \Snc\RedisBundle\Logger\RedisLogger(${($_ = isset($this->services['monolog.logger.snc_redis']) ? $this->services['monolog.logger.snc_redis'] : $this->get('monolog.logger.snc_redis', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'snc_redis.monolog' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_MonologService()
    {
        return $this->services['snc_redis.monolog'] = new \Predis\Client(new \Predis\Connection\Parameters(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => true, 'exceptions' => true, 'logging' => false, 'alias' => 'monolog', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 18, 'database' => 18, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => new \Predis\Profile\RedisVersion320(), 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => true, 'exceptions' => true)));
    }

    /**
     * Gets the public 'snc_redis.profiler_storage' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_ProfilerStorageService()
    {
        return $this->services['snc_redis.profiler_storage'] = new \Predis\Client(new \Predis\Connection\Parameters(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => false, 'alias' => 'profiler_storage', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 17, 'database' => 17, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => new \Predis\Profile\RedisVersion320(), 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true)));
    }

    /**
     * Gets the public 'snc_redis.secondLevelCache' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SecondLevelCacheService()
    {
        $a = new \Predis\Profile\RedisVersion220();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.secondLevelCache'] = new \Predis\Client(new \Predis\Connection\Parameters(array('replication' => false, 'profile' => 2.2, 'read_write_timeout' => 30, 'iterable_multibulk' => false, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 10, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'secondLevelCache', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 15, 'database' => 15, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('replication' => false, 'profile' => $a, 'read_write_timeout' => 30, 'iterable_multibulk' => false, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 10, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'snc_redis.sncredis' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SncredisService()
    {
        $a = new \Predis\Profile\RedisVersion320();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.sncredis'] = new \Predis\Client(new \Predis\Connection\Parameters(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'sncredis', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 11, 'database' => 11, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => $a, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'snc_redis.sncredisDoctrineQueryCache' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SncredisDoctrineQueryCacheService()
    {
        $a = new \Predis\Profile\RedisVersion320();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.sncredisDoctrineQueryCache'] = new \Predis\Client(new \Predis\Connection\Parameters(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'sncredisDoctrineQueryCache', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 14, 'database' => 14, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => $a, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'snc_redis.sncredisDoctrineResult' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SncredisDoctrineResultService()
    {
        $a = new \Predis\Profile\RedisVersion320();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.sncredisDoctrineResult'] = new \Predis\Client(new \Predis\Connection\Parameters(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'sncredisDoctrineResult', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 13, 'database' => 13, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => $a, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'snc_redis.sncredisDoctrinemetadata' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SncredisDoctrinemetadataService()
    {
        $a = new \Predis\Profile\RedisVersion320();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.sncredisDoctrinemetadata'] = new \Predis\Client(new \Predis\Connection\Parameters(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'sncredisDoctrinemetadata', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 12, 'database' => 12, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('replication' => false, 'read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => $a, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'snc_redis.sncredisSessionPhp' shared service.
     *
     * @return \Predis\Client
     */
    protected function getSncRedis_SncredisSessionPhpService()
    {
        $a = new \Predis\Profile\RedisVersion320();

        $b = new \Snc\RedisBundle\Client\Predis\Connection\ConnectionFactory($a);
        $b->setConnectionWrapperClass('Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper');
        $b->setLogger(${($_ = isset($this->services['snc_redis.logger']) ? $this->services['snc_redis.logger'] : $this->get('snc_redis.logger')) && false ?: '_'});

        return $this->services['snc_redis.sncredisSessionPhp'] = new \Predis\Client(new \Predis\Connection\Parameters(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => 'default', 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'logging' => true, 'alias' => 'sncredisSessionPhp', 'scheme' => 'tcp', 'host' => '172.24.0.6', 'port' => 6379, 'path' => 16, 'database' => 16, 'password' => NULL, 'weight' => NULL)), new \Predis\Configuration\Options(array('read_write_timeout' => NULL, 'iterable_multibulk' => false, 'profile' => $a, 'prefix' => NULL, 'service' => NULL, 'async_connect' => false, 'timeout' => 5, 'persistent' => false, 'exceptions' => true, 'connections' => $b)));
    }

    /**
     * Gets the public 'streamed_response_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener
     */
    protected function getStreamedResponseListenerService()
    {
        return $this->services['streamed_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener();
    }

    /**
     * Gets the public 'swiftmailer.email_sender.listener' shared service.
     *
     * @return \Symfony\Bundle\SwiftmailerBundle\EventListener\EmailSenderListener
     */
    protected function getSwiftmailer_EmailSender_ListenerService()
    {
        return $this->services['swiftmailer.email_sender.listener'] = new \Symfony\Bundle\SwiftmailerBundle\EventListener\EmailSenderListener($this, ${($_ = isset($this->services['logger']) ? $this->services['logger'] : $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'swiftmailer.mailer.default' shared service.
     *
     * @return \Swift_Mailer
     */
    protected function getSwiftmailer_Mailer_DefaultService()
    {
        return $this->services['swiftmailer.mailer.default'] = new \Swift_Mailer(${($_ = isset($this->services['swiftmailer.mailer.default.transport']) ? $this->services['swiftmailer.mailer.default.transport'] : $this->get('swiftmailer.mailer.default.transport')) && false ?: '_'});
    }

    /**
     * Gets the public 'swiftmailer.mailer.default.plugin.messagelogger' shared service.
     *
     * @return \Swift_Plugins_MessageLogger
     */
    protected function getSwiftmailer_Mailer_Default_Plugin_MessageloggerService()
    {
        return $this->services['swiftmailer.mailer.default.plugin.messagelogger'] = new \Swift_Plugins_MessageLogger();
    }

    /**
     * Gets the public 'swiftmailer.mailer.default.spool' shared service.
     *
     * @return \Swift_MemorySpool
     */
    protected function getSwiftmailer_Mailer_Default_SpoolService()
    {
        return $this->services['swiftmailer.mailer.default.spool'] = new \Swift_MemorySpool();
    }

    /**
     * Gets the public 'swiftmailer.mailer.default.transport' shared service.
     *
     * @return \Swift_Transport_SpoolTransport
     */
    protected function getSwiftmailer_Mailer_Default_TransportService()
    {
        $this->services['swiftmailer.mailer.default.transport'] = $instance = new \Swift_Transport_SpoolTransport(${($_ = isset($this->services['swiftmailer.mailer.default.transport.eventdispatcher']) ? $this->services['swiftmailer.mailer.default.transport.eventdispatcher'] : $this->getSwiftmailer_Mailer_Default_Transport_EventdispatcherService()) && false ?: '_'}, ${($_ = isset($this->services['swiftmailer.mailer.default.spool']) ? $this->services['swiftmailer.mailer.default.spool'] : $this->get('swiftmailer.mailer.default.spool')) && false ?: '_'});

        $instance->registerPlugin(${($_ = isset($this->services['swiftmailer.mailer.default.plugin.messagelogger']) ? $this->services['swiftmailer.mailer.default.plugin.messagelogger'] : $this->get('swiftmailer.mailer.default.plugin.messagelogger')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'swiftmailer.mailer.default.transport.real' shared service.
     *
     * @return \Swift_Transport_EsmtpTransport
     */
    protected function getSwiftmailer_Mailer_Default_Transport_RealService()
    {
        $a = new \Swift_Transport_Esmtp_AuthHandler(array(0 => new \Swift_Transport_Esmtp_Auth_CramMd5Authenticator(), 1 => new \Swift_Transport_Esmtp_Auth_LoginAuthenticator(), 2 => new \Swift_Transport_Esmtp_Auth_PlainAuthenticator()));
        $a->setUsername(NULL);
        $a->setPassword(NULL);
        $a->setAuthMode(NULL);

        $this->services['swiftmailer.mailer.default.transport.real'] = $instance = new \Swift_Transport_EsmtpTransport(new \Swift_Transport_StreamBuffer(new \Swift_StreamFilters_StringReplacementFilterFactory()), array(0 => $a), ${($_ = isset($this->services['swiftmailer.mailer.default.transport.eventdispatcher']) ? $this->services['swiftmailer.mailer.default.transport.eventdispatcher'] : $this->getSwiftmailer_Mailer_Default_Transport_EventdispatcherService()) && false ?: '_'});

        $instance->setHost('127.0.0.1');
        $instance->setPort(25);
        $instance->setEncryption(NULL);
        $instance->setTimeout(30);
        $instance->setSourceIp(NULL);
        (new \Symfony\Bundle\SwiftmailerBundle\DependencyInjection\SmtpTransportConfigurator(NULL, ${($_ = isset($this->services['router.request_context']) ? $this->services['router.request_context'] : $this->getRouter_RequestContextService()) && false ?: '_'}))->configure($instance);

        return $instance;
    }

    /**
     * Gets the public 'templating' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\TwigEngine
     */
    protected function getTemplatingService()
    {
        return $this->services['templating'] = new \Symfony\Bundle\TwigBundle\TwigEngine(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['templating.name_parser']) ? $this->services['templating.name_parser'] : $this->get('templating.name_parser')) && false ?: '_'}, ${($_ = isset($this->services['templating.locator']) ? $this->services['templating.locator'] : $this->getTemplating_LocatorService()) && false ?: '_'});
    }

    /**
     * Gets the public 'templating.filename_parser' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\TemplateFilenameParser
     */
    protected function getTemplating_FilenameParserService()
    {
        return $this->services['templating.filename_parser'] = new \Symfony\Bundle\FrameworkBundle\Templating\TemplateFilenameParser();
    }

    /**
     * Gets the public 'templating.helper.logout_url' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Templating\Helper\LogoutUrlHelper
     */
    protected function getTemplating_Helper_LogoutUrlService()
    {
        return $this->services['templating.helper.logout_url'] = new \Symfony\Bundle\SecurityBundle\Templating\Helper\LogoutUrlHelper(${($_ = isset($this->services['security.logout_url_generator']) ? $this->services['security.logout_url_generator'] : $this->getSecurity_LogoutUrlGeneratorService()) && false ?: '_'});
    }

    /**
     * Gets the public 'templating.helper.security' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Templating\Helper\SecurityHelper
     */
    protected function getTemplating_Helper_SecurityService()
    {
        return $this->services['templating.helper.security'] = new \Symfony\Bundle\SecurityBundle\Templating\Helper\SecurityHelper(${($_ = isset($this->services['security.authorization_checker']) ? $this->services['security.authorization_checker'] : $this->get('security.authorization_checker', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'templating.loader' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\Loader\FilesystemLoader
     */
    protected function getTemplating_LoaderService()
    {
        return $this->services['templating.loader'] = new \Symfony\Bundle\FrameworkBundle\Templating\Loader\FilesystemLoader(${($_ = isset($this->services['templating.locator']) ? $this->services['templating.locator'] : $this->getTemplating_LocatorService()) && false ?: '_'});
    }

    /**
     * Gets the public 'templating.name_parser' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\TemplateNameParser
     */
    protected function getTemplating_NameParserService()
    {
        return $this->services['templating.name_parser'] = new \Symfony\Bundle\FrameworkBundle\Templating\TemplateNameParser(${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel')) && false ?: '_'});
    }

    /**
     * Gets the public 'translation.dumper.csv' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\CsvFileDumper
     */
    protected function getTranslation_Dumper_CsvService()
    {
        return $this->services['translation.dumper.csv'] = new \Symfony\Component\Translation\Dumper\CsvFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.ini' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\IniFileDumper
     */
    protected function getTranslation_Dumper_IniService()
    {
        return $this->services['translation.dumper.ini'] = new \Symfony\Component\Translation\Dumper\IniFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.json' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\JsonFileDumper
     */
    protected function getTranslation_Dumper_JsonService()
    {
        return $this->services['translation.dumper.json'] = new \Symfony\Component\Translation\Dumper\JsonFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.mo' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\MoFileDumper
     */
    protected function getTranslation_Dumper_MoService()
    {
        return $this->services['translation.dumper.mo'] = new \Symfony\Component\Translation\Dumper\MoFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.php' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\PhpFileDumper
     */
    protected function getTranslation_Dumper_PhpService()
    {
        return $this->services['translation.dumper.php'] = new \Symfony\Component\Translation\Dumper\PhpFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.po' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\PoFileDumper
     */
    protected function getTranslation_Dumper_PoService()
    {
        return $this->services['translation.dumper.po'] = new \Symfony\Component\Translation\Dumper\PoFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.qt' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\QtFileDumper
     */
    protected function getTranslation_Dumper_QtService()
    {
        return $this->services['translation.dumper.qt'] = new \Symfony\Component\Translation\Dumper\QtFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.res' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\IcuResFileDumper
     */
    protected function getTranslation_Dumper_ResService()
    {
        return $this->services['translation.dumper.res'] = new \Symfony\Component\Translation\Dumper\IcuResFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.xliff' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\XliffFileDumper
     */
    protected function getTranslation_Dumper_XliffService()
    {
        return $this->services['translation.dumper.xliff'] = new \Symfony\Component\Translation\Dumper\XliffFileDumper();
    }

    /**
     * Gets the public 'translation.dumper.yml' shared service.
     *
     * @return \Symfony\Component\Translation\Dumper\YamlFileDumper
     */
    protected function getTranslation_Dumper_YmlService()
    {
        return $this->services['translation.dumper.yml'] = new \Symfony\Component\Translation\Dumper\YamlFileDumper();
    }

    /**
     * Gets the public 'translation.extractor' shared service.
     *
     * @return \Symfony\Component\Translation\Extractor\ChainExtractor
     */
    protected function getTranslation_ExtractorService()
    {
        $this->services['translation.extractor'] = $instance = new \Symfony\Component\Translation\Extractor\ChainExtractor();

        $instance->addExtractor('php', ${($_ = isset($this->services['translation.extractor.php']) ? $this->services['translation.extractor.php'] : $this->get('translation.extractor.php')) && false ?: '_'});
        $instance->addExtractor('twig', ${($_ = isset($this->services['twig.translation.extractor']) ? $this->services['twig.translation.extractor'] : $this->get('twig.translation.extractor')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'translation.extractor.php' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\PhpExtractor
     */
    protected function getTranslation_Extractor_PhpService()
    {
        return $this->services['translation.extractor.php'] = new \Symfony\Bundle\FrameworkBundle\Translation\PhpExtractor();
    }

    /**
     * Gets the public 'translation.loader' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\TranslationLoader
     */
    protected function getTranslation_LoaderService()
    {
        $a = ${($_ = isset($this->services['translation.loader.xliff']) ? $this->services['translation.loader.xliff'] : $this->get('translation.loader.xliff')) && false ?: '_'};

        $this->services['translation.loader'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\TranslationLoader();

        $instance->addLoader('php', ${($_ = isset($this->services['translation.loader.php']) ? $this->services['translation.loader.php'] : $this->get('translation.loader.php')) && false ?: '_'});
        $instance->addLoader('yml', ${($_ = isset($this->services['translation.loader.yml']) ? $this->services['translation.loader.yml'] : $this->get('translation.loader.yml')) && false ?: '_'});
        $instance->addLoader('xlf', $a);
        $instance->addLoader('xliff', $a);
        $instance->addLoader('po', ${($_ = isset($this->services['translation.loader.po']) ? $this->services['translation.loader.po'] : $this->get('translation.loader.po')) && false ?: '_'});
        $instance->addLoader('mo', ${($_ = isset($this->services['translation.loader.mo']) ? $this->services['translation.loader.mo'] : $this->get('translation.loader.mo')) && false ?: '_'});
        $instance->addLoader('ts', ${($_ = isset($this->services['translation.loader.qt']) ? $this->services['translation.loader.qt'] : $this->get('translation.loader.qt')) && false ?: '_'});
        $instance->addLoader('csv', ${($_ = isset($this->services['translation.loader.csv']) ? $this->services['translation.loader.csv'] : $this->get('translation.loader.csv')) && false ?: '_'});
        $instance->addLoader('res', ${($_ = isset($this->services['translation.loader.res']) ? $this->services['translation.loader.res'] : $this->get('translation.loader.res')) && false ?: '_'});
        $instance->addLoader('dat', ${($_ = isset($this->services['translation.loader.dat']) ? $this->services['translation.loader.dat'] : $this->get('translation.loader.dat')) && false ?: '_'});
        $instance->addLoader('ini', ${($_ = isset($this->services['translation.loader.ini']) ? $this->services['translation.loader.ini'] : $this->get('translation.loader.ini')) && false ?: '_'});
        $instance->addLoader('json', ${($_ = isset($this->services['translation.loader.json']) ? $this->services['translation.loader.json'] : $this->get('translation.loader.json')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'translation.loader.csv' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\CsvFileLoader
     */
    protected function getTranslation_Loader_CsvService()
    {
        return $this->services['translation.loader.csv'] = new \Symfony\Component\Translation\Loader\CsvFileLoader();
    }

    /**
     * Gets the public 'translation.loader.dat' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\IcuDatFileLoader
     */
    protected function getTranslation_Loader_DatService()
    {
        return $this->services['translation.loader.dat'] = new \Symfony\Component\Translation\Loader\IcuDatFileLoader();
    }

    /**
     * Gets the public 'translation.loader.ini' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\IniFileLoader
     */
    protected function getTranslation_Loader_IniService()
    {
        return $this->services['translation.loader.ini'] = new \Symfony\Component\Translation\Loader\IniFileLoader();
    }

    /**
     * Gets the public 'translation.loader.json' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\JsonFileLoader
     */
    protected function getTranslation_Loader_JsonService()
    {
        return $this->services['translation.loader.json'] = new \Symfony\Component\Translation\Loader\JsonFileLoader();
    }

    /**
     * Gets the public 'translation.loader.mo' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\MoFileLoader
     */
    protected function getTranslation_Loader_MoService()
    {
        return $this->services['translation.loader.mo'] = new \Symfony\Component\Translation\Loader\MoFileLoader();
    }

    /**
     * Gets the public 'translation.loader.php' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\PhpFileLoader
     */
    protected function getTranslation_Loader_PhpService()
    {
        return $this->services['translation.loader.php'] = new \Symfony\Component\Translation\Loader\PhpFileLoader();
    }

    /**
     * Gets the public 'translation.loader.po' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\PoFileLoader
     */
    protected function getTranslation_Loader_PoService()
    {
        return $this->services['translation.loader.po'] = new \Symfony\Component\Translation\Loader\PoFileLoader();
    }

    /**
     * Gets the public 'translation.loader.qt' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\QtFileLoader
     */
    protected function getTranslation_Loader_QtService()
    {
        return $this->services['translation.loader.qt'] = new \Symfony\Component\Translation\Loader\QtFileLoader();
    }

    /**
     * Gets the public 'translation.loader.res' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\IcuResFileLoader
     */
    protected function getTranslation_Loader_ResService()
    {
        return $this->services['translation.loader.res'] = new \Symfony\Component\Translation\Loader\IcuResFileLoader();
    }

    /**
     * Gets the public 'translation.loader.xliff' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\XliffFileLoader
     */
    protected function getTranslation_Loader_XliffService()
    {
        return $this->services['translation.loader.xliff'] = new \Symfony\Component\Translation\Loader\XliffFileLoader();
    }

    /**
     * Gets the public 'translation.loader.yml' shared service.
     *
     * @return \Symfony\Component\Translation\Loader\YamlFileLoader
     */
    protected function getTranslation_Loader_YmlService()
    {
        return $this->services['translation.loader.yml'] = new \Symfony\Component\Translation\Loader\YamlFileLoader();
    }

    /**
     * Gets the public 'translation.writer' shared service.
     *
     * @return \Symfony\Component\Translation\Writer\TranslationWriter
     */
    protected function getTranslation_WriterService()
    {
        $this->services['translation.writer'] = $instance = new \Symfony\Component\Translation\Writer\TranslationWriter();

        $instance->addDumper('php', ${($_ = isset($this->services['translation.dumper.php']) ? $this->services['translation.dumper.php'] : $this->get('translation.dumper.php')) && false ?: '_'});
        $instance->addDumper('xlf', ${($_ = isset($this->services['translation.dumper.xliff']) ? $this->services['translation.dumper.xliff'] : $this->get('translation.dumper.xliff')) && false ?: '_'});
        $instance->addDumper('po', ${($_ = isset($this->services['translation.dumper.po']) ? $this->services['translation.dumper.po'] : $this->get('translation.dumper.po')) && false ?: '_'});
        $instance->addDumper('mo', ${($_ = isset($this->services['translation.dumper.mo']) ? $this->services['translation.dumper.mo'] : $this->get('translation.dumper.mo')) && false ?: '_'});
        $instance->addDumper('yml', ${($_ = isset($this->services['translation.dumper.yml']) ? $this->services['translation.dumper.yml'] : $this->get('translation.dumper.yml')) && false ?: '_'});
        $instance->addDumper('ts', ${($_ = isset($this->services['translation.dumper.qt']) ? $this->services['translation.dumper.qt'] : $this->get('translation.dumper.qt')) && false ?: '_'});
        $instance->addDumper('csv', ${($_ = isset($this->services['translation.dumper.csv']) ? $this->services['translation.dumper.csv'] : $this->get('translation.dumper.csv')) && false ?: '_'});
        $instance->addDumper('ini', ${($_ = isset($this->services['translation.dumper.ini']) ? $this->services['translation.dumper.ini'] : $this->get('translation.dumper.ini')) && false ?: '_'});
        $instance->addDumper('json', ${($_ = isset($this->services['translation.dumper.json']) ? $this->services['translation.dumper.json'] : $this->get('translation.dumper.json')) && false ?: '_'});
        $instance->addDumper('res', ${($_ = isset($this->services['translation.dumper.res']) ? $this->services['translation.dumper.res'] : $this->get('translation.dumper.res')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'translator' shared service.
     *
     * @return \Symfony\Component\Translation\DataCollectorTranslator
     */
    protected function getTranslatorService()
    {
        return $this->services['translator'] = new \Symfony\Component\Translation\DataCollectorTranslator(new \Symfony\Component\Translation\LoggingTranslator(${($_ = isset($this->services['translator.default']) ? $this->services['translator.default'] : $this->get('translator.default')) && false ?: '_'}, ${($_ = isset($this->services['monolog.logger.translation']) ? $this->services['monolog.logger.translation'] : $this->get('monolog.logger.translation')) && false ?: '_'}));
    }

    /**
     * Gets the public 'translator.default' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslator_DefaultService()
    {
        $this->services['translator.default'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator(new \Symfony\Component\DependencyInjection\ServiceLocator(array('translation.loader.csv' => function () {
            return ${($_ = isset($this->services['translation.loader.csv']) ? $this->services['translation.loader.csv'] : $this->get('translation.loader.csv')) && false ?: '_'};
        }, 'translation.loader.dat' => function () {
            return ${($_ = isset($this->services['translation.loader.dat']) ? $this->services['translation.loader.dat'] : $this->get('translation.loader.dat')) && false ?: '_'};
        }, 'translation.loader.ini' => function () {
            return ${($_ = isset($this->services['translation.loader.ini']) ? $this->services['translation.loader.ini'] : $this->get('translation.loader.ini')) && false ?: '_'};
        }, 'translation.loader.json' => function () {
            return ${($_ = isset($this->services['translation.loader.json']) ? $this->services['translation.loader.json'] : $this->get('translation.loader.json')) && false ?: '_'};
        }, 'translation.loader.mo' => function () {
            return ${($_ = isset($this->services['translation.loader.mo']) ? $this->services['translation.loader.mo'] : $this->get('translation.loader.mo')) && false ?: '_'};
        }, 'translation.loader.php' => function () {
            return ${($_ = isset($this->services['translation.loader.php']) ? $this->services['translation.loader.php'] : $this->get('translation.loader.php')) && false ?: '_'};
        }, 'translation.loader.po' => function () {
            return ${($_ = isset($this->services['translation.loader.po']) ? $this->services['translation.loader.po'] : $this->get('translation.loader.po')) && false ?: '_'};
        }, 'translation.loader.qt' => function () {
            return ${($_ = isset($this->services['translation.loader.qt']) ? $this->services['translation.loader.qt'] : $this->get('translation.loader.qt')) && false ?: '_'};
        }, 'translation.loader.res' => function () {
            return ${($_ = isset($this->services['translation.loader.res']) ? $this->services['translation.loader.res'] : $this->get('translation.loader.res')) && false ?: '_'};
        }, 'translation.loader.xliff' => function () {
            return ${($_ = isset($this->services['translation.loader.xliff']) ? $this->services['translation.loader.xliff'] : $this->get('translation.loader.xliff')) && false ?: '_'};
        }, 'translation.loader.yml' => function () {
            return ${($_ = isset($this->services['translation.loader.yml']) ? $this->services['translation.loader.yml'] : $this->get('translation.loader.yml')) && false ?: '_'};
        })), new \Symfony\Component\Translation\MessageSelector(), 'it', array('translation.loader.php' => array(0 => 'php'), 'translation.loader.yml' => array(0 => 'yml'), 'translation.loader.xliff' => array(0 => 'xlf', 1 => 'xliff'), 'translation.loader.po' => array(0 => 'po'), 'translation.loader.mo' => array(0 => 'mo'), 'translation.loader.qt' => array(0 => 'ts'), 'translation.loader.csv' => array(0 => 'csv'), 'translation.loader.res' => array(0 => 'res'), 'translation.loader.dat' => array(0 => 'dat'), 'translation.loader.ini' => array(0 => 'ini'), 'translation.loader.json' => array(0 => 'json')), array('cache_dir' => (__DIR__.'/translations'), 'debug' => true, 'resource_files' => array('ca' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.ca.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.ca.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ca.xlf')), 'sk' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sk.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.sk.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.sk.xlf')), 'lb' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.lb.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.lb.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.lb.xlf')), 'gl' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.gl.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.gl.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.gl.xlf')), 'tr' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.tr.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.tr.xlf')), 'hu' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.hu.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.hu.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.hu.xlf')), 'nn' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.nn.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.nn.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.nn.xlf')), 'cy' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.cy.xlf')), 'et' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.et.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.et.xlf')), 'az' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.az.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.az.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.az.xlf')), 'sr_Cyrl' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sr_Cyrl.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.sr_Cyrl.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.sr_Cyrl.xlf')), 'zh_TW' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.zh_TW.xlf')), 'ro' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.ro.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.ro.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ro.xlf')), 'sv' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sv.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.sv.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.sv.xlf')), 'hy' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.hy.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.hy.xlf')), 'fr' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.fr.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.fr.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.fr.xlf')), 'sr_Latn' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sr_Latn.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.sr_Latn.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.sr_Latn.xlf')), 'zh_CN' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.zh_CN.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.zh_CN.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.zh_CN.xlf')), 'fa' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.fa.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.fa.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.fa.xlf')), 'en' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.en.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.en.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.en.xlf'), 3 => ($this->targetDirs[3].'/app/Resources/translations/messages.en.yml'), 4 => ($this->targetDirs[3].'/app/Resources/translations/messages.en.yml')), 'sl' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sl.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.sl.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.sl.xlf')), 'ar' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.ar.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.ar.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ar.xlf')), 'mn' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.mn.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.mn.xlf')), 'es' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.es.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.es.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.es.xlf')), 'pt_BR' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.pt_BR.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.pt_BR.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.pt_BR.xlf')), 'nb' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.nb.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.nb.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.nb.xlf')), 'hr' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.hr.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.hr.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.hr.xlf')), 'cs' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.cs.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.cs.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.cs.xlf')), 'th' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.th.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.th.xlf')), 'he' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.he.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.he.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.he.xlf')), 'da' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.da.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.da.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.da.xlf')), 'ja' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.ja.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.ja.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ja.xlf')), 'id' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.id.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.id.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.id.xlf')), 'bg' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.bg.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.bg.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.bg.xlf')), 'el' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.el.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.el.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.el.xlf')), 'pl' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.pl.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.pl.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.pl.xlf')), 'af' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.af.xlf')), 'eu' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.eu.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.eu.xlf')), 'fi' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.fi.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.fi.xlf')), 'sq' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.sq.xlf')), 'vi' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.vi.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.vi.xlf')), 'it' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.it.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.it.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.it.xlf'), 3 => ($this->targetDirs[3].'/app/Resources/translations/messages.it.yml'), 4 => ($this->targetDirs[3].'/app/Resources/translations/messages.it.yml')), 'lv' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.lv.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.lv.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.lv.xlf')), 'pt' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.pt.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.pt.xlf')), 'de' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.de.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.de.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.de.xlf')), 'lt' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.lt.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.lt.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.lt.xlf')), 'nl' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.nl.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.nl.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.nl.xlf')), 'uk' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.uk.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.uk.xlf')), 'no' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.no.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.no.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.no.xlf')), 'ru' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Validator/Resources/translations/validators.ru.xlf'), 1 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/translations/validators.ru.xlf'), 2 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ru.xlf')), 'ua' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.ua.xlf')), 'pt_PT' => array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Security/Core/Resources/translations/security.pt_PT.xlf')))));

        $instance->setConfigCacheFactory(${($_ = isset($this->services['config_cache_factory']) ? $this->services['config_cache_factory'] : $this->get('config_cache_factory')) && false ?: '_'});
        $instance->setFallbackLocales(array(0 => 'it'));

        return $instance;
    }

    /**
     * Gets the public 'translator_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\TranslatorListener
     */
    protected function getTranslatorListenerService()
    {
        return $this->services['translator_listener'] = new \Symfony\Component\HttpKernel\EventListener\TranslatorListener(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'}, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'});
    }

    /**
     * Gets the public 'twig' shared service.
     *
     * @return \Twig\Environment
     */
    protected function getTwigService()
    {
        $a = ${($_ = isset($this->services['debug.stopwatch']) ? $this->services['debug.stopwatch'] : $this->get('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'};
        $b = ${($_ = isset($this->services['debug.file_link_formatter']) ? $this->services['debug.file_link_formatter'] : $this->getDebug_FileLinkFormatterService()) && false ?: '_'};
        $c = ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'};

        $d = new \Symfony\Component\VarDumper\Dumper\HtmlDumper(NULL, 'UTF-8', 0);
        $d->setDisplayOptions(array('fileLinkFormat' => $b));

        $e = new \Symfony\Component\VarDumper\Dumper\HtmlDumper(NULL, 'UTF-8', 1);
        $e->setDisplayOptions(array('maxStringLength' => 4096, 'fileLinkFormat' => $b));

        $f = new \Symfony\Bridge\Twig\AppVariable();
        $f->setEnvironment('dev');
        $f->setDebug(true);
        if ($this->has('security.token_storage')) {
            $f->setTokenStorage(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
        }
        if ($this->has('request_stack')) {
            $f->setRequestStack($c);
        }

        $this->services['twig'] = $instance = new \Twig\Environment(${($_ = isset($this->services['twig.loader']) ? $this->services['twig.loader'] : $this->get('twig.loader')) && false ?: '_'}, array('debug' => true, 'strict_variables' => true, 'cache' => false, 'exception_controller' => 'twig.controller.exception:showAction', 'form_themes' => array(0 => 'form_div_layout.html.twig'), 'autoescape' => 'name', 'charset' => 'UTF-8', 'paths' => array(), 'date' => array('format' => 'F j, Y H:i', 'interval_format' => '%d days', 'timezone' => NULL), 'number_format' => array('decimals' => 0, 'decimal_point' => '.', 'thousands_separator' => ',')));

        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\LogoutUrlExtension(${($_ = isset($this->services['security.logout_url_generator']) ? $this->services['security.logout_url_generator'] : $this->getSecurity_LogoutUrlGeneratorService()) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\SecurityExtension(${($_ = isset($this->services['security.authorization_checker']) ? $this->services['security.authorization_checker'] : $this->get('security.authorization_checker', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\ProfilerExtension(${($_ = isset($this->services['twig.profile']) ? $this->services['twig.profile'] : $this->get('twig.profile')) && false ?: '_'}, $a));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\AssetExtension(${($_ = isset($this->services['assets.packages']) ? $this->services['assets.packages'] : $this->get('assets.packages')) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\CodeExtension($b, ($this->targetDirs[3].'/app'), 'UTF-8'));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\RoutingExtension(${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router')) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\YamlExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\StopwatchExtension($a, true));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\ExpressionExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpKernelExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpFoundationExtension($c, ${($_ = isset($this->services['router.request_context']) ? $this->services['router.request_context'] : $this->getRouter_RequestContextService()) && false ?: '_'}));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\FormExtension(array(0 => $this, 1 => 'twig.form.renderer')));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\WebLinkExtension($c));
        $instance->addExtension(new \Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension());
        $instance->addExtension(${($_ = isset($this->services['mobile_detect.twig.extension']) ? $this->services['mobile_detect.twig.extension'] : $this->get('mobile_detect.twig.extension')) && false ?: '_'});
        $instance->addExtension(new \JMS\Serializer\Twig\SerializerRuntimeExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\DumpExtension(${($_ = isset($this->services['var_dumper.cloner']) ? $this->services['var_dumper.cloner'] : $this->get('var_dumper.cloner')) && false ?: '_'}, $d));
        $instance->addExtension(new \Symfony\Bundle\WebProfilerBundle\Twig\WebProfilerExtension($e));
        $instance->addGlobal('app', $f);
        $instance->addRuntimeLoader(new \Twig\RuntimeLoader\ContainerRuntimeLoader(new \Symfony\Component\DependencyInjection\ServiceLocator(array('JMS\\Serializer\\Twig\\SerializerRuntimeHelper' => function () {
            return ${($_ = isset($this->services['jms_serializer.twig_extension.serializer_runtime_helper']) ? $this->services['jms_serializer.twig_extension.serializer_runtime_helper'] : $this->get('jms_serializer.twig_extension.serializer_runtime_helper')) && false ?: '_'};
        }, 'Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => function () {
            return ${($_ = isset($this->services['twig.runtime.httpkernel']) ? $this->services['twig.runtime.httpkernel'] : $this->get('twig.runtime.httpkernel')) && false ?: '_'};
        }, 'Symfony\\Bridge\\Twig\\Form\\TwigRenderer' => function () {
            return ${($_ = isset($this->services['twig.form.renderer']) ? $this->services['twig.form.renderer'] : $this->get('twig.form.renderer')) && false ?: '_'};
        }))));
        $instance->addGlobal('cssVersion', 20200721);
        $instance->addGlobal('jsVersion', 20200721);
        $instance->addGlobal('folder_js_minified', '/js/widget/');
        $instance->addGlobal('hostImg', 'https://www.acquistigiusti.it');
        $instance->addGlobal('folder_img_banners', 'https://www.acquistigiusti.it/imagesBanners/');
        $instance->addGlobal('folder_img_small', 'https://www.acquistigiusti.it/imagesArticleSmall/');
        $instance->addGlobal('folder_img_medium', 'https://www.acquistigiusti.it/imagesArticleMedium/');
        $instance->addGlobal('folder_img_big', 'https://www.acquistigiusti.it/imagesArticleBig/');
        $instance->addGlobal('folder_img_category', '/imagesCategories/');
        $instance->addGlobal('folder_img_trademark', 'https://www.acquistigiusti.it/imagesTrademarks/');
        $instance->addGlobal('folder_img_affiliation_small', 'https://www.acquistigiusti.it/imagesAffiliationsSmall/');
        $instance->addGlobal('folder_img_affiliation_big', 'https://www.acquistigiusti.it/imagesAffiliationsBig/');
        $instance->addGlobal('folder_img_products', 'https://www.acquistigiusti.it/imagesProducts/');
        $instance->addGlobal('folder_img_products_small', 'https://www.acquistigiusti.it/imagesProductsSmall/');
        $instance->addGlobal('folder_img_models', 'https://www.acquistigiusti.it/imagesModels/');
        $instance->addGlobal('folder_img_subcategories', '/imagesSubcategories/');
        $instance->addGlobal('folder_img_microsection', '/imagesMicroSection/');
        $instance->addGlobal('folder_img_typologies', '/imagesTypologies/');
        $instance->addGlobal('folder_img_models_gallery', '/galleryImagesModel/');
        $instance->addGlobal('folder_img_small_models_gallery', '/galleryImagesSmallModel/');
        $instance->addGlobal('folder_manuals', '/manuals/');
        $instance->addGlobal('pathAllNews', 'allnews');
        $instance->addGlobal('categoryIdAbbigliamento', 8);
        $instance->addGlobal('hostProtocol', 'https');
        $instance->addGlobal('wwwProtocol', 'www.');
        $instance->addGlobal('freeSearchPath', 'search');
        $instance->addGlobal('debugLinkLinkAssistant', false);
        $instance->addGlobal('folder_video_default', '/videosArticleDefault/');
        $instance->addGlobal('facebookAppId', 354876088590324);
        $instance->addGlobal('facebookScope', 'email, public_profile, user_birthday');
        $instance->addGlobal('googleApiKey', 'AIzaSyAfIAJs3i03T4Vyw0KxVktvhDfT8rwskJQ');
        $instance->addGlobal('googleScopes', 'https://www.googleapis.com/auth/userinfo.email');
        $instance->addGlobal('googleClientId', '299398455921-4s8a06t99vkvr8bigh903454086j0gch.apps.googleusercontent.com');
        $instance->addGlobal('socketChatHostServer', 'localhost');
        $instance->addGlobal('socketChatHostClient', 'localhost');
        $instance->addGlobal('socketChatPort', 3003);
        $instance->addGlobal('superUserChat', 'Ale');
        $instance->addGlobal('demoEmail', 'acquistigiusti@gmail.com');
        $instance->addGlobal('labelPriceList', 'Prezzo consigliato');
        (new \Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator('F j, Y H:i', '%d days', NULL, 0, '.', ','))->configure($instance);

        return $instance;
    }

    /**
     * Gets the public 'twig.controller.exception' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\Controller\ExceptionController
     */
    protected function getTwig_Controller_ExceptionService()
    {
        return $this->services['twig.controller.exception'] = new \Symfony\Bundle\TwigBundle\Controller\ExceptionController(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'twig.controller.preview_error' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\Controller\PreviewErrorController
     */
    protected function getTwig_Controller_PreviewErrorService()
    {
        return $this->services['twig.controller.preview_error'] = new \Symfony\Bundle\TwigBundle\Controller\PreviewErrorController(${($_ = isset($this->services['http_kernel']) ? $this->services['http_kernel'] : $this->get('http_kernel')) && false ?: '_'}, 'twig.controller.exception:showAction');
    }

    /**
     * Gets the public 'twig.exception_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ExceptionListener
     */
    protected function getTwig_ExceptionListenerService()
    {
        return $this->services['twig.exception_listener'] = new \Symfony\Component\HttpKernel\EventListener\ExceptionListener('twig.controller.exception:showAction', ${($_ = isset($this->services['monolog.logger.request']) ? $this->services['monolog.logger.request'] : $this->get('monolog.logger.request', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'twig.form.renderer' shared service.
     *
     * @return \Symfony\Bridge\Twig\Form\TwigRenderer
     */
    protected function getTwig_Form_RendererService()
    {
        return $this->services['twig.form.renderer'] = new \Symfony\Bridge\Twig\Form\TwigRenderer(new \Symfony\Bridge\Twig\Form\TwigRendererEngine(array(0 => 'form_div_layout.html.twig'), ${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}), ${($_ = isset($this->services['security.csrf.token_manager']) ? $this->services['security.csrf.token_manager'] : $this->get('security.csrf.token_manager', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the public 'twig.loader' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader
     */
    protected function getTwig_LoaderService()
    {
        $this->services['twig.loader'] = $instance = new \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader(${($_ = isset($this->services['templating.locator']) ? $this->services['templating.locator'] : $this->getTemplating_LocatorService()) && false ?: '_'}, ${($_ = isset($this->services['templating.name_parser']) ? $this->services['templating.name_parser'] : $this->get('templating.name_parser')) && false ?: '_'}, $this->targetDirs[3]);

        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views'), 'Framework');
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/SecurityBundle/Resources/views'), 'Security');
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views'), 'Twig');
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/swiftmailer-bundle/Resources/views'), 'Swiftmailer');
        $instance->addPath(($this->targetDirs[3].'/vendor/doctrine/doctrine-bundle/Resources/views'), 'Doctrine');
        $instance->addPath(($this->targetDirs[3].'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/Resources/views'), 'MobileDetect');
        $instance->addPath(($this->targetDirs[3].'/vendor/snc/redis-bundle/Resources/views'), 'SncRedis');
        $instance->addPath(($this->targetDirs[3].'/vendor/friendsofsymfony/elastica-bundle/Resources/views'), 'FOSElastica');
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/DebugBundle/Resources/views'), 'Debug');
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views'), 'WebProfiler');
        $instance->addPath(($this->targetDirs[3].'/app/Resources/views'));
        $instance->addPath(($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bridge/Twig/Resources/views/Form'));

        return $instance;
    }

    /**
     * Gets the public 'twig.profile' shared service.
     *
     * @return \Twig\Profiler\Profile
     */
    protected function getTwig_ProfileService()
    {
        return $this->services['twig.profile'] = new \Twig\Profiler\Profile();
    }

    /**
     * Gets the public 'twig.runtime.httpkernel' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\HttpKernelRuntime
     */
    protected function getTwig_Runtime_HttpkernelService()
    {
        return $this->services['twig.runtime.httpkernel'] = new \Symfony\Bridge\Twig\Extension\HttpKernelRuntime(${($_ = isset($this->services['fragment.handler']) ? $this->services['fragment.handler'] : $this->get('fragment.handler')) && false ?: '_'});
    }

    /**
     * Gets the public 'twig.translation.extractor' shared service.
     *
     * @return \Symfony\Bridge\Twig\Translation\TwigExtractor
     */
    protected function getTwig_Translation_ExtractorService()
    {
        return $this->services['twig.translation.extractor'] = new \Symfony\Bridge\Twig\Translation\TwigExtractor(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'});
    }

    /**
     * Gets the public 'uri_signer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\UriSigner
     */
    protected function getUriSignerService()
    {
        return $this->services['uri_signer'] = new \Symfony\Component\HttpKernel\UriSigner('djsa90dj9as0dj093jklnklmasdklm4363249');
    }

    /**
     * Gets the public 'validate_request_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener
     */
    protected function getValidateRequestListenerService()
    {
        return $this->services['validate_request_listener'] = new \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener();
    }

    /**
     * Gets the public 'validator' shared service.
     *
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected function getValidatorService()
    {
        return $this->services['validator'] = ${($_ = isset($this->services['validator.builder']) ? $this->services['validator.builder'] : $this->get('validator.builder')) && false ?: '_'}->getValidator();
    }

    /**
     * Gets the public 'validator.builder' shared service.
     *
     * @return \Symfony\Component\Validator\ValidatorBuilderInterface
     */
    protected function getValidator_BuilderService()
    {
        $this->services['validator.builder'] = $instance = \Symfony\Component\Validator\Validation::createValidatorBuilder();

        $instance->setConstraintValidatorFactory(new \Symfony\Component\Validator\ContainerConstraintValidatorFactory(new \Symfony\Component\DependencyInjection\ServiceLocator(array('Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator' => function () {
            return ${($_ = isset($this->services['doctrine.orm.validator.unique']) ? $this->services['doctrine.orm.validator.unique'] : $this->get('doctrine.orm.validator.unique')) && false ?: '_'};
        }, 'Symfony\\Component\\Security\\Core\\Validator\\Constraints\\UserPasswordValidator' => function () {
            return ${($_ = isset($this->services['security.validator.user_password']) ? $this->services['security.validator.user_password'] : $this->get('security.validator.user_password')) && false ?: '_'};
        }, 'Symfony\\Component\\Validator\\Constraints\\EmailValidator' => function () {
            return ${($_ = isset($this->services['validator.email']) ? $this->services['validator.email'] : $this->get('validator.email')) && false ?: '_'};
        }, 'Symfony\\Component\\Validator\\Constraints\\ExpressionValidator' => function () {
            return ${($_ = isset($this->services['validator.expression']) ? $this->services['validator.expression'] : $this->get('validator.expression')) && false ?: '_'};
        }, 'doctrine.orm.validator.unique' => function () {
            return ${($_ = isset($this->services['doctrine.orm.validator.unique']) ? $this->services['doctrine.orm.validator.unique'] : $this->get('doctrine.orm.validator.unique')) && false ?: '_'};
        }, 'security.validator.user_password' => function () {
            return ${($_ = isset($this->services['security.validator.user_password']) ? $this->services['security.validator.user_password'] : $this->get('security.validator.user_password')) && false ?: '_'};
        }, 'validator.expression' => function () {
            return ${($_ = isset($this->services['validator.expression']) ? $this->services['validator.expression'] : $this->get('validator.expression')) && false ?: '_'};
        }))));
        $instance->setTranslator(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'});
        $instance->setTranslationDomain('validators');
        $instance->addXmlMappings(array(0 => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Component/Form/Resources/config/validation.xml')));
        $instance->enableAnnotationMapping(${($_ = isset($this->services['annotation_reader']) ? $this->services['annotation_reader'] : $this->get('annotation_reader')) && false ?: '_'});
        $instance->addMethodMapping('loadValidatorMetadata');
        $instance->addObjectInitializers(array(0 => ${($_ = isset($this->services['doctrine.orm.validator_initializer']) ? $this->services['doctrine.orm.validator_initializer'] : $this->get('doctrine.orm.validator_initializer')) && false ?: '_'}));

        return $instance;
    }

    /**
     * Gets the public 'validator.email' shared service.
     *
     * @return \Symfony\Component\Validator\Constraints\EmailValidator
     */
    protected function getValidator_EmailService()
    {
        return $this->services['validator.email'] = new \Symfony\Component\Validator\Constraints\EmailValidator(false);
    }

    /**
     * Gets the public 'validator.expression' shared service.
     *
     * @return \Symfony\Component\Validator\Constraints\ExpressionValidator
     */
    protected function getValidator_ExpressionService()
    {
        return $this->services['validator.expression'] = new \Symfony\Component\Validator\Constraints\ExpressionValidator();
    }

    /**
     * Gets the public 'var_dumper.cli_dumper' shared service.
     *
     * @return \Symfony\Component\VarDumper\Dumper\CliDumper
     */
    protected function getVarDumper_CliDumperService()
    {
        return $this->services['var_dumper.cli_dumper'] = new \Symfony\Component\VarDumper\Dumper\CliDumper(NULL, 'UTF-8', 0);
    }

    /**
     * Gets the public 'var_dumper.cloner' shared service.
     *
     * @return \Symfony\Component\VarDumper\Cloner\VarCloner
     */
    protected function getVarDumper_ClonerService()
    {
        $this->services['var_dumper.cloner'] = $instance = new \Symfony\Component\VarDumper\Cloner\VarCloner();

        $instance->setMaxItems(2500);
        $instance->setMaxString(-1);

        return $instance;
    }

    /**
     * Gets the public 'web_profiler.controller.exception' shared service.
     *
     * @return \Symfony\Bundle\WebProfilerBundle\Controller\ExceptionController
     */
    protected function getWebProfiler_Controller_ExceptionService()
    {
        return $this->services['web_profiler.controller.exception'] = new \Symfony\Bundle\WebProfilerBundle\Controller\ExceptionController(${($_ = isset($this->services['profiler']) ? $this->services['profiler'] : $this->get('profiler', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, true);
    }

    /**
     * Gets the public 'web_profiler.controller.profiler' shared service.
     *
     * @return \Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController
     */
    protected function getWebProfiler_Controller_ProfilerService()
    {
        return $this->services['web_profiler.controller.profiler'] = new \Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController(${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['profiler']) ? $this->services['profiler'] : $this->get('profiler', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, array('data_collector.request' => array(0 => 'request', 1 => '@WebProfiler/Collector/request.html.twig'), 'data_collector.time' => array(0 => 'time', 1 => '@WebProfiler/Collector/time.html.twig'), 'data_collector.memory' => array(0 => 'memory', 1 => '@WebProfiler/Collector/memory.html.twig'), 'data_collector.ajax' => array(0 => 'ajax', 1 => '@WebProfiler/Collector/ajax.html.twig'), 'data_collector.form' => array(0 => 'form', 1 => '@WebProfiler/Collector/form.html.twig'), 'data_collector.exception' => array(0 => 'exception', 1 => '@WebProfiler/Collector/exception.html.twig'), 'data_collector.logger' => array(0 => 'logger', 1 => '@WebProfiler/Collector/logger.html.twig'), 'data_collector.events' => array(0 => 'events', 1 => '@WebProfiler/Collector/events.html.twig'), 'data_collector.router' => array(0 => 'router', 1 => '@WebProfiler/Collector/router.html.twig'), 'data_collector.cache' => array(0 => 'cache', 1 => '@WebProfiler/Collector/cache.html.twig'), 'data_collector.translation' => array(0 => 'translation', 1 => '@WebProfiler/Collector/translation.html.twig'), 'data_collector.security' => array(0 => 'security', 1 => '@Security/Collector/security.html.twig'), 'data_collector.twig' => array(0 => 'twig', 1 => '@WebProfiler/Collector/twig.html.twig'), 'data_collector.doctrine' => array(0 => 'db', 1 => '@Doctrine/Collector/db.html.twig'), 'swiftmailer.data_collector' => array(0 => 'swiftmailer', 1 => '@Swiftmailer/Collector/swiftmailer.html.twig'), 'data_collector.dump' => array(0 => 'dump', 1 => '@Debug/Profiler/dump.html.twig'), 'mobile_detect_bundle.device.collector' => array(0 => 'device.collector', 1 => '@MobileDetect/Collector/device.html.twig'), 'snc_redis.data_collector' => array(0 => 'redis', 1 => '@SncRedis/Collector/redis.html.twig'), 'fos_elastica.data_collector' => array(0 => 'elastica', 1 => 'FOSElasticaBundle:Collector:elastica'), 'data_collector.config' => array(0 => 'config', 1 => '@WebProfiler/Collector/config.html.twig')), 'bottom', new \Symfony\Bundle\WebProfilerBundle\Csp\ContentSecurityPolicyHandler(new \Symfony\Bundle\WebProfilerBundle\Csp\NonceGenerator()), $this->targetDirs[3]);
    }

    /**
     * Gets the public 'web_profiler.controller.router' shared service.
     *
     * @return \Symfony\Bundle\WebProfilerBundle\Controller\RouterController
     */
    protected function getWebProfiler_Controller_RouterService()
    {
        return $this->services['web_profiler.controller.router'] = new \Symfony\Bundle\WebProfilerBundle\Controller\RouterController(${($_ = isset($this->services['profiler']) ? $this->services['profiler'] : $this->get('profiler', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->get('twig')) && false ?: '_'}, ${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private '1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker
     */
    protected function get1Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService()
    {
        return $this->services['1_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a'] = new \Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker($this);
    }

    /**
     * Gets the private '2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a' shared service.
     *
     * @return \Symfony\Component\Config\Resource\SelfCheckingResourceChecker
     */
    protected function get2Cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9aService()
    {
        return $this->services['2_cdd0f7532a9b3a0566179fb2f6ce4c026d80791c53518735ec8de0fb0c76ce9a'] = new \Symfony\Component\Config\Resource\SelfCheckingResourceChecker();
    }

    /**
     * Gets the private 'annotations.cache' shared service.
     *
     * @return \Symfony\Component\Cache\DoctrineProvider
     */
    protected function getAnnotations_CacheService()
    {
        return $this->services['annotations.cache'] = new \Symfony\Component\Cache\DoctrineProvider(\Symfony\Component\Cache\Adapter\PhpArrayAdapter::create((__DIR__.'/annotations.php'), ${($_ = isset($this->services['cache.annotations']) ? $this->services['cache.annotations'] : $this->getCache_AnnotationsService()) && false ?: '_'}));
    }

    /**
     * Gets the private 'annotations.reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    protected function getAnnotations_ReaderService()
    {
        $a = new \Doctrine\Common\Annotations\AnnotationRegistry();
        $a->registerUniqueLoader('class_exists');

        $this->services['annotations.reader'] = $instance = new \Doctrine\Common\Annotations\AnnotationReader();

        $instance->addGlobalIgnoredName('required', $a);

        return $instance;
    }

    /**
     * Gets the private 'argument_resolver.default' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver
     */
    protected function getArgumentResolver_DefaultService()
    {
        return $this->services['argument_resolver.default'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver();
    }

    /**
     * Gets the private 'argument_resolver.request' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver
     */
    protected function getArgumentResolver_RequestService()
    {
        return $this->services['argument_resolver.request'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver();
    }

    /**
     * Gets the private 'argument_resolver.request_attribute' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver
     */
    protected function getArgumentResolver_RequestAttributeService()
    {
        return $this->services['argument_resolver.request_attribute'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver();
    }

    /**
     * Gets the private 'argument_resolver.service' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver
     */
    protected function getArgumentResolver_ServiceService()
    {
        return $this->services['argument_resolver.service'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver(${($_ = isset($this->services['service_locator.6f24348b77840ec12a20c22a3f985cf7']) ? $this->services['service_locator.6f24348b77840ec12a20c22a3f985cf7'] : $this->getServiceLocator_6f24348b77840ec12a20c22a3f985cf7Service()) && false ?: '_'});
    }

    /**
     * Gets the private 'argument_resolver.session' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver
     */
    protected function getArgumentResolver_SessionService()
    {
        return $this->services['argument_resolver.session'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver();
    }

    /**
     * Gets the private 'argument_resolver.variadic' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver
     */
    protected function getArgumentResolver_VariadicService()
    {
        return $this->services['argument_resolver.variadic'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver();
    }

    /**
     * Gets the private 'cache.annotations' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_AnnotationsService()
    {
        return $this->services['cache.annotations'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(${($_ = isset($this->services['cache.annotations.recorder_inner']) ? $this->services['cache.annotations.recorder_inner'] : $this->getCache_Annotations_RecorderInnerService()) && false ?: '_'});
    }

    /**
     * Gets the private 'cache.annotations.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Annotations_RecorderInnerService($lazyLoad = true)
    {
        return $this->services['cache.annotations.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('NIjrWVymHV', 0, 'oenc7Ee83akpXBARKCxY-Q', (__DIR__.'/pools'), ${($_ = isset($this->services['monolog.logger.cache']) ? $this->services['monolog.logger.cache'] : $this->get('monolog.logger.cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'cache.app.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    protected function getCache_App_RecorderInnerService($lazyLoad = true)
    {
        $this->services['cache.app.recorder_inner'] = $instance = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('sHvycMYGaO', 0, (__DIR__.'/pools'));

        if ($this->has('monolog.logger.cache')) {
            $instance->setLogger(${($_ = isset($this->services['monolog.logger.cache']) ? $this->services['monolog.logger.cache'] : $this->get('monolog.logger.cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
        }

        return $instance;
    }

    /**
     * Gets the private 'cache.serializer.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Serializer_RecorderInnerService($lazyLoad = true)
    {
        return $this->services['cache.serializer.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('0YAxbuPQQQ', 0, 'oenc7Ee83akpXBARKCxY-Q', (__DIR__.'/pools'), ${($_ = isset($this->services['monolog.logger.cache']) ? $this->services['monolog.logger.cache'] : $this->get('monolog.logger.cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'cache.system.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_System_RecorderInnerService($lazyLoad = true)
    {
        return $this->services['cache.system.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('ej-Tfa2gkW', 0, 'oenc7Ee83akpXBARKCxY-Q', (__DIR__.'/pools'), ${($_ = isset($this->services['monolog.logger.cache']) ? $this->services['monolog.logger.cache'] : $this->get('monolog.logger.cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'cache.validator' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_ValidatorService()
    {
        return $this->services['cache.validator'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(${($_ = isset($this->services['cache.validator.recorder_inner']) ? $this->services['cache.validator.recorder_inner'] : $this->getCache_Validator_RecorderInnerService()) && false ?: '_'});
    }

    /**
     * Gets the private 'cache.validator.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Validator_RecorderInnerService($lazyLoad = true)
    {
        return $this->services['cache.validator.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('VilFa2DG-O', 0, 'oenc7Ee83akpXBARKCxY-Q', (__DIR__.'/pools'), ${($_ = isset($this->services['monolog.logger.cache']) ? $this->services['monolog.logger.cache'] : $this->get('monolog.logger.cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'console.error_listener' shared service.
     *
     * @return \Symfony\Component\Console\EventListener\ErrorListener
     */
    protected function getConsole_ErrorListenerService()
    {
        return $this->services['console.error_listener'] = new \Symfony\Component\Console\EventListener\ErrorListener(${($_ = isset($this->services['monolog.logger.console']) ? $this->services['monolog.logger.console'] : $this->get('monolog.logger.console', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'controller_name_converter' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser
     */
    protected function getControllerNameConverterService()
    {
        return $this->services['controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(${($_ = isset($this->services['kernel']) ? $this->services['kernel'] : $this->get('kernel')) && false ?: '_'});
    }

    /**
     * Gets the private 'debug.file_link_formatter' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Debug\FileLinkFormatter
     */
    protected function getDebug_FileLinkFormatterService()
    {
        return $this->services['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL, ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, $this->targetDirs[3], '/_profiler/open?file=%f&line=%l#line%l');
    }

    /**
     * Gets the private 'debug.log_processor' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Processor\DebugProcessor
     */
    protected function getDebug_LogProcessorService()
    {
        return $this->services['debug.log_processor'] = new \Symfony\Bridge\Monolog\Processor\DebugProcessor();
    }

    /**
     * Gets the private 'debug.security.access.decision_manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\TraceableAccessDecisionManager
     */
    protected function getDebug_Security_Access_DecisionManagerService()
    {
        return $this->services['debug.security.access.decision_manager'] = new \Symfony\Component\Security\Core\Authorization\TraceableAccessDecisionManager(new \Symfony\Component\Security\Core\Authorization\AccessDecisionManager(new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['security.access.authenticated_voter']) ? $this->services['security.access.authenticated_voter'] : $this->getSecurity_Access_AuthenticatedVoterService()) && false ?: '_'};
            yield 1 => ${($_ = isset($this->services['security.access.simple_role_voter']) ? $this->services['security.access.simple_role_voter'] : $this->getSecurity_Access_SimpleRoleVoterService()) && false ?: '_'};
            yield 2 => ${($_ = isset($this->services['security.access.expression_voter']) ? $this->services['security.access.expression_voter'] : $this->getSecurity_Access_ExpressionVoterService()) && false ?: '_'};
        }, 3), 'affirmative', false, true));
    }

    /**
     * Gets the private 'doctrine.dbal.logger.profiling.default' shared service.
     *
     * @return \Doctrine\DBAL\Logging\DebugStack
     */
    protected function getDoctrine_Dbal_Logger_Profiling_DefaultService()
    {
        return $this->services['doctrine.dbal.logger.profiling.default'] = new \Doctrine\DBAL\Logging\DebugStack();
    }

    /**
     * Gets the private 'form.server_params' shared service.
     *
     * @return \Symfony\Component\Form\Util\ServerParams
     */
    protected function getForm_ServerParamsService()
    {
        return $this->services['form.server_params'] = new \Symfony\Component\Form\Util\ServerParams(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack')) && false ?: '_'});
    }

    /**
     * Gets the private 'form.type.choice' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\ChoiceType
     */
    protected function getForm_Type_ChoiceService()
    {
        return $this->services['form.type.choice'] = new \Symfony\Component\Form\Extension\Core\Type\ChoiceType(new \Symfony\Component\Form\ChoiceList\Factory\CachingFactoryDecorator(new \Symfony\Component\Form\ChoiceList\Factory\PropertyAccessDecorator(new \Symfony\Component\Form\ChoiceList\Factory\DefaultChoiceListFactory(), ${($_ = isset($this->services['property_accessor']) ? $this->services['property_accessor'] : $this->get('property_accessor')) && false ?: '_'})));
    }

    /**
     * Gets the private 'form.type.form' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Core\Type\FormType
     */
    protected function getForm_Type_FormService()
    {
        return $this->services['form.type.form'] = new \Symfony\Component\Form\Extension\Core\Type\FormType(${($_ = isset($this->services['property_accessor']) ? $this->services['property_accessor'] : $this->get('property_accessor')) && false ?: '_'});
    }

    /**
     * Gets the private 'form.type_extension.csrf' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension
     */
    protected function getForm_TypeExtension_CsrfService()
    {
        return $this->services['form.type_extension.csrf'] = new \Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension(${($_ = isset($this->services['security.csrf.token_manager']) ? $this->services['security.csrf.token_manager'] : $this->get('security.csrf.token_manager')) && false ?: '_'}, true, '_token', ${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'}, 'validators', ${($_ = isset($this->services['form.server_params']) ? $this->services['form.server_params'] : $this->getForm_ServerParamsService()) && false ?: '_'});
    }

    /**
     * Gets the private 'form.type_extension.form.data_collector' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\Type\DataCollectorTypeExtension
     */
    protected function getForm_TypeExtension_Form_DataCollectorService()
    {
        return $this->services['form.type_extension.form.data_collector'] = new \Symfony\Component\Form\Extension\DataCollector\Type\DataCollectorTypeExtension(${($_ = isset($this->services['data_collector.form']) ? $this->services['data_collector.form'] : $this->get('data_collector.form')) && false ?: '_'});
    }

    /**
     * Gets the private 'form.type_extension.form.http_foundation' shared service.
     *
     * @return \Symfony\Component\Form\Extension\HttpFoundation\Type\FormTypeHttpFoundationExtension
     */
    protected function getForm_TypeExtension_Form_HttpFoundationService()
    {
        return $this->services['form.type_extension.form.http_foundation'] = new \Symfony\Component\Form\Extension\HttpFoundation\Type\FormTypeHttpFoundationExtension(new \Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler(${($_ = isset($this->services['form.server_params']) ? $this->services['form.server_params'] : $this->getForm_ServerParamsService()) && false ?: '_'}));
    }

    /**
     * Gets the private 'form.type_extension.form.validator' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension
     */
    protected function getForm_TypeExtension_Form_ValidatorService()
    {
        return $this->services['form.type_extension.form.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension(${($_ = isset($this->services['validator']) ? $this->services['validator'] : $this->get('validator')) && false ?: '_'});
    }

    /**
     * Gets the private 'form.type_extension.repeated.validator' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Validator\Type\RepeatedTypeValidatorExtension
     */
    protected function getForm_TypeExtension_Repeated_ValidatorService()
    {
        return $this->services['form.type_extension.repeated.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\RepeatedTypeValidatorExtension();
    }

    /**
     * Gets the private 'form.type_extension.submit.validator' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Validator\Type\SubmitTypeValidatorExtension
     */
    protected function getForm_TypeExtension_Submit_ValidatorService()
    {
        return $this->services['form.type_extension.submit.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\SubmitTypeValidatorExtension();
    }

    /**
     * Gets the private 'form.type_extension.upload.validator' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Validator\Type\UploadValidatorExtension
     */
    protected function getForm_TypeExtension_Upload_ValidatorService()
    {
        return $this->services['form.type_extension.upload.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\UploadValidatorExtension(${($_ = isset($this->services['translator']) ? $this->services['translator'] : $this->get('translator')) && false ?: '_'}, 'validators');
    }

    /**
     * Gets the private 'form.type_guesser.validator' shared service.
     *
     * @return \Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser
     */
    protected function getForm_TypeGuesser_ValidatorService()
    {
        return $this->services['form.type_guesser.validator'] = new \Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser(${($_ = isset($this->services['validator']) ? $this->services['validator'] : $this->get('validator')) && false ?: '_'});
    }

    /**
     * Gets the private 'fos_elastica.elastica_to_model_transformer.cmsmodel.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer
     */
    protected function getFosElastica_ElasticaToModelTransformer_Cmsmodel_ModelService()
    {
        $this->services['fos_elastica.elastica_to_model_transformer.cmsmodel.model'] = $instance = new \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, 'AppBundle\\Entity\\Model', array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder', 'identifier' => 'id'));

        $instance->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the private 'fos_elastica.elastica_to_model_transformer.cmsproduct.product' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer
     */
    protected function getFosElastica_ElasticaToModelTransformer_Cmsproduct_ProductService()
    {
        $this->services['fos_elastica.elastica_to_model_transformer.cmsproduct.product'] = $instance = new \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, 'AppBundle\\Entity\\Product', array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder', 'identifier' => 'id'));

        $instance->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the private 'fos_elastica.elastica_to_model_transformer.cmstypologies.model' shared service.
     *
     * @return \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer
     */
    protected function getFosElastica_ElasticaToModelTransformer_Cmstypologies_ModelService()
    {
        $this->services['fos_elastica.elastica_to_model_transformer.cmstypologies.model'] = $instance = new \FOS\ElasticaBundle\Doctrine\ORM\ElasticaToModelTransformer(${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->get('doctrine')) && false ?: '_'}, 'AppBundle\\Entity\\Typology', array('ignore_missing' => true, 'hints' => array(), 'hydrate' => true, 'query_builder_method' => 'createQueryBuilder', 'identifier' => 'id'));

        $instance->setPropertyAccessor(${($_ = isset($this->services['fos_elastica.property_accessor']) ? $this->services['fos_elastica.property_accessor'] : $this->get('fos_elastica.property_accessor')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the private 'jms_serializer.unserialize_object_constructor' shared service.
     *
     * @return \JMS\Serializer\Construction\UnserializeObjectConstructor
     */
    protected function getJmsSerializer_UnserializeObjectConstructorService()
    {
        return $this->services['jms_serializer.unserialize_object_constructor'] = new \JMS\Serializer\Construction\UnserializeObjectConstructor();
    }

    /**
     * Gets the private 'monolog.processor.psr_log_message' shared service.
     *
     * @return \Monolog\Processor\PsrLogMessageProcessor
     */
    protected function getMonolog_Processor_PsrLogMessageService()
    {
        return $this->services['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor();
    }

    /**
     * Gets the private 'resolve_controller_name_subscriber' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber
     */
    protected function getResolveControllerNameSubscriberService()
    {
        return $this->services['resolve_controller_name_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber(${($_ = isset($this->services['controller_name_converter']) ? $this->services['controller_name_converter'] : $this->getControllerNameConverterService()) && false ?: '_'});
    }

    /**
     * Gets the private 'router.request_context' shared service.
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    protected function getRouter_RequestContextService()
    {
        return $this->services['router.request_context'] = new \Symfony\Component\Routing\RequestContext('', 'GET', 'localhost', 'http', 80, 443);
    }

    /**
     * Gets the private 'security.access.authenticated_voter' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter
     */
    protected function getSecurity_Access_AuthenticatedVoterService()
    {
        return $this->services['security.access.authenticated_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter(${($_ = isset($this->services['security.authentication.trust_resolver']) ? $this->services['security.authentication.trust_resolver'] : $this->getSecurity_Authentication_TrustResolverService()) && false ?: '_'});
    }

    /**
     * Gets the private 'security.access.expression_voter' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\Voter\ExpressionVoter
     */
    protected function getSecurity_Access_ExpressionVoterService()
    {
        return $this->services['security.access.expression_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\ExpressionVoter(new \Symfony\Component\Security\Core\Authorization\ExpressionLanguage(), ${($_ = isset($this->services['security.authentication.trust_resolver']) ? $this->services['security.authentication.trust_resolver'] : $this->getSecurity_Authentication_TrustResolverService()) && false ?: '_'}, ${($_ = isset($this->services['security.role_hierarchy']) ? $this->services['security.role_hierarchy'] : $this->getSecurity_RoleHierarchyService()) && false ?: '_'});
    }

    /**
     * Gets the private 'security.access.simple_role_voter' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\Voter\RoleVoter
     */
    protected function getSecurity_Access_SimpleRoleVoterService()
    {
        return $this->services['security.access.simple_role_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\RoleVoter();
    }

    /**
     * Gets the private 'security.authentication.manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager
     */
    protected function getSecurity_Authentication_ManagerService()
    {
        $this->services['security.authentication.manager'] = $instance = new \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager(new RewindableGenerator(function () {
            yield 0 => ${($_ = isset($this->services['security.authentication.provider.anonymous.main']) ? $this->services['security.authentication.provider.anonymous.main'] : $this->getSecurity_Authentication_Provider_Anonymous_MainService()) && false ?: '_'};
        }, 1), true);

        $instance->setEventDispatcher(${($_ = isset($this->services['debug.event_dispatcher']) ? $this->services['debug.event_dispatcher'] : $this->get('debug.event_dispatcher')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the private 'security.authentication.provider.anonymous.main' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider
     */
    protected function getSecurity_Authentication_Provider_Anonymous_MainService()
    {
        return $this->services['security.authentication.provider.anonymous.main'] = new \Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider('650f49e0e6f707.35449910');
    }

    /**
     * Gets the private 'security.authentication.trust_resolver' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver
     */
    protected function getSecurity_Authentication_TrustResolverService()
    {
        return $this->services['security.authentication.trust_resolver'] = new \Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver('Symfony\\Component\\Security\\Core\\Authentication\\Token\\AnonymousToken', 'Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken');
    }

    /**
     * Gets the private 'security.firewall.map' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallMap
     */
    protected function getSecurity_Firewall_MapService()
    {
        return $this->services['security.firewall.map'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallMap(new \Symfony\Component\DependencyInjection\ServiceLocator(array('security.firewall.map.context.dev' => function () {
            return ${($_ = isset($this->services['security.firewall.map.context.dev']) ? $this->services['security.firewall.map.context.dev'] : $this->get('security.firewall.map.context.dev')) && false ?: '_'};
        }, 'security.firewall.map.context.main' => function () {
            return ${($_ = isset($this->services['security.firewall.map.context.main']) ? $this->services['security.firewall.map.context.main'] : $this->get('security.firewall.map.context.main')) && false ?: '_'};
        })), new RewindableGenerator(function () {
            yield 'security.firewall.map.context.dev' => ${($_ = isset($this->services['security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d']) ? $this->services['security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d'] : $this->getSecurity_RequestMatcher_5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1dService()) && false ?: '_'};
            yield 'security.firewall.map.context.main' => NULL;
        }, 2));
    }

    /**
     * Gets the private 'security.logout_url_generator' shared service.
     *
     * @return \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator
     */
    protected function getSecurity_LogoutUrlGeneratorService()
    {
        return $this->services['security.logout_url_generator'] = new \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator(${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : $this->get('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['router']) ? $this->services['router'] : $this->get('router', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'}, ${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage', ContainerInterface::NULL_ON_INVALID_REFERENCE)) && false ?: '_'});
    }

    /**
     * Gets the private 'security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\RequestMatcher
     */
    protected function getSecurity_RequestMatcher_5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1dService()
    {
        return $this->services['security.request_matcher.5314eeb91110adf24b9b678372bb11bbe00e8858c519c088bfb65f525181ad3bf573fd1d'] = new \Symfony\Component\HttpFoundation\RequestMatcher('^/(_(profiler|wdt)|css|images|js)/');
    }

    /**
     * Gets the private 'security.role_hierarchy' shared service.
     *
     * @return \Symfony\Component\Security\Core\Role\RoleHierarchy
     */
    protected function getSecurity_RoleHierarchyService()
    {
        return $this->services['security.role_hierarchy'] = new \Symfony\Component\Security\Core\Role\RoleHierarchy(array());
    }

    /**
     * Gets the private 'security.user_value_resolver' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\SecurityUserValueResolver
     */
    protected function getSecurity_UserValueResolverService()
    {
        return $this->services['security.user_value_resolver'] = new \Symfony\Bundle\SecurityBundle\SecurityUserValueResolver(${($_ = isset($this->services['security.token_storage']) ? $this->services['security.token_storage'] : $this->get('security.token_storage')) && false ?: '_'});
    }

    /**
     * Gets the private 'service_locator.3368f0f4075960b08010e4ebdaedef01' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    protected function getServiceLocator_3368f0f4075960b08010e4ebdaedef01Service()
    {
        return $this->services['service_locator.3368f0f4075960b08010e4ebdaedef01'] = new \Symfony\Component\DependencyInjection\ServiceLocator(array('esi' => function () {
            return ${($_ = isset($this->services['fragment.renderer.esi']) ? $this->services['fragment.renderer.esi'] : $this->get('fragment.renderer.esi')) && false ?: '_'};
        }, 'hinclude' => function () {
            return ${($_ = isset($this->services['fragment.renderer.hinclude']) ? $this->services['fragment.renderer.hinclude'] : $this->get('fragment.renderer.hinclude')) && false ?: '_'};
        }, 'inline' => function () {
            return ${($_ = isset($this->services['fragment.renderer.inline']) ? $this->services['fragment.renderer.inline'] : $this->get('fragment.renderer.inline')) && false ?: '_'};
        }));
    }

    /**
     * Gets the private 'service_locator.6f24348b77840ec12a20c22a3f985cf7' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    protected function getServiceLocator_6f24348b77840ec12a20c22a3f985cf7Service()
    {
        return $this->services['service_locator.6f24348b77840ec12a20c22a3f985cf7'] = new \Symfony\Component\DependencyInjection\ServiceLocator(array());
    }

    /**
     * Gets the private 'session.storage.metadata_bag' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Storage\MetadataBag
     */
    protected function getSession_Storage_MetadataBagService()
    {
        return $this->services['session.storage.metadata_bag'] = new \Symfony\Component\HttpFoundation\Session\Storage\MetadataBag('_sf2_meta', '0');
    }

    /**
     * Gets the private 'swiftmailer.mailer.default.transport.eventdispatcher' shared service.
     *
     * @return \Swift_Events_SimpleEventDispatcher
     */
    protected function getSwiftmailer_Mailer_Default_Transport_EventdispatcherService()
    {
        return $this->services['swiftmailer.mailer.default.transport.eventdispatcher'] = new \Swift_Events_SimpleEventDispatcher();
    }

    /**
     * Gets the private 'templating.locator' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator
     */
    protected function getTemplating_LocatorService()
    {
        return $this->services['templating.locator'] = new \Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator(${($_ = isset($this->services['file_locator']) ? $this->services['file_locator'] : $this->get('file_locator')) && false ?: '_'}, __DIR__);
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters) || isset($this->loadedDynamicParameters[$name]))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters) || isset($this->loadedDynamicParameters[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = array(
        'kernel.root_dir' => false,
        'kernel.project_dir' => false,
        'kernel.logs_dir' => false,
        'kernel.bundles_metadata' => false,
        'app.folder_banners' => false,
        'app.folder_img_banners_write' => false,
        'app.folder_img_sliders_write' => false,
        'app.folder_img_category_write' => false,
        'app.folder_img_subcategories_write' => false,
        'app.folder_img_typologies_write' => false,
        'app.folder_img_microsection_write' => false,
        'app.folder_img_models_write' => false,
        'app.folder_img_models_gallery_write' => false,
        'app.folder_img_small_models_gallery_write' => false,
        'app.folder_manuals_write' => false,
        'app.folder_img_small_write' => false,
        'app.folder_img_medium_write' => false,
        'app.folder_img_big_write' => false,
        'app.folder_imgtopnews_default_write' => false,
        'app.folder_video_default_write' => false,
        'app.folder_imgexternaluser_default_write' => false,
        'app.folder_imgtrademarks_write' => false,
        'app.folder_imgaffiliations_small_write' => false,
        'app.folder_imgaffiliations_big_write' => false,
        'app.folder_imgproducts_write' => false,
        'app.folder_imgproductssmall_write' => false,
        'app.folder_menu' => false,
        'app.folder_templates_xml' => false,
        'xml_feeds_dir' => false,
        'session.save_path' => false,
        'router.resource' => false,
    );
    private $dynamicParameters = array();

    /**
     * Computes a dynamic parameter.
     *
     * @param string The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        switch ($name) {
            case 'kernel.root_dir': $value = ($this->targetDirs[3].'/app'); break;
            case 'kernel.project_dir': $value = $this->targetDirs[3]; break;
            case 'kernel.logs_dir': $value = ($this->targetDirs[2].'/logs'); break;
            case 'kernel.bundles_metadata': $value = array(
                'FrameworkBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle'),
                    'namespace' => 'Symfony\\Bundle\\FrameworkBundle',
                ),
                'SecurityBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/SecurityBundle'),
                    'namespace' => 'Symfony\\Bundle\\SecurityBundle',
                ),
                'TwigBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle'),
                    'namespace' => 'Symfony\\Bundle\\TwigBundle',
                ),
                'MonologBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/monolog-bundle'),
                    'namespace' => 'Symfony\\Bundle\\MonologBundle',
                ),
                'SwiftmailerBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/swiftmailer-bundle'),
                    'namespace' => 'Symfony\\Bundle\\SwiftmailerBundle',
                ),
                'DoctrineBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/doctrine/doctrine-bundle'),
                    'namespace' => 'Doctrine\\Bundle\\DoctrineBundle',
                ),
                'SensioFrameworkExtraBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/sensio/framework-extra-bundle'),
                    'namespace' => 'Sensio\\Bundle\\FrameworkExtraBundle',
                ),
                'MobileDetectBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle'),
                    'namespace' => 'SunCat\\MobileDetectBundle',
                ),
                'AppBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/src/AppBundle'),
                    'namespace' => 'AppBundle',
                ),
                'SncRedisBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/snc/redis-bundle'),
                    'namespace' => 'Snc\\RedisBundle',
                ),
                'FOSElasticaBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/friendsofsymfony/elastica-bundle'),
                    'namespace' => 'FOS\\ElasticaBundle',
                ),
                'JMSSerializerBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/jms/serializer-bundle'),
                    'namespace' => 'JMS\\SerializerBundle',
                ),
                'DebugBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/DebugBundle'),
                    'namespace' => 'Symfony\\Bundle\\DebugBundle',
                ),
                'WebProfilerBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle'),
                    'namespace' => 'Symfony\\Bundle\\WebProfilerBundle',
                ),
                'SensioDistributionBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/sensio/distribution-bundle'),
                    'namespace' => 'Sensio\\Bundle\\DistributionBundle',
                ),
                'SensioGeneratorBundle' => array(
                    'parent' => NULL,
                    'path' => ($this->targetDirs[3].'/vendor/sensio/generator-bundle'),
                    'namespace' => 'Sensio\\Bundle\\GeneratorBundle',
                ),
            ); break;
            case 'app.folder_banners': $value = ($this->targetDirs[3].'/app/Resources/views/'); break;
            case 'app.folder_img_banners_write': $value = ($this->targetDirs[3].'/app/../web/imagesBanners/'); break;
            case 'app.folder_img_sliders_write': $value = ($this->targetDirs[3].'/app/../web/sliders/'); break;
            case 'app.folder_img_category_write': $value = ($this->targetDirs[3].'/app/../web/imagesCategories/'); break;
            case 'app.folder_img_subcategories_write': $value = ($this->targetDirs[3].'/app/../web/imagesSubcategories/'); break;
            case 'app.folder_img_typologies_write': $value = ($this->targetDirs[3].'/app/../web/imagesTypologies/'); break;
            case 'app.folder_img_microsection_write': $value = ($this->targetDirs[3].'/app/../web/imagesMicroSection/'); break;
            case 'app.folder_img_models_write': $value = ($this->targetDirs[3].'/app/../web/imagesModels/'); break;
            case 'app.folder_img_models_gallery_write': $value = ($this->targetDirs[3].'/app/../web/galleryImagesModel/'); break;
            case 'app.folder_img_small_models_gallery_write': $value = ($this->targetDirs[3].'/app/../web/galleryImagesSmallModel/'); break;
            case 'app.folder_manuals_write': $value = ($this->targetDirs[3].'/app/../web/manuals/'); break;
            case 'app.folder_img_small_write': $value = ($this->targetDirs[3].'/app/../web/imagesArticleSmall/'); break;
            case 'app.folder_img_medium_write': $value = ($this->targetDirs[3].'/app/../web/imagesArticleMedium/'); break;
            case 'app.folder_img_big_write': $value = ($this->targetDirs[3].'/app/../web/imagesArticleBig/'); break;
            case 'app.folder_imgtopnews_default_write': $value = ($this->targetDirs[3].'/app/../web/imagesTopNews/'); break;
            case 'app.folder_video_default_write': $value = ($this->targetDirs[3].'/app/../web/videosArticleDefault/'); break;
            case 'app.folder_imgexternaluser_default_write': $value = ($this->targetDirs[3].'/app/../web/imagesExternalUsers/'); break;
            case 'app.folder_imgtrademarks_write': $value = ($this->targetDirs[3].'/app/../web/imagesTrademarks/'); break;
            case 'app.folder_imgaffiliations_small_write': $value = ($this->targetDirs[3].'/app/../web/imagesAffiliationsSmall/'); break;
            case 'app.folder_imgaffiliations_big_write': $value = ($this->targetDirs[3].'/app/../web/imagesAffiliationsBig/'); break;
            case 'app.folder_imgproducts_write': $value = ($this->targetDirs[3].'/app/../web/imagesProducts/'); break;
            case 'app.folder_imgproductssmall_write': $value = ($this->targetDirs[3].'/app/../web/imagesProductsSmall/'); break;
            case 'app.folder_menu': $value = ($this->targetDirs[3].'/app/../src/AppBundle/Menu/Layout'); break;
            case 'app.folder_templates_xml': $value = ($this->targetDirs[3].'/app/Resources/layouts/'); break;
            case 'xml_feeds_dir': $value = ($this->targetDirs[3].'/app/../var/feeds/'); break;
            case 'session.save_path': $value = ($this->targetDirs[3].'/app/../var/sessions/dev'); break;
            case 'router.resource': $value = ($this->targetDirs[3].'/app/config/routing_dev.yml'); break;
            default: throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
        }
        $this->loadedDynamicParameters[$name] = true;

        return $this->dynamicParameters[$name] = $value;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'kernel.environment' => 'dev',
            'kernel.debug' => true,
            'kernel.name' => 'app',
            'kernel.cache_dir' => __DIR__,
            'kernel.bundles' => array(
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'SecurityBundle' => 'Symfony\\Bundle\\SecurityBundle\\SecurityBundle',
                'TwigBundle' => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
                'MonologBundle' => 'Symfony\\Bundle\\MonologBundle\\MonologBundle',
                'SwiftmailerBundle' => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle',
                'DoctrineBundle' => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle',
                'SensioFrameworkExtraBundle' => 'Sensio\\Bundle\\FrameworkExtraBundle\\SensioFrameworkExtraBundle',
                'MobileDetectBundle' => 'SunCat\\MobileDetectBundle\\MobileDetectBundle',
                'AppBundle' => 'AppBundle\\AppBundle',
                'SncRedisBundle' => 'Snc\\RedisBundle\\SncRedisBundle',
                'FOSElasticaBundle' => 'FOS\\ElasticaBundle\\FOSElasticaBundle',
                'JMSSerializerBundle' => 'JMS\\SerializerBundle\\JMSSerializerBundle',
                'DebugBundle' => 'Symfony\\Bundle\\DebugBundle\\DebugBundle',
                'WebProfilerBundle' => 'Symfony\\Bundle\\WebProfilerBundle\\WebProfilerBundle',
                'SensioDistributionBundle' => 'Sensio\\Bundle\\DistributionBundle\\SensioDistributionBundle',
                'SensioGeneratorBundle' => 'Sensio\\Bundle\\GeneratorBundle\\SensioGeneratorBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'appDevDebugProjectContainer',
            'database_host' => 'mysql',
            'database_port' => 3306,
            'database_name' => 'acquistigiusti',
            'database_user' => 'root',
            'database_password' => 'secret',
            'mailer_transport' => 'smtp',
            'mailer_host' => '127.0.0.1',
            'mailer_user' => NULL,
            'mailer_password' => NULL,
            'secret' => 'djsa90dj9as0dj093jklnklmasdklm4363249',
            'redis_host' => '172.24.0.6',
            'handler_cache' => 'redis',
            'elestica_host' => 'localhost',
            'elestica_port' => 9200,
            'socketchathostserver' => 'localhost',
            'socketchathostclient' => 'localhost',
            'socketchatport' => 3003,
            'app.maxidlastdb' => 263060,
            'session_memcached_lib' => 'memcached',
            'session_memcached_host' => '127.0.0.1',
            'session_memcached_port' => 11211,
            'session_memcached_prefix' => 'sess_',
            'session_memcached_expire' => 3200,
            'session_memcached_persistent_id' => 20160618,
            's_memcached_expire_default' => 600,
            's_memcached_expire_widget' => 86000,
            's_memcached_expire_data_widget' => 600,
            's_memcached_prefix_userdata' => 'user_login_',
            's_memcached_prefix_appcall' => 'app_call_',
            's_memcached_expire_data_appcall' => 3600,
            'facebookappid' => 354876088590324,
            'facebookscope' => 'email, public_profile, user_birthday',
            'googleapikey' => 'AIzaSyAfIAJs3i03T4Vyw0KxVktvhDfT8rwskJQ',
            'googlescopes' => 'https://www.googleapis.com/auth/userinfo.email',
            'googleclientid' => '299398455921-4s8a06t99vkvr8bigh903454086j0gch.apps.googleusercontent.com',
            'categoryidabbigliamento' => 8,
            'pathallnews' => 'allnews',
            'app.hostimg' => 'https://www.acquistigiusti.it',
            'app.freesearchpath' => 'search',
            'app.ampprefix' => '/amp',
            'app.folder_tmp' => '/tmp/',
            'app.folder_img_banners' => '/imagesBanners/',
            'app.img_banner_width' => 2000,
            'app.img_banner_height' => 2000,
            'app.folder_img_sliders' => '/sliders/',
            'app.img_sliders_width' => 1500,
            'app.img_sliders_height' => 600,
            'app.folder_img_category' => '/imagesCategories/',
            'app.img_category_width' => 150,
            'app.img_category_height' => 120,
            'app.folder_img_subcategories' => '/imagesSubcategories/',
            'app.img_subcategories_width' => 100,
            'app.img_subcategories_height' => 100,
            'app.folder_img_typologies' => '/imagesTypologies/',
            'app.img_typologies_width' => 100,
            'app.img_typologies_height' => 100,
            'app.folder_img_microsection' => '/imagesMicroSection/',
            'app.img_microsection_width' => 100,
            'app.img_microsection_height' => 100,
            'app.folder_img_models' => '/imagesModels/',
            'app.img_models_width' => 158,
            'app.img_models_height' => 158,
            'app.folder_img_models_gallery' => '/galleryImagesModel/',
            'app.img_models_width_gallery' => 800,
            'app.img_models_height_gallery' => 800,
            'app.folder_img_small_models_gallery' => '/galleryImagesSmallModel/',
            'app.img_small_models_width_gallery' => 100,
            'app.img_small_models_height_gallery' => 100,
            'app.folder_manuals' => '/manuals/',
            'app.folder_img_small' => '/imagesArticleSmall/',
            'app.img_small_width' => 250,
            'app.img_small_height' => 250,
            'app.folder_img_medium' => '/imagesArticleMedium/',
            'app.img_medium_width' => 450,
            'app.img_medium_height' => 300,
            'app.folder_img_big' => '/imagesArticleBig/',
            'app.img_big_width' => 900,
            'app.img_big_height' => 900,
            'app.folder_imgtopnews_default' => '/imagesTopNews/',
            'app.imgtopnews_default_width' => 1200,
            'app.imgtopnews_default_height' => 720,
            'app.folder_video_default' => '/videosArticleDefault/',
            'app.video_default_width' => 500,
            'app.video_default_height' => 300,
            'app.folder_imgexternaluser_default' => '/imagesExternalUsers/',
            'app.imgexternaluser_default_width' => 60,
            'app.imgexternaluser_default_height' => 60,
            'app.folder_imgtrademarks' => '/imagesTrademarks/',
            'app.folder_imgaffiliations_small' => '/imagesAffiliationsSmall/',
            'app.imgaffiliations_small_width' => 80,
            'app.imgaffiliations_small_height' => 30,
            'app.folder_imgaffiliations_big' => '/imagesAffiliationsBig/',
            'app.imgaffiliations_big_width' => 160,
            'app.imgaffiliations_big_height' => 60,
            'app.folder_imgproducts' => '/imagesProducts/',
            'app.imgproducts_width' => 300,
            'app.imgproducts_height' => 300,
            'app.folder_imgproductssmall' => '/imagesProductsSmall/',
            'app.imgproductssmall_width' => 158,
            'app.imgproductssmall_height' => 158,
            'app.imgproductssmallabbigliamento_width' => 158,
            'app.imgproductssmallabbigliamento_height' => 158,
            'app.totarticlelistcategory' => 30,
            'app.totlistmodelstrademark' => 90,
            'app.totlistmodels' => 30,
            'app.totpolls' => 10,
            'app.tolinkspagination' => 99,
            'app.tolinkspaginationguide' => 12,
            'app.totimggallery' => 60,
            'app.totcommentsarticle' => 10,
            'app.totproductdetaillist' => 10,
            'app.usercode' => 'dpsonanevorna',
            'app.folder_css' => '/css/',
            'app.folder_js' => '/js/',
            'app.folder_js_minified' => '/js/widget/',
            'app.cssversion' => 20200721,
            'app.jsversion' => 20200721,
            'app.etagversion' => 8,
            'app.default_version_site' => 'template',
            'app.compactsite' => false,
            'app.extensiontpl' => '.html.twig',
            'app.compactversion' => '/min',
            'app.cdn' => '',
            'app.enabledhttpcache' => false,
            'app.debuglinklinkassistant' => false,
            'app.ttldetailarticlecache' => 3,
            'app.ttlcategorieslistcache' => 3,
            'app.ttlhomapagecache' => 3,
            'app.dependencymanager' => array(
                'commonPath' => '/php/assets/',
                'extensionsJsPath' => '/js/',
                'commonCSSPath' => '/php/assets/',
                'extensionCssPath' => '/css/template/',
                'extensionsJsAdminPath' => '/js/admin',
                'extensionsTemplates' => '/templates/',
                'catalogsPath' => '/home/prod/catalogs/',
            ),
            'app.js' => array(
                'module' => 'admin',
                'app' => '{}',
                'basePath' => 'admin/',
                'commonPath' => '../assets/',
                'rootPath' => '../',
                'dev' => 'false',
                'componentsPath' => '../assets/components/',
                'primaryColor' => '#25ad9f',
                'dangerColor' => '#b55151',
                'successColor' => '#609450',
                'infoColor' => '#4a8bc2',
                'warningColor' => '#ab7a4b',
                'inverseColor' => '#45484d',
                'themerPrimaryColor' => '#45484d',
                'skin' => 'stylesheet-complete.min.css',
                'ajaxCallPath' => '/call/ajax/',
                'extensionsJsPath' => '/js/',
            ),
            'admin.subcategoriestype' => 'relationship',
            'app.superuserchat' => 'Ale',
            'app.demoemail' => 'acquistigiusti@gmail.com',
            'app.labelpricelist' => 'Prezzo consigliato',
            'redis_sncredis_db_n' => 11,
            'redis_sncredisdoctrinemetadata' => 12,
            'redis_sncredisdoctrineresult' => 13,
            'redis_sncredisdoctrinequerycache' => 14,
            'redis_secondlevelcache' => 15,
            'redis_sncredissessionphp' => 16,
            'redis_profiler_storage' => 17,
            'redis_monolog' => 18,
            'app.totproductslist' => 18,
            'app.hostprotocol' => 'https',
            'app.wwwprotocol' => 'www.',
            'dbal_service_connection' => 'default',
            'locale' => 'it',
            'app.catalogspath' => '/home/prod/catalogs/',
            'secondlevelcacheenabled' => false,
            'fragment.renderer.hinclude.global_template' => NULL,
            'fragment.path' => '/_fragment',
            'kernel.secret' => 'djsa90dj9as0dj093jklnklmasdklm4363249',
            'kernel.http_method_override' => true,
            'kernel.trusted_hosts' => array(

            ),
            'kernel.default_locale' => 'it',
            'templating.helper.code.file_link_format' => NULL,
            'debug.file_link_format' => NULL,
            'session.metadata.storage_key' => '_sf2_meta',
            'session.storage.options' => array(
                'cookie_httponly' => true,
                'gc_probability' => 1,
            ),
            'session.metadata.update_threshold' => '0',
            'form.type_extension.csrf.enabled' => true,
            'form.type_extension.csrf.field_name' => '_token',
            'templating.loader.cache.path' => NULL,
            'templating.engines' => array(
                0 => 'twig',
            ),
            'validator.mapping.cache.prefix' => '',
            'validator.mapping.cache.file' => (__DIR__.'/validation.php'),
            'validator.translation_domain' => 'validators',
            'translator.logging' => true,
            'profiler_listener.only_exceptions' => false,
            'profiler_listener.only_master_requests' => false,
            'profiler.storage.dsn' => ('file:'.__DIR__.'/profiler'),
            'debug.error_handler.throw_at' => -1,
            'debug.container.dump' => (__DIR__.'/appDevDebugProjectContainer.xml'),
            'router.options.generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
            'router.options.matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher',
            'router.options.matcher_base_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher',
            'router.options.matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper',
            'router.options.matcher.cache_class' => 'appDevDebugProjectContainerUrlMatcher',
            'router.options.generator.cache_class' => 'appDevDebugProjectContainerUrlGenerator',
            'router.request_context.host' => 'localhost',
            'router.request_context.scheme' => 'http',
            'router.request_context.base_url' => '',
            'router.cache_class_prefix' => 'appDevDebugProjectContainer',
            'request_listener.http_port' => 80,
            'request_listener.https_port' => 443,
            'security.authentication.trust_resolver.anonymous_class' => 'Symfony\\Component\\Security\\Core\\Authentication\\Token\\AnonymousToken',
            'security.authentication.trust_resolver.rememberme_class' => 'Symfony\\Component\\Security\\Core\\Authentication\\Token\\RememberMeToken',
            'security.role_hierarchy.roles' => array(

            ),
            'security.access.denied_url' => NULL,
            'security.authentication.manager.erase_credentials' => true,
            'security.authentication.session_strategy.strategy' => 'migrate',
            'security.access.always_authenticate_before_granting' => false,
            'security.authentication.hide_user_not_found' => true,
            'twig.exception_listener.controller' => 'twig.controller.exception:showAction',
            'twig.form.resources' => array(
                0 => 'form_div_layout.html.twig',
            ),
            'monolog.logger.class' => 'Symfony\\Bridge\\Monolog\\Logger',
            'monolog.gelf.publisher.class' => 'Gelf\\MessagePublisher',
            'monolog.gelfphp.publisher.class' => 'Gelf\\Publisher',
            'monolog.handler.stream.class' => 'Monolog\\Handler\\StreamHandler',
            'monolog.handler.console.class' => 'Symfony\\Bridge\\Monolog\\Handler\\ConsoleHandler',
            'monolog.handler.group.class' => 'Monolog\\Handler\\GroupHandler',
            'monolog.handler.buffer.class' => 'Monolog\\Handler\\BufferHandler',
            'monolog.handler.deduplication.class' => 'Monolog\\Handler\\DeduplicationHandler',
            'monolog.handler.rotating_file.class' => 'Monolog\\Handler\\RotatingFileHandler',
            'monolog.handler.syslog.class' => 'Monolog\\Handler\\SyslogHandler',
            'monolog.handler.syslogudp.class' => 'Monolog\\Handler\\SyslogUdpHandler',
            'monolog.handler.null.class' => 'Monolog\\Handler\\NullHandler',
            'monolog.handler.test.class' => 'Monolog\\Handler\\TestHandler',
            'monolog.handler.gelf.class' => 'Monolog\\Handler\\GelfHandler',
            'monolog.handler.rollbar.class' => 'Monolog\\Handler\\RollbarHandler',
            'monolog.handler.flowdock.class' => 'Monolog\\Handler\\FlowdockHandler',
            'monolog.handler.browser_console.class' => 'Monolog\\Handler\\BrowserConsoleHandler',
            'monolog.handler.firephp.class' => 'Symfony\\Bridge\\Monolog\\Handler\\FirePHPHandler',
            'monolog.handler.chromephp.class' => 'Symfony\\Bridge\\Monolog\\Handler\\ChromePhpHandler',
            'monolog.handler.debug.class' => 'Symfony\\Bridge\\Monolog\\Handler\\DebugHandler',
            'monolog.handler.swift_mailer.class' => 'Symfony\\Bridge\\Monolog\\Handler\\SwiftMailerHandler',
            'monolog.handler.native_mailer.class' => 'Monolog\\Handler\\NativeMailerHandler',
            'monolog.handler.socket.class' => 'Monolog\\Handler\\SocketHandler',
            'monolog.handler.pushover.class' => 'Monolog\\Handler\\PushoverHandler',
            'monolog.handler.raven.class' => 'Monolog\\Handler\\RavenHandler',
            'monolog.handler.newrelic.class' => 'Monolog\\Handler\\NewRelicHandler',
            'monolog.handler.hipchat.class' => 'Monolog\\Handler\\HipChatHandler',
            'monolog.handler.slack.class' => 'Monolog\\Handler\\SlackHandler',
            'monolog.handler.cube.class' => 'Monolog\\Handler\\CubeHandler',
            'monolog.handler.amqp.class' => 'Monolog\\Handler\\AmqpHandler',
            'monolog.handler.error_log.class' => 'Monolog\\Handler\\ErrorLogHandler',
            'monolog.handler.loggly.class' => 'Monolog\\Handler\\LogglyHandler',
            'monolog.handler.logentries.class' => 'Monolog\\Handler\\LogEntriesHandler',
            'monolog.handler.whatfailuregroup.class' => 'Monolog\\Handler\\WhatFailureGroupHandler',
            'monolog.activation_strategy.not_found.class' => 'Symfony\\Bundle\\MonologBundle\\NotFoundActivationStrategy',
            'monolog.handler.fingers_crossed.class' => 'Monolog\\Handler\\FingersCrossedHandler',
            'monolog.handler.fingers_crossed.error_level_activation_strategy.class' => 'Monolog\\Handler\\FingersCrossed\\ErrorLevelActivationStrategy',
            'monolog.handler.filter.class' => 'Monolog\\Handler\\FilterHandler',
            'monolog.handler.mongo.class' => 'Monolog\\Handler\\MongoDBHandler',
            'monolog.mongo.client.class' => 'MongoClient',
            'monolog.handler.elasticsearch.class' => 'Monolog\\Handler\\ElasticSearchHandler',
            'monolog.elastica.client.class' => 'Elastica\\Client',
            'monolog.use_microseconds' => true,
            'monolog.swift_mailer.handlers' => array(

            ),
            'monolog.handlers_to_channels' => array(
                'monolog.handler.console_very_verbose' => array(
                    'type' => 'inclusive',
                    'elements' => array(
                        0 => 'doctrine',
                    ),
                ),
                'monolog.handler.console' => array(
                    'type' => 'exclusive',
                    'elements' => array(
                        0 => 'doctrine',
                    ),
                ),
                'monolog.handler.main' => NULL,
            ),
            'swiftmailer.class' => 'Swift_Mailer',
            'swiftmailer.transport.sendmail.class' => 'Swift_Transport_SendmailTransport',
            'swiftmailer.transport.mail.class' => 'Swift_Transport_MailTransport',
            'swiftmailer.transport.failover.class' => 'Swift_Transport_FailoverTransport',
            'swiftmailer.plugin.redirecting.class' => 'Swift_Plugins_RedirectingPlugin',
            'swiftmailer.plugin.impersonate.class' => 'Swift_Plugins_ImpersonatePlugin',
            'swiftmailer.plugin.messagelogger.class' => 'Swift_Plugins_MessageLogger',
            'swiftmailer.plugin.antiflood.class' => 'Swift_Plugins_AntiFloodPlugin',
            'swiftmailer.transport.smtp.class' => 'Swift_Transport_EsmtpTransport',
            'swiftmailer.plugin.blackhole.class' => 'Swift_Plugins_BlackholePlugin',
            'swiftmailer.spool.file.class' => 'Swift_FileSpool',
            'swiftmailer.spool.memory.class' => 'Swift_MemorySpool',
            'swiftmailer.email_sender.listener.class' => 'Symfony\\Bundle\\SwiftmailerBundle\\EventListener\\EmailSenderListener',
            'swiftmailer.data_collector.class' => 'Symfony\\Bundle\\SwiftmailerBundle\\DataCollector\\MessageDataCollector',
            'swiftmailer.mailer.default.transport.name' => 'smtp',
            'swiftmailer.mailer.default.transport.smtp.encryption' => NULL,
            'swiftmailer.mailer.default.transport.smtp.port' => 25,
            'swiftmailer.mailer.default.transport.smtp.host' => '127.0.0.1',
            'swiftmailer.mailer.default.transport.smtp.username' => NULL,
            'swiftmailer.mailer.default.transport.smtp.password' => NULL,
            'swiftmailer.mailer.default.transport.smtp.auth_mode' => NULL,
            'swiftmailer.mailer.default.transport.smtp.timeout' => 30,
            'swiftmailer.mailer.default.transport.smtp.source_ip' => NULL,
            'swiftmailer.mailer.default.transport.smtp.local_domain' => NULL,
            'swiftmailer.spool.default.memory.path' => (__DIR__.'/swiftmailer/spool/default'),
            'swiftmailer.mailer.default.spool.enabled' => true,
            'swiftmailer.mailer.default.plugin.impersonate' => NULL,
            'swiftmailer.mailer.default.single_address' => NULL,
            'swiftmailer.mailer.default.delivery.enabled' => true,
            'swiftmailer.spool.enabled' => true,
            'swiftmailer.delivery.enabled' => true,
            'swiftmailer.single_address' => NULL,
            'swiftmailer.mailers' => array(
                'default' => 'swiftmailer.mailer.default',
            ),
            'swiftmailer.default_mailer' => 'default',
            'doctrine_cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine_cache.apcu.class' => 'Doctrine\\Common\\Cache\\ApcuCache',
            'doctrine_cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine_cache.chain.class' => 'Doctrine\\Common\\Cache\\ChainCache',
            'doctrine_cache.couchbase.class' => 'Doctrine\\Common\\Cache\\CouchbaseCache',
            'doctrine_cache.couchbase.connection.class' => 'Couchbase',
            'doctrine_cache.couchbase.hostnames' => 'localhost:8091',
            'doctrine_cache.file_system.class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
            'doctrine_cache.php_file.class' => 'Doctrine\\Common\\Cache\\PhpFileCache',
            'doctrine_cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine_cache.memcache.connection.class' => 'Memcache',
            'doctrine_cache.memcache.host' => 'localhost',
            'doctrine_cache.memcache.port' => 11211,
            'doctrine_cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine_cache.memcached.connection.class' => 'Memcached',
            'doctrine_cache.memcached.host' => 'localhost',
            'doctrine_cache.memcached.port' => 11211,
            'doctrine_cache.mongodb.class' => 'Doctrine\\Common\\Cache\\MongoDBCache',
            'doctrine_cache.mongodb.collection.class' => 'MongoCollection',
            'doctrine_cache.mongodb.connection.class' => 'MongoClient',
            'doctrine_cache.mongodb.server' => 'localhost:27017',
            'doctrine_cache.predis.client.class' => 'Predis\\Client',
            'doctrine_cache.predis.scheme' => 'tcp',
            'doctrine_cache.predis.host' => 'localhost',
            'doctrine_cache.predis.port' => 6379,
            'doctrine_cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine_cache.redis.connection.class' => 'Redis',
            'doctrine_cache.redis.host' => 'localhost',
            'doctrine_cache.redis.port' => 6379,
            'doctrine_cache.riak.class' => 'Doctrine\\Common\\Cache\\RiakCache',
            'doctrine_cache.riak.bucket.class' => 'Riak\\Bucket',
            'doctrine_cache.riak.connection.class' => 'Riak\\Connection',
            'doctrine_cache.riak.bucket_property_list.class' => 'Riak\\BucketPropertyList',
            'doctrine_cache.riak.host' => 'localhost',
            'doctrine_cache.riak.port' => 8087,
            'doctrine_cache.sqlite3.class' => 'Doctrine\\Common\\Cache\\SQLite3Cache',
            'doctrine_cache.sqlite3.connection.class' => 'SQLite3',
            'doctrine_cache.void.class' => 'Doctrine\\Common\\Cache\\VoidCache',
            'doctrine_cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine_cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine_cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine_cache.security.acl.cache.class' => 'Doctrine\\Bundle\\DoctrineCacheBundle\\Acl\\Model\\AclCache',
            'doctrine.dbal.logger.chain.class' => 'Doctrine\\DBAL\\Logging\\LoggerChain',
            'doctrine.dbal.logger.profiling.class' => 'Doctrine\\DBAL\\Logging\\DebugStack',
            'doctrine.dbal.logger.class' => 'Symfony\\Bridge\\Doctrine\\Logger\\DbalLogger',
            'doctrine.dbal.configuration.class' => 'Doctrine\\DBAL\\Configuration',
            'doctrine.data_collector.class' => 'Doctrine\\Bundle\\DoctrineBundle\\DataCollector\\DoctrineDataCollector',
            'doctrine.dbal.connection.event_manager.class' => 'Symfony\\Bridge\\Doctrine\\ContainerAwareEventManager',
            'doctrine.dbal.connection_factory.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ConnectionFactory',
            'doctrine.dbal.events.mysql_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\MysqlSessionInit',
            'doctrine.dbal.events.oracle_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\OracleSessionInit',
            'doctrine.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Registry',
            'doctrine.entity_managers' => array(
                'default' => 'doctrine.orm.default_entity_manager',
            ),
            'doctrine.default_entity_manager' => 'default',
            'doctrine.dbal.connection_factory.types' => array(

            ),
            'doctrine.connections' => array(
                'default' => 'doctrine.dbal.default_connection',
            ),
            'doctrine.default_connection' => 'default',
            'doctrine.orm.configuration.class' => 'Doctrine\\ORM\\Configuration',
            'doctrine.orm.entity_manager.class' => 'Doctrine\\ORM\\EntityManager',
            'doctrine.orm.manager_configurator.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ManagerConfigurator',
            'doctrine.orm.cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine.orm.cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine.orm.cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine.orm.cache.memcache_host' => 'localhost',
            'doctrine.orm.cache.memcache_port' => 11211,
            'doctrine.orm.cache.memcache_instance.class' => 'Memcache',
            'doctrine.orm.cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine.orm.cache.memcached_host' => 'localhost',
            'doctrine.orm.cache.memcached_port' => 11211,
            'doctrine.orm.cache.memcached_instance.class' => 'Memcached',
            'doctrine.orm.cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine.orm.cache.redis_host' => 'localhost',
            'doctrine.orm.cache.redis_port' => 6379,
            'doctrine.orm.cache.redis_instance.class' => 'Redis',
            'doctrine.orm.cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine.orm.cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine.orm.cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine.orm.metadata.driver_chain.class' => 'Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriverChain',
            'doctrine.orm.metadata.annotation.class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
            'doctrine.orm.metadata.xml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedXmlDriver',
            'doctrine.orm.metadata.yml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedYamlDriver',
            'doctrine.orm.metadata.php.class' => 'Doctrine\\ORM\\Mapping\\Driver\\PHPDriver',
            'doctrine.orm.metadata.staticphp.class' => 'Doctrine\\ORM\\Mapping\\Driver\\StaticPHPDriver',
            'doctrine.orm.proxy_cache_warmer.class' => 'Symfony\\Bridge\\Doctrine\\CacheWarmer\\ProxyCacheWarmer',
            'form.type_guesser.doctrine.class' => 'Symfony\\Bridge\\Doctrine\\Form\\DoctrineOrmTypeGuesser',
            'doctrine.orm.validator.unique.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator',
            'doctrine.orm.validator_initializer.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\DoctrineInitializer',
            'doctrine.orm.security.user.provider.class' => 'Symfony\\Bridge\\Doctrine\\Security\\User\\EntityUserProvider',
            'doctrine.orm.listeners.resolve_target_entity.class' => 'Doctrine\\ORM\\Tools\\ResolveTargetEntityListener',
            'doctrine.orm.listeners.attach_entity_listeners.class' => 'Doctrine\\ORM\\Tools\\AttachEntityListenersListener',
            'doctrine.orm.naming_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultNamingStrategy',
            'doctrine.orm.naming_strategy.underscore.class' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
            'doctrine.orm.quote_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultQuoteStrategy',
            'doctrine.orm.quote_strategy.ansi.class' => 'Doctrine\\ORM\\Mapping\\AnsiQuoteStrategy',
            'doctrine.orm.entity_listener_resolver.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Mapping\\ContainerAwareEntityListenerResolver',
            'doctrine.orm.second_level_cache.default_cache_factory.class' => 'Doctrine\\ORM\\Cache\\DefaultCacheFactory',
            'doctrine.orm.second_level_cache.default_region.class' => 'Doctrine\\ORM\\Cache\\Region\\DefaultRegion',
            'doctrine.orm.second_level_cache.filelock_region.class' => 'Doctrine\\ORM\\Cache\\Region\\FileLockRegion',
            'doctrine.orm.second_level_cache.logger_chain.class' => 'Doctrine\\ORM\\Cache\\Logging\\CacheLoggerChain',
            'doctrine.orm.second_level_cache.logger_statistics.class' => 'Doctrine\\ORM\\Cache\\Logging\\StatisticsCacheLogger',
            'doctrine.orm.second_level_cache.cache_configuration.class' => 'Doctrine\\ORM\\Cache\\CacheConfiguration',
            'doctrine.orm.second_level_cache.regions_configuration.class' => 'Doctrine\\ORM\\Cache\\RegionsConfiguration',
            'doctrine.orm.auto_generate_proxy_classes' => true,
            'doctrine.orm.proxy_dir' => (__DIR__.'/doctrine/orm/Proxies'),
            'doctrine.orm.proxy_namespace' => 'Proxies',
            'sensio_framework_extra.view.guesser.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\Templating\\TemplateGuesser',
            'sensio_framework_extra.controller.listener.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\EventListener\\ControllerListener',
            'sensio_framework_extra.routing.loader.annot_dir.class' => 'Symfony\\Component\\Routing\\Loader\\AnnotationDirectoryLoader',
            'sensio_framework_extra.routing.loader.annot_file.class' => 'Symfony\\Component\\Routing\\Loader\\AnnotationFileLoader',
            'sensio_framework_extra.routing.loader.annot_class.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\Routing\\AnnotatedRouteControllerLoader',
            'sensio_framework_extra.converter.listener.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\EventListener\\ParamConverterListener',
            'sensio_framework_extra.converter.manager.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\Request\\ParamConverter\\ParamConverterManager',
            'sensio_framework_extra.converter.doctrine.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\Request\\ParamConverter\\DoctrineParamConverter',
            'sensio_framework_extra.converter.datetime.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\Request\\ParamConverter\\DateTimeParamConverter',
            'sensio_framework_extra.view.listener.class' => 'Sensio\\Bundle\\FrameworkExtraBundle\\EventListener\\TemplateListener',
            'mobile_detect.mobile_detector.class' => 'SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector',
            'mobile_detect.device_view.class' => 'SunCat\\MobileDetectBundle\\Helper\\DeviceView',
            'mobile_detect.cookie_key' => 'device_view',
            'mobile_detect.switch_param' => 'device_view',
            'mobile_detect.cookie_expire_datetime_modifier' => '1 month',
            'mobile_detect.request_response_listener.class' => 'SunCat\\MobileDetectBundle\\EventListener\\RequestResponseListener',
            'mobile_detect.redirect' => array(
                'mobile' => array(
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ),
                'tablet' => array(
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ),
                'full' => array(
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ),
                'detect_tablet_as_mobile' => false,
            ),
            'mobile_detect.switch_device_view.save_referer_path' => true,
            'mobile_detect.twig.extension.class' => 'SunCat\\MobileDetectBundle\\Twig\\Extension\\MobileDetectExtension',
            'mobile_detect.cookie_path' => '/',
            'mobile_detect.cookie_domain' => '',
            'mobile_detect.cookie_secure' => false,
            'mobile_detect.cookie_httponly' => true,
            'snc_redis.client.class' => 'Predis\\Client',
            'snc_redis.client_options.class' => 'Predis\\Configuration\\Options',
            'snc_redis.connection_parameters.class' => 'Predis\\Connection\\Parameters',
            'snc_redis.connection_factory.class' => 'Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionFactory',
            'snc_redis.connection_wrapper.class' => 'Snc\\RedisBundle\\Client\\Predis\\Connection\\ConnectionWrapper',
            'snc_redis.phpredis_client.class' => 'Redis',
            'snc_redis.phpredis_connection_wrapper.class' => 'Snc\\RedisBundle\\Client\\Phpredis\\Client',
            'snc_redis.logger.class' => 'Snc\\RedisBundle\\Logger\\RedisLogger',
            'snc_redis.data_collector.class' => 'Snc\\RedisBundle\\DataCollector\\RedisDataCollector',
            'snc_redis.doctrine_cache_phpredis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'snc_redis.doctrine_cache_predis.class' => 'Doctrine\\Common\\Cache\\PredisCache',
            'snc_redis.monolog_handler.class' => 'Monolog\\Handler\\RedisHandler',
            'snc_redis.swiftmailer_spool.class' => 'Snc\\RedisBundle\\SwiftMailer\\RedisSpool',
            'snc_redis.profiler_storage.class' => 'Snc\\RedisBundle\\Profiler\\Storage\\RedisProfilerStorage',
            'snc_redis.profiler_storage.client' => 'profiler_storage',
            'snc_redis.profiler_storage.ttl' => 3600,
            'fos_elastica.use_v5_api' => false,
            'fos_elastica.client.class' => 'FOS\\ElasticaBundle\\Elastica\\Client',
            'fos_elastica.logger.class' => 'FOS\\ElasticaBundle\\Logger\\ElasticaLogger',
            'fos_elastica.data_collector.class' => 'FOS\\ElasticaBundle\\DataCollector\\ElasticaDataCollector',
            'fos_elastica.mapping_builder.class' => 'FOS\\ElasticaBundle\\Index\\MappingBuilder',
            'fos_elastica.property_accessor.class' => 'Symfony\\Component\\PropertyAccess\\PropertyAccessor',
            'fos_elastica.property_accessor.magiccall' => false,
            'fos_elastica.property_accessor.throwexceptiononinvalidindex' => false,
            'fos_elastica.alias_processor.class' => 'FOS\\ElasticaBundle\\Index\\AliasProcessor',
            'fos_elastica.finder.class' => 'FOS\\ElasticaBundle\\Finder\\TransformedFinder',
            'fos_elastica.index.class' => 'FOS\\ElasticaBundle\\Elastica\\Index',
            'fos_elastica.indexable.class' => 'FOS\\ElasticaBundle\\Provider\\Indexable',
            'fos_elastica.index_manager.class' => 'FOS\\ElasticaBundle\\Index\\IndexManager',
            'fos_elastica.resetter.class' => 'FOS\\ElasticaBundle\\Index\\Resetter',
            'fos_elastica.type.class' => 'Elastica\\Type',
            'fos_elastica.repository_manager.class' => 'FOS\\ElasticaBundle\\Manager\\RepositoryManager',
            'fos_elastica.object_persister.class' => 'FOS\\ElasticaBundle\\Persister\\ObjectPersister',
            'fos_elastica.object_serializer_persister.class' => 'FOS\\ElasticaBundle\\Persister\\ObjectSerializerPersister',
            'fos_elastica.provider_registry.class' => 'FOS\\ElasticaBundle\\Provider\\ProviderRegistry',
            'fos_elastica.elastica_to_model_transformer.collection.class' => 'FOS\\ElasticaBundle\\Transformer\\ElasticaToModelTransformerCollection',
            'fos_elastica.model_to_elastica_transformer.class' => 'FOS\\ElasticaBundle\\Transformer\\ModelToElasticaAutoTransformer',
            'fos_elastica.model_to_elastica_identifier_transformer.class' => 'FOS\\ElasticaBundle\\Transformer\\ModelToElasticaIdentifierTransformer',
            'fos_elastica.slice_fetcher.orm.class' => 'FOS\\ElasticaBundle\\Doctrine\\ORM\\SliceFetcher',
            'fos_elastica.provider.prototype.orm.class' => 'FOS\\ElasticaBundle\\Doctrine\\ORM\\Provider',
            'fos_elastica.listener.prototype.orm.class' => 'FOS\\ElasticaBundle\\Doctrine\\Listener',
            'fos_elastica.elastica_to_model_transformer.prototype.orm.class' => 'FOS\\ElasticaBundle\\Doctrine\\ORM\\ElasticaToModelTransformer',
            'fos_elastica.manager.orm.class' => 'FOS\\ElasticaBundle\\Doctrine\\RepositoryManager',
            'fos_elastica.default_index' => 'cmsproduct',
            'jms_serializer.metadata.file_locator.class' => 'Metadata\\Driver\\FileLocator',
            'jms_serializer.metadata.annotation_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\AnnotationDriver',
            'jms_serializer.metadata.chain_driver.class' => 'Metadata\\Driver\\DriverChain',
            'jms_serializer.metadata.yaml_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\YamlDriver',
            'jms_serializer.metadata.xml_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\XmlDriver',
            'jms_serializer.metadata.php_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\PhpDriver',
            'jms_serializer.metadata.doctrine_type_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\DoctrineTypeDriver',
            'jms_serializer.metadata.doctrine_phpcr_type_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\DoctrinePHPCRTypeDriver',
            'jms_serializer.metadata.lazy_loading_driver.class' => 'Metadata\\Driver\\LazyLoadingDriver',
            'jms_serializer.metadata.metadata_factory.class' => 'Metadata\\MetadataFactory',
            'jms_serializer.metadata.cache.file_cache.class' => 'Metadata\\Cache\\FileCache',
            'jms_serializer.event_dispatcher.class' => 'JMS\\Serializer\\EventDispatcher\\LazyEventDispatcher',
            'jms_serializer.camel_case_naming_strategy.class' => 'JMS\\Serializer\\Naming\\CamelCaseNamingStrategy',
            'jms_serializer.identical_property_naming_strategy.class' => 'JMS\\Serializer\\Naming\\IdenticalPropertyNamingStrategy',
            'jms_serializer.serialized_name_annotation_strategy.class' => 'JMS\\Serializer\\Naming\\SerializedNameAnnotationStrategy',
            'jms_serializer.cache_naming_strategy.class' => 'JMS\\Serializer\\Naming\\CacheNamingStrategy',
            'jms_serializer.doctrine_object_constructor.class' => 'JMS\\Serializer\\Construction\\DoctrineObjectConstructor',
            'jms_serializer.unserialize_object_constructor.class' => 'JMS\\Serializer\\Construction\\UnserializeObjectConstructor',
            'jms_serializer.version_exclusion_strategy.class' => 'JMS\\Serializer\\Exclusion\\VersionExclusionStrategy',
            'jms_serializer.serializer.class' => 'JMS\\Serializer\\Serializer',
            'jms_serializer.twig_extension.class' => 'JMS\\Serializer\\Twig\\SerializerExtension',
            'jms_serializer.twig_runtime_extension.class' => 'JMS\\Serializer\\Twig\\SerializerRuntimeExtension',
            'jms_serializer.twig_runtime_extension_helper.class' => 'JMS\\Serializer\\Twig\\SerializerRuntimeHelper',
            'jms_serializer.templating.helper.class' => 'JMS\\SerializerBundle\\Templating\\SerializerHelper',
            'jms_serializer.json_serialization_visitor.class' => 'JMS\\Serializer\\JsonSerializationVisitor',
            'jms_serializer.json_serialization_visitor.options' => 0,
            'jms_serializer.json_deserialization_visitor.class' => 'JMS\\Serializer\\JsonDeserializationVisitor',
            'jms_serializer.xml_serialization_visitor.class' => 'JMS\\Serializer\\XmlSerializationVisitor',
            'jms_serializer.xml_deserialization_visitor.class' => 'JMS\\Serializer\\XmlDeserializationVisitor',
            'jms_serializer.xml_deserialization_visitor.doctype_whitelist' => array(

            ),
            'jms_serializer.xml_serialization_visitor.format_output' => true,
            'jms_serializer.yaml_serialization_visitor.class' => 'JMS\\Serializer\\YamlSerializationVisitor',
            'jms_serializer.handler_registry.class' => 'JMS\\Serializer\\Handler\\LazyHandlerRegistry',
            'jms_serializer.datetime_handler.class' => 'JMS\\Serializer\\Handler\\DateHandler',
            'jms_serializer.array_collection_handler.class' => 'JMS\\Serializer\\Handler\\ArrayCollectionHandler',
            'jms_serializer.php_collection_handler.class' => 'JMS\\Serializer\\Handler\\PhpCollectionHandler',
            'jms_serializer.form_error_handler.class' => 'JMS\\Serializer\\Handler\\FormErrorHandler',
            'jms_serializer.constraint_violation_handler.class' => 'JMS\\Serializer\\Handler\\ConstraintViolationHandler',
            'jms_serializer.doctrine_proxy_subscriber.class' => 'JMS\\Serializer\\EventDispatcher\\Subscriber\\DoctrineProxySubscriber',
            'jms_serializer.stopwatch_subscriber.class' => 'JMS\\SerializerBundle\\Serializer\\StopwatchEventSubscriber',
            'jms_serializer.configured_context_factory.class' => 'JMS\\SerializerBundle\\ContextFactory\\ConfiguredContextFactory',
            'jms_serializer.expression_evaluator.class' => 'JMS\\Serializer\\Expression\\ExpressionEvaluator',
            'jms_serializer.expression_language.class' => 'Symfony\\Component\\ExpressionLanguage\\ExpressionLanguage',
            'jms_serializer.expression_language.function_provider.class' => 'JMS\\SerializerBundle\\ExpressionLanguage\\BasicSerializerFunctionsProvider',
            'jms_serializer.accessor_strategy.default.class' => 'JMS\\Serializer\\Accessor\\DefaultAccessorStrategy',
            'jms_serializer.accessor_strategy.expression.class' => 'JMS\\Serializer\\Accessor\\ExpressionAccessorStrategy',
            'jms_serializer.cache.cache_warmer.class' => 'JMS\\SerializerBundle\\Cache\\CacheWarmer',
            'web_profiler.debug_toolbar.position' => 'bottom',
            'data_collector.templates' => array(
                'data_collector.request' => array(
                    0 => 'request',
                    1 => '@WebProfiler/Collector/request.html.twig',
                ),
                'data_collector.time' => array(
                    0 => 'time',
                    1 => '@WebProfiler/Collector/time.html.twig',
                ),
                'data_collector.memory' => array(
                    0 => 'memory',
                    1 => '@WebProfiler/Collector/memory.html.twig',
                ),
                'data_collector.ajax' => array(
                    0 => 'ajax',
                    1 => '@WebProfiler/Collector/ajax.html.twig',
                ),
                'data_collector.form' => array(
                    0 => 'form',
                    1 => '@WebProfiler/Collector/form.html.twig',
                ),
                'data_collector.exception' => array(
                    0 => 'exception',
                    1 => '@WebProfiler/Collector/exception.html.twig',
                ),
                'data_collector.logger' => array(
                    0 => 'logger',
                    1 => '@WebProfiler/Collector/logger.html.twig',
                ),
                'data_collector.events' => array(
                    0 => 'events',
                    1 => '@WebProfiler/Collector/events.html.twig',
                ),
                'data_collector.router' => array(
                    0 => 'router',
                    1 => '@WebProfiler/Collector/router.html.twig',
                ),
                'data_collector.cache' => array(
                    0 => 'cache',
                    1 => '@WebProfiler/Collector/cache.html.twig',
                ),
                'data_collector.translation' => array(
                    0 => 'translation',
                    1 => '@WebProfiler/Collector/translation.html.twig',
                ),
                'data_collector.security' => array(
                    0 => 'security',
                    1 => '@Security/Collector/security.html.twig',
                ),
                'data_collector.twig' => array(
                    0 => 'twig',
                    1 => '@WebProfiler/Collector/twig.html.twig',
                ),
                'data_collector.doctrine' => array(
                    0 => 'db',
                    1 => '@Doctrine/Collector/db.html.twig',
                ),
                'swiftmailer.data_collector' => array(
                    0 => 'swiftmailer',
                    1 => '@Swiftmailer/Collector/swiftmailer.html.twig',
                ),
                'data_collector.dump' => array(
                    0 => 'dump',
                    1 => '@Debug/Profiler/dump.html.twig',
                ),
                'mobile_detect_bundle.device.collector' => array(
                    0 => 'device.collector',
                    1 => '@MobileDetect/Collector/device.html.twig',
                ),
                'snc_redis.data_collector' => array(
                    0 => 'redis',
                    1 => '@SncRedis/Collector/redis.html.twig',
                ),
                'fos_elastica.data_collector' => array(
                    0 => 'elastica',
                    1 => 'FOSElasticaBundle:Collector:elastica',
                ),
                'data_collector.config' => array(
                    0 => 'config',
                    1 => '@WebProfiler/Collector/config.html.twig',
                ),
            ),
            'console.command.ids' => array(
                'console.command.symfony_bundle_securitybundle_command_userpasswordencodercommand' => 'console.command.symfony_bundle_securitybundle_command_userpasswordencodercommand',
                'console.command.doctrine_bundle_doctrinecachebundle_command_containscommand' => 'doctrine_cache.contains_command',
                'console.command.doctrine_bundle_doctrinecachebundle_command_deletecommand' => 'doctrine_cache.delete_command',
                'console.command.doctrine_bundle_doctrinecachebundle_command_flushcommand' => 'doctrine_cache.flush_command',
                'console.command.doctrine_bundle_doctrinecachebundle_command_statscommand' => 'doctrine_cache.stats_command',
                'console.command.doctrine_bundle_doctrinebundle_command_createdatabasedoctrinecommand' => 'doctrine.database_create_command',
                'console.command.doctrine_bundle_doctrinebundle_command_dropdatabasedoctrinecommand' => 'doctrine.database_drop_command',
                'console.command.doctrine_bundle_doctrinebundle_command_generateentitiesdoctrinecommand' => 'doctrine.generate_entities_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_runsqldoctrinecommand' => 'doctrine.query_sql_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_clearmetadatacachedoctrinecommand' => 'doctrine.cache_clear_metadata_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_clearquerycachedoctrinecommand' => 'doctrine.cache_clear_query_cache_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_clearresultcachedoctrinecommand' => 'doctrine.cache_clear_result_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_collectionregiondoctrinecommand' => 'doctrine.cache_collection_region_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_convertmappingdoctrinecommand' => 'doctrine.mapping_convert_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_createschemadoctrinecommand' => 'doctrine.schema_create_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_dropschemadoctrinecommand' => 'doctrine.schema_drop_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_ensureproductionsettingsdoctrinecommand' => 'doctrine.ensure_production_settings_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_entityregioncachedoctrinecommand' => 'doctrine.clear_entity_region_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_importdoctrinecommand' => 'doctrine.database_import_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_infodoctrinecommand' => 'doctrine.mapping_info_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_queryregioncachedoctrinecommand' => 'doctrine.clear_query_region_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_rundqldoctrinecommand' => 'doctrine.query_dql_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_updateschemadoctrinecommand' => 'doctrine.schema_update_command',
                'console.command.doctrine_bundle_doctrinebundle_command_proxy_validateschemacommand' => 'doctrine.schema_validate_command',
                'console.command.doctrine_bundle_doctrinebundle_command_importmappingdoctrinecommand' => 'doctrine.mapping_import_command',
                'console.command.snc_redisbundle_command_redisflushallcommand' => 'snc_redis.command.flush_all',
                'console.command.snc_redisbundle_command_redisflushdbcommand' => 'snc_redis.command.flush_db',
                'console.command.sensiolabs_security_command_securitycheckercommand' => 'sensio_distribution.security_checker.command',
            ),
        );
    }
}
