<?php
// credits.php - Statement of Credits
require_once 'includes/header.php';
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="results-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                Statement of Credits
            </h2>
        </div>

        <div class="card-body">

            <h4>Sources of Code Used</h4>
            <ul>
                <li>PDO database connection and query structure: Based on official PHP PDO documentation and examples from class notes.</li>
                <li>Bootstrap 5: Used for responsive layout, cards, buttons, and icons throughout the entire website.
    <a href="https://getbootstrap.com/docs/5.3/components/card/" target="_blank">Bootstrap Cards</a>.</li>
                <li>NCBI EDirect: Used to fetch protein sequences from NCBI Protein database. 
    <a href="https://www.ncbi.nlm.nih.gov/books/NBK179288/" target="_blank">NCBI EDirect Documentation</a></li>
                <li>EMBOSS tools (patmatmotifs, pepstats.): Used for motif scanning and physicochemical property analysis. 
    <a href="https://emboss.sourceforge.net/" target="_blank">EMBOSS</a></li>            
                <li>Clustal Omega: Used for Multiple Sequence Alignment. 
    <a href="https://www.ebi.ac.uk/tools/msa/clustalo/" target="_blank">Clustal Omega Official</a></li>
                <li>Biopython: Used for generating conservation plots.</li>
                <li>Table display, responsive design, and Bootstrap Icons: Modified from Bootstrap 5 official examples and class notes.</li>
            </ul>

            <h4 class="mt-5">2. AI Tools and What They Were Used For</h4>
            <ul>
                <p>Grok (xAI): 
                    <ul>
                        <li>Responsible for the encoding and debugging of the New Analysis search interface (new_analysis.php).</li>
                        <li>Refined the fetch_sequence script (including the recommendation for usage of edirect and sequence import logic).</li>
                        <li>Organized and curated reference materials for commonly used CSS design</li>
                    </ul>
                </p>
            </ul>

            <ul>
                <p>Entire project is hosted on GitHub: 
                    <a href="https://github.com/ILOVEYUZUSOFT/B295709_IWD2_ICA2" target="_blank">https://github.com/ILOVEYUZUSOFT/B295709_IWD2_ICA2</a></p>
            </ul>

            <div class="mt-5 pt-4 border-top text-center text-muted">
                <p>AY25 IWD2 – Introduction to Website and Database Design<br></p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
