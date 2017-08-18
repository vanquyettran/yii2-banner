<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \common\modules\banner\models\Banner;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\Banner */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
    ['depends' => \yii\web\JqueryAsset::className()]
);
$this->registerJsFile(
    \yii\helpers\Url::to(['/cdn/image-upload/index']),
    ['depends' => \yii\web\JqueryAsset::className()]
);
$this->registerJs(
    'imageUpload("' . Html::getInputId($model, 'image_id') . '", "image-preview-wrapper", "image-file-input")',
    \yii\web\View::POS_READY
);
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="<?= Yii::getAlias('@web/libs/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= Url::to(['/cdn/ckeditor/index']) ?>"></script>
<?php
// @TODO: Default value for some boolean attributes
if ($model->isNewRecord) {
    foreach (['active'] as $attribute) {
        $model->$attribute = true;
    }
}
?>
<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type')->dropDownList(Banner::getTypes(), ['prompt' => 'Select one...']) ?>

            <?php
            $image_uploader = '<div class="clearfix">' .
                '<div id="image-preview-wrapper">'
                . $model->img() .
                (($image = $model->image) ? "<div>{$image->width}x{$image->height}; {$image->aspect_ratio}</div>" : '') .
                '</div>' .
                '<input type="file" id="image-file-input" name="image_file" accept="image/*">' .
                '</div>';

            echo $form->field($model, 'image_id', [
                'template' => "{label}$image_uploader{input}{error}{hint}"])->dropDownList(
                $model->image ? [$model->image->id => $model->image->name] : []);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'caption')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort_order')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
