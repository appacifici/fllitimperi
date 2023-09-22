<?php 

require_once __DIR__.'/ExtraConfig.php';
$container->setParameter( 'secondLevelCacheEnabled', SECOND_LEVEL_CACHE_ENABLED );

//$container->loadFromExtension('doctrine', array(
//    'orm' => array(
//        'second_level_cache' => array(
////            'regions_configuration' => array(
////                'class' => 'succhia'
////            )
//        )
//    )
//));
//
