<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamVault - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0EA5E9 0%, #0277BD 50%, #01579B 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 8s ease-in-out infinite;
        }

        .orb:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .orb:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 50%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 14px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.06);
            animation: cardSlideUp 0.6s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes cardSlideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #38BDF8, #0284C7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .brand-header p {
            color: #475569;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 40px 12px 40px;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #FFFFFF;
        }

        .form-group input:focus {
            border-color: #38BDF8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
            outline: none;
        }

        .form-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #38BDF8, #0284C7);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #0EA5E9, #0369A1);
        }

        .error-message {
            background: #FEE2E2;
            color: #EF4444;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .shake {
            animation: shakeError 0.4s ease-in-out;
        }

        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>

    <div class="login-container">
        <div class="brand-header">
            <h1>StreamVault</h1>
            <p>Admin Dashboard Login</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
        <div class="error-message shake" id="error-message">
            Invalid email or password
        </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="post">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                password.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        }

        // Show error if present
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'block';
        }
    </script>
</body>
</html>