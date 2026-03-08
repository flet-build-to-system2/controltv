<h2>Admin Account</h2>
<p>Create your admin account. This will be used to log in to the dashboard.</p>

<form method="post">
    <div class="form-group">
        <label for="admin_email">Admin Email</label>
        <input type="email" id="admin_email" name="admin_email" placeholder="admin@example.com" required>
    </div>
    <div class="form-group">
        <label for="admin_pass">Admin Password</label>
        <input type="password" id="admin_pass" name="admin_pass" required>
        <div id="password-strength" style="margin-top: 5px; height: 4px; background: #E2E8F0; border-radius: 2px; overflow: hidden;">
            <div id="strength-bar" style="height: 100%; width: 0%; transition: width 0.3s ease;"></div>
        </div>
        <small id="strength-text" style="color: #94A3B8;">Password strength</small>
    </div>
    <div class="form-group">
        <label for="admin_pass_confirm">Confirm Password</label>
        <input type="password" id="admin_pass_confirm" name="admin_pass_confirm" required>
        <small id="confirm-text" style="color: #EF4444; display: none;">Passwords do not match</small>
    </div>
    <div class="text-center">
        <button type="submit" id="submit-btn" class="btn primary" disabled>Create Account <i class="fas fa-user-plus"></i></button>
    </div>
</form>

<script>
const password = document.getElementById('admin_pass');
const confirmPass = document.getElementById('admin_pass_confirm');
const strengthBar = document.getElementById('strength-bar');
const strengthText = document.getElementById('strength-text');
const confirmText = document.getElementById('confirm-text');
const submitBtn = document.getElementById('submit-btn');

function checkStrength(pass) {
    let strength = 0;
    if (pass.length >= 8) strength++;
    if (/[a-z]/.test(pass)) strength++;
    if (/[A-Z]/.test(pass)) strength++;
    if (/[0-9]/.test(pass)) strength++;
    if (/[^A-Za-z0-9]/.test(pass)) strength++;

    const colors = ['#EF4444', '#F59E0B', '#F59E0B', '#10B981', '#10B981'];
    const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];

    strengthBar.style.width = (strength / 5) * 100 + '%';
    strengthBar.style.background = colors[strength - 1] || '#EF4444';
    strengthText.textContent = texts[strength - 1] || 'Very Weak';
    strengthText.style.color = colors[strength - 1] || '#EF4444';

    return strength >= 3;
}

function checkMatch() {
    const match = password.value === confirmPass.value && password.value !== '';
    confirmText.style.display = match ? 'none' : 'block';
    return match;
}

password.addEventListener('input', function() {
    const strong = checkStrength(this.value);
    const match = checkMatch();
    submitBtn.disabled = !(strong && match);
});

confirmPass.addEventListener('input', function() {
    const match = checkMatch();
    const strong = checkStrength(password.value);
    submitBtn.disabled = !(strong && match);
});
</script>