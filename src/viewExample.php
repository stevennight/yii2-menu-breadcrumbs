<?php
/**
 * Created by PhpStorm.
 * User: Stevennight
 * Date: 2018/4/27
 * Time: 10:46
 */

$menu = stevennight\menu_breadcrumbs\MenuBreadcrumbs::widget([
    'options' => ['class' => 'sidebar-menu'],
    'breadcrumbs_cache_key' => 'aaaaaa',
    'items' => [
        [
            'label' => '权限管理',
            'icon' => 'sticky-note',
            'url' => '#',
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
                            'visible' => false,
                            'url' => ['auth/add-role']
                        ],
                        [
                            'label' => '角色编辑',
                            'icon' => 'tasks',
                            'visible' => false,
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