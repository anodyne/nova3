<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database\Schema;

trait TipTapContent
{
    public static function tipTapSchema(array $content = []): array
    {
        return [
            'type' => 'doc',
            'content' => $content,
        ];
    }
}
