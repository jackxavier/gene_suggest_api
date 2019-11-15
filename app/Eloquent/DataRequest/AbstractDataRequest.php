<?php

namespace App\Eloquent\DataRequest;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator as PaginatorInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class AbstractDataRequest
{
    /**
     * @var Builder
     */
    protected $qb;

    /**
     * @var callable
     */
    protected $filter;

    /**
     * AbstractFetch constructor.
     *
     * @param Builder $qb
     */
    public function __construct(Builder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @param Builder $qb
     *
     * @return static
     */
    public static function create(Builder $qb)
    {
        return new static($qb);
    }

    /**
     * @param callable $filter
     *
     * @return $this
     */
    public function withFilter(callable $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return EloquentCollection
     */
    public function get(?int $limit = null)
    {
        if (isset($limit)) {
            $this->qb->limit($limit);
        }

        $collection = $this->qb->get();
        $collection = $this->filterCollection($collection);

        return $collection;
    }

    /**
     * @param array $fields
     *
     * @return EloquentCollection|static[]
     */
    public function all(array $fields = [])
    {
        return $this->qb->get($fields)->toArray();
    }

    /**
     * @param int $id
     *
     * @return Model|mixed
     */
    public function findOrFail(int $id)
    {
        $entity = $this->qb->findOrFail($id);
        if (!isset($this->transformer)) {
            return $entity;
        }

        return call_user_func($this->transformer, $entity);
    }

    /**
     * @return Model|mixed
     */
    public function firstOrFail()
    {
        $entity = $this->qb->firstOrFail();
        if (!isset($this->transformer)) {
            return $entity;
        }

        return call_user_func($this->transformer, $entity);
    }

    /**
     * @return Model|mixed|null
     */
    public function first(): ?Model
    {
        $entity = $this->qb->first();

        return $entity instanceof Model ? $entity : null;
    }

    /**
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->qb->paginate($perPage);
    }

    /**
     * @param int $perPage
     *
     * @return PaginatorInterface
     */
    public function simplePaginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->qb->simplePaginate($perPage);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->qb->count();
    }

    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return Collection
     */
    public function pluck(string $column, string $key = null): Collection
    {
        return $this->qb->pluck($column, $key);
    }

    /**
     * @param Collection|PaginatorInterface $collection
     *
     * @return Collection|PaginatorInterface
     */
    protected function filterCollection($collection)
    {
        if (!isset($this->filter)) {
            return $collection;
        }

        if ($collection instanceof Paginator) {
            $collection = $collection->getCollection();
        }

        return $collection->filter($this->filter);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Scope|string $scope
     *
     * @return $this
     */
    public function withoutGlobalScope($scope): self
    {
        $this->qb->withoutGlobalScope($scope);

        return $this;
    }

    /**
     * @param string $order (ASC|DESC)
     *
     * @return string
     */
    protected function normalizeOrderDirection($order): string
    {
        $order = Str::lower($order);

        return $order === 'desc' ? 'DESC' : 'ASC';
    }

    /**
     * @param $query
     * @param $table
     *
     * @return bool
     */
    public static function isJoined($query, $table)
    {
        $joins = $query->getQuery()->joins;
        if ($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }

        return false;
    }
}
