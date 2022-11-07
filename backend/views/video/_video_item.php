<?php

/** @var $model \common\models\Video */

use \yii\helpers\StringHelper;
use yii\helpers\Url;

?>

<div class="row" style="width: 300px;">
    <div class="col-sm-3">
        <a href="<?php echo Url::to(['/video/update', 'video_id' => $model->video_id]) ?>">
            <video class="mt-2" 
                    style="width: 200px;" 
                    poster="<?php echo $model->getThumbnailLink() ?>" 
                    src="<?php echo $model->getVideoLink() ?>" >
            </video>
        </a>    
    </div>

    <div class="offset-6 col-sm-1">
        <h6 class="mt-2" style="min-width:250px;"><?php echo $model->title ?></h6>
       
    </div>

</div>
