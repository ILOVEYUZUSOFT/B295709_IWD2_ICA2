<?php
// help.php 
require_once 'includes/header.php';
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="results-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-question-circle me-3"></i>Help &amp; Biological Context
            </h2>

        </div>

        <div class="card-body">

            <div class="mt5 mb-4">
                This website helps biologists explore protein sequence conservation, functional motifs, 
                and physicochemical properties across different taxonomic groups. It provides insights 
                into protein similarity, functional prediction, and evolutionary relationships, which 
                are valuable for pathological research, drug development, and related studies.
            </div>

            <h4> Example Dataset (Glucose-6-phosphatase from Aves)</h4>
            <p>
                Glucose-6-phosphatase is a key enzyme in glucose metabolism. The example dataset contains 
                90 real G6PC protein sequences from birds (Aves). By examining how conserved this enzyme 
                is across different avian species, you can quickly understand how evolutionary conservation 
                reflects the core biological function of the protein.
            </p>

            <h4> New Analysis Features</h4>
            <p>
                You can select any protein family of interest (e.g. G6PC, kinases, ABC transporters) and 
                any taxonomic group (e.g. Mammalia, Aves, Homo sapiens). The website automatically retrieves 
                the latest sequences from NCBI and performs multiple sequence alignment, conservation analysis, 
                motif detection, physicochemical property analysis, and amino acid composition visualisation.
            </p>

            <h4> Multiple Sequence Alignment and Conservation Visualisation</h4>
            <p>
                Multiple sequence alignment reveals highly conserved regions across species. These regions 
                often correspond to critical functional sites such as catalytic residues or binding pockets, 
                which are important for coevolution studies, protein structure analysis, and drug target identification.
            </p>

            <h4> Functional Motif and Domain Detection</h4>
            <p>
                By scanning against the PROSITE database, this website can rapidly identify known functional 
                motifs and domains. This helps determine binding properties, active site characteristics, 
                and supports protein family classification.
            </p>

            <h4> Physicochemical Properties and Amino Acid Composition</h4>
            <p>
                The analysis includes molecular weight, isoelectric point, net charge, physicochemical 
                properties for each residue, and an overall amino acid composition distribution. These properties 
                influence protein solubility, stability, localisation, and interactions, revealing evolutionary 
                adaptation patterns.
            </p>

            <h4>Usage Workflow</h4>
            <ul>
                <li>Use the <strong>Example Dataset</strong> first to quickly explore the full analysis pipeline.</li>
                <li>Use <strong>New Analysis</strong> to study proteins you are interested in.</li>
                <li>Return to any previous dataset via <strong>My Previous Analyses</strong>.</li>
            </ul>


        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>