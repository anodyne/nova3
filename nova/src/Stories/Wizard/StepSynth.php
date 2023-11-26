<?php

declare(strict_types=1);

namespace Nova\Stories\Wizard;

class StepSynth extends \Livewire\Mechanisms\HandleComponents\Synthesizers\Synth
{
    public static $key = 'step';

    public static function match($target)
    {
        return $target instanceof Step;
    }

    public function dehydrate($target)
    {
        return [[
            'stepName' => $target->stepName,
            'info' => $target->info,
            'status' => $target->status->value,
        ], []];
    }

    public function hydrate($value)
    {
        return new Step(
            $value['stepName'],
            $value['info'],
            StepStatus::from($value['status']),
        );
    }
}
