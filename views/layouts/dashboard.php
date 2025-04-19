<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="dashboard-container">
    <!-- Side Navigation -->
    <aside class="admin-nav">
        <div class="admin-nav-header">
            <img src="/images/logo.png" alt="Logo" class="admin-logo">
            <h1>Admin Panel</h1>
        </div>
        
        <nav class="admin-nav-menu">
            <div class="nav-item">
                <a href="/dashboard" class="nav-link">
                    <span class="nav-icon dashboard"></span>
                    <span class="nav-label">Dashboard</span>
                </a>
            </div>
            
            <div class="nav-item has-submenu active">
                <a href="#" class="nav-link">
                    <span class="nav-icon organization"></span>
                    <span class="nav-label">Organization</span>
                    <span class="submenu-arrow"></span>
                </a>
                <div class="submenu">
                    <a href="/organization/units" class="submenu-item">Organization Units</a>
                    <a href="/organization/structure" class="submenu-item">Structure</a>
                </div>
            </div>
            
            <div class="nav-item">
                <a href="/users" class="nav-link">
                    <span class="nav-icon users"></span>
                    <span class="nav-label">Users</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/activity" class="nav-link">
                    <span class="nav-icon activity"></span>
                    <span class="nav-label">Activity Log</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/downloads" class="nav-link">
                    <span class="nav-icon download"></span>
                    <span class="nav-label">Downloads</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/settings" class="nav-link">
                    <span class="nav-icon settings"></span>
                    <span class="nav-label">Settings</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <?= $content ?>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?> 