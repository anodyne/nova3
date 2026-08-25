<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

use Nova\Pages\Blocks\Content\FreeformContentBlock;
use Nova\Pages\Blocks\ContentRatings\CardsContentRatingsBlock;
use Nova\Pages\Blocks\ContentRatings\GridContentRatingsBlock;
use Nova\Pages\Blocks\ContentRatings\SplitContentRatingsBlock;
use Nova\Pages\Blocks\Features\AlternatingFeatureBlock;
use Nova\Pages\Blocks\Features\CardsFeatureBlock;
use Nova\Pages\Blocks\Features\GridFeatureBlock;
use Nova\Pages\Blocks\Hero\ImageTilesHeroBlock;
use Nova\Pages\Blocks\Hero\SplitHeroBlock;
use Nova\Pages\Blocks\Hero\StackedHeroBlock;
use Nova\Pages\Blocks\ImageGallery\CarouselImageGalleryBlock;
use Nova\Pages\Blocks\ImageGallery\ThumbnailImageGalleryBlock;
use Nova\Pages\Blocks\Logos\SimpleLogosBlock;
use Nova\Pages\Blocks\Logos\SplitLogosBlock;
use Nova\Pages\Blocks\Manifest\ManifestBlock;
use Nova\Pages\Blocks\Stats\SimpleStatsBlock;
use Nova\Pages\Blocks\Stats\SplitStatsBlock;
use Nova\Pages\Blocks\Stories\AlternatingStoriesBlock;
use Nova\Pages\Blocks\Stories\StoriesTimelineBlock;

class PageBlockRegistry
{
    /** @return array<int, Block> */
    public static function blocks(): array
    {
        return [
            ManifestBlock::make(ManifestBlock::component),

            CardsContentRatingsBlock::make(CardsContentRatingsBlock::component),
            GridContentRatingsBlock::make(GridContentRatingsBlock::component),
            SplitContentRatingsBlock::make(SplitContentRatingsBlock::component),

            GridFeatureBlock::make(GridFeatureBlock::component),
            CardsFeatureBlock::make(CardsFeatureBlock::component),
            AlternatingFeatureBlock::make(AlternatingFeatureBlock::component),

            FreeformContentBlock::make(FreeformContentBlock::component),

            StackedHeroBlock::make(StackedHeroBlock::component),
            SplitHeroBlock::make(SplitHeroBlock::component),
            ImageTilesHeroBlock::make(ImageTilesHeroBlock::component),

            CarouselImageGalleryBlock::make(CarouselImageGalleryBlock::component),
            ThumbnailImageGalleryBlock::make(ThumbnailImageGalleryBlock::component),

            SimpleLogosBlock::make(SimpleLogosBlock::component),
            SplitLogosBlock::make(SplitLogosBlock::component),

            SimpleStatsBlock::make(SimpleStatsBlock::component),
            SplitStatsBlock::make(SplitStatsBlock::component),

            AlternatingStoriesBlock::make(AlternatingStoriesBlock::component),
            StoriesTimelineBlock::make(StoriesTimelineBlock::component),
        ];
    }
}
