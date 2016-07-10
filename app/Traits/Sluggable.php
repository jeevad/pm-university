<?php

namespace App\Traits;

trait Sluggable
{

    public function generateSlug($model, $title, $id = false)
    {

        $slug  = str_slug(strtolower($title));
        $query = "slug REGEXP '^{$slug}(-[0-9]*)?$'";
        if ($id) {
            $query .= "and id != '{$model->id}'";
        }
        $slugs = $model->whereRaw($query);

        if ($slugs->count() === 0) {
            return $slug;
        }

        // Get the last matching slug
        $lastSlug = $slugs->orderBy('slug', 'desc')->first()->slug;

        // Strip the number off of the last slug, if any
        $lastSlugNumber = intval(str_replace($slug.'-', '', $lastSlug));

        // Increment/append the counter and return the slug we generated
        return $slug.'-'.($lastSlugNumber + 1);
    }

    /**
     * Generate a unique slug.
     * If it already exists, a number suffix will be appended.
     * It probably works only with MySQL.
     *
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $value
     * @return string
     */
    public function getUniqueSlug(\Illuminate\Database\Eloquent\Model $model,
                                  $value)
    {
        $slug      = str_slug(strtolower($value));
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}