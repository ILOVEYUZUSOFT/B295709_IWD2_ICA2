<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AY25 IWD2 - Protein Conservation Explorer</title>

    <!-- Import Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .results-card, 
        .analysis-card, 
        .alignment-card, 
        .motif-card, 
        .extra-card, 
        .revisit-card {
            max-width: 1100px;
            margin: 20px auto;
            border-radius: 28px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(90deg, #0f3460, #1e5799);
            color: white;
            padding: 22px 30px;
        }

        .card-body {
            padding: 36px 40px !important;
        }

        table, .table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 20px !important;
        }
        th, td {
            border: 1px solid #ccc !important;
            padding: 12px 15px !important;
            text-align: left !important;
            vertical-align: middle !important;
        }
        th {
            background: #0f3460 !important;
            color: white !important;
            font-weight: bold !important;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f8 !important;
        }

        .seq-pill {
            display: inline-block;
            padding: 6px 14px;
            background: #f8f9fa;
            color: #0f3460;
            font-weight: bold;
            border-radius: 50px;
            font-size: 0.95rem;
        }

        .btn-action {
            padding: 12px 24px;
            font-size: 1.05rem;
        }
        .btn-back {
            color: white;
            border-color: white;
            font-weight: bold;
        }
        .btn-back:hover {
            background-color: white;
            color: #0f3460;
        }

        .plot-container, 
        .report-pre {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="color:#1e3a8a; margin-top:20px;">Protein Conservation Explorer</h1>
        

        <nav style="background:#0f3460; padding:18px 30px; border-radius:8px; margin-bottom:25px;">
            <a href="index.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">Home</a>
            <a href="example.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">Example Dataset</a>
            <a href="new_analysis.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">New Analysis</a>
            <a href="revisit.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">Revisit</a>
            <a href="about.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">About</a>
            <a href="help.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">Help</a>
            <a href="credits.php" style="color:#fff; margin-right:22px; text-decoration:none; font-weight:bold;">Statement of Credits</a>
        </nav>
        
        <hr style="border:0; height:1px; background:#ddd; margin:0 30px 30px 30px;">
    </div>
</body>
</html>
