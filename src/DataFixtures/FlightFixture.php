<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class FlightFixture extends Fixture implements DependentFixtureInterface
{
    protected const AIRPORT_CODES = ['BWS', 'FAK', 'WKK', 'TSS', 'FOB', 'KBP', 'DUB',];
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 20; $i++) {
            $departureDateTime = $this->faker->dateTimeBetween('+2 days', '+3 days');
            $arrivalDateTime = clone $departureDateTime;
            $arrivalDateTime =  $arrivalDateTime->add(new DateInterval('PT' . mt_rand(2, 12) . 'H'));

        $flight = new Flight();

        $flight->setDepartureAirport($this->faker->randomElement(self::AIRPORT_CODES))
            ->setArrivalAirport($this->faker->randomElement(self::AIRPORT_CODES))
            ->setDepartureDateTime($departureDateTime)
            ->setArrivalDateTime($arrivalDateTime)
            ->setTransporter($this->getReference('transporter_' . mt_rand(1, 2)))
            ->setFlightNumber($this->getFlightNumber())
            ->setDuration(($arrivalDateTime->getTimestamp() - $departureDateTime->getTimestamp()) / 60);

            $manager->persist($flight);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TransporterFixture::class,
        ];
    }

    protected function getFlightNumber()
    {
        return (strtoupper(substr($this->faker->words(1, true), 0, 4) . $this->faker->numberBetween(10000, 99999)));
    }
}
