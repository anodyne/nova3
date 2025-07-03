<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

class PageBlockRegistry
{
    public static function blocks(): array
    {
        return [
            Manifest\ManifestBlock::make(Manifest\ManifestBlock::component),

            ContentRatings\CardsContentRatingsBlock::make(ContentRatings\CardsContentRatingsBlock::component),
            ContentRatings\GridContentRatingsBlock::make(ContentRatings\GridContentRatingsBlock::component),
            ContentRatings\SplitContentRatingsBlock::make(ContentRatings\SplitContentRatingsBlock::component),

            Features\GridFeatureBlock::make(Features\GridFeatureBlock::component),
            Features\CardsFeatureBlock::make(Features\CardsFeatureBlock::component),
            Features\AlternatingFeatureBlock::make(Features\AlternatingFeatureBlock::component),

            Content\FreeformContentBlock::make(Content\FreeformContentBlock::component),

            Hero\StackedHeroBlock::make(Hero\StackedHeroBlock::component),
            Hero\SplitHeroBlock::make(Hero\SplitHeroBlock::component),
            Hero\ImageTilesHeroBlock::make(Hero\ImageTilesHeroBlock::component),

            Logos\SimpleLogosBlock::make(Logos\SimpleLogosBlock::component),
            Logos\SplitLogosBlock::make(Logos\SplitLogosBlock::component),

            Stats\SimpleStatsBlock::make(Stats\SimpleStatsBlock::component),
            Stats\SplitStatsBlock::make(Stats\SplitStatsBlock::component),

            Stories\AlternatingStoriesBlock::make(Stories\AlternatingStoriesBlock::component),
            Stories\StoriesTimelineBlock::make(Stories\StoriesTimelineBlock::component),
        ];
    }
}
