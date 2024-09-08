<?php

namespace App\Traits;

trait Parser
{
    private function parseUsers($users): array
    {
        $arrayCollection = array();

        foreach ($users as $item) {

            $arrayCollection[] = $this->parseUser($item);
        }

        return $arrayCollection;
    }


    private function parseUser($item): array
    {

        return array(
            'id' => $item->getId(),
            'name' => $item->getName(),
            'last_name' => $item->getLastName(),
            'email' => $item->getEmail()
        );
    }


    private function parseSensors($sensors): array
    {
        $arrayCollection = array();

        foreach ($sensors as $item) {

            $arrayCollection[] = $this->parseSensor($item);
        }

        return $arrayCollection;
    }


    private function parseSensor($item): array
    {

        return array(
            'id' => $item->getId(),
            'name' => $item->getName()
        );
    }


    private function parseWines($wines, $withMeasurings = true): array
    {
        $arrayCollection = array();

        foreach ($wines as $item) {

            $arrayCollection[] = $this->parseWine($item, $withMeasurings);
        }

        return $arrayCollection;
    }


    private function parseWine($item, $withMeasurings = true): array
    {
        $wine = array(
            'id' => $item->getId(),
            'name' => $item->getName(),
            'year' => $item->getYear()
        );

        if ($withMeasurings) {

            $wine['measurings'] = $this->parseMeasurings($item->getMeasurings(), false);
        }

        return $wine;
    }


    private function parseMeasurings($measurings, $withWine = true): array
    {
        $arrayCollection = array();

        foreach ($measurings as $item) {

            $arrayCollection[] = $this->parseMeasuring($item, $withWine);
        }

        return $arrayCollection;
    }


    private function parseMeasuring($item, $withWine = true): array
    {
        $measuring = array(
            'id' => $item->getId(),
            'year' => $item->getYear(),
            'type' => $item->getType(),
            'value' => $item->getValue(),
            'sensor' => $item->getSensor() ? $this->parseSensor($item->getSensor()) : null
        );

        if ($withWine) {

            $measuring['wine'] = $item->getWine() ? $this->parseWine($item->getWine(), false) : null;
        }

        return $measuring;
    }
}
