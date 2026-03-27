<?php
// import_user_sequences.php
// Import fetched FASTA file into user_sequences table
// Called automatically after fetch in new_analysis.php

function importFastaToDB($analysis_id, $fasta_full_path) {
    global $pdo;

    if (!file_exists($fasta_full_path) || filesize($fasta_full_path) === 0) {
        return false;
    }

    $file = fopen($fasta_full_path, 'r');
    if (!$file) {
        return false;
    }

    // Parsing Variables 
    $currentSeq  = '';      
    $header      = '';      
    $importCount = 0;       

    $pdo->beginTransaction();

    // Line-by-Line reading FASTA file
    while (($line = fgets($file)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;

        // Detect start of a new sequence 
        if (strpos($line, '>') === 0) {
            // Save the previous sequence (if it exists)
            if ($currentSeq !== '' && $header !== '') {
                insertSingleSequence($pdo, $analysis_id, $header, $currentSeq);
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
        insertSingleSequence($pdo, $analysis_id, $header, $currentSeq);
        $importCount++;
    }

    fclose($file);
    $pdo->commit();

    return $importCount;
}

// Insert Function 
function insertSingleSequence($pdo, $analysis_id, $header, $seq) {
    $parts = explode(' ', $header, 2);
    $acc   = $parts[0];
    $desc  = $parts[1] ?? $header;

    preg_match('/\[(.*?)\]/', $header, $m);
    $org = $m[1] ?? 'Unknown';

    $stmt = $pdo->prepare("INSERT INTO user_sequences
        (analysis_id, accession, description, organism, sequence, seq_length) 
        VALUES (?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([$analysis_id, $acc, $desc, $org, $seq, strlen($seq)]);
}
?>
