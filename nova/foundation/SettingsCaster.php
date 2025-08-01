<?php

declare(strict_types=1);

namespace Domain\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Jsonable;

class SettingsCaster implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Settings
     */
    public function get($model, $key, $value, $attributes)
    {
        $defaultsProperty = $model->defaultSettingsProperty ?: 'defaultSettings';

        return Settings::fromJson($value)->defaults($model->$defaultsProperty ?: []);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param  string  $key
     * @param Settings $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value instanceof Jsonable ? $value->toJson() : json_encode($value);
    }
}
