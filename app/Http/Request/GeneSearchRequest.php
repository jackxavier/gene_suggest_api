<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class GeneSearchRequest extends FormRequest
{
    public const V_FILTER_GENE_NAME = 'query';
    public const V_FILTER_SPECIES   = 'species';
    public const V_FILTER_LIMIT     = 'limit';
    public const V_FILTER_PAGE      = 'page';

    public const V_DEFAULT_LIMIT = 30;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            self::V_FILTER_GENE_NAME => [
                'nullable',
                'string',
            ],
            self::V_FILTER_SPECIES   => [
                'nullable',
                'string',
            ],
            self::V_FILTER_LIMIT     => [
                'nullable',
                'integer',
            ],
            self::V_FILTER_PAGE      => [
                'nullable',
                'integer',
            ],
        ];
    }
}
