<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <script src="{{asset('vendors/jquery/jquery-3.6.0.min.js')}}"></script>
</head>

<body>
    <iframe src="{{ $data['link'] }}" frameborder="0" width="100%" height="1000px"></iframe>

    <script>
        function getLocalStream() {
            navigator.mediaDevices
                .getUserMedia({
                    video: true,
                    audio: true
                })
                .then((stream) => {
                    window.localStream = stream; // A
                    window.localAudio.srcObject = stream; // B
                    window.localAudio.autoplay = true; // C
                })
                .catch((err) => {
                    console.error(`you got an error: ${err}`);
                });
        }
        //document on ready
        $(document).ready(function() {
            getLocalStream();
        });
    </script>
</body>

</html>
