<?php

use humhub\modules\space\widgets\Chooser;
use humhub\modules\space\widgets\SpaceChooserItem;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\modules\ui\form\widgets\ActiveForm;

\humhub\modules\sharebetween\assets\Select2ExtensionAssetModal::register($this);
$triggerError = (strlen($error) > 0 ? '1' : '0');
?>
<div id="shareModal" class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <?= Yii::t('SharebetweenModule.base', '<strong>Share content</strong><BR><BR><span>Please select spaces</span>') ?>
            </h4>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'space_form', 'options' => ['data-ui-tabbed-form' => '']]); ?>
        
        <div class="modal-body">
            <div class="text-center">
                <?= SpacePickerField::widget([
                    'id' => 'space_filter',
                    'model' => $space,
                    'selection' => [],
                    'attribute' => 'guids',
                    'placeholder' => Yii::t('SearchModule.base', 'Specify space')
                ]) ?>

                <?= \humhub\widgets\LoaderWidget::widget(['id' => 'share-loader', 'cssClass' => 'loader-modal', 'show' => '']) ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('SharebetweenModule.base', 'Share'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ $("#share-loader").show() }'),
                    'success' => new yii\web\JsExpression("function(html){ $('#globalModal').html(html); }"),
                    'url' => yii\helpers\Url::to(['/sharebetween/share/index', 'id' => $content->id]),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]) ?>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><?= Yii::t('SharebetweenModule.base', 'Close') ?></button>
        </div>

        <?php $form::end(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        let triggerError = '<?= $triggerError ?>' ?? false;
        $.fn.select2.defaults = {};
        $('#space_filter').select2();
        $('#space_filter').trigger('update');
        setTimeout(() => {
            $('#space_filter + .select2 input[type=search]').focus();
        }, 100);

        if (triggerError == '1') {
            alert("<?= $error ?>");
            let errorFlag = true;
            $("#globalModal").modal("hide");
            $("#globalModal").on("hidden.bs.modal", function (e) {
                if (errorFlag) {
                    $(".media.wall-entry-header li > a[data-share-id='<?= $content->id ?>']").click();
                    errorFlag = false;
                }
            });
        }
    });
</script>