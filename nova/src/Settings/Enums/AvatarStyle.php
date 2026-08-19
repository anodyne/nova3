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
    case Blobs = 'blobs';
    case Bottts = 'bottts';
    case BotttsNeutral = 'bottts-neutral';
    case Clay = 'clay';
    case Constellation = 'constellation';
    case Critters = 'critters';
    case Croodles = 'croodles';
    case CroodlesNeutral = 'croodles-neutral';
    case Cutouts = 'cutouts';
    case Disco = 'disco';
    case Dylan = 'dylan';
    case FunEmoji = 'fun-emoji';
    case Glass = 'glass';
    case Glyphs = 'glyphs';
    case Icons = 'icons';
    case Identicon = 'identicon';
    case InitialFace = 'initial-face';
    case Initials = 'initials';
    case Landscape = 'landscape';
    case LineFace = 'line-face';
    case Loops = 'loops';
    case Lorelei = 'lorelei';
    case LoreleiNeutral = 'lorelei-neutral';
    case Micah = 'micah';
    case Miniavs = 'miniavs';
    case Moods = 'moods';
    case Notionists = 'notionists';
    case NotionistsNeutral = 'notionists-neutral';
    case OpenPeeps = 'open-peeps';
    case Patchwork = 'patchwork';
    case Personas = 'personas';
    case PixelArt = 'pixel-art';
    case PixelArtNeutral = 'pixel-art-neutral';
    case Pixelbot = 'pixelbot';
    case Planets = 'planets';
    case Rings = 'rings';
    case ShapeGrid = 'shape-grid';
    case Shapes = 'shapes';
    case Sprouts = 'sprouts';
    case Squircles = 'squircles';
    case Stripes = 'stripes';
    case Thumbs = 'thumbs';
    case ToonHead = 'toon-head';
    case Triangles = 'triangles';
    case VoxelArt = 'voxel-art';
    case VoxelBot = 'voxel-bot';
    case Waves = 'waves';
    case Weave = 'weave';

    public function getLabel(): string
    {
        return str($this->value)->replace('-', ' ')->title()->toString();
    }
}
