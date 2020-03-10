<?php

namespace App\DataFixtures;

use App\Entity\Transporter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TransporterFixture extends Fixture
{
    public const TRANSPORTERS = [
        'W6' => 'WizzAir',
        'PS' => 'UkraineInternational',
    ];

    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::TRANSPORTERS as $code => $name) {
            $transporter = new Transporter();
            $transporter->setName($name)
                ->setCode($code);
            $this->addReference('transporter_' . ++$i, $transporter);
            $manager->persist($transporter);
        }

        $manager->flush();
    }
}
