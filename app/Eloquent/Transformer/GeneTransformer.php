<?php

namespace App\Eloquent\Transformer;

use App\Eloquent\Entity\Gene;

class GeneTransformer
{
    /**
     * @param Gene        $gene
     * @param mixed| null $key
     *
     * @return array
     */
    public function __invoke(Gene $gene, $key = null): array
    {
        $arrayGene = $gene->toArray();
        unset($arrayGene['db']);

        return $arrayGene;
    }
}
