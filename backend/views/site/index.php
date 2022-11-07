<?php

/* @var $this yii\web\View */
/** @var $latestVideo \common\models\Video */
/** @var $numberOfView integer */
/** @var $numberOfSubscribers integer */
/** @var $subscribers \common\models\Subscriber[] */

$this->title = Yii::$app->name;
?>
<div class="site-index d-flex">
    <div class="card m-3" style="width: 30rem;">
        <?php if ($latestVideo): ?>
            <div class="embed-responsive mx-auto mt-1">
                <video class="embed-responsive-item" style="width: 470px;"
                       poster="<?php echo $latestVideo->getThumbnailLink() ?>"
                       src="<?php echo $latestVideo->getVideoLink() ?>"></video>
            </div>
            <div class="card-body">
                <h6 class="card-title"><?php echo $latestVideo->title ?></h6>
                <p class="card-text">
                    Likes: <?php echo $latestVideo->getLikes()->count() ?><br>
                    Views: <?php echo $latestVideo->getViews()->count() ?>
                </p>
                <a href="<?php echo \yii\helpers\Url::to(['/video/update',
                    'video_id' => $latestVideo->video_id]) ?>"
                   class="btn btn-primary">
                    Edit
                </a>
            </div>
        <?php else: ?>
            <div class="card-body">
                You don't have uploaded videos yet
            </div>
        <?php endif; ?>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Total Views</h6>
            <p class="card-text" style="font-size: 48px">
                <?php echo $numberOfView ?>
            </p>
        </div>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Total Subscribers</h6>
            <p class="card-text" style="font-size: 48px">
                <?php echo $numberOfSubscribers ?>
            </p>
        </div>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Latest Subscribers</h6>
            <?php foreach ($subscribers as $subscriber): ?>
                <div>
                    <?php echo $subscriber->user->username ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
