<?php

namespace App\Eloquent\DataRequest;

use App\Http\Request\GeneSearchRequest;

class GeneSearchRequestAssembler
{
    /**
     * @param GeneDataRequest $dataRequest
     * @param array           $validatedData
     *
     * @return void
     */
    public static function assembleDataRequest(
        GeneDataRequest &$dataRequest,
        array $validatedData
    ): void {

        if (array_key_exists(GeneSearchRequest::V_FILTER_GENE_NAME, $validatedData)) {
            $dataRequest->withNameLike($validatedData[GeneSearchRequest::V_FILTER_GENE_NAME]);
        }

        if (array_key_exists(GeneSearchRequest::V_FILTER_SPECIES, $validatedData)) {
            $dataRequest->withSpeciesLike($validatedData[GeneSearchRequest::V_FILTER_SPECIES]);
        }
    }
}
