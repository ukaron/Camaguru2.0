(function camshoot() {

    let width = 320;
    let height = 0;
    let streaming = false;
    let video = null;
    let canvas = null;
    let photo = null;
    let startbutton = null;
    let gallery = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');
        gallery = document.getElementById('gallery');

        navigator.mediaDevices.getUserMedia({video: true, audio: false})
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                console.log("An error occurred: " + err);
            });

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);

                // Firefox currently has a bug where the height can't be read from
                // the video, so we will make assumptions if this happens.

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;

            }
        }, false);

        startbutton.addEventListener('click', function(ev){
            takepicture();
                ev.preventDefault();
        }, false);

        clearphoto();
        let lastNode = gallery.lastChild;
        lastNode.parentNode.removeChild(lastNode);

    }

    // Fill the photo with an indication that none has been
    // captured.

    function clearphoto() {
        let context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
        let data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);

    }



    function takepicture() {
        let mask = document.querySelector("input[name='mask']:checked").value
        let context = canvas.getContext('2d');
        if (width && height)
        {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            let data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", '/index.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function olol(){
                if (xhr.readyState === 4)
                    if(xhr.status === 200)
                        uploadPicture()
            };
            xhr.send("photo="+ btoa(photo.src)+"&mask="+mask);

        }
        else
            {
            clearphoto();
        }
    }

       function uploadPicture()
       {
           let newImg = document.createElement('img');
           let inputSave = document.createElement('input');
           let scriptSave = document.createElement('script');
           newImg.setAttribute("src", "./resources/tmp.png");
           newImg.setAttribute('id', 'mergePhoto');
           inputSave.setAttribute('type', 'submit');
           inputSave.setAttribute('action', './save.php');
           inputSave.setAttribute('onClick', 'savePhoto()');
           inputSave.setAttribute('id', 'buttonSave');

           gallery.appendChild(scriptSave);
           gallery.appendChild(newImg);
           gallery.appendChild(inputSave);
          inputSave.addEventListener('click', savePhoto, false);
       }

      function savePhoto() {
               let xhr = new XMLHttpRequest();
               xhr.open("POST", '/main/camshoot/', true);
               xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
               xhr.onreadystatechange = function olol() {
                   if (xhr.readyState === 4)
                       if (xhr.status === 200)
                           alert("OK");
               };
               xhr.send("action=1");

       }
    window.addEventListener('load', startup, false);
})();

