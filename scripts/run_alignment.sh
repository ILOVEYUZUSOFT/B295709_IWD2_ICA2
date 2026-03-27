#!/bin/bash
# scripts/run_alignment.sh
ANALYSIS_ID=$1
FASTA_FILE=$2
ALN_FILE=$3

clustalo -i "$FASTA_FILE" -o "$ALN_FILE" --outfmt=clustal --force --threads=4

echo "ALIGNMENT_DONE=$ALN_FILE"
