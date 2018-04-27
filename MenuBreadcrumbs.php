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
    public $parentActiveIfItemHidden = true;        //子项隐藏后是否激活父项。(主要是在哪里unset掉子项，是在判断激活前还是判断激活后)
    public $breadcrumbs = [];
    public $breadcrumbs_cache_key = 'breadcrumbs';
    public $title;
    public $title_cache_key = 'pageTitle';

    public function run()
    {
        parent::run();

        //反转数组并存到session里面  cache应该会在并发时出现问题
        $session = Yii::$app->session;
        $session->set($this->breadcrumbs_cache_key, array_reverse($this->breadcrumbs));
        $session->set($this->title_cache_key, $this->title);
    }


    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (!$this->parentActiveIfItemHidden && isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
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
                    $active = $items[$i]['active'] = true;
                    //设置breadcrumbs
                    if(!isset($item['displayInBreadcrumbs']) || $item['displayInBreadcrumbs']){
                        $breadcrumb = [
                            'label' => $item['label'],
                            'url' => isset($item['url']) ? $item['url'] : null,
                        ];
                        $this->breadcrumbs[] = $breadcrumb;
                    }
                    //设置标题
                    if (isset($isActiveItem) && $isActiveItem) {
                        $this->title = $item['label'];
                    }
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
            //visible设置为不显示，因此unset掉。(激活父级，最前面的将不激活父级。)
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
        }
        return array_values($items);
    }
}