#!/usr/bin/env python3
import sys
import matplotlib.pyplot as plt
from collections import Counter

fasta_file = sys.argv[1]
output_png = sys.argv[2]

aa_count = Counter()
total_aa = 0

with open(fasta_file) as f:
    for line in f:
        if line.startswith('>'): continue
        seq = line.strip()
        aa_count.update(seq.upper())
        total_aa += len(seq)

# Top 20 amino acids
aas = ['A','R','N','D','C','Q','E','G','H','I','L','K','M','F','P','S','T','W','Y','V']
values = [aa_count.get(aa, 0) / total_aa * 100 for aa in aas]

plt.figure(figsize=(10, 6))
plt.bar(aas, values, color='#1f77b4')
plt.title('Amino Acid Composition (%) - All Sequences')
plt.xlabel('Amino Acid')
plt.ylabel('Percentage (%)')
plt.grid(axis='y', alpha=0.3)
plt.tight_layout()
plt.savefig(output_png, dpi=300, bbox_inches='tight')
plt.close()

