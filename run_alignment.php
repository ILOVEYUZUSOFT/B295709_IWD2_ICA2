<?php
// run_alignment.php
// Perform Multiple Sequence Alignment (using Clustal Omega) and generate conservation plot
require_once 'includes/header.php';

$is_example = isset($_GET['example']) && $_GET['example'] == 1;
$analysis_id = isset($_GET['analysis_id']) ? (int)$_GET['analysis_id'] : 0;

// Determine if loading example dataset or user analysis, determine paths and data based on mode
if ($is_example) {
    $analysis_name = "Example Dataset: Glucose-6-phosphatase from Aves";
    $back_url = "example.php";
    $fasta_path = __DIR__ . "/data/g6p_aves.fasta";
    $aln_path   = "outputs/alignment_example.aln";
    $plot_path  = "outputs/conservation_example.png";
} elseif ($analysis_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM user_analyses WHERE id = ?");
    $stmt->execute([$analysis_id]);
    $analysis = $stmt->fetch();
    if (!$analysis) {
     // Show error if analysis does not exist
        echo "<div class='alert alert-danger text-center'>Analysis not found.</div>";
        require_once 'includes/footer.php';
        exit;
    }
    $analysis_name = $analysis['analysis_name'];
    $back_url = "results.php?id=$analysis_id";
    $fasta_path = __DIR__ . '/' . $analysis['fasta_file'];
    $aln_path   = "outputs/alignment_{$analysis_id}.aln";
    $plot_path  = "outputs/conservation_{$analysis_id}.png";
} else {
    echo "<div class='alert alert-danger text-center'>Missing parameters.</div>";
    require_once 'includes/footer.php';
    exit;
}

$full_aln  = __DIR__ . '/' . $aln_path;
$full_plot = __DIR__ . '/' . $plot_path;

$message = '';
$show_results = false;

// Run alignment and generate conservation plot
if (!file_exists($full_aln) ) {
    exec("scripts/run_alignment.sh " . escapeshellarg($analysis_id ?: 'example') . " " .
         escapeshellarg($fasta_path) . " " . escapeshellarg($full_aln) . " 2>&1", $output);
    
    exec("scripts/conservation_plot.py " . escapeshellarg($full_aln) . " " .
         escapeshellarg($full_plot) . " 2>&1", $output);
    
    $message = "<div class='alert alert-success'> Alignment and conservation plot completed!</div>";
    $show_results = true;
} else {
    $message = "<div class='alert alert-info'> Using existing alignment results.</div>";
    $show_results = true;
}
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="alignment-card">
        <!-- Main card -->
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-align-middle me-3"></i>Multiple Sequence Alignment + Conservation Plot
            </h2>
            <a href="<?php echo $back_url; ?>" class="btn btn-outline-light btn-back">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card-body">
            <h3 class="mb-4"><?php echo htmlspecialchars($analysis_name); ?></h3>
           
            <?php echo $message; ?>

            <?php if ($show_results && file_exists($full_plot)): ?>
               
                <!-- Conservation Plot -->
                <div class="plot-container mb-4">
                    <h5 class="mb-3">Conservation Plot</h5>
                    <img src="<?php echo $plot_path; ?>"
                         style="max-width: 100%; height: auto; border-radius: 8px;"
                         class="img-fluid shadow-sm"
                         alt="Conservation Plot">
                </div>

                <!-- Alignment Summary -->
                <h5 class="mb-3">Alignment Summary</h5>
                <div class="border rounded p-3 bg-light" style="max-height: 420px; overflow: auto; font-size: 0.9em;">
                    <pre style="background: transparent; border: none; margin: 0; padding: 0; white-space: pre;">
<?php echo htmlspecialchars(file_get_contents($full_aln)); ?>
                    </pre>
                </div>
                
                <!-- Download & Next step buttons -->
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="<?php echo $aln_path; ?>" class="btn btn-primary btn-action" download>
                        <i class="bi bi-download me-2"></i>Download Full Alignment (.aln)
                    </a>
                    <a href="run_motif_scan.php?<?php echo $is_example ? 'example=1' : 'analysis_id=' . $analysis_id; ?>" 
                       class="btn btn-success btn-action">
                        <i class="bi bi-search me-2"></i>Next: Scan PROSITE Motifs
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>