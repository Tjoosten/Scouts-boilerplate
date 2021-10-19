<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

}
