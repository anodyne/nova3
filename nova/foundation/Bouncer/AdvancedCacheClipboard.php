<?php

namespace Nova\Foundation\Bouncer;

use Silber\Bouncer\CachedClipboard;
use Illuminate\Database\Eloquent\Model;

class AdvancedCachedClipboard extends CachedClipboard
{
    protected $abilities = [];

    protected $roles = [];

    /**
     * Get the given authority's abilities.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $authority
     * @param  bool  $allowed
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAbilities(Model $authority, $allowed = true)
    {
        $key = $this->getCacheKey($authority, 'abilities', $allowed);

        if (! isset($this->abilities[$key])) {
            $this->abilities[$key] = parent::getAbilities($authority, $allowed);
        }

        return $this->abilities[$key];
    }

    /**
     * Get the given authority's roles.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $authority
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRoles(Model $authority)
    {
        $key = $this->getCacheKey($authority, 'roles');

        if (! isset($this->roles[$key])) {
            $this->roles[$key] = parent::getRoles($authority);
        }

        return $this->roles[$key];
    }

    /**
     * Clear the cache.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $authority
     *
     * @return $this
     */
    public function refresh($authority = null)
    {
        parent::refresh($authority);

        if (is_null($authority)) {
            $this->abilities = [];
            $this->roles = [];
        }

        return $this;
    }

    /**
     * Clear the cache for the given authority.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $authority
     *
     * @return $this
     */
    public function refreshFor(Model $authority)
    {
        parent::refreshFor($authority);

        unset($this->abilities[$this->getCacheKey($authority, 'abilities', true)], $this->abilities[$this->getCacheKey($authority, 'abilities', false)], $this->roles[$this->getCacheKey($authority, 'roles')]);

        return $this;
    }
}
