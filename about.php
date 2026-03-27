<?php
// about.php
// Overview of the website
require_once 'includes/header.php';
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
    <div class="results-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0 fw-bold" style="font-size: 1.4rem;">
                <i class="bi bi-question-circle me-3"></i>About This Website
            </h2>
        </div>

        <div class="card-body">

            <h4 class="mb-4">Project Overview</h4>
            <p class="lead">
                This project was created as part of the In-Course Assessment 2 for the AY25 module 
                "Introduction to Website and Database Design" (IWD2). It is a fully functional 
                bioinformatics web application that enables users to retrieve protein sequences 
                from any user-defined taxonomic group, perform multiple biological analyses, 
                and revisit their results at any time.
            </p>

            <h5 class="mt-5 mb-4">Technical Architecture</h5>
            <p>
                The system uses a hybrid architecture with PHP as the primary backend language. 
                Computationally intensive bioinformatics tasks are performed by Bash and Python 
                scripts, allowing integration with professional tools installed on the server 
                (NCBI EDirect, EMBOSS suite, Clustal Omega, etc.).
            </p>

            <h5 class="mt-5 mb-4">Core Features</h5>
            <ul>
                <li>Dynamic retrieval of protein sequences from any protein family and taxonomic group from NCBI.</li>
                <li>Multiple Sequence Alignment and conservation analysis.</li>
                <li>PROSITE motif scanning using the EMBOSS patmatmotifs tool.</li>
                <li>EMBOSS pepstats and amino acid composition visualisation.</li>
                <li>Pre-loaded example dataset (Glucose-6-phosphatase from Aves) that demonstrates all functionalities.</li>
                <li>Storage of all user-generated analyses, allowing users to revisit results anytime.</li>
            </ul>

            <h5 class="mt-5 mb-4">Database Design</h5>
            <p>
                The database consists of three core tables:
            </p>
            <ul>
                <li><strong>example_g6p_aves</strong> – Contains the pre-loaded example dataset (Glucose-6-phosphatase from Aves) for functions demonstration.</li>
                <li><strong>user_analyses</strong> – Metadata table that records each user analysis (analysis name, protein family, taxonomic group, access code, creation time, etc.).</li>
                <li><strong>user_sequences</strong> – Detail table that stores the actual protein sequences.</li>
            </ul>


            <div class="mt-5 pt-4 border-top text-center text-muted">
                <p>
                    This project demonstrates a complete web development workflow.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>