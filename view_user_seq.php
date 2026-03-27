<?php
// view_user_seq.php
// Displays details of protein sequence

require_once 'includes/header.php';

// Get Parameters from URL
$seq_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

//  Database Query
$stmt = $pdo->prepare("SELECT accession, description, organism, sequence, seq_length
                       FROM user_sequences 
                       WHERE id = ?");
$stmt->execute([$seq_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Main Page
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
    
    <!-- Metadata -->
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
   
    <!-- Sequence display -->
    <h3 style="color: #0f3460; font-size: 20px;">Protein Sequence:</h3>
    <pre style="background:#f8f9fa;
                padding:20px;
                border-radius:10px;
                overflow:auto;
                font-family:Consolas, monospace;
                line-height:1.5;
                border: 1px solid #ddd;">
<?php echo chunk_split(htmlspecialchars($row['sequence']), 60, "\n"); ?></pre>

    <!-- FASTA format display -->
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
    echo '>' . htmlspecialchars($row['accession']) . ' ' 
         . htmlspecialchars($row['description']) 
         . ' | Organism: ' . htmlspecialchars($row['organism']) . "\n";
    echo chunk_split(htmlspecialchars($row['sequence']), 60, "\n");
?>
    </pre>

    <!-- Back Navigation -->
    <p style="margin-top:25px;">
        <a href="javascript:history.back()" 
           style="color:#2563eb; font-weight:bold; text-decoration:none;">
            ← Back to Analysis Results
        </a>
    </p>
<?php
}

echo '</div>';

require_once 'includes/footer.php';
?>