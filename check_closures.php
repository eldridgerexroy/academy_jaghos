<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Login Test</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
            // Optionally decode the ID token for more information
            // You can use the token for your backend authentication
        }

        window.onload = function () {
            google.accounts.id.initialize({
                client_id: '59090348286-rt0js2aijchn4r6hi3e23vbjgut3enlo.apps.googleusercontent.com.apps.googleusercontent.com',
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.getElementById("buttonDiv"),
                { theme: "outline", size: "large" } // customization attributes
            );
        }
    </script>
</head>
<body>
    <h1>Google Login Test</h1>
    <div id="buttonDiv"></div>
</body>
</html>
