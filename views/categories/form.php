<div class="page-header">
    <h1 class="page-title">Categories</h1>
    <div class="breadcrumb">Home / Categories</div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3>All Categories</h3>
        <button class="btn btn-primary" onclick="showForm()">Add Category</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td><?php echo ucfirst($category['type']); ?></td>
                <td><?php echo date('M d, Y', strtotime($category['created_at'])); ?></td>
                <td>
                    <button class="action-btn btn-edit" onclick="editCategory(<?php echo $category['id']; ?>)">Edit</button>
                    <button class="action-btn btn-delete" onclick="deleteCategory(<?php echo $category['id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="category-form" class="card" style="display: none;">
    <h3 id="form-title">Add Category</h3>
    <form id="form" method="post" action="index.php?page=categories&action=store">
        <input type="hidden" name="id" id="category-id">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Name</label>
                <input type="text" name="name" id="category-name" required style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Type</label>
                <select name="type" id="category-type" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px;">
                    <option value="general">General</option>
                    <option value="movie">Movie</option>
                    <option value="channel">Channel</option>
                    <option value="anime">Anime</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn" style="background: var(--border);" onclick="hideForm()">Cancel</button>
        </div>
    </form>
</div>

<script>
function showForm() {
    document.getElementById('category-form').style.display = 'block';
    document.getElementById('form-title').textContent = 'Add Category';
    document.getElementById('form').action = 'index.php?page=categories&action=store';
    document.getElementById('category-id').value = '';
    document.getElementById('category-name').value = '';
    document.getElementById('category-type').value = 'general';
}

function hideForm() {
    document.getElementById('category-form').style.display = 'none';
}

function editCategory(id) {
    // Fetch category data and populate form
    fetch('index.php?page=categories&action=edit&id=' + id)
        .then(response => response.text())
        .then(html => {
            // This is a simple way, but since it's the same page, perhaps redirect or use AJAX
            // For simplicity, assume we have the data
            // In real, need to modify the controller to return JSON or something
        });
    // Placeholder
}

function deleteCategory(id) {
    if (confirm('Are you sure?')) {
        window.location.href = 'index.php?page=categories&action=delete&id=' + id;
    }
}
</script>