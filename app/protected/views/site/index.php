<?php
/* @var $this SiteController */

$cameraId = 'videome001';

// register scripts required
$videoScript = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application').'/../_assets/js/010-camera.js');
Yii::app()->clientScript->registerScriptFile($videoScript,CClientScript::POS_END);
Yii::app()->clientScript->registerScript('camera',"vm.camera.init('$cameraId');",CClientScript::POS_READY);

$this->pageTitle=Yii::app()->name;

?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p class="msg">Record your video:</p>

<div id="myCamera">
   <camera id="<?php echo $cameraId; ?>" data-app-id="a-7c641d60-dbb1-0131-3985-1231390c0c78" data-sources="record" style="width:400px;height:300px;" data-poll-for-processed="true"></camera> 
</div>

<div id="myVideo" style="display:none;">
    <video id="<?php echo $cameraId; ?>" data-uuid=""></video>
    <button type="button" class="deleteVideo" data-uuid="">Delete Your Video</button>
</div>


<!-- Modal -->
<div class="modal fade" id="modalProcessing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Please wait while we process your video.</h4>
        <p>(maybe go grab a cup of tea....)</p>
      </div>
      <div class="modal-body center-block">
        <img src="/_assets/images/ajax-loader.gif">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete your video?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


