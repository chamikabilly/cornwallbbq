<?php
function add_advanced_loading_screen()
{
    ?>
    <div id="loading-screen">
        <div class="loading-container">
            <div class="logo">
                <!-- Add your logo here -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="Loading..."
                    loading="lazy">
            </div>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <p>Loading your experience...</p>
        </div>
    </div>

    <style>
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .loading-container {
            text-align: center;
            max-width: 300px;
        }

        .logo img {
            max-width: 150px;
            margin-bottom: 30px;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: #f0f0f0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress {
            width: 0%;
            height: 100%;
            background: #3498db;
            transition: width 0.3s ease;
        }

        .loaded #loading-screen {
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressBar = document.querySelector('.progress');
            const loadingScreen = document.getElementById('loading-screen');

            // Simulate progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress >= 90) {
                    progress = 90;
                    clearInterval(interval);
                }
                progressBar.style.width = progress + '%';
            }, 200);

            window.addEventListener('load', function () {
                progressBar.style.width = '100%';
                setTimeout(() => {
                    document.body.classList.add('loaded');
                    setTimeout(() => {
                        loadingScreen.remove();
                    }, 500);
                }, 300);
            });

            // Fallback
            setTimeout(() => {
                document.body.classList.add('loaded');
                setTimeout(() => {
                    loadingScreen.remove();
                }, 500);
            }, 4000);
        });
    </script>
    <?php
}
add_action('wp_body_open', 'add_advanced_loading_screen');