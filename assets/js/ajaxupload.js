window.onload = function() {
  
  var btn = document.getElementById('upload-btn'),
      wrap = document.getElementById('pic-progress-wrap'),
      picBox = document.getElementById('picbox'),
      errBox = document.getElementById('errormsg');
  
  var uploader = new ss.SimpleUpload({
        button: btn,
        url: '#',
        progressUrl: '#',
        name: 'imgfile',
        multiple: true,
        maxUploads: 2,
        maxSize: 500,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        accept: 'image/*',
        hoverClass: 'btn-hover',
        focusClass: 'active',
        disabledClass: 'disabled',
        responseType: 'json',
        onExtError: function(filename, extension) {
          alert(filename + ' is not a permitted file type.'+"\n\n"+'Only PNG, JPG, and GIF files are allowed in the demo.');
        },
        onSizeError: function(filename, fileSize) {
          alert(filename + ' is too big. (500K max file size)');
        },        
        onSubmit: function(filename, ext) {            
           var prog = document.createElement('div'),
               outer = document.createElement('div'),
               bar = document.createElement('div'),
               size = document.createElement('div');
                       
            prog.className = 'prog';
            size.className = 'size';
            outer.className = 'progress progress-striped active';
            bar.className = 'progress-bar progress-bar-success';
            
            outer.appendChild(bar);
            prog.innerHTML = '<span style="vertical-align:middle;">'+safe_tags(filename)+' - </span>';
            prog.appendChild(size);
            prog.appendChild(outer);
            wrap.appendChild(prog); // 'wrap' is an element on the page
            
            this.setProgressBar(bar);
            this.setProgressContainer(prog);
            this.setFileSizeBox(size);      
            
            errBox.innerHTML = '';
            btn.value = 'Choose another file';
          },    
        startXHR: function() {
          // Dynamically add a "Cancel" button to be displayed when upload begins
          // By doing it here ensures that it will only be added in browses which 
          // support cancelling uploads
          var abort = document.createElement('button');
            
            wrap.appendChild(abort);
            abort.className = 'btn btn-sm btn-info';
            abort.innerHTML = 'Cancel';

            // Adds click event listener that will cancel the upload
            // The second argument is whether the button should be removed after the upload
            // true = yes, remove abort button after upload
            // false/default = do not remove
            this.setAbortBtn(abort, true);              
        },          
        onComplete: function(filename, response) {
            if (!response) {
              errBox.innerHTML = 'Unable to upload file';
              return;
            }     
            if (response.success === true) {
              picBox.innerHTML = '<img src="/code/ajaxuploader/view-img.php?file=' + encodeURIComponent(response.file) + '">';
            } else {
              if (response.msg)  {
                errBox.innerHTML = response.msg;
              } else {
                errBox.innerHTML = 'Unable to upload file';
              }
            }
          }
  });
};
