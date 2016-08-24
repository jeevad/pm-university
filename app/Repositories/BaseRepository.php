<?php

namespace App\Repositories;

use App\Traits\Sluggable;

abstract class BaseRepository
{
    use Sluggable;

    /**
     * The Model instance.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Get number of records.
     *
     * @return array
     */
    public function getNumber()
    {
        $total = $this->model->count();

        $new = $this->model->whereSeen(0)->count();

        return compact('total', 'new');
    }

    /**
     * Destroy a model.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $this->getById($id)->delete();
    }

    /**
     * Get Model by id.
     *
     * @param int $id
     *
     * @return App\Models\Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get max id.
     *
     * @return type
     */
    public function getMaxValue($columnName = 'id')
    {
        return $this->model->max($columnName);
    }
}
