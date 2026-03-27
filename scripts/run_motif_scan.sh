#!/bin/bash
# scripts/run_motif_scan.sh
ANALYSIS_ID=$1
FASTA_FILE=$2
OUTFILE=$3

patmatmotifs -sequence "$FASTA_FILE" \
             -outfile "$OUTFILE" \
             -full \
             -auto \
             -stdout

echo "MOTIF_SCAN_DONE=$OUTFILE"
