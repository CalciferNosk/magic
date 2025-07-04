<!DOCTYPE html>
<html>

<head>
    <title>QR Scanner</title>
</head>

<body>
    <h1>Scanner</h1>
    <center>
        <div style="border:70px solid grey;width: <?= $ismobile ?>">
            <video id="video" style="width: 100%;"></video>
            <canvas id="canvas" hidden></canvas>
        </div>
        <p id="status"></p>
        <a href="#"target="_blank" id="link"> Your Google Link</a>
        <input type="hidden" id="geo_loc" value="" style="width: 50%;" readonly>
        <center>
            <p id="output"></p>
            <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
            <script>
                getLocation();
                const event_id = 1;
                const video = document.getElementById('video');
                const canvasElement = document.getElementById('canvas');
                const canvas = canvasElement.getContext('2d');
                const output = document.getElementById('output');
                var geo = document.getElementById('geo_loc')

                function startQRScanner() {
                    navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: 'environment'
                            }
                        })
                        .then(function(stream) {
                            video.srcObject = stream;
                            video.setAttribute('playsinline', true); // Required for iOS
                            video.play();
                            requestAnimationFrame(scanQR);
                        })
                        .catch(err => {
                            console.error("Error accessing camera: ", err);
                        });
                }

                function scanQR() {
                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        canvasElement.height = video.videoHeight;
                        canvasElement.width = video.videoWidth;
                        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                        const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);

                        if (code) {
                            // Output the QR code data and stop scanning
                            // output.innerText = `QR Code: ${code.data}`;
                            console.log(code.data);
                            stopScanner();
                            // Optionally navigate to the scanned URL
                            var lati = sessionStorage.getItem('scan_lat');
                            var longi = sessionStorage.getItem('scan_long');
                            var maps = sessionStorage.getItem('scan_maps');
                            location.href = code.data + 'attendance&ml_encode=' + maps + '&ml_lati=' + lati + '&ml_longi=' + longi;
                        }
                    }
                    requestAnimationFrame(scanQR);
                }

                function stopScanner() {
                    // Stop the video stream and cleanup
                    const stream = video.srcObject;
                    if (stream) {
                        const tracks = stream.getTracks();
                        tracks.forEach(track => track.stop());
                    }
                    video.srcObject = null;
                }

                startQRScanner();



                function getLocation() {
                    const status = document.getElementById("status");

                    if (!navigator.geolocation) {
                        status.textContent = "Geolocation is not supported by this browser.";
                        return null;
                    }

                    status.textContent = "Getting location...";

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const {
                                latitude,
                                longitude
                            } = position.coords;
                            const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;

                            status.textContent = "Location found! Opening Google Maps...";
                            // window.open(googleMapsUrl, "_blank");
                            sessionStorage.setItem('scan_maps',googleMapsUrl);
                            sessionStorage.setItem('scan_lat',latitude);
                            sessionStorage.setItem('scan_long',longitude);
                           

                            document.getElementById('link').href = googleMapsUrl;
                            loc.href = googleMapsUrl;
                            geo.value = googleMapsUrl;
                            // alert(googleMapsUrl);
                            return googleMapsUrl;
                        },
                        (error) => {
                            const errorMessages = {
                                PERMISSION_DENIED: "Permission denied. Please allow location access.",
                                POSITION_UNAVAILABLE: "Location information is unavailable.",
                                TIMEOUT: "Location request timed out.",
                            };
                            status.textContent = errorMessages[error.code] || "An unknown error occurred.";
                        }
                    );
                }
            </script>
</body>

</html>