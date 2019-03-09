<?php

namespace App\Eloquent\DataRequest;

use Illuminate\Support\Facades\DB;

class GeneDataRequest extends AbstractDataRequest
{
    /**
     * @param string $name
     *
     * @return GeneDataRequest
     */
    public function withNameLike(string $name = ''): self
    {
        $query = <<<SQL
display_label LIKE '%s'
SQL;
        $this->qb->whereRaw(
            DB::raw(sprintf($query, $this->prepareSearchString($name)))
        );

        return $this;
    }

    /**
     * @param string $species
     *
     * @return GeneDataRequest
     */
    public function withSpeciesLike(string $species = ''): self
    {
        $query = <<<SQL
species LIKE '%s'
SQL;
        $this->qb->whereRaw(
            DB::raw(sprintf($query, $this->prepareSearchString($species)))
        );

        return $this;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function prepareSearchString(string $value = ''): string
    {
        if (empty($value)) {
            return $value;
        }

        if (!preg_match('/\s/', $value)) {
            return sprintf('%%%s%%', $value);
        }

        $values = explode(' ', $value);
        $values = array_map(
            function ($value) {
                if (strlen($value) <= 3) {
                    return sprintf('%%%s', $value);
                }

                return sprintf('%%%s', $value);
            },
            $values
        );

        return sprintf('%s%%', implode('%', $values));
    }
}