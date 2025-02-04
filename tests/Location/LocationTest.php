<?php

declare(strict_types=1);

namespace NuthouseCIS\IPLocation\Tests\Location;

use NuthouseCIS\IPLocation\Location\City;
use NuthouseCIS\IPLocation\Location\Coordinates;
use NuthouseCIS\IPLocation\Location\Country;
use NuthouseCIS\IPLocation\Location\Location;
use NuthouseCIS\IPLocation\Location\Region;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testSuccess(): void
    {
        $location = new Location(
            $country = new Country('RU', null, null, null),
            $region = new Region('Saint-Petersburg', null, null),
            $city = new City('Saint-Petersburg', null),
            $extra = ['extra' => true]
        );

        $this->assertSame($country, $location->getCountry());
        $this->assertSame($region, $location->getRegion());
        $this->assertSame($city, $location->getCity());
        $this->assertSame($extra, $location->getExtra());

        $locationMinimal = new Location($country);
        $this->assertNull($locationMinimal->getRegion());
        $this->assertNull($locationMinimal->getCity());
        $this->assertNull($locationMinimal->getCoordinates());
        $this->assertNull($locationMinimal->getExtra());
    }

    public function testCoordinates(): void
    {
        $location = new Location(
            $country = new Country(null, null, 'Russia', new Coordinates(1, 1)),
            $region = new Region(
                'Saint-Petersburg',
                null,
                new Coordinates(2, 2)
            ),
            $city = new City(
                'Saint-Petersburg',
                $coords = new Coordinates(10, 10)
            )
        );
        $this->assertSame($coords, $location->getCoordinates());

        $location2 = new Location(
            $country = new Country(null, null, 'Russia', new Coordinates(1, 1)),
            $region = new Region(
                'Saint-Petersburg',
                null,
                $coords2 = new Coordinates(10, 10)
            ),
            $city = new City('Saint-Petersburg')
        );
        $this->assertSame($coords2, $location2->getCoordinates());

        $location3 = new Location(
            $country = new Country(
                null,
                null,
                'Russia',
                $coords3 = new Coordinates(10, 10)
            ),
            $region = new Region('Saint-Petersburg'),
            $city = new City('Saint-Petersburg')
        );
        $this->assertSame($coords3, $location3->getCoordinates());
    }
}
