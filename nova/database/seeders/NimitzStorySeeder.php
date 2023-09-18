<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Nova\Stories\Models\Story;

class NimitzStorySeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $season1 = Story::factory()->completed()->create(['title' => 'Season 1', 'order_column' => 2]);
        $season2 = Story::factory()->completed()->create(['title' => 'Season 2', 'order_column' => 3]);
        $season3 = Story::factory()->completed()->create(['title' => 'Season 3', 'order_column' => 4]);
        $season4 = Story::factory()->completed()->create(['title' => 'Season 4', 'order_column' => 5]);
        $season5 = Story::factory()->completed()->create([
            'title' => 'Armistice',
            'description' => 'Nine months after the devastating destruction of Romulus, the crew of the newly commissioned USS Nimitz NXI-3 are tasked with overseeing a contentious peace summit that brings all the major powers of the Alpha Quadrant to the table.',
            'order_column' => 6,
        ]);

        Story::create([
            'title' => 'New Crew, New Mission',
            'description' => 'The USS Nimitz, still in drydock, prepares to get underway as her senior staff begins to arrive on the eve of its first mission since her refit and mysterious accident...',
            'parent_id' => null,
            'order_column' => 1,
            'status' => 'completed',
            'started_at' => Date::createFromFormat('Y-m-d H:i', '2005-02-21 19:00', 'America/New_York'),
            'ended_at' => Date::createFromFormat('Y-m-d H:i', '2005-03-04 19:00', 'America/New_York'),
        ]);
        Story::factory()->completed()->create([
            'title' => 'Vile Intentions',
            'description' => 'Riots have broken out on the colony world of Carvek 3 and the USS Nimitz has been rushed out of dry-dock a week and a half early to intervene.',
            'parent_id' => $season1->id,
            'order_column' => 2,
            'started_at' => '2005-03-04 19:00:00',
            'ended_at' => '2005-06-01 17:08:00',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Belief of the Prophets',
            'description' => 'Starfleet dispatches the Nimitz on a mission to recover a highly secretive starship prototype near the Romulan Neutral Zone as rumors begin to circulate that Starfleet Command has begun a move against the Romulan Empire.',
            'parent_id' => $season1->id,
            'order_column' => 3,
            'started_at' => '2005-06-15',
            'ended_at' => '2005-08-06',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Behind Enemy Lines',
            'description' => 'The Nimitz is dispatched on a top secret mission that sends her into the heart of Romulan territory to recover a valuable asset in order to prevent a full-scale war from developing between the Federation and Romulan Empire.',
            'parent_id' => $season1->id,
            'order_column' => 4,
            'started_at' => '2005-08-20',
            'ended_at' => '2005-10-11',
        ]);
        Story::factory()->completed()->create([
            'title' => 'The Enemy Within',
            'description' => 'The Nimitz, after foiling several plans to ignite a war between the Romulans and the Federation, confronts the ultimate enemy who will stop at nothing to start a war or destroy them in the process.',
            'parent_id' => $season1->id,
            'order_column' => 5,
            'started_at' => '2005-10-22',
            'ended_at' => '2005-12-21',
        ]);

        Story::factory()->completed()->create([
            'title' => 'Vanishing Point',
            'description' => 'In a far corner of Federation space, a deep-space research colony has gone silent for six months and the Nimitz is dispatched to investigate the situation, only to find that the research colony is no longer there. To make matters even more interesting, there are no traces the colony ever existed there in the first place.',
            'parent_id' => $season2->id,
            'order_column' => 1,
            'started_at' => '2006-01-14',
            'ended_at' => '2006-03-22',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Dark Resurrection',
            'description' => "Starfleet orders the Nimitz to turn over Pyyr'l's evil alternate to a secure location, and while there, they will have to turn over Pyyr'l's body as well, despite the crew's unwillingness to let go of one of their own.",
            'parent_id' => $season2->id,
            'order_column' => 2,
            'started_at' => '2006-04-17',
            'ended_at' => '2006-06-01',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Games',
            'description' => 'The crew is thrown into a wartime training scenario onboard the Nimitz where they have to simulate a first strike on a military target, a situation they have never faced. In the process, they will be tested as officers and as a crew.',
            'parent_id' => $season2->id,
            'order_column' => 3,
            'started_at' => '2006-05-31',
            'ended_at' => '2006-08-09',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Internal Affairs',
            'description' => 'The Nimitz is dispatched to Arria 4 when Starfleet suspects an insurrection at an important Federation mining facility led by the Starfleet officer in command of the facility.',
            'parent_id' => $season2->id,
            'order_column' => 4,
            'started_at' => '2006-10-01',
            'ended_at' => '2007-01-09',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Acquisition',
            'description' => 'With sagging approval ratings, the Federation President strikes a free trade agreement with the Ferengi and the Nimitz is tasked with escorting the Chairman of the Ferengi Trade Mission and his delegation back to Earth for final negotiations.',
            'parent_id' => $season2->id,
            'order_column' => 5,
            'started_at' => '2007-02-10',
            'ended_at' => '2007-05-02',
        ]);

        Story::factory()->completed()->create([
            'title' => 'The Ninth Circle of Hell',
            'description' => 'The Nimitz crew wakes to find themselves stranded on an arctic planet with the wreckage of the Nimitz on the icy plain below...',
            'parent_id' => $season3->id,
            'order_column' => 1,
            'started_at' => '2007-05-02',
            'ended_at' => '2007-10-08',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Friends & Enemies',
            'description' => 'The Nimitz discovers a deadly weapon and an ugly side to a species they thought they knew...',
            'parent_id' => $season3->id,
            'order_column' => 2,
            'started_at' => '2007-10-08',
            'ended_at' => '2008-04-14',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Once More Unto the Breach',
            'description' => 'The Nimitz crew finds themselves faced with an incorrigible foe and the safety of an entire quadrant resting squarely on their shoulders...',
            'parent_id' => $season3->id,
            'order_column' => 3,
            'started_at' => '2008-04-14',
            'ended_at' => '2008-12-07',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Recalled',
            'description' => "The Nimitz is recalled to Earth to undergo repairs while two of its crew stand before JAG for decisions they've made...",
            'parent_id' => $season3->id,
            'order_column' => 4,
            'started_at' => '2008-12-07',
            'ended_at' => '2009-02-11',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Gambit',
            'description' => 'The Nimitz is dispatched to the Zarinn system after a Starfleet fighter is destroyed and the Federation fears the system could devolve into anarchy.',
            'parent_id' => $season3->id,
            'order_column' => 5,
            'started_at' => '2009-02-11',
            'ended_at' => '2009-09-07',
        ]);
        Story::factory()->completed()->create([
            'title' => 'In Memorium',
            'description' => 'Forty-five years after the mission to Zarinn 2, the crew of the USS Nimitz gathers again to pay their respects to a fallen crew member.',
            'parent_id' => $season3->id,
            'order_column' => 6,
            'started_at' => '2009-09-07',
            'ended_at' => '2009-10-31',
        ]);

        Story::factory()->completed()->create([
            'title' => 'To Boldly Go...',
            'description' => "The crew of the Nimitz, still reeling from the resignation of Will Reardon, finds out they've been assigned to a new ship with secrets and dangers none of them can imagine...",
            'parent_id' => $season4->id,
            'order_column' => 1,
            'started_at' => '2009-10-31',
            'ended_at' => '2010-01-30',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Sojourner vs the Gods',
            'description' => "When a shuttle accident leaves several Sojourner crew stranded on a planet, the planet's residents think they're deities, but an alien race doesn't appreciate the intrusion.",
            'parent_id' => $season4->id,
            'order_column' => 2,
            'started_at' => '2010-01-30',
            'ended_at' => '2010-08-18',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Salvaged',
            'description' => "A catastrophic accident on the Nimitz during her upgrades prompts Admiral Reardon to send the Sojourner back to a place the crew swore they'd never go again to salvage their dying ship.",
            'parent_id' => $season4->id,
            'order_column' => 3,
            'started_at' => '2010-09-16',
            'ended_at' => '2011-01-17',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Search & Rescue',
            'description' => 'Following the cataclysmic events of the Hobus star supernova, the crew of the Sojourner rush to the aid of the Romulan Star Empire.',
            'parent_id' => $season4->id,
            'order_column' => 4,
            'started_at' => '2011-01-17',
            'ended_at' => '2011-07-07',
        ]);

        Story::factory()->completed()->create([
            'title' => 'We Are Gathered Here Today',
            'description' => 'The USS Nimitz arrives at the location for the peace summit and must play the role of playground cop as the Romulans, Klingons and others arrive for the peace talks all while preparations happen down on the planet.',
            'parent_id' => $season5->id,
            'order_column' => 1,
            'started_at' => '2011-10-20',
            'ended_at' => '2011-12-05',
        ]);
        Story::factory()->completed()->create([
            'title' => 'No Room for Enemies',
            'description' => "When the first day of talks goes worse than expected, it's up to the crew of the Nimitz to salvage the summit before everything falls apart.",
            'parent_id' => $season5->id,
            'order_column' => 2,
            'started_at' => '2011-12-05',
            'ended_at' => '2012-03-14',
        ]);
        Story::factory()->completed()->create([
            'title' => 'Day of Infamy',
            'description' => 'After salvaging the peace summit, the first day closes on a positive note, but the silent night is shattered by a devastating attack that will threaten to bring the summit to a halt and the quadrant to the brink of war.',
            'parent_id' => $season5->id,
            'order_column' => 3,
            'started_at' => '2012-03-14',
            'ended_at' => '2012-07-13',
        ]);
        Story::factory()->completed()->create([
            'title' => 'The Blame Game',
            'description' => "With the attack on the peace summit only hours old, each delegation begins blaming the others for the attacks. The crew of the Nimitz will have to solve the mystery behind the attacks if there's to be any hope of successful peace talks.",
            'parent_id' => $season5->id,
            'order_column' => 4,
            'started_at' => '2012-07-13',
            'ended_at' => '2012-09-23',
        ]);

        activity()->enableLogging();
    }
}
