<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamVault - Installer</title>
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
            background: #F0F4F8;
            background-image:
                radial-gradient(ellipse at 10% 20%, rgba(186, 230, 253, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(186, 230, 253, 0.2) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.1);
            animation: float 8s ease-in-out infinite;
        }

        .bubble:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .bubble:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 15%;
            animation-delay: 3s;
        }

        .bubble:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 70%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .installer-container {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 14px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.06);
            animation: cardIn 0.5s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes cardIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
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
        }

        .brand-header p {
            color: #475569;
            font-size: 14px;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #E2E8F0;
            color: #94A3B8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #38BDF8;
            color: white;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.2);
        }

        .step.done {
            background: #10B981;
            color: white;
        }

        .step.done::before {
            content: '✓';
        }

        .step-content {
            min-height: 300px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: alertIn 0.35s ease-out;
        }

        @keyframes alertIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert.success {
            background: #D1FAE5;
            color: #10B981;
            border: 1px solid #A7F3D0;
        }

        .alert.error {
            background: #FEE2E2;
            color: #EF4444;
            border: 1px solid #FECACA;
        }

        .alert i {
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #1E293B;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #38BDF8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
            outline: none;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn.primary {
            background: linear-gradient(135deg, #38BDF8, #0284C7);
            color: white;
        }

        .btn.primary:hover {
            background: linear-gradient(135deg, #0EA5E9, #0369A1);
        }

        .btn.secondary {
            background: #F1F5F9;
            color: #475569;
        }

        .btn.secondary:hover {
            background: #E2E8F0;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: #E2E8F0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #38BDF8, #0EA5E9);
            width: 0%;
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 480px) {
            .installer-container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <div class="installer-container">
        <div class="brand-header">
            <h1>StreamVault</h1>
            <p>Installation Wizard</p>
        </div>

        <div class="step-indicator">
            <div class="step <?php echo $current_step >= 1 ? 'active' : ''; ?> <?php echo $current_step > 1 ? 'done' : ''; ?>">1</div>
            <div class="step <?php echo $current_step >= 2 ? 'active' : ''; ?> <?php echo $current_step > 2 ? 'done' : ''; ?>">2</div>
            <div class="step <?php echo $current_step >= 3 ? 'active' : ''; ?> <?php echo $current_step > 3 ? 'done' : ''; ?>">3</div>
            <div class="step <?php echo $current_step >= 4 ? 'active' : ''; ?> <?php echo $current_step > 4 ? 'done' : ''; ?>">4</div>
        </div>

        <div class="step-content">
            <?php
            $step_names = ['requirements', 'database', 'admin', 'finish'];
            include __DIR__ . "/step{$current_step}_{$step_names[$current_step - 1]}.php";
            ?>
        </div>
    </div>
</body>
</html>