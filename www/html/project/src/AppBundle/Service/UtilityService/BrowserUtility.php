<?php

namespace AppBundle\Service\UtilityService;

use Sinergi\BrowserDetector\Browser;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;

/**
 * Description of DependenciesModules
 * @author alessandro
 */
class BrowserUtility {
    
    const ISNOTMOBILE = 1;
    const ISMOBILE    = 2;
    
    public $mobileDetector;
    
    public function __construct( MobileDetector $mobileDetector )  {                
        $this->mobileDetector   = $mobileDetector; 
    }
    
    /**
     * Determina se il dispositivo è un mobile
     * @return boolean
     */
    public function isMobile() {
        if( !empty( $_SERVER["ISMOBILE"] ) && $_SERVER["ISMOBILE"] == self::ISMOBILE ) {
            return true;
        } else if( !empty( $_SERVER["ISMOBILE"] ) && $_SERVER["ISMOBILE"] == self::ISNOTMOBILE ) {    
            return false;
        } else {
            if( $this->mobileDetector->isMobile() && $this->mobileDetector->isIpad() )
                return false;            
            return $this->mobileDetector->isMobile();
        }
    }
    
    
    /**
     * Determina se la view e un tablet mini
     * @return boolean
     */
    public function isTablet() {
         if( $this->mobileDetector->isTablet() )
             return true;
         return false;
             
    }
    
    
    /**
     * Determina se la view e un tablet mini
     * @return boolean
     */
    public function is_TabletMini() {
         if( $this->mobileDetector->isMobile() && $this->mobileDetector->isIpad() )
             return true;
         return false;
             
    }
   
    /**
     * Metodo che ritorna la versione si IE
     * @return type
     */
    public function getIsIeVersion() {
        //https://packagist.org/packages/sinergi/browser-detector
        $browser = new Browser();
        if ( $browser->getName() === Browser::IE ) {
            return $browser->getVersion();
        }
        return false;
    }
    
}//End Class
