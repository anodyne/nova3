<?php

namespace Nova\Foundation;

use Illuminate\Support\Facades\Storage;

class WordGenerator
{
    protected $lengths;
    protected $bigrams;
    protected $trigrams;

    public function __construct()
    {
        $this->loadFiles();
    }

    /**
     * This is a refactoring of Wordle into a class-based architecture.
     *
     * @param  int  $count
     * @return array
     */
    public function words($count = 1)
    {
        $words = [];

        for ($i = 0; $i < $count; $i++) {
            do {
                $length = $this->getRandomWeightedArrayItem($this->lengths);
                $start = $this->getRandomWeightedArrayItem($this->bigrams);
                $word = $this->fillWord($start, $length);
            } while (!preg_match('/[AEIOUY]/', $word));

            $words[] = strtolower($word);
        }

        return $words;
    }

    protected function fillWord($word, $length)
    {
        while (strlen($word) < $length) {
            $tail = substr($word, -2) ?: $word;

            if (! isset($this->trigrams[$tail])) {
                return $word;
            }

            $word.= $this->getRandomWeightedArrayItem($this->trigrams[$tail]);
        }

        return $word;
    }

    protected function getRandomWeightedArrayItem(array $list)
    {
        $totalWeight = 0;

        foreach ($list as $key => $weight) {
            if ($weight < 0) {
                throw new \InvalidArgumentException("Weights cannot be negative. Found $key => $weight.");
            }

            $totalWeight += $weight;
        }

        if ($totalWeight === 0) {
            throw new \InvalidArgumentException("Total weight must exceed zero.");
        } elseif ($totalWeight === 1) {
            return array_search(1, $list);
        }

        $rand = mt_rand(1, $totalWeight);

        foreach ($list as $key => $weight) {
            $rand -= $weight;

            if ($rand <= 0) {
                return $key;
            }
        }
    }

    protected function loadFiles()
    {
        $disk = Storage::disk('nova');

        $this->lengths = json_decode($disk->get('foundation/words/distinct-word-lengths.json'), true);
        $this->bigrams = json_decode($disk->get('foundation/words/word-start-bigrams.json'), true);
        $this->trigrams = json_decode($disk->get('foundation/words/trigrams.json'), true);
    }
}