<?php

require_once ('../src/gilded_rose.php');

class GildedRoseTest extends PHPUnit_Framework_TestCase {

    function roseGetter($items)
    {

        $gildedRose = new GildedRose($items);
        return $gildedRose;
    }

    function daysQualityUpdate($gildedRose, $numberOfDays = 1)
    {
        for ($i = 0; $i < $numberOfDays; $i++){
            $gildedRose->update_quality();
        }
    }

    function testBrie() {
        $items = array(new Item("Aged Brie", 5, 10));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose);
        $this->assertEquals("Aged Brie", $items[0]->name);
        $this->assertEquals("4", $items[0]->sell_in);
        $this->assertEquals("11", $items[0]->quality);
    }

    function testBrieOver5Days()
    {
        $items = array(new Item("Aged Brie", 5, 10));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose, 5);
        $this->assertEquals("0", $items[0]->sell_in);
        $this->assertEquals("15", $items[0]->quality);
    }

    function testLimitOnValueUsingBrie()
    {
        $items = array(new Item("Aged Brie", 30, 10));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose, 500);
        $this->assertEquals("50", $items[0]->quality);
    }

    function testPasses() {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 5, 10));
        $gildedRose = $this->roseGetter($items);
        $gildedRose->update_quality();
        $this->assertEquals("Backstage passes to a TAFKAL80ETC concert", $items[0]->name);
        $this->assertEquals("4", $items[0]->sell_in);
        $this->assertEquals("13", $items[0]->quality);
    }

    function testPassesOver5Days()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 5, 10));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose, 5);
        $this->assertEquals("0", $items[0]->sell_in);
        $this->assertEquals("25", $items[0]->quality);
    }

    function testPassesAfterConcert()
    {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 5, 10));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose, 6);
        $this->assertEquals("0", $items[0]->quality);
    }

    function testLegendarySwordOfSulfuras()
    {
        $items = array(new Item("Sulfuras, Hand of Ragnaros", 20, 80));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose, 6);
        $this->assertEquals("80", $items[0]->quality);
    }

    function testElixirOfTheMongoose()
    {
        $items = array( new Item("Elixir of the Mongoose", 5, 7));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose);
        $this->assertEquals(4, $items[0]->sell_in);
        $this->assertEquals(6, $items[0]->quality);
    }

    function testConjuredManaCake()
    {
        $items = array(new Item("Conjured Mana Cake", 3, 6));
        $gildedRose = $this->roseGetter($items);
        $this->daysQualityUpdate($gildedRose);
        $this->assertEquals(2, $items[0]->sell_in);
        $this->assertEquals(4, $items[0]->quality);
    }
}
