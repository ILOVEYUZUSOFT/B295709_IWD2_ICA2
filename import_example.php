<?php
// import_example.php


require_once 'includes/db.php';

// File Path and Initialization
$filename = 'data/g6p_aves.fasta';
$file = fopen($filename, 'r');

if (!$file) {
    die("Failed to Open the File!");
}

// Clear the target table 
$pdo->exec("TRUNCATE TABLE example_g6p_aves");

// Parsing Variables 
$currentSeq = '';      
$header     = '';      
$importCount = 0;       

// Line-by-Line reading FASTA file
while (($line = fgets($file)) !== false) {
    $line = trim($line);
    if (empty($line)) continue;

    // Detect start of a new sequence
    if (strpos($line, '>') === 0) {
        // Save the previous sequence (if it exists) 
        if ($currentSeq !== '' && $header !== '') {
            insertSequence($pdo, $header, $currentSeq);
            $importCount++;
        }
        
        // New header
        $header = substr($line, 1);
        $currentSeq = '';
    } else {
        // Accumulate sequence lines 
        $currentSeq .= $line;
    }
}

// Process the last sequence in the file
if ($currentSeq !== '' && $header !== '') {
    insertSequence($pdo, $header, $currentSeq);
    $importCount++;
}

fclose($file);

echo "A total of <strong>$importCount</strong> sequences have been successfully imported to the dataset (It should be 90 in the example)!";

// Insert Function
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