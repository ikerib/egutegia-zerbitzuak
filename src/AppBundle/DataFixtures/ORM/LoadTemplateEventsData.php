<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\TemplateEvent;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTemplateEventsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $te1 = new TemplateEvent();
        $te1->setName('Errege Eguna');
        $te1->setStartDate(new \DateTime('2017-01-06'));
        $te1->setEndDate(new \DateTime('2017-01-06'));
        $te1->setType($this->getReference('type-oporrak'));
        $te1->setTemplate($this->getReference('template'));
        $manager->persist($te1);

        $te2 = new TemplateEvent();
        $te2->setName('Aste Santua');
        $te2->setStartDate(new \DateTime('2017-04-13'));
        $te2->setEndDate(new \DateTime('2017-04-17'));
        $te2->setType($this->getReference('type-oporrak'));
        $te2->setTemplate($this->getReference('template'));
        $manager->persist($te2);

        $te3 = new TemplateEvent();
        $te3->setName('Langileen Eguna');
        $te3->setStartDate(new \DateTime('2017-05-01'));
        $te3->setEndDate(new \DateTime('2017-05-01'));
        $te3->setType($this->getReference('type-oporrak'));
        $te3->setTemplate($this->getReference('template'));
        $manager->persist($te3);

        $te4 = new TemplateEvent();
        $te4->setName('Santiago');
        $te4->setStartDate(new \DateTime('2017-07-24'));
        $te4->setEndDate(new \DateTime('2017-07-25'));
        $te4->setType($this->getReference('type-oporrak'));
        $te4->setTemplate($this->getReference('template'));
        $manager->persist($te4);

        $te5 = new TemplateEvent();
        $te5->setName('San Ignazio');
        $te5->setStartDate(new \DateTime('2017-07-31'));
        $te5->setEndDate(new \DateTime('2017-07-31'));
        $te5->setType($this->getReference('type-oporrak'));
        $te5->setTemplate($this->getReference('template'));
        $manager->persist($te5);

        $te6 = new TemplateEvent();
        $te6->setName('Ama birjina');
        $te6->setStartDate(new \DateTime('2017-08-14'));
        $te6->setEndDate(new \DateTime('2017-08-15'));
        $te6->setType($this->getReference('type-oporrak'));
        $te6->setTemplate($this->getReference('template'));
        $manager->persist($te6);

        $te7 = new TemplateEvent();
        $te7->setName('Hispanidad');
        $te7->setStartDate(new \DateTime('2017-10-12'));
        $te7->setEndDate(new \DateTime('2017-10-13'));
        $te7->setType($this->getReference('type-oporrak'));
        $te7->setTemplate($this->getReference('template'));
        $manager->persist($te7);

        $te8 = new TemplateEvent();
        $te8->setName('Santu guztien eguna');
        $te8->setStartDate(new \DateTime('2017-11-01'));
        $te8->setEndDate(new \DateTime('2017-11-01'));
        $te8->setType($this->getReference('type-oporrak'));
        $te8->setTemplate($this->getReference('template'));
        $manager->persist($te8);

        $te9 = new TemplateEvent();
        $te9->setName('Konstituzioaren zubia');
        $te9->setStartDate(new \DateTime('2017-12-06'));
        $te9->setEndDate(new \DateTime('2017-12-08'));
        $te9->setType($this->getReference('type-oporrak'));
        $te9->setTemplate($this->getReference('template'));
        $manager->persist($te9);

        $te10 = new TemplateEvent();
        $te10->setName('Olentzero');
        $te10->setStartDate(new \DateTime('2017-12-25'));
        $te10->setEndDate(new \DateTime('2017-12-25'));
        $te10->setType($this->getReference('type-oporrak'));
        $te10->setTemplate($this->getReference('template'));
        $manager->persist($te10);

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
