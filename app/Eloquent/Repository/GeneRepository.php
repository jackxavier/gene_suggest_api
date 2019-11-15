<?php

namespace App\Eloquent\Repository;

use App\Eloquent\DataRequest\GeneDataRequest;
use App\Eloquent\Entity\Gene;

class GeneRepository
{
    /**
     * @param array $relations
     *
     * @return GeneDataRequest
     */
    public function fetchAll(array $relations = []): GeneDataRequest
    {
        $dataRequest = GeneDataRequest::create(
            Gene::with($relations)
        );

        return $dataRequest;
    }
}
