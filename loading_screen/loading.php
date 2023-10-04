<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Page Loading</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* CSS for Loading Screen */
        body {
            margin: 0;
            overflow: hidden;
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        .loading-message {
            color: white;
            margin-top: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Loading Screen -->
    <div id="loading" class="loading-screen">
        <div class="loader-container">
            <div class="loader"></div>
            <div class="loading-message">Please wait...</div>
        </div>
    </div>

    <!-- Content Container -->
    <!-- <div id="content-container"> -->
    <!-- Content will be loaded here -->
    </div>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentContainer = document.getElementById('content-container');

            // Function to load content into the content container
            function loadContent(contentUrl) {
                // Show the loading screen
                const loadingScreen = document.getElementById('loading');
                loadingScreen.style.display = 'flex';

                // Simulate loading content with a delay (replace with fetch or AJAX)
                setTimeout(function() {
                    // Hide the loading screen
                    loadingScreen.style.display = 'none';
                }, 2000); // Simulated 2-second delay

                // You can replace the simulated loading with actual content loading logic
            }

            // Load initial content
            loadContent('initial-content.html'); // Replace with the initial content URL

            // Example: Load content on button click
            const loadButton = document.createElement('button');
            loadButton.textContent = 'Load New Content';
            loadButton.addEventListener('click', function() {
                loadContent('new-content.html'); // Replace with the new content URL
            });
            contentContainer.appendChild(loadButton);
        });
    </script>
</body>

</html>