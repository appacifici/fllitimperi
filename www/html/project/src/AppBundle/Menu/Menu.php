<?php

namespace AppBundle\Menu;

class Menu {

    private $loader;
    private $page;
    private $module;
    private $urlActive;
    private $basePath;
    public static $htmlMenu;

    public function __construct($menu, $page, $urlActive, $config) {
        global $loader;

        $this->loader = $loader;
        $this->menu = $menu;
        $this->page = $page;
        $this->urlActive = $urlActive;
        $this->module = $config->appConfig->module;
        $this->basePath = $config->basePath;
        $this->config = $config;

        if (isset($this->loader->keep_url) && $this->loader->keep_url === true) {
            Menu::make($menu["menu"]["' . $this->loader->module . '"], $page, $urlActive, $config);
            return Menu::$htmlMenu;
        }

        return $this->makeMenu();
    }

    public static function make($menu, $page, $urlActive, $config) {
        new static($menu, $page, $urlActive, $config);
    }

    public static function getMenu() {
        return Menu::$htmlMenu;
    }

    public function makeMenu() {
        global $skins;
        foreach ($this->menu as $menu) {
            $menuId = 'menu-' . md5(time() . mt_rand(0, 1000000));
            $menuClass = array();
            $menuCollapseClass = array('collapse');
            $menuCollapse = isset($menu['type']) && $menu['type'] == 'collapse';
            $menuLabel = true;
            $menuFile = false;

            if (isset($menu['widget'])) {
                //Qui va richiamato il servizio widget e renderizzato il template
                $this->config->twig->addGlobal("fetch_" . $menu['widget'], '');
                $data = array();
                if (isset($menu['core'])) {
                    $widget = $this->config->container->get('app.' . $menu['core']);
                    $data = $widget->processData();
                    if ($data == null) {
                        $data = array();
                    }
                }
                $html = $this->config->twig->render($this->config->appConfig->versionSite . "/{$menu['widget']}" . $this->config->appConfig->extension, $data);
                Menu::$htmlMenu .= $html;
                continue;
            }


            if (isset($menu['file']) && $menu['file'] !== false) {
                $menuFile = $this->module . DS . 'menus' . DS . $menu['file'];
                $menuLabel = false;
            }

            if (isset($menu['class']))
                $menuClass[] = $menu['class'];

            if ($menuCollapse)
                $menuClass[] = 'hasSubmenu';

            if ($menuCollapse && $this->in_array_r($this->urlActive, $menu['page'])) {
                $menuClass[] = 'active';
                $menuCollapseClass[] = 'in';
            }

            if (!$menuCollapse && isset($menu['page']) && $this->urlActive == $menu['page'])
                $menuClass[] = 'active';

            Menu::$htmlMenu .= '<li class="' . implode(" ", $menuClass) . '">';

            $href = '';
            if ($menuCollapse)
                $href .='#' . $menuId;

            if (!$menuCollapse) {
                if (isset($menu['href']))
                    $href = $menu['href'];
                else if (!empty($menu['page']))
                    $href = $this->getURL(array($menu['page']));
                else
                    $href = '';
            }

            if (isset($menu['page']) || isset($menu['href'])) {
                Menu::$htmlMenu .= '<a href="/' . ltrim($href,'/') . '"';

                if ($menuCollapse)
                    Menu::$htmlMenu .= 'data-toggle="collapse"';

                if (isset($menu['link_class']))
                    Menu::$htmlMenu .= 'class="' . $menu['link_class'] . '"';
//                Menu::$htmlMenu .= '>';
                Menu::$htmlMenu .= '>';
            }


            if (isset($menu['badge'])) {
                Menu::$htmlMenu .= '<span class="badge pull-right';
                if (isset($menu['badge']['class']))
                    Menu::$htmlMenu .= $menu['badge']['class'];
                Menu::$htmlMenu .= '">' . $menu['badge']['label'] . '</span>';
            }

            if (!empty($menu['icon']))
                Menu::$htmlMenu .= '<i class="' . $menu['icon'] . '"></i>';

            if (!empty($menu['img']))
                Menu::$htmlMenu .= '<img src="' . $menu['img'] . '" width="24" height="24" class="flagImg lazy">';

            if ($menuLabel && isset($menu['label']))
                Menu::$htmlMenu .= '<span>' . $menu['label'] . '</span>';

            if ($menuFile && @stream_resolve_include_path($menuFile)) {
                ob_start();
                include $menuFile;
                Menu::$htmlMenu .= ob_get_contents();
                ob_end_clean();
            }

            if (isset($menu['page']) || isset($menu['href']))
                Menu::$htmlMenu .= '</a>';

            if ($menuCollapse) {
                Menu::$htmlMenu .= '<ul class="' . implode(" ", $menuCollapseClass) . '" id="' . $menuId . '">';
                self::make($menu['page'], $this->page, $this->urlActive, $this->config);

                Menu::$htmlMenu .= '</ul>';
            }

            Menu::$htmlMenu .= '</li>';
        }
    }

    function getURL($query) {
        //$url = !isset($query[0]) ? "?" . http_build_query($query, '', '&amp;') : 'index.php?page=' . $query[0];
        //$url = !isset($query[0]) ? "?" . http_build_query($query, '', '&amp;') . '&amp;lang=' . $locale : 'index.php?lang=' . $locale . '&page=' . $query[0];
        $url = "$query[0]";

        if (!isset($query['skin']) && isset($_GET['skin']))
            $url .= "?skin=" . $_GET['skin'];

        return $url;
    }

    function in_array_r($needle, $haystack, $strict = false) {
        if (!is_array($haystack))
            return false;

        foreach ($haystack as $item) {
            if (( $strict ? $item === $needle : $item == $needle ) || ( is_array($item) && $this->in_array_r($needle, $item, $strict) )) {
                return true;
            }
        }
        return false;
    }

}