<?php
/**
 * Full Sequence Detail View Page - view_seq.php
 *
 * This page displays the complete protein sequence and metadata for a single record from the example_g6p_aves table.
 * NCBI Protein database external link generation is also included.
 * You also can copy the sequence metadata as FASTA format.
 */
require_once 'includes/header.php';
// ====================== Database Query ======================
// Get the sequence ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT accession, description, organism, sequence, seq_length
                       FROM example_g6p_aves WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

// ====================== Main Page ======================
echo '<div style="padding: 10px 30px;">';
if (!$row) {
    echo "<h2 style='color: #0f3460;'>❌ Sequence not found</h2>";
} else {
    $accession = htmlspecialchars($row['accession']);
    // Generate NCBI Protein link
    $ncbi_url = "https://www.ncbi.nlm.nih.gov/protein/" . $accession;
?>
    <!-- Page Title -->
    <h2 style="color: #0f3460; font-size: 24px;">
        Full Sequence: <?php echo $accession; ?>
    </h2>
    <!-- Metadata Information -->
    <div style="background: #ffffff; border-radius: 12px; padding: 20px 25px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin: 20px 0;">
        <p style="font-size: 16px; line-height: 1.7; margin:0;">
            <strong>Organism:</strong> <?php echo htmlspecialchars($row['organism']); ?><br>
            <strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?><br>
            <strong>Length:</strong> <?php echo $row['seq_length']; ?> amino acids<br><br>
           
            <!-- NCBI Protein link -->
            <strong>View on NCBI:</strong>
            <a href="<?php echo $ncbi_url; ?>" target="_blank"
               style="color:#1a73e8; font-weight:bold; text-decoration:none;">
               <?php echo $accession; ?> (Open in NCBI Protein)
            </a>
        </p>
    </div>
   
    <!-- Sequence Section-->
    <h3 style="color: #0f3460; font-size: 20px;">Protein Sequence:</h3>
    <pre style="background:#f8f9fa;
                padding:20px;
                border-radius:10px;
                overflow:auto;
                font-family:Consolas, monospace;
                line-height:1.5;
                border: 1px solid #ddd;">
<?php echo chunk_split(htmlspecialchars($row['sequence']), 60, "\n"); ?></pre>

<!-- Full FASTA Format Card -->
    <!-- This shows the complete FASTA record in a .fasta file -->
    <h3 style="color: #0f3460; font-size: 20px; margin-top: 30px;">
        FASTA Format
    </h3>
    <pre style="background:#f8f9fa;
                padding:20px;
                border-radius:10px;
                overflow:auto;
                font-family:Consolas, monospace;
                line-height:1.5;
                border: 1px solid #ddd; white-space: pre-wrap;">
<?php
    // Output standard FASTA format (header + sequence)
    echo '>' . htmlspecialchars($row['accession']) . ' ' 
         . htmlspecialchars($row['description']) 
         . ' | Organism: ' . htmlspecialchars($row['organism']) . "\n";
    echo chunk_split(htmlspecialchars($row['sequence']), 60, "\n");
?>
    </pre>


    <!-- Back to Navigation -->
    <p style="margin-top:25px;">
        <a href="example.php" style="color:#2563eb; font-weight:bold; text-decoration:none;">
            ← Back to Example Dataset
        </a>
    </p>
<?php
}
echo '</div>';
require_once 'includes/footer.php';
?>