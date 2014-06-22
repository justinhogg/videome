/**
 * 
 * camera - handles the camera functions
 * @author Justin Hogg
 */
vm.camera = {
    
    _cameraId:null,
    _myCamera:null,
    _pleaseWaitDiv:null,
    
    //init for camera
    init: function(cameraId) {
        var self = this;
        
        self._cameraId = cameraId;

        //if camera has initialized then set my camera
        CameraTag.observe(self._cameraId, 'initialized', function(){
            self._myCamera = CameraTag.cameras[self._cameraId];
        });
       
        //if camera is published then get data
        CameraTag.observe(self._cameraId, 'published', function(){
            //post the content
            $.post('/addVideo', self._myCamera.getVideo(), 
                function(response){
                    //if the data is success
                    if(response.result == 'success') {
                        $('#myCamera').remove();
                        
                        //show video block
                        $('#myVideo').show();
                        
                        //change message
                        $('.msg').html('Play/Delete your video:');

                        //set the uuid
                        $('#myVideo video').attr('data-uuid',response.data.uuid);
                        $('#myVideo button.deleteVideo').attr('data-uuid',response.data.uuid);
                       
                        //center video/button
                        $('#myVideo').css('margin','0 auto').css('display','inline-block');
                        $('button.deleteVideo').css('margin-top','10px');
                        
                        //processing modal
                        $('#modalProcessing').modal();
                        
                    }
                    //TODO handle errors
            }, 'json');
            
        });
        
        //if video has processed then load video
        CameraTag.observe(self._cameraId, 'processed', function(){
            //remove processing modal
            $('#modalProcessing').modal('hide');
            //reload
            CameraTag.setup();           
        });
        
        //if delete is clicked
        $('button.deleteVideo').on('click',function(event) {
            //confirm deletion
            $('#modalConfirm').modal().one('click', '#delete', function() {
                var video = self._myCamera.getVideo();
                var values  = {};
                values['uuid'] = video.uuid;
                //delete the video
                $.getJSON('/deleteVideo', values, function(response){
                    if(response.result == 'success') {
                        $('#myVideo').remove();

                        //change message
                        $('.msg').html('Your video has been removed');
                        
                    }
                   //TODO handle errors
                  });  
            
            });
            //prevent the default bahavior
            event.preventDefault();
        });
    }
}



