<?php
/**
 * Created by PhpStorm.
 * User: Stevennight
 * Date: 2018/4/27
 * Time: 10:46
 */

$menu = stevennight\menu_breadcrumbs\MenuBreadcrumbs::widget([
    'options' => ['class' => 'sidebar-menu'],
    'parentActiveIfItemHidden' => true,         //Setting the parent item active is it when the item is hidden in the menu. 设置子项在菜单中隐藏时，父级菜单是否激活。
    'breadcrumbs_cache_key' => 'aaaaaa',        //define a key of the cache which save the breadcrumbs array. 定义面包屑储存在缓存的键。
    'items' => [
        [
            'label' => '权限管理',
            'icon' => 'sticky-note',
            'displayInBreadcrumbs' => false,    //Hidden this node in breadcrumbs. 在面包屑中隐藏该节点。
            'items' => [
                [
                    'label' => '管理员管理',
                    'icon' => 'user-plus',
                    'url' => ['auth/index'],
                ],
                [
                    'label' => '角色管理',
                    'icon' => 'tasks',
                    'url' => ['auth/role'],
                    'items' => [
                        [
                            'label' => '角色添加',
                            'icon' => 'tasks',
                            'visible' => false,     //hidden the item in menu. 不在菜单中显示该项。
                            'url' => ['auth/add-role']
                        ],
                        [
                            'label' => '角色编辑',
                            'icon' => 'tasks',
                            'visible' => false,     //hidden the item in menu. 不在菜单中显示该项。
                            'url' => ['auth/permission']
                        ],
                    ],
                ],
            ]
        ],
    ],
]);
if(!isset($this->params['customerBreadcrumbs']) || $this->params['customerBreadcrumbs']){
    $breadcrumbs = Yii::$app->cache->get('aaaaaa');
    $this->params['breadcrumbs'] = $breadcrumbs;
}
if(!isset($this->params['customerTitle']) || $this->params['customerTitle']){
    $title = Yii::$app->cache->get('pageTitle');
    $this->title = $title;
}