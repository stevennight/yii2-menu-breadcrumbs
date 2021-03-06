<?php
/**
 * Created by PhpStorm.
 * User: Stevennight
 * Date: 2018/4/27
 * Time: 10:46
 */

$menu = stevennight\menu_breadcrumbs\MenuBreadcrumbs::widget([
    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
    'breadcrumbs_cache_key' => 'aaaaaa',        //define a key of the cache which save the breadcrumbs array. 定义面包屑储存在缓存的键。
    'openRbac' => true,                        //Use Rbac.
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
$session = Yii::$app->session;
if (!isset($this->params['customerBreadcrumbs']) || !$this->params['customerBreadcrumbs']) {
    $breadcrumbs = $session->get('aaaaaa');         //default key is breadcrumbs, but set 'aaaaaa' in above config here. 默认键为breadcrumbs，但是此处上面的配置中设置为'aaaaaa'
    if(!empty($breadcrumbs)){
        $this->params['breadcrumbs'] = $breadcrumbs;
    }else{
        $this->params['breadcrumbs'] = [];
    }
}
if (!isset($this->params['customerTitle']) || !$this->params['customerTitle']) {
    $title = $session->get('pageTitle');            //This is a default key here. 这个是默认的键
    if(!empty($title)){
        $this->title = $title;
    }
}