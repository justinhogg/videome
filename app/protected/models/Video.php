<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property string $uuid
 * @property string $uuidCamera
 * @property string $urlThumbnail
 * @property string $urlThumbnailSmall
 * @property string $urlVideo
 * @property string $status
 * @property string $timestamp
 */
class Video extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uuid, uuidCamera, status', 'required'),
			array('uuid, uuidCamera,urlThumbnail, urlThumbnailSmall, urlVideo', 'length', 'max'=>255),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uuid' => 'Uuid',
                        'uuidCamera' => 'Uuid',
			'urlThumbnail' => 'Url Thumbnail',
			'urlThumbnailSmall' => 'Url Thumbnail Small',
			'urlVideo' => 'Url Video',
                        'status' => 'Url Video',
			'timestamp' => 'Timestamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Video the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * deleteFromProvider - deletes the video from the provider
         * @param string $uuid
         * @return boolean
         */
        public function deleteFromProvider($uuid){
            
            //TODO abstract the apikey/provider
            if($uuid){
                //set up new HTTP client
                $client = new Guzzle\Http\Client();
               
                try {
                    //make request
                    $request = $client->delete('https://cameratag.com/videos/'.$uuid.'.json?api_key=a-7c641d60-dbb1-0131-3985-1231390c0c78');
                    //get response
                    $response = $request->send();
                 } catch (RequestException $e) {
                     if ($e->hasResponse()) {
                         $this->errors = $e->getResponse();
                     }
                 }
                //if good return
                //TODO handle response code better
                if($response){
                    return TRUE;
                }
            }
            
            return FALSE;
        }
}
