<?php
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;

    use yii\helpers\Url;
?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-nav navbar-expand-lg navbar-light bg-light shadow-sm']
    ]);

    $menuItems = [ ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }
    ?> 

    <form action="<?php echo Url::to(['/video/search']) ?>"
          class="form-inline">

        <input class="mt-1" 
               style="border-radius: 5px; border: 1px solid grey; padding: 7px;" 
               size="50px" type="search" 
               placeholder="Search"
               name="keyword"
               value="<?php echo Yii::$app->request->get('keyword') ?>">
            
        <button class="mb-1 btn btn-outline-success">Search</button>
    </form>

<?php
    echo Nav::widget(['options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0 navbar-collapse justify-content-end'],'items' => $menuItems]);

    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link text-danger login text-decoration-none']]),['class' => ['d-flex']]);
    } 
    else {
         echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout text-black-50 text-decoration-none'])
            . Html::endForm();
        }
    NavBar::end();
    ?>
</header>