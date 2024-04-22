<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum AvatarStyle: string implements HasLabel
{
    use HasSelectOptions;

    case Adventurer = 'adventurer';

    case AdventurerNeutral = 'adventurer-neutral';

    case Avataaars = 'avataaars';

    case AvataaarsNeutral = 'avataaars-neutral';

    case BigEars = 'big-ears';

    case BigEarsNeutral = 'big-ears-neutral';

    case BigSmile = 'big-smile';

    case Bottts = 'bottts';

    case BotttsNeutral = 'bottts-neutral';

    case Croodles = 'croodles';

    case CroodlesNeutral = 'croodles-neutral';

    case FunEmoji = 'fun-emoji';

    case Icons = 'icons';

    case Identicon = 'identicon';

    case Initials = 'initials';

    case Lorelei = 'lorelei';

    case LoreleiNeutral = 'lorelei-neutral';

    case Micah = 'micah';

    case Miniavs = 'miniavs';

    case Notionists = 'notionists';

    case NotionistsNeutral = 'notionists-neutral';

    case OpenPeeps = 'open-peeps';

    case Personas = 'personas';

    case PixelArt = 'pixel-art';

    case PixelArtNeutral = 'pixel-art-neutral';

    case Rings = 'rings';

    case Shapes = 'shapes';

    case Thumbs = 'thumbs';

    public function getLabel(): ?string
    {
        return str($this->value)->replace('-', ' ')->title()->toString();
    }
}
