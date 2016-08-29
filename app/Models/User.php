<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
            'password',
            'remember_token',
    ];

    /**
     * Validation rules to store an user.
     *
     * @var array
     */
    public static $loginAdminRules = [
            'user.email'    => 'required|exists:users,email',
            'user.password' => 'required',
            'user.memory'   => 'sometimes|boolean',
    ];

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'Channel');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(env('APP_MODEL_NAMESPACE').'Role');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function topics()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Topic');
    }

    /**
     * One to Many relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function content()
    {
        return $this->hasMany(env('APP_MODEL_NAMESPACE').'Content');
    }

    /**
     * Get user status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->role->slug;
    }

    /**
     * Check media all access.
     *
     * @return bool
     */
    public function accessMediasAll()
    {
        return $this->getStatus() === 'super_admin' or $this->getStatus() === 'admin';
    }

    /**
     * Check api all access.
     *
     * @return bool
     */
    public function accessApisAll()
    {
        return $this->getStatus() === 'super_admin' or $this->getStatus() === 'admin';
    }

    /**
     * Check media access one folder.
     *
     * @return bool
     */
    public function accessMediasFolder()
    {
        return $this->getStatus() != 'user';
    }

    /**
     * Get user files directory.
     *
     * @return string|null
     */
    public function getFilesDirectory()
    {
        if ($this->role->slug === 'redac') {
            $folderPath = 'user'.$this->id;
            if (!in_array($folderPath, Storage::disk('files')->directories())) {
                Storage::disk('files')->makeDirectory($folderPath);
            }

            return $folderPath;
        }
    }
}
