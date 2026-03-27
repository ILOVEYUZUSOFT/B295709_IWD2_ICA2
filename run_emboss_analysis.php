<?php
// run_emboss_analysis.php for EMBOSS pepstats Analysis and amino acid composition bar plot
require_once 'includes/header.php';

// Determine whether run on example dataset or user analysis
$is_example = isset($_GET['example']) && $_GET['example'] == 1;
$analysis_id = isset($_GET['analysis_id']) ? (int)$_GET['analysis_id'] : 0;

if ($is_example) {
    // Example dataset
    $analysis_name = "Example Dataset: Glucose-6-phosphatase from Aves";
    $back_url = "example.php";
    $fasta_path = __DIR__ . "/data/g6p_aves.fasta";
    $pepstats_file = "outputs/pepstats_example.txt";
    $plot_file = "outputs/aac_plot_example.png";
} elseif ($analysis_id > 0) {
    // Fetch user analysis from database
    $stmt = $pdo->prepare("SELECT * FROM user_analyses WHERE id = ?");
    $stmt->execute([$analysis_id]);
    $analysis = $stmt->fetch();
    // Show error if analysis not found
    if (!$analysis) {
        echo "<div class='alert alert-danger text-center'>Analysis not found.</div>";
        require_once 'includes/footer.php';
        exit;
    }
    $analysis_name = $analysis['analysis_name'];
    $back_url = "results.php?id=$analysis_id";
    $fasta_path = __DIR__ . '/' . $analysis['fasta_file'];
    $pepstats_file = "outputs/pepstats_{$analysis_id}.txt";
    $plot_file = "outputs/aac_plot_{$analysis_id}.png";
} else {
    echo "<div class='alert alert-danger text-center'>Missing parameters.</div>";
    require_once 'includes/footer.php';
    exit;
}

$full_pepstats = __DIR__ . '/' . $pepstats_file;
$full_plot = __DIR__ . '/' . $plot_file;

$message = '';
$show_results = false;

// Run analysis 
if (!file_exists($full_pepstats) ) {
    exec("scripts/run_pepstats.sh " . escapeshellarg($analysis_id ?: 'example') . " " .
         escapeshellarg($fasta_path) . " " . escapeshellarg($full_pepstats) . " 2>&1", $output);
  
    exec("scripts/aac_plot.py " . escapeshellarg($fasta_path) . " " .
         escapeshellarg($full_plot) . " 2>&1", $output);
  
    $message = "<div class='alert alert-success'> Additional EMBOSS analysis (pepstats) completed!</div>";
    $show_results = true;
} else {
    $message = "<div class='alert alert-info'> Using existing analysis results.</div>";
    $show_results = true;
}
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="extra-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-bar-chart-steps me-3"></i>Additional EMBOSS Analysis
            </h2>
            <a href="<?php echo $back_url; ?>" class="btn btn-outline-light btn-back">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <div class="card-body">
            <h3 class="mb-4"><?php echo htmlspecialchars($analysis_name); ?></h3>
           
            <?php echo $message; ?>

            <?php if ($show_results && file_exists($full_plot)): ?>
               
                <!-- Amino Acid Composition Plot -->
                <h5 class="mb-3"><i class="bi bi-pie-chart me-2"></i>Amino Acid Composition (%)</h5>
                <div class="plot-container mb-5">
                    <img src="<?php echo $plot_file; ?>"
                         style="max-width: 100%; height: auto; border-radius: 8px;"
                         class="img-fluid shadow-sm"
                         alt="Amino Acid Composition Plot">
                </div>

                <!-- Pepstats Report -->
                <h5 class="mb-3"><i class="bi bi-file-earmark-text me-2"></i>pepstats Report (Physicochemical Properties)</h5>
                <div class="border rounded p-3 bg-light" style="max-height: 420px; overflow: auto; font-size: 0.9em;">
                    <pre style="background: transparent; border: none; margin: 0; padding: 0; white-space: pre;">
<?php echo htmlspecialchars(file_get_contents($full_pepstats)); ?>
                    </pre>
                </div>

                <!-- Download and return button -->
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo $pepstats_file; ?>" class="btn btn-primary btn-action" download>
                        <i class="bi bi-download me-2"></i>Download Full pepstats Report
                    </a>
                    <a href="<?php echo $back_url; ?>" class="btn btn-secondary btn-action">
                        <i class="bi bi-house-door me-2"></i>Back to My Analyses
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>