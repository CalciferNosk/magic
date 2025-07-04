<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        video {
            margin-top: 20px;
            width: 100%;
            max-width: 400px;
            height: auto;
            border: 1px solid #ccc;
        }
        p {
            font-size: 18px;
        }
        #outputData {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <h1>QR Code Scanner</h1>
    <video id="video" playsinline></video>
    <canvas id="canvas" style="display:none;"></canvas>
    <p id="outputMessage">Waiting for camera...</p>
    <p id="outputData"></p>

    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const outputMessage = document.getElementById('outputMessage');
        const outputData = document.getElementById('outputData');

        function getUserMediaSupport() {
            return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
        }

        if (getUserMediaSupport()) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    video.onloadedmetadata = () => {
                        video.play();
                        requestAnimationFrame(tick);
                    };
                })
                .catch(function(err) {
                    console.error("Error accessing camera: ", err);
                    outputMessage.innerText = "Error accessing the camera.";
                });
        } else {
            alert("Your browser does not support accessing the camera via getUserMedia.");
        }

        function tick() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.height = video.videoHeight;
                canvas.width = video.videoWidth;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    drawLine(code.location.topLeftCorner, code.location.topRightCorner, context);
                    drawLine(code.location.topRightCorner, code.location.bottomRightCorner, context);
                    drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, context);
                    drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, context);
                    outputMessage.hidden = true;
                    outputData.innerText = `QR Code Data: ${code.data}`;
                    
                    // Redirect after successful scan
                    window.location.href = `${code.data}?data_user=1`;
                } else {
                    outputMessage.hidden = false;
                    outputMessage.innerText = "No QR code detected.";
                    outputData.innerText = '';
                }
            }
            requestAnimationFrame(tick);
        }

        function drawLine(begin, end, context) {
            context.beginPath();
            context.moveTo(begin.x, begin.y);
            context.lineTo(end.x, end.y);
            context.lineWidth = 4;
            context.strokeStyle = 'red';
            context.stroke();
        }
    </script>
</body>
</html>
