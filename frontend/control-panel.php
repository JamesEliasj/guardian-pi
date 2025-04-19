<?
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Recognition Control Panel</title>
    <script>
        function sendRequest(endpoint) {
            fetch(endpoint)
                .then(response => response.json())
                .then(data => alert(data.status))
                .catch(error => console.error('Error:', error));
        }

        function captureImage() {
            let name = prompt("Enter name for this person:");
            if (name) {
                fetch('http://localhost:5000/capture', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `name=${name}`
                }).then(response => response.json())
                  .then(data => alert(data.status))
                  .catch(error => console.error('Error:', error)
                );
            }
        }
    </script>
</head>
<body style="background-color: black;">
    <h1 style="color: white;">Face Recognition Control Panel</h1>
    <button onclick="sendRequest('http://localhost:5000/start')">Start Face Recognition</button>
    <!--button onclick="sendRequest('http://localhost:5000/stop')">Stop Face Recognition</button-->
    <button onclick="captureImage()">Capture Image</button>
    <button onclick="sendRequest('http://localhost:5000/train')">Train Model</button>
</body>
</html>
