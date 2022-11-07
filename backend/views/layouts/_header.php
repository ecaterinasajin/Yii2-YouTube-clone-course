<?php
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;
?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-nav navbar-expand-lg navbar-light bg-light shadow-sm']
    ]);

    $menuItems = [['label' => 'Create', 'url' => ['/video/create']]];
  
    echo Nav::widget(['options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0 navbar-collapse justify-content-end'],'items' => $menuItems]);

    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } 
    else {
         echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout text-black-50 text-decoration-none'])
            . Html::endForm();
        }
    NavBar::end();
    ?>
</header>