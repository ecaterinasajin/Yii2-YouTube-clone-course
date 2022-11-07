<?php

use common\helpers\Html as HelpersHtml;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
/** @var $model \common\models\Video */
/** @var $similarVideos \common\models\Video[] */
?>

<div class="row">
    <div class="col-sm-8">

        <div class="embed-responsive">
            <video class="embed-responsive-item" style="width: 1040px;" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" controls></video>
        </div>

        <div class="mt-2 fs-3"><b><?php echo $model->title ?></b></div>

        <div class="d-flex mt-sm-3">
            <div class="mt-sm-2">
                <?php echo $model->getViews()->count() ?> views | <?php echo Yii::$app->formatter->asDate($model->created_at) ?> &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            
            <div>
                <?php yii\widgets\Pjax::begin()?>
                    <?php echo $this->render('_buttons', ['model' => $model]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div> 

        <div>
            <p class="text-muted">
                video author: 
                <?php //echo Html::a($model->createdBy->username, ['/channel/view', 'username' => $model->createdBy->username]) ?>
                <a class="text-body"> <?php echo \common\helpers\Html::channelLink($model->createdBy) ?> </a>
            </p>
            <?php echo Html::encode($model->description) ?> 
        </div>
    </div>

    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo) : ?>

            <div class="row">
            
            <div class="col-4">
                <a href="<?php echo Url::to(['/video/view', 'video_id' => $similarVideo->video_id]) ?>">
                    <video class="mt-2" 
                            style="width: 250px;" 
                            poster="<?php echo $similarVideo->getThumbnailLink() ?>" 
                            src="<?php echo $similarVideo->getVideoLink() ?>" >
                    </video>
                </a>  
            </div>  

                <div class="offset-2 col-5">
                    <h6 class="mt-2" style="min-width:150px;"><?php echo $similarVideo->title ?></h6>

                    <div class="text-muted">
                        <p>
                            <?php echo HelpersHtml::channelLink($similarVideo->createdBy) ?>
                        </p>
                        <p>
                            <?php echo $similarVideo->getViews()->count() ?> views |
                            <?php echo Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                        </p>

                    </div>

                </div>

            </div>


        <?php endforeach; ?>
    </div>
</div>