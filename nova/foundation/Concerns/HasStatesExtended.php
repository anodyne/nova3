<?php

namespace Nova\Foundation\Concerns;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

trait HasStatesExtended
{
    public function canTransitionTo($to, ?string $field = null): bool
    {
        $statesConfig = self::getStateConfig();

        if ($field === null && count($statesConfig) > 1) {
            throw InvalidConfig::unknownState($field, $this);
        }

        $field = $field ?? reset($statesConfig)->field;

        $stateConfig = $statesConfig[$field];

        try {
            $this->resolveTransitionClass(
                $stateConfig->stateClass::resolveStateClass($this->$field),
                $stateConfig->stateClass::resolveStateClass($to)
            );
        } catch (CouldNotPerformTransition $exception) {
            return false;
        }

        return true;
    }
}
