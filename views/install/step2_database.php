<h2>Database Configuration</h2>
<p>Enter your database connection details. We'll test the connection before proceeding.</p>

<form id="db-form" method="post">
    <div class="form-group">
        <label for="db_host">Database Host</label>
        <input type="text" id="db_host" name="db_host" value="localhost" required>
    </div>
    <div class="form-group">
        <label for="db_name">Database Name</label>
        <input type="text" id="db_name" name="db_name" placeholder="e.g., streaming_db" required>
    </div>
    <div class="form-group">
        <label for="db_user">Database Username</label>
        <input type="text" id="db_user" name="db_user" value="root" required>
    </div>
    <div class="form-group">
        <label for="db_pass">Database Password</label>
        <input type="password" id="db_pass" name="db_pass">
    </div>
    <div class="text-center">
        <button type="button" id="test-btn" class="btn secondary">Test Connection <i class="fas fa-plug"></i></button>
        <button type="submit" id="continue-btn" class="btn primary" disabled>Continue <i class="fas fa-arrow-right"></i></button>
    </div>
</form>

<div id="test-result" style="margin-top: 20px;"></div>

<script>
document.getElementById('test-btn').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('db-form'));
    const resultDiv = document.getElementById('test-result');
    const testBtn = this;
    const continueBtn = document.getElementById('continue-btn');

    testBtn.disabled = true;
    testBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
    resultDiv.innerHTML = '';

    fetch('install.php?step=2&test=1', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = '<div class="alert success"><i class="fas fa-check-circle"></i> Connection successful!</div>';
            continueBtn.disabled = false;
        } else {
            resultDiv.innerHTML = '<div class="alert error"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>';
            continueBtn.disabled = true;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert error"><i class="fas fa-exclamation-triangle"></i> Test failed. Please check your details.</div>';
        continueBtn.disabled = true;
    })
    .finally(() => {
        testBtn.disabled = false;
        testBtn.innerHTML = 'Test Connection <i class="fas fa-plug"></i>';
    });
});
</script>