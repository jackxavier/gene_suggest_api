<?php

namespace App\Eloquent\Entity;

use Illuminate\Database\Eloquent\Model;

class Gene extends Model
{
    public const VAR_TABLE_NAME = 'gene_autocomplete';

    protected $table = self::VAR_TABLE_NAME;
}
