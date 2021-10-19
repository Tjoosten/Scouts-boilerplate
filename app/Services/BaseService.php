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
    /**
     * The Eloquent model for the Service repository.
     *
     * @var Model
     */
    protected Model $eloquentModel;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected Builder $query;

    /**
     * Alias for the query limit.
     *
     * @var int|null
     */
    protected int|null $take;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected array $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    protected array $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    protected array $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
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

    /**
     * Get the first specified model record from the database or throw and exception if not found.
     *
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function firstOrFail(): Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail();

        $this->unsetClauses();

        return $model;
    }

    /**
     * Getting all the records from the database table.
     *
     * @param  array|string[] $columns The columns name that u want to select in your query output.
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Method for getting a database record based on their unique identifier.
     *
     * @param  int|string $identifier The unique identifier from the database record.
     * @return Model|Collection|Builder|array|null
     */
    public function getByIdentifier(int|string $identifier): Model|Collection|Builder|array|null
    {
        $this->unsetClauses();
        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($identifier);
    }

    /**
     * Method for getting the records based on an database column.
     *
     * @param  string         $item     The item value in the database records.
     * @param  string         $column   The database column name
     * @param  array|string[] $columns  The column u want to select in your query output.
     * @return Builder|Model|null
     */
    public function getByColumn(string $item, string $column, array $columns = ['*']): Builder|Model|null
    {
        $this->unsetClauses();
        $this->newQuery()->eagerLoad();

        return $this->query->where($column, $item)->first($columns);
    }

    /**
     * Delete the specified model record from the database based on his unique identifier.
     *
     * @param  int|string $identifier The unique identifier from the database record.
     * @return bool|null
     *
     * @throws Exception
     */
    public function deleteByIdentifier(int|string $identifier): bool|null
    {
        $this->unsetClauses();

        return $this->getByIdentifier($identifier)->delete();
    }

    /**
     * Method for limiting the MySQL SELECT query.
     *
     * @param  int $limit The limit integer of the records u want to select.
     * @return self
     */
    public function limit(int $limit): self
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Method for sorting the database records based on an column.
     *
     * @param  string $column    The column name from the table that u want to sort.
     * @param  string $direction The direction u want to sort in can be ASC or DESC
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Get all the database records in a paginated form.
     *
     * @param  int            $limit    The amount of records u want per page.
     * @param  array|string[] $columns  The columns u want to select in the query.
     * @param  string         $pageName The request parameter name.
     * @param  string|null    $page     The current page in view.
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', null|string $page = null): LengthAwarePaginator
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param  string $column    The column name from the database table.
     * @param  string $value     The value from the database column.
     * @param  string $operator  The MySQL comparison operator.
     * @return self
     */
    public function where(string $column, string $value, string $operator = '='): self
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param  string $column The column name where u want to perform the where clause one.
     * @param  mixed  $values The given values that need to be matched against the column name
     * @return self
     */
    public function whereIn(string $column, mixed $values): self
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eagerload.
     *
     * @param  mixed $relations The relationship names u want to set on the query.
     * @return $this
     */
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
