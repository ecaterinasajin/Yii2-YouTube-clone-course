<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Video $model */
/** @var yii\bootstrap5\ActiveForm $form */

\backend\assets\TagsInputAsset::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="offset-sm-2 col-sm-4"><br>

            <?php echo $form->errorSummary($model) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 7]) ?>

            <div class="form-group">
                <label><?php echo $model->getAttributeLabel('thumbnail') ?></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                    <label class="custom-file-lable" for="thumbnail"> Choose file </label>
                </div>
            </div>

            <div class="mt-sm-4">
                <?= $form->field($model, 'tags',['inputOptions' => ['data-role' => 'tagsinput']])->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <!-- video in grid -->
        <div class="col-sm-4 mt-lg-2">
            <div class="embed-responsive embed-responsive-16by9"><br>
                <video class="embed-responsive-item mt-9" style="width: 520px;" 
                       poster="<?php echo $model->getThumbnailLink() ?>" 
                       src="<?php echo $model->getVideoLink() ?>" 
                       controls>
                </video>
            </div>

            <div class="mt-1">
                <a class="text-muted" style="text-decoration: none;">Video Link - </a>
                <a href="<?php echo $model->getVideoLink() ?>">
                    Open Video
                </a>
            </div>

            <div class="mt-2">
                <a class="text-muted" style="text-decoration: none;"> Video Name - </a>
                <?php echo $model->video_name ?>
            </div>

            
            <div class="mt-4" style="width:520px;">
                <?= $form->field($model, 'status')->dropDownList($model->getStatusLabel()) ?>
            </div>
        </div>
        </div>
    </div><br><br>
    
    <div class="row">
        <div class="d-flex justify-content-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'style' => 'width:70px;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
