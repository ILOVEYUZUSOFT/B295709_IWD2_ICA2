<?php
// Example Dataset Viewer
require_once 'includes/header.php';
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="results-card">
        <!-- Main page container -->
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-table me-3"></i>Example Dataset
            </h2>
            <a href="new_analysis.php" class="btn btn-outline-light btn-back">
                <i class="bi bi-plus-circle me-2"></i>Start My Own Analysis
            </a>
        </div>

        <div class="card-body">
            <h3 class="mb-4">Glucose-6-phosphatase proteins from Aves (90 sequences)</h3>
            
            <!--Dataset information-->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>Protein Family</strong><br>
                    G6PC
                </div>
                <div class="col-md-4">
                    <strong>Taxonomic Group</strong><br>
                    Aves
                </div>
                <div class="col-md-4">
                    <strong>Total Sequences</strong><br>
                    <span class="seq-pill">90</span>
                </div>
            </div>

            <!-- Action buttons to run analyses -->
            <h5 class="mb-3"><i class="bi bi-gear-wide-connected me-2"></i>Try ALL Website Features with This Example Dataset</h5>
            <p class="text-muted mb-4">Click any button below to run the analysis on the Glucose-6-phosphatase from Aves.</p>
            
            <div class="d-flex flex-wrap gap-3 mb-5">
                <a href="run_alignment.php?example=1" class="btn btn-primary btn-action">
                    <i class="bi bi-align-middle me-2"></i>Multiple Sequence Alignment + Conservation Plot
                </a>
                <a href="run_motif_scan.php?example=1" class="btn btn-success btn-action">
                    <i class="bi bi-search me-2"></i>Scan PROSITE Motifs 
                </a>
                <a href="run_emboss_analysis.php?example=1" class="btn btn-info btn-action">
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
                    // Query example sequences from database
                    $stmt = $pdo->query("SELECT id, accession, organism, seq_length
                                         FROM example_g6p_aves ORDER BY accession");
                    // Loop through and display each sequence record
                    while ($row = $stmt->fetch()) {
                        echo "<tr>
                            <td><strong>{$row['accession']}</strong></td>
                            <td>{$row['organism']}</td>
                            <td class='text-center'>
                                <span class='seq-pill'>{$row['seq_length']}</span>
                            </td>
                            <td>
                                <a href='view_example_seq.php?id={$row['id']}' class='btn btn-primary btn-sm btn-view'>
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