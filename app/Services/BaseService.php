<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BaseService
 * ---
 * Modified from: https://github.com/rappasoft/laravel-boilerplate/blob/master/app/Services/BaseService.php
 *
 * @package App\Services
 */
abstract class BaseService implements BaseServiceInterface
{
    /** The Eloquent model for the Service repository. */
    protected Model $eloquentModel;

    /** The query builder. */
    protected Builder $query;

    /** Alias for the query limit. */
    protected ?int $take;

    /** Array of related models to eager load. */
    protected array $with = [];

    /** Array of one or more where clause parameters. */
    protected array $wheres = [];

    /** Array of one or more where in clause parameters. */
    protected array $whereIns = [];

    /** Array of one or more ORDER BY column/value pairs. */
    protected array $orderBys = [];

    /** Array of scope methods to call on the model. */
    protected array $scopes = [];

    /** {@inheritDoc} */
    public function allRecords(array $columns = ['*']): Collection
    {
        $this->newQuery()->eagerLoad();

        return $this->query->get($columns);
    }

    /** {@inheritDoc} */
    public function countRecords(): int
    {
        return $this->allRecords()->count();
    }

    /** {@inheritDoc} */
    public function first(): Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->first();

        $this->unsetClauses();

        return $model;
    }

    /** {@inheritDoc} */
    public function firstOrFail(): Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail();

        $this->unsetClauses();

        return $model;
    }

    /** {@inheritDoc} */
    public function get(array $columns = ['*']): Collection
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /** {@inheritDoc} */
    public function getByIdentifier(int|string $identifier): Model|Collection|Builder|array|null
    {
        $this->unsetClauses();
        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($identifier);
    }

    /** {@inheritDoc} */
    public function getByColumn(string $item, string $column, array $columns = ['*']): Builder|Model|null
    {
        $this->unsetClauses();
        $this->newQuery()->eagerLoad();

        return $this->query->where($column, $item)->first($columns);
    }

    /** {@inheritDoc} */
    public function deleteByIdentifier(int|string $identifier): bool|null
    {
        $this->unsetClauses();

        return $this->getByIdentifier($identifier)->delete();
    }

    /** {@inheritDoc} */
    public function limit(int $limit): self
    {
        $this->take = $limit;

        return $this;
    }

    /** {@inheritDoc} */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /** {@inheritDoc} */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', null|string $page = null): LengthAwarePaginator
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }

    /** {@inheritDoc} */
    public function where(string $column, string $value, string $operator = '='): self
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /** {@inheritDoc} */
    public function whereIn(string $column, mixed $values): self
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /** {@inheritDoc} */
    public function with(mixed $relations): self
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return self
     */
    protected function newQuery(): self
    {
        $this->query = $this->eloquentModel->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return self
     */
    protected function eagerLoad(): self
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses(): self
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and ! is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set query scopes/
     *
     * @return $this
     */
    protected function setScopes(): self
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses(): self
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;

        return $this;
    }
}
