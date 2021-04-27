<?php


namespace app\modules\ccadmin\components;


use yii\bootstrap4\Widget;
use yii\caching\TagDependency;
use app\modules\ccadmin\components\Configs;
use app\modules\ccadmin\models\Menu;

class MenuHelper
{
    public $userId;

    public static function getAssignedMenu($userId, $root = null, $callback = null, $refresh = false)
    {
        $config = Configs::instance();

        /* @var $manager \yii\rbac\BaseManager */
        $manager = Configs::authManager();
        $menus = Menu::find()->asArray()->indexBy('id')->all();
        $key = [__METHOD__, $userId, $manager->defaultRoles];
        $cache = $config->cache;

        if ($refresh || $cache === null || ($assigned = $cache->get($key)) === false) {
            $routes = $filter1 = $filter2 = [];
            if ($userId !== null) {

                foreach ($manager->getPermissionsByUser($userId) as $name => $value) {
                    if ($name[0] === '/') {
                        if (substr($name, -2) === '/*') {
                            $name = substr($name, 0, -1);
                        }
                        $routes[] = $name;
                    }
                }
            }
            foreach ($manager->defaultRoles as $role) {
                foreach ($manager->getPermissionsByRole($role) as $name => $value) {
                    if ($name[0] === '/') {
                        if (substr($name, -2) === '/*') {
                            $name = substr($name, 0, -1);
                        }
                        $routes[] = $name;
                    }
                }
            }
            $routes = array_unique($routes);
            sort($routes);
            $prefix = '\\';
            foreach ($routes as $route) {
                if (strpos($route, $prefix) !== 0) {
                    if (substr($route, -1) === '/') {
                        $prefix = $route;
                        $filter1[] = $route . '%';
                    } else {
                        $filter2[] = $route;
                    }
                }
            }
            $assigned = [];
            $query = Menu::find()->select(['id'])->asArray();
            if (count($filter2)) {
                $assigned = $query->where(['route' => $filter2])->column();
            }
            if (count($filter1)) {
                $query->where('route like :filter');
                foreach ($filter1 as $filter) {
                    $assigned = array_merge($assigned, $query->params([':filter' => $filter])->column());
                }
            }
            $assigned = static::requiredParent($assigned, $menus);

            if ($cache !== null) {
                $cache->set($key, $assigned, $config->cacheDuration, new TagDependency([
                    'tags' => Configs::CACHE_TAG
                ]));
            }
        }

        $key = [__METHOD__, $assigned, $root];

        if ($refresh || $callback !== null || $cache === null || (($result = $cache->get($key)) === false)) {
            $result = static::normalizeMenu($assigned, $menus, $callback, $root);
            if ($cache !== null && $callback === null) {
                $cache->set($key, $result, $config->cacheDuration, new TagDependency([
                    'tags' => Configs::CACHE_TAG
                ]));
            }
        }
//        var_dump($result);
//        exit();
        return static::setLi($result);
    }

    /**
     * Ensure all item menu has parent.
     * @param array $assigned
     * @param array $menus
     * @return array
     */
    private static function requiredParent($assigned, &$menus)
    {
        $l = count($assigned);
        for ($i = 0; $i < $l; $i++) {
            $id = $assigned[$i];
            $parent_id = $menus[$id]['parent'];
            if ($parent_id !== null && !in_array($parent_id, $assigned)) {
                $assigned[$l++] = $parent_id;
            }
        }

        return $assigned;
    }

    /**
     * Parse route
     * @param string $route
     * @return mixed
     */
    public static function parseRoute($route)
    {
        if (!empty($route)) {
            $url = [];
            $r = explode('&', $route);
            $url[0] = $r[0];
            unset($r[0]);
            foreach ($r as $part) {
                $part = explode('=', $part);
                $url[$part[0]] = isset($part[1]) ? $part[1] : '';
            }

            return $url;
        }

        return '#';
    }

    /**
     * Normalize menu
     * @param array $assigned
     * @param array $menus
     * @param Closure $callback
     * @param integer $parent
     * @return array
     */
    private static function normalizeMenu(&$assigned, &$menus, $callback, $parent = null)
    {
        $result = [];
        $order = [];
        foreach ($assigned as $id) {
            $menu = $menus[$id];
            if ($menu['parent'] == $parent) {
                $menu['children'] = static::normalizeMenu($assigned, $menus, $callback, $id);
                if ($callback !== null) {
                    $item = call_user_func($callback, $menu);
                } else {
                    $item = [
                        'label' => $menu['name'],
                        'url' => static::parseRoute($menu['route']),
                    ];
                    if ($menu['children'] != []) {
                        $item['items'] = $menu['children'];
                    }
                }
                $result[] = $item;
                $order[] = $menu['order'];
            }
        }
        if ($result != []) {
            array_multisort($order, $result);
        }

        return $result;
    }

    public static function setLi($res)
    {
        $html = '';
        if (!empty($res)) {
            $active = false;
            foreach ($res as $li) {
//                var_dump($li);
//                exit();
                if (isset($li['label']) && isset($li['url'])) {
                    if ($active) {
                        $liClass = 'nav-item';
                        $aClass = 'nav-link';
                    } else {
                        $liClass = 'nav-item menu-open';
                        $aClass = 'nav-link  active';
                        $active = true;
                    }
                    $html .= ' <li class="' . $liClass . '">
                    <a href="' . $li['url'][0] . '" class="' . $aClass . '">
                        <i class="nav-icon fas fa-cicle"></i>
                        <p>' . $li['label'] . '<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>';
                    if (isset($li['items']) && !empty($li['items'])) {
                        $html .= static::setUl($li['items']);
                    }
                    $html .= '</li>';
                }
            }
            return $html;
        }
    }

    private static function setUl($items)
    {
        $html = '<ul class="nav nav-treeview">';
        foreach ($items as $item) {
            if (isset($item['label']) && isset($item['url'])) {
                $html .= '<li class="nav-item">
                            <a href="' . $item['url'][0] . '" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>' . $item['label'] . '</p>
                            </a>';
                if (isset($item['items']) && !empty($item['items'])) {
                    $html .= static::setUl($item['items']);
                }
                $html .= '</li>';
            }

        }
        return $html . '</ul>';
    }
}
