<?php
// revisit.php 
require_once 'includes/header.php';

// Retrieve access code from GET request
$access_code = isset($_GET['access_code']) ? trim($_GET['access_code']) : '';

// Query data in MySQL
$where = "WHERE username = 's2827275'";
$params = [];

if ($access_code !== '') {
    $where .= " AND access_code LIKE ?";
    $params[] = "%$access_code%";
}

$stmt = $pdo->prepare("SELECT id, analysis_name, access_code, protein_family, 
                              taxonomic_group, num_sequences, created_at
                       FROM user_analyses
                       $where
                       ORDER BY created_at DESC");
$stmt->execute($params);
$analyses = $stmt->fetchAll();
?>

<!Main page container>
<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="revisit-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-clock-history me-3"></i>My Previous Analyses
            </h2>
        </div>

        <!Main content>
        <div class="card-body">
            <!Access code search>
            <div class="mb-5">
                <h5 class="mb-3"></i>Search by Access Code</h5>
                <form method="get" class="row g-3 align-items-end">
                    <div class="col-md-9">
                        <input type="text" name="access_code" class="form-control form-control-lg"
                               placeholder="Enter Access Code"
                               value="<?php echo htmlspecialchars($access_code); ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>
                
                <!Show success message when searching with an access code>
                <?php if ($access_code): ?>
                    <p class="mt-3 text-success">
                        Showing results for Access Code: <strong><?php echo htmlspecialchars($access_code); ?></strong>
                    </p>
                <?php endif; ?>
            </div>

            <!If no analysis records match the search>
            <?php if (empty($analyses)): ?>
                <div class="alert alert-warning text-center py-5">
                    No analyses found for this Access Code.<br>
                </div>
            <?php else: ?>
            <!--Display table for records-->
                <div class="table-responsive" style="max-height: 420px; overflow: auto; font-size: 0.9em;">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Access Code</th>
                                <th>Analysis Name</th>
                                <th>Protein Family</th>
                                <th>Sequences</th>
                                <th>Created</th>
                                <th style="width: 130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($analyses as $row): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['access_code']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['analysis_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['protein_family']); ?></td>
                                <td class="text-center">
                                    <span class="seq-pill"><?php echo $row['num_sequences']; ?></span>
                                </td>
                                <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="results.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-primary btn-sm btn-view">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>