<?php
/**
 * Created by PhpStorm.
 * User: Stevennight
 * Date: 2018/4/26
 * Time: 17:29
 */

namespace stevennight\menu_breadcrumbs;

use dmstr\widgets\Menu;
use yii\helpers\Html;
use Yii;

class MenuBreadcrumbs extends Menu
{
    public $openRbac = false;                       //是否进行RBAC处理，隐藏无权限的子项。
    public $parentActiveIfItemHidden = true;        //子项隐藏后是否激活父项。(主要是在哪里unset掉子项，是在判断激活前还是判断激活后)
    public $breadcrumbs = [];
    public $breadcrumbs_cache_key = 'breadcrumbs';
    public $title;
    public $title_cache_key = 'pageTitle';
    public $menu_cache_key = 'menu_';

    public function run()
    {
        if($this->openRbac){
            $cache = Yii::$app->cache;
            $userId = Yii::$app->user->id;
            $cache_key = $this->menu_cache_key . $userId;
            $cache_key_global = $this->menu_cache_key . 0; //全局(用于储存完整的menu)
            $menu_items_cache = $cache->get($cache_key_global);
            $menuUpdate = false;
            if (!$menu_items_cache) {
                //没有设置时
                $menuUpdate = true;
                $cache->set($cache_key_global, $this->items);
            } else {
                if (serialize($this->items) != serialize($menu_items_cache)) {
                    $menuUpdate = true;
                    $cache->set($cache_key_global, $this->items);
                }
            }

            if ($menuUpdate || !($menu = $cache->get($cache_key))) {
                //没有缓存 获取有权限的菜单
                $menu = $this->_getMenu($this->items);
                $cache->set($cache_key, $menu);
            }
            //重新设置菜单items。
            $this->items = $menu;
        }

        parent::run();

        //反转数组并存到session里面  cache应该会在并发时出现问题
        $session = Yii::$app->session;
        $session->set($this->breadcrumbs_cache_key, array_reverse($this->breadcrumbs));
        $session->set($this->title_cache_key, $this->title);
    }


    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            /*if (!$this->parentActiveIfItemHidden && isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }*/
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && ($isActiveItem = $this->isItemActive($item))) {
                    //设置breadcrumbs
                    if(!isset($item['displayInBreadcrumbs']) || $item['displayInBreadcrumbs']){
                        $breadcrumb = [
                            'label' => $item['label'],
                            'url' => isset($item['url']) ? $item['url'] : null,
                        ];
                        //当前页面的面包屑去掉url，不可点击。
                        if (isset($isActiveItem) && $isActiveItem) {
                            unset($breadcrumb['url']);
                        }
                        $this->breadcrumbs[] = $breadcrumb;
                    }
                    //设置标题
                    if (isset($isActiveItem) && $isActiveItem) {
                        $this->title = $item['label'];
                    }
                    //todo:: $active will affect generation of breadcrumbs, remove "disable parent active if active item is hidden" feature now. $active会影响breadcrumbs的生成，因此，暂时去掉不激活父级的选择....
                    /*if (!$this->parentActiveIfItemHidden && isset($item['visible']) && !$item['visible']) {
                        unset($items[$i]);
                        continue;
                    }*/

                    //必须在上述操作之后激活active = true;否则就会激活父级。
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
            //visible设置为不显示，因此unset掉。(激活父级)
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
        }
        return array_values($items);
    }

    private function _getMenu($items)
    {
        if (empty($items)) {
            return $items;
        }

        self::_checkAccess($items);
        return $items;
    }

    private function _checkAccess(&$items)
    {
        foreach ($items as $key => &$item) {
            if (isset($item['items'])) {
                self::_checkAccess($item['items']);
                if (count($item['items']) == 0) {
                    unset($items[$key]);
                }
            } else {
                if (isset($item['url'])) {
                    $admin = Yii::$app->user;
//                    $url = $item['url'][0];
                    $url = rtrim($item['url'][0], '\/');
                    if (!$admin->can($url)) {
                        //没有权限 删除菜单。
                        unset($items[$key]);
                    }
                }
            }
        }
    }
}