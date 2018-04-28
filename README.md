# yii2-menu-breadcrumbs

[![GitHub version](https://badge.fury.io/gh/stevennight%2Fyii2-menu-breadcrumbs.svg)](https://badge.fury.io/gh/stevennight%2Fyii2-menu-breadcrumbs)
[![Latest Stable Version](https://poser.pugx.org/stevennight/menu-breadcrumbs-package/v/stable)](https://packagist.org/packages/stevennight/menu-breadcrumbs-package)
[![Total Downloads](https://poser.pugx.org/stevennight/menu-breadcrumbs-package/downloads)](https://packagist.org/packages/stevennight/menu-breadcrumbs-package)
[![Latest Unstable Version](https://poser.pugx.org/stevennight/menu-breadcrumbs-package/v/unstable)](https://packagist.org/packages/stevennight/menu-breadcrumbs-package)
[![License](https://poser.pugx.org/stevennight/menu-breadcrumbs-package/license)](https://packagist.org/packages/stevennight/menu-breadcrumbs-package)
[![composer.lock](https://poser.pugx.org/stevennight/menu-breadcrumbs-package/composerlock)](https://packagist.org/packages/stevennight/menu-breadcrumbs-package)

Automatic generate the breadcrumbs with the menu setting.And try to optimizate the menu plugin.

**Test in dmstr's yii2 adminLTE asset bundle and only for it now, because this plugin extends from dmstr/menu...**

*There are some features of this plugin:*
1. Automatic generate the breadcrumbs by the menu setting.
1. Also could automatic generate the page title by the menu item label.
1. Could set the parent item active when the item is invisible which is below this parent item 
1. The item would be hidden when it link to a page user without rbac permission. (set openRbac to true)

*future plan:*
1. to independent, not extends from dmstr/menu.

There is a example in the viewExample.php file.

**If you have any question, ask to me please.**

# 中文说明

根据菜单设置自动生成面包屑，并且尝试优化菜单插件。

**通过在dmstr的yii2 adminLTE asset包的测试，并且目前只能运作在它上面，因为插件继承自dmstr/menu…**

*插件功能*
1. 自动根据菜单设置生成面包屑。
1. 也自动根据标签生成页面标题。
1. 可以将激活并且不可见的菜单项的父级设置成active激活。
1. 根据rbac的权限进行菜单的显影。

*未来计划*
1. 独立成一款插件，不继承自dmstr/menu。

关于示例，可以查看viewExample.php文件。

**如果有什么问题，请联系我，谢谢。**
