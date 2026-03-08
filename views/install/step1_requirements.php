<?php
$requirements = InstallController::checkRequirements();
$all_pass = !in_array(false, $requirements);
?>

<h2>Requirements Check</h2>
<p>Let's make sure your server meets the minimum requirements for StreamVault.</p>

<div class="requirements-list" style="margin: 20px 0;">
    <div class="requirement">
        <i class="fas <?php echo $requirements['php_version'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        PHP Version >= 7.4
        <span class="version"><?php echo PHP_VERSION; ?></span>
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['pdo'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        PDO Extension
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['pdo_mysql'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        PDO MySQL Extension
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['mbstring'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        MBString Extension
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['json'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        JSON Extension
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['writable_env'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        Writable .env file location
    </div>
    <div class="requirement">
        <i class="fas <?php echo $requirements['writable_uploads'] ? 'fa-check text-success' : 'fa-times text-danger'; ?>"></i>
        Writable uploads directory
    </div>
</div>

<style>
.requirements-list .requirement {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #E2E8F0;
}
.requirements-list .requirement i {
    width: 20px;
    margin-right: 10px;
}
.requirements-list .requirement .text-success { color: #10B981; }
.requirements-list .requirement .text-danger { color: #EF4444; }
.requirements-list .requirement .version {
    margin-left: auto;
    color: #94A3B8;
}
</style>

<?php if ($all_pass): ?>
<div class="alert success">
    <i class="fas fa-check-circle"></i>
    All requirements are met! You can proceed to the next step.
</div>
<form method="post">
    <button type="submit" class="btn primary">Continue <i class="fas fa-arrow-right"></i></button>
</form>
<?php else: ?>
<div class="alert error">
    <i class="fas fa-exclamation-triangle"></i>
    Some requirements are not met. Please fix them before continuing.
</div>
<button class="btn secondary" onclick="location.reload()">Check Again</button>
<?php endif; ?>