#!/bin/bash
# scripts/run_pepstats.sh
ANALYSIS_ID=$1
FASTA_FILE=$2
OUTFILE=$3

pepstats -sequence "$FASTA_FILE" -outfile "$OUTFILE" -auto

echo "PEPSTAT_DONE=$OUTFILE"
