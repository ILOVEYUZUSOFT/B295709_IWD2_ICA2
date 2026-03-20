<?php
/**
 * FASTA File Parsing and Import into MySQL Database
 *
 * Adapted from:
 * 1. Stack Overflow: "Parse a fasta file using PHP"
 *    https://stackoverflow.com/questions/54980654/parse-a-fasta-file-using-php
 *    (Use the strpos('>') for FASTA header detection + sequence accumulation method)
 *
 * 2. PHPpot Tutorial: "Import CSV File into MySQL using PHP"
 *    https://phppot.com/php/import-csv-file-into-mysql-using-php/
 *    (The file reading loop + PDO prepared statement structure is almost 
 *     identical, only replacing fgetcsv with FASTA logic)
 *
 */

require_once 'includes/db.php';
// ====================== File Path and Initialization ======================
$filename = 'data/g6p_aves.fasta';
$handle = fopen($filename, 'r');

if (!$handle) {
    die("❌ Failed to Open the File!");
}

// Clear the target table 
$pdo->exec("TRUNCATE TABLE example_g6p_aves");

// ====================== Parsing Variables ======================
$current_seq = '';      // Current sequence content
$header      = '';      // Current header
$count       = 0;       // Successfully imported count

// ====================== Line-by-Line Reading (Classic FASTA Parsing Method) ======================
while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    if (empty($line)) continue;

    // Detect start of a new sequence (referencing Stark Overflow's strpos / str_starts_with style)
    if (strpos($line, '>') === 0) {
        // Save the previous sequence (if it exists)
        if ($current_seq !== '' && $header !== '') {
            insertSequence($pdo, $header, $current_seq);
            $count++;
        }
        
        // New header
        $header = substr($line, 1);
        $current_seq = '';
    } else {
        // Accumulate sequence lines (supports multi-line sequences)
        $current_seq .= $line;
    }
}

// Process the last sequence in the file
if ($current_seq !== '' && $header !== '') {
    insertSequence($pdo, $header, $current_seq);
    $count++;
}

fclose($handle);

echo "✅ A total of <strong>$count</strong> sequences have been successfully imported to the dataset (It should be 90 in the example)!";

// ====================== Insert Function (referencing from PHPpot) ======================
function insertSequence($pdo, $header, $seq) {
    $parts = explode(' ', $header, 2);
    $acc   = $parts[0];
    $desc  = $parts[1] ?? $header;

    preg_match('/\[(.*?)\]/', $header, $m);
    $org = $m[1] ?? 'Aves';

    $stmt = $pdo->prepare("INSERT INTO example_g6p_aves 
        (accession, description, organism, sequence, seq_length) 
        VALUES (?, ?, ?, ?, ?)");
    
    $stmt->execute([$acc, $desc, $org, $seq, strlen($seq)]);
}
?>