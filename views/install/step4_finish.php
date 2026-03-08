<h2>Installation Summary</h2>
<p>Review your settings and complete the installation.</p>

<div class="summary" style="background: #F8FAFC; padding: 20px; border-radius: 10px; margin: 20px 0;">
    <h3>Database Configuration</h3>
    <p><strong>Host:</strong> <?php echo htmlspecialchars($_SESSION['db_host']); ?></p>
    <p><strong>Database:</strong> <?php echo htmlspecialchars($_SESSION['db_name']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['db_user']); ?></p>

    <h3 style="margin-top: 20px;">Admin Account</h3>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['admin_email']); ?></p>
</div>

<div class="text-center">
    <button id="install-btn" class="btn primary">Install StreamVault <i class="fas fa-rocket"></i></button>
</div>

<div id="install-progress" style="display: none; margin-top: 20px;">
    <div class="progress-bar">
        <div class="progress-fill" id="progress-fill"></div>
    </div>
    <p id="progress-text" class="text-center" style="margin-top: 10px;">Installing...</p>
</div>

<div id="install-result" style="margin-top: 20px;"></div>

<script>
document.getElementById('install-btn').addEventListener('click', function() {
    const installBtn = this;
    const progress = document.getElementById('install-progress');
    const result = document.getElementById('install-result');
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');

    installBtn.disabled = true;
    installBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Installing...';
    progress.style.display = 'block';
    result.innerHTML = '';

    // Simulate progress
    let progressValue = 0;
    const progressInterval = setInterval(() => {
        progressValue += 10;
        progressFill.style.width = progressValue + '%';
        if (progressValue >= 100) {
            clearInterval(progressInterval);
        }
    }, 200);

    fetch('install.php?step=4', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        clearInterval(progressInterval);
        progressFill.style.width = '100%';
        if (data.success) {
            progressText.textContent = 'Installation complete!';
            result.innerHTML = '<div class="alert success"><i class="fas fa-check-circle"></i> StreamVault has been installed successfully! <a href="index.php">Go to Dashboard</a></div>';
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 2000);
        } else {
            progressText.textContent = 'Installation failed.';
            result.innerHTML = '<div class="alert error"><i class="fas fa-exclamation-triangle"></i> Installation failed. Please check your settings and try again.</div>';
            installBtn.disabled = false;
            installBtn.innerHTML = 'Install StreamVault <i class="fas fa-rocket"></i>';
        }
    })
    .catch(error => {
        clearInterval(progressInterval);
        progressText.textContent = 'Installation failed.';
        result.innerHTML = '<div class="alert error"><i class="fas fa-exclamation-triangle"></i> An error occurred during installation.</div>';
        installBtn.disabled = false;
        installBtn.innerHTML = 'Install StreamVault <i class="fas fa-rocket"></i>';
    });
});
</script>