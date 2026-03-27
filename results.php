<?php
// results.php
// Displays query results and provides navigation to further analysis tools
require_once 'includes/header.php';

// Get analysis ID from URL parameter
$analysis_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM user_analyses WHERE id = ?");
$stmt->execute([$analysis_id]);
$analysis = $stmt->fetch();

if (!$analysis) {
    echo "<div class='alert alert-danger text-center'>Analysis not found.</div>";
    require_once 'includes/footer.php';
    exit;
}
?>


<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="results-card">
        <!-- Title and back navigation -->
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-clipboard-data me-3"></i>Analysis Results
            </h2>
            <a href="revisit.php" class="btn btn-outline-light btn-back">
                <i class="bi bi-arrow-left me-2"></i>Back to My Analyses
            </a>
        </div>

        <div class="card-body">
            <h3 class="mb-3"><?php echo htmlspecialchars($analysis['analysis_name']); ?></h3>
            
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>Protein Family</strong><br>
                    <?php echo htmlspecialchars($analysis['protein_family']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Taxonomic Group</strong><br>
                    <?php echo htmlspecialchars($analysis['taxonomic_group']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Sequences Found</strong><br>
                    <span class="seq-pill"><?php echo $analysis['num_sequences']; ?></span>
                </div>
            </div>

            <!-- Buttons to launch additional analysis tools -->
            <h5 class="mb-3">Start Further Analysis</h5>
            <div class="d-flex flex-wrap gap-3 mb-5">
                <a href="run_alignment.php?analysis_id=<?php echo $analysis_id; ?>" class="btn btn-primary btn-action">
                    <i class="bi bi-align-middle me-2"></i>Run Multiple Sequence Alignment + Conservation Plot
                </a>
                <a href="run_motif_scan.php?analysis_id=<?php echo $analysis_id; ?>" class="btn btn-success btn-action">
                    <i class="bi bi-search me-2"></i>Scan PROSITE Motifs
                </a>
                <a href="run_emboss_analysis.php?analysis_id=<?php echo $analysis_id; ?>" class="btn btn-info btn-action">
                    <i class="bi bi-bar-chart-steps me-2"></i>Additional EMBOSS Analysis
                </a>
            </div>

            <!-- Sequence list table -->
            <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i>Sequence List</h5>
            <div class="table-responsive" style="max-height: 420px; overflow: auto; font-size: 0.9em;">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Accession</th>
                            <th>Organism</th>
                            <th>Length</th>
                            <th style="width: 160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $seq_stmt = $pdo->prepare("SELECT id, accession, organism, seq_length
                                               FROM user_sequences WHERE analysis_id = ? ORDER BY accession");
                    $seq_stmt->execute([$analysis_id]);
                    while ($row = $seq_stmt->fetch()) {
                        echo "<tr>
                            <td><strong>{$row['accession']}</strong></td>
                            <td>{$row['organism']}</td>
                            <td class='text-center'>
                                <span class='seq-pill'>{$row['seq_length']}</span>
                            </td>
                            <td>
                                <a href='view_user_seq.php?id={$row['id']}' class='btn btn-primary btn-sm btn-view'>
                                    <i class='bi bi-eye me-1'></i>View Sequence
                                </a>
                            </td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>