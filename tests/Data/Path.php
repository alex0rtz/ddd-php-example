<?php


namespace Auth\Tests\Data;


use Auth\Tests\Data\Assets;
use Faker\Factory;

class Path
{
    private static $data;

    public static function getData($provider = false): array
    {
        if (empty(self::$data)) {
            self::fillData($provider);
        }

        return self::$data;
    }

    private function fillData($provider): void
    {
        self::$data = [];

        for ($i = 0; $i < Assets::ITEMS_BY_TABLE; $i++) {
            $item = $provider ? [self::builder()] : self::builder();

            array_push(self::$data, $item);
        }
    }


    private function builder()
    {
        $faker = Factory::create();

        return (object)[
            'uuid' => $faker->uuid,
            'uri' => $faker->url
        ];
    }

}