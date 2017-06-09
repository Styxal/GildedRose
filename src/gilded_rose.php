<?php

class GildedRose {

    private $items;

    public function __construct($items) {
        $this->items = $items;
    }

    public function update_quality() {
        foreach ($this->items as $item) {
            switch ($item->name) {
                case 'Aged Brie':
                    $this->agedBrie($item);
                    break;
                case 'Backstage passes to a TAFKAL80ETC concert':
                    $this->concertTickets($item);
                    break;
                case 'Sulfuras, Hand of Ragnaros':
                    $item->quality = 80;
                    break;
                default:
                    $this->regularItems($item);
                    break;
            }
        }
    }

    private function agedBrie($item) {
        $item->sell_in -= 1;
        $item->quality += 1;
        $this->capQuality($item);
    }

    private function concertTickets($item) {
        $item->sell_in -= 1;
        if ($item->sell_in < 0) {
            $item->quality = 0;
        } elseif ($item->sell_in >= 0 && $item->sell_in <= 5) {
            $item->quality += 3;
        } elseif ($item->sell_in > 5 && $item->sell_in <= 10) {
            $item->quality += 2;
        } else {
            $item->quality -= 1;
        }
        $this->capQuality($item);
    }

    private function regularItems($item) {
        $name = strtolower($item->name);
        $item->sell_in -= 1;
        if (strpos($name, 'conjured') !== false) {
            $item->quality -= 2;
        } else {
            $item->quality -= 1;
        }
        $this->capQuality($item);
    }

    private function capQuality($item){
        if ($item->quality > 50) {
            $item->quality = 50;
        }
        return $item;
    }
}
