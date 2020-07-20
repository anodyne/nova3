<?php

use Illuminate\Database\Seeder;
use Nova\Stories\Models\States\Stories\Completed;
use Nova\Stories\Models\States\Stories\Current;
use Nova\Stories\Models\States\Stories\Upcoming;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run()
    {
        factory(Story::class)->create([
            'title' => 'Encounter at Farpoint',
            'description' => "Captain Jean-Luc Picard leads the crew of the USS Enterprise-D on its maiden voyage, to examine a new planetary station for trade with the Federation. On the way, they encounter Q, an omnipotent extra-dimensional being, who challenges Humanity as a barbaric, inferior species. Picard and his new crew must hold off Q's challenge and solve the puzzle of Farpoint station on Deneb IV, a base that is far more than it seems to be.",
            'status' => Completed::class,
            'sort' => 0,
        ]);

        factory(Story::class)->create([
            'title' => 'The Naked Now',
            'description' => "The crew of the Enterprise is subjected to an exotic illness that drives them to unusual manic behavior, akin to a type of alcoholic intoxication.",
            'status' => Completed::class,
            'sort' => 1,
        ]);

        factory(Story::class)->create([
            'title' => 'Code of Honor',
            'description' => "A mission of mercy is jeopardized when a planetary ruler decides he wants an Enterprise officer as his wife.",
            'status' => Current::class,
            'sort' => 2,
        ]);

        factory(Story::class)->create([
            'title' => 'The Last Outpost',
            'description' => "In pursuit of Ferengi marauders, the Enterprise and its quarry become trapped by a mysterious planet that is draining both ships' energies.",
            'status' => Upcoming::class,
            'sort' => 3,
        ]);
    }
}
