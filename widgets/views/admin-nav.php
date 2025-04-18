<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="admin-nav">
    <div class="admin-nav-header">
        <?= Html::img('@web/images/logo.png', ['class' => 'admin-logo', 'alt' => 'Admin Hub']) ?>
        <h1>Admin Hub</h1>
    </div>
    
    <nav class="admin-nav-menu">
        <?php foreach ($items as $item): ?>
            <div class="nav-item <?= isset($item['items']) ? 'has-submenu' : '' ?>">
                <a href="<?= Url::to($item['url']) ?>" class="nav-link">
                    <span class="nav-icon <?= $item['icon'] ?>"></span>
                    <span class="nav-label"><?= Html::encode($item['label']) ?></span>
                    <?php if (isset($item['items'])): ?>
                        <span class="submenu-arrow"></span>
                    <?php endif; ?>
                </a>
                
                <?php if (isset($item['items'])): ?>
                    <div class="submenu">
                        <?php foreach ($item['items'] as $subItem): ?>
                            <a href="<?= Url::to($subItem['url']) ?>" class="submenu-item">
                                <?= Html::encode($subItem['label']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </nav>
</div> 