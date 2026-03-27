<?php
// run_motif_scan.php 
// Run PROSITE motif scan using EMBOSS patmatmotifs
require_once 'includes/header.php';

$is_example = isset($_GET['example']) && $_GET['example'] == 1;
$analysis_id = isset($_GET['analysis_id']) ? (int)$_GET['analysis_id'] : 0;

// Determine if loading example dataset or user analysis, determine paths and data based on mode
if ($is_example) {
    $analysis_name = "Example Dataset: Glucose-6-phosphatase from Aves";
    $back_url = "example.php";
    $fasta_path = __DIR__ . "/data/g6p_aves.fasta";
    $motif_file = "outputs/motifs_example.txt";
} elseif ($analysis_id > 0) {
    // Fetch user analysis from database
    $stmt = $pdo->prepare("SELECT * FROM user_analyses WHERE id = ?");
    $stmt->execute([$analysis_id]);
    $analysis = $stmt->fetch();
    if (!$analysis) {
        echo "<div class='alert alert-danger text-center'>Analysis not found.</div>";
        require_once 'includes/footer.php';
        exit;
    }
    
    $analysis_name = $analysis['analysis_name'];
    $back_url = "results.php?id=$analysis_id";
    $fasta_path = __DIR__ . '/' . $analysis['fasta_file'];
    $motif_file = "outputs/motifs_{$analysis_id}.txt";
} else {
    echo "<div class='alert alert-danger text-center'>Missing parameters.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Server path to the motif result file
$full_motif = __DIR__ . '/' . $motif_file;

$message = '';
$show_results = false;

// Run motif scan
if (!file_exists($full_motif)) {
    exec("scripts/run_motif_scan.sh " . escapeshellarg($analysis_id ?: 'example') . " " .
         escapeshellarg($fasta_path) . " " . escapeshellarg($full_motif) . " 2>&1", $output);
  
    $message = "<div class='alert alert-success'> PROSITE motif scan completed!</div>";
    $show_results = true;
} else {
    $message = "<div class='alert alert-info'> PROSITE motif scan completed!</div>";
    $show_results = true;
}
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="motif-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-search me-3"></i>PROSITE Motif Scan (patmatmotifs)
            </h2>
            <a href="<?php echo $back_url; ?>" class="btn btn-outline-light btn-back">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card-body">
            <h3 class="mb-4"><?php echo htmlspecialchars($analysis_name); ?></h3>
           
            <?php echo $message; ?>

            <?php if ($show_results && file_exists($full_motif)): ?>
               
                <!-- Motif Summary -->
                <h5 class="mb-3"></i>Motif Summary</h5>
                <div class="alert alert-light border">
                    <?php
                    $motif_content = file_get_contents($full_motif);
                    $motif_count = substr_count($motif_content, 'Motif = ');
                    echo "<strong>$motif_count</strong> motifs detected across all sequences";
                    ?>
                </div>
                
                <!-- Motif Scan Report -->
                <h5 class="mb-3"><i class="bi bi-file-earmark-text me-2"></i>Motif Scan Report</h5>
                <div class="border rounded p-3 bg-light" style="max-height: 420px; overflow: auto; font-size: 0.9em;">
                    <pre style="background: transparent; border: none; margin: 0; padding: 0; white-space: pre;">
<?php echo htmlspecialchars(file_get_contents($full_motif)); ?>
                    </pre>
                </div>

                <!-- Download and return button -->
                <div class="d-flex flex-wrap gap-3 mt-4 mb-5">
                    <a href="<?php echo $motif_file; ?>" class="btn btn-primary btn-action" download>
                        <i class="bi bi-download me-2"></i>Download Full Motif Report (.txt)
                    </a>
                    <a href="run_emboss_analysis.php?<?php echo $is_example ? 'example=1' : 'analysis_id=' . $analysis_id; ?>" 
                       class="btn btn-info btn-action">
                        <i class="bi bi-bar-chart-steps me-2"></i>Next: Additional EMBOSS Analysis
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>