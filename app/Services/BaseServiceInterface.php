<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BaseServiceInterface
 * ---
 * Modified from: https://github.com/rappasoft/laravel-boilerplate/blob/master/app/Services/BaseService.php
 *
 * @package App\Services
 */
interface BaseServiceInterface
{
    /**
     * Method for getting all the database records from the model out of the database.
     *
     * @param  array|string[] $columns
     * @return Collection
     */
    public function allRecords(array $columns = ['*']): Collection;

    /**
     * Count all the database records from the database table.
     *
     * @return int
     */
    public function countRecords(): int;

    /**
     * Get the first specified model record from the database.
     *
     * @return Model
     */
    public function first(): Model;

    /**
     * Get the first specified model record from the database or throw and exception if not found.
     *
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function firstOrFail(): Model;

    /**
     * Getting all the records from the database table.
     *
     * @param  array|string[] $columns The columns name that u want to select in your query output.
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection;

    /**
     * Method for getting a database record based on their unique identifier.
     *
     * @param  int|string $identifier The unique identifier from the database record.
     * @return Model|Collection|Builder|array|null
     */
    public function getByIdentifier(int|string $identifier): Model|Collection|Builder|array|null;

    /**
     * Method for getting the records based on an database column.
     *
     * @param  string         $item     The item value in the database records.
     * @param  string         $column   The database column name
     * @param  array|string[] $columns  The column u want to select in your query output.
     * @return Builder|Model|null
     */
    public function getByColumn(string $item, string $column, array $columns = ['*']): Builder|Model|null;

    /**
     * Delete the specified model record from the database based on his unique identifier.
     *
     * @param  int|string $identifier The unique identifier from the database record.
     * @return bool|null
     *
     * @throws Exception
     */
    public function deleteByIdentifier(int|string $identifier): bool|null;

    /**
     * Method for limiting the MySQL SELECT query.
     *
     * @param  int $limit The limit integer of the records u want to select.
     * @return self
     */
    public function limit(int $limit): self;

    /**
     * Method for sorting the database records based on an column.
     *
     * @param  string $column    The column name from the table that u want to sort.
     * @param  string $direction The direction u want to sort in can be ASC or DESC
     * @return self
     */
    public function orderBy(string $column, string $direction = 'ASC'): self;

    /**
     * Get all the database records in a paginated form.
     *
     * @param  int            $limit    The amount of records u want per page.
     * @param  array|string[] $columns  The columns u want to select in the query.
     * @param  string         $pageName The request parameter name.
     * @param  string|null    $page     The current page in view.
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', null|string $page = null): LengthAwarePaginator;

    /**
     * Add a simple where clause to the query.
     *
     * @param  string $column    The column name from the database table.
     * @param  string $value     The value from the database column.
     * @param  string $operator  The MySQL comparison operator.
     * @return self
     */
    public function where(string $column, string $value, string $operator = '='): self;

    /**
     * Add a simple where in clause to the query.
     *
     * @param  string $column The column name where u want to perform the where clause one.
     * @param  mixed  $values The given values that need to be matched against the column name
     * @return self
     */
    public function whereIn(string $column, mixed $values): self;

    /**
     * Set Eloquent relationships to eagerload.
     *
     * @param  mixed $relations The relationship names u want to set on the query.
     * @return $this
     */
    public function with(mixed $relations): self;
}
