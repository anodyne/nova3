<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait CanManageResources
{
    /** @return Attribute<bool, never> */
    public function canManage(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('department.*')
                || $this->isAbleTo('rank.*')
                || $this->isAbleTo('role.*')
                || $this->isAbleTo('theme.*')
                || $this->isAbleTo('user.*')
        );
    }

    /** @return Attribute<bool, never> */
    public function canManageUsers(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('user.*')
                || $this->isAbleTo('role.*')
        );
    }

    /** @return Attribute<bool, never> */
    public function canManageForms(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('form.*')
                || $this->isAbleTo('form-submission.*')
        );
    }

    /** @return Attribute<bool, never> */
    public function canManageSystem(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('theme.*')
                || $this->isAbleTo('menu.*')
                || $this->isAbleTo('system.*')
                || $this->isAbleTo('addon.*')
        );
    }

    /** @return Attribute<bool, never> */
    public function canWrite(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('post.*')
                || $this->isAbleTo('story.*')
                || $this->isAbleTo('post-type.*')
        );
    }

    /** @return Attribute<bool, never> */
    public function canManageStorytelling(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('post.*')
                || $this->isAbleTo('story.*')
                || $this->isAbleTo('post-type.*')
        );
    }
}
