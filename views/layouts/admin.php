<?php
use yii\helpers\Html;
use app\widgets\AdminNavWidget;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerCssFile('@web/css/admin-nav.css');
$this->registerJsFile('@web/js/admin-nav.js', ['depends' => [\yii\web\JqueryAsset::class]]);
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

<div class="admin-layout">
    <?= AdminNavWidget::widget() ?>
    
    <div class="admin-content">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?> 