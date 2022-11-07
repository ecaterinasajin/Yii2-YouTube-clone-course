<?php
use yii\helpers\Url;

/** @var $model \common\models\Video */
?>

<div class="card m-lg-4" style="width:340px; border:none;">
    <a href="<?php echo Url::to(['/video/view', 'video_id' => $model->video_id]) ?>">
        <div class="embed-responsive rounded mx-auto d-block">
            <video class="embed-responsive-item mx-auto d-block mt-1" style="width: 330px;" 
                    poster="<?php echo $model->getThumbnailLink() ?>" 
                    src="<?php echo $model->getVideoLink() ?>"></video>
        </div>
    </a>
    <div class="card-bod p-2">
        <h5 class="card-title m-0"><?php echo $model->title ?></h5>
        <p class="text-muted card-text m-0">
            <?php //echo \common\helpers\Html::channelLink($model->createdBy) ?>
                 video author: 
           <?php //echo $model->createdBy->username ?>
           <?php echo \common\helpers\Html::channelLink($model->createdBy) ?>
        </p>
        <p class="text-muted card-text m-0">
            <?php echo $model->getViews()->count() ?> 
                views | 
            <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
    </div>
</div>
