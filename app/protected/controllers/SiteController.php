<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
        
        public function actionAddVideo(){
            
            if(Yii::app()->request->isAjaxRequest){
                //TODO perform sanitization
                $video = new Video();
                
                $result = array(
                    'result' => NULL,
                    'msg'    => NULL,
                    'errors' => array(),
                );
                
                (isset($_POST['uuid'])) ? $video->uuid = $_POST['uuid']:false;
                (isset($_POST['camera_uuid'])) ? $video->uuidCamera = $_POST['camera_uuid']:false;
                (isset($_POST['formats']['qvga']['video_url'])) ? $video->urlVideo = $_POST['formats']['qvga']['video_url']:false;
                (isset($_POST['formats']['qvga']['thumb_url'])) ? $video->urlThumbnail = $_POST['formats']['qvga']['thumb_url']:false;
                (isset($_POST['formats']['qvga']['small_thumb_url'])) ? $video->urlThumbnailSmall = $_POST['formats']['qvga']['small_thumb_url']:false;
                (isset($_POST['state'])) ? $video->status = $_POST['state']:false;
                
                if($video->validate() && $video->save()){
                    $result['result']   = 'success';
                    $result['data'] = $video->attributes;
                } else {
                    $result['result']   = 'error';
                    $result['msg']      = 'There were errors with your submission!';
                    $result['errors']   = CJSON::decode($video->getErrors());
                }
                
                exit(CJSON::encode($result));
            }else {
                $this->render('error', array('code'=>500, 'message' => 'There was a problem accessing this page!'));
            }
        }
        
        public function actionDeleteVideo(){
            
            if(Yii::app()->request->isAjaxRequest){
                //TODO perform sanitization
                $params = $this->getActionParams();

                $result = array(
                    'result' => NULL,
                    'msg'    => NULL,
                    'errors' => array(),
                );
                
                $video = new Video();
                
                //video uuid
                (isset($params['uuid'])) ? $uuid = $params['uuid']:false;
                
                //if the record exists and uuid is set then delete it
                if(isset($uuid) && $video->exists('uuid = :uuid', array(':uuid' => $uuid))){
                    //TODO getting a unauthorised error on $video->deleteFromProvider($uuid)
                    if($video->deleteByPk($uuid)){
                        $result = array(
                            'result' => 'success',
                        );
                    } else {
                        $result = array(
                            'result' => 'error',
                            'msg'    => 'Unable to delete the video!',
                            'errors' => CJSON::decode($video->getErrors())
                        );
                    }
                } else {
                    $result = array(
                        'result' => 'error',
                        'msg'    => 'Video does not exists or Uuid is not valid',
                    );
                }
                exit(CJSON::encode($result));
            } else {
                $this->render('error', array('code'=>500, 'message' => 'There was a problem accessing this page!'));
            }
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}