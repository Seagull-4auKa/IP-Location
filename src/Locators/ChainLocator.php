<?php

declare(strict_types=1);

namespace Seagull4auka\IPLocation\Locators;

use Seagull4auka\IPLocation\Ip;
use Seagull4auka\IPLocation\Location\Location;
use Seagull4auka\IPLocation\Locator;

class ChainLocator implements Locator
{
    /**
     * @var Locator[]
     */
    private array $locators;

    public function __construct(Locator ...$locators)
    {
        $this->locators = $locators;
    }

    public function locate(Ip $ip): ?Location
    {
        $result = null;
        foreach ($this->locators as $locator) {
            $location = $locator->locate($ip);
            if ($location === null) {
                continue;
            }
            if ($location->getCity() !== null) {
                return $location;
            }
            if ($result === null && $location->getRegion() !== null) {
                $result = $location;
                continue;
            }
            if ($result === null || $result->getRegion() === null) {
                $result = $location;
            }
        }
        return $result;
    }
}
