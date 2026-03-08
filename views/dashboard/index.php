<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div class="breadcrumb">Home / Dashboard</div>
</div>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 24px;">
    <div class="card stat-card">
        <div class="stat-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, #38BDF8, #0284C7); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 16px;">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-number" style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?php echo $data['counts']['categories']; ?></div>
        <div class="stat-label" style="color: var(--text-secondary);">Categories</div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, #38BDF8, #0284C7); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 16px;">
            <i class="fas fa-tv"></i>
        </div>
        <div class="stat-number" style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?php echo $data['counts']['channels']; ?></div>
        <div class="stat-label" style="color: var(--text-secondary);">Channels</div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, #38BDF8, #0284C7); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 16px;">
            <i class="fas fa-film"></i>
        </div>
        <div class="stat-number" style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?php echo $data['counts']['movies']; ?></div>
        <div class="stat-label" style="color: var(--text-secondary);">Movies</div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, #38BDF8, #0284C7); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 16px;">
            <i class="fas fa-play-circle"></i>
        </div>
        <div class="stat-number" style="font-size: 32px; font-weight: 700; margin-bottom: 4px;"><?php echo $data['counts']['anime']; ?></div>
        <div class="stat-label" style="color: var(--text-secondary);">Anime</div>
    </div>
</div>

<div class="recent-section" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 600;">Recent Channels</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['recentChannels'] as $channel): ?>
                <tr>
                    <td><?php echo htmlspecialchars($channel['name']); ?></td>
                    <td><span class="status-badge status-<?php echo $channel['status']; ?>"><?php echo ucfirst($channel['status']); ?></span></td>
                    <td><?php echo date('M d, Y', strtotime($channel['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 600;">Recent Movies</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['recentMovies'] as $movie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($movie['title']); ?></td>
                    <td><?php echo $movie['release_year'] ?: 'N/A'; ?></td>
                    <td><?php echo date('M d, Y', strtotime($movie['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>