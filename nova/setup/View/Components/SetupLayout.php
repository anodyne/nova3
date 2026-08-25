<?php

declare(strict_types=1);

namespace Nova\Setup\View\Components;

use Illuminate\View\Component;
use Nova\Setup\Enums\SetupType;

class SetupLayout extends Component
{
    public SetupType $type;

    public function __construct(SetupType|string $type = 'install')
    {
        $this->type = $type instanceof SetupType ? $type : SetupType::from($type);
    }

    public function render()
    {
        return view('layouts.setup');
    }
}
