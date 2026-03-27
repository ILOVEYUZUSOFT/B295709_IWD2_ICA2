#!/usr/bin/env python3
# scripts/conservation_plot.py 
import sys
import matplotlib.pyplot as plt
from Bio import AlignIO
import numpy as np

alignment_file = sys.argv[1]
output_png = sys.argv[2]

alignment = AlignIO.read(alignment_file, "clustal")
length = alignment.get_alignment_length()

# Calculate conservation score (Shannon entropy)
conservation = []
for i in range(length):
    column = alignment[:, i]
    unique, counts = np.unique(list(column), return_counts=True)
    freq = counts / len(column)
    entropy = -np.sum(freq * np.log2(freq + 1e-10))
    conservation.append(1 - (entropy / np.log2(20)))

# Plot
plt.figure(figsize=(12, 5))
plt.plot(conservation, color='#2E8B57', linewidth=2)
plt.title('Protein Sequence Conservation Across Species', fontsize=14, fontweight='bold')
plt.xlabel('Position in Alignment')
plt.ylabel('Conservation Score (0-1)')
plt.grid(True, alpha=0.3)
plt.axhline(y=0.7, color='red', linestyle='--', alpha=0.5, label='High Conservation')
plt.legend()
plt.tight_layout()
plt.savefig(output_png, dpi=300, bbox_inches='tight')
plt.close()

