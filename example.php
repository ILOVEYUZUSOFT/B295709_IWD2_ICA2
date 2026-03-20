<?php
/**
 * Table Display Page - Example Dataset Viewer
 *
 * This page displays a sample dataset of Glucose-6-phosphatase proteins from Aves class.
 * This table shows the first 50 records with direct links to view full sequences.
 */


require_once 'includes/header.php';
?>

// ====================== Page Title and Navigation Link ======================
<div style="padding: 10px 30px;">
    <h2 style="color: #0f3460; font-size: 22px; margin-bottom: 8px;">
        Example Dataset: Glucose-6-phosphatase proteins from Aves (90 sequences)
    </h2>
    <p style="margin-top: 0;">
        <a href="new_analysis.php" style="color: #2563eb; font-weight: bold; text-decoration: none;">
            → Start my own new analysis
        </a>
    </p>

    <!-- Table Container -->
    <div style="margin: 25px 0;">
        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 12px; box-shadow: 0 3px 12px rgba(0,0,0,0.05); overflow: hidden;">
            <!-- Table Header Row -->
            <tr style="background-color: #0f3460; color: #fff; text-align: left;">
                <th style="padding: 14px 20px; font-size: 15px; font-weight: bold;">Accession</th>
                <th style="padding: 14px 20px; font-size: 15px; font-weight: bold;">Organism</th>
                <th style="padding: 14px 20px; font-size: 15px; font-weight: bold;">Length (aa)</th>
                <th style="padding: 14px 20px; font-size: 15px; font-weight: bold;">Action</th>
            </tr>

            // Query the database: Fetch first 50 records ordered by accession
            // Columns selected: id (for view link), accession, organism, seq_length
            <?php
            $stmt = $pdo->query("SELECT id, accession, organism, seq_length FROM example_g6p_aves ORDER BY accession LIMIT 50");
            // Loop through each row to generate HTML table
            while ($row = $stmt->fetch()) {
                echo "<tr style='border-top: 1px solid #eee;'>
                    <td style='padding: 12px 20px;'>{$row['accession']}</td>
                    <td style='padding: 12px 20px;'>{$row['organism']}</td>
                    <td style='padding: 12px 20px;'>{$row['seq_length']}</td>
                    <td style='padding: 12px 20px;'>
                        <a href='view_seq.php?id={$row['id']}' style='color: #2563eb; font-weight: bold;'>View full sequence</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>