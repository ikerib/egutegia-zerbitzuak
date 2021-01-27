<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Template;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $template = new Template();
        $template->setName('2017 Orokorra');
        $template->setHoursYear(1590); // lan orduak
        $template->setHoursFree(187.46); // oporrak
        $template->setHoursSelf(43.26); // norberarentzako
        $template->setHoursDay(7.21); // jornada bat zenbat ordu
        $manager->persist($template);
        $manager->flush();

        $this->addReference('template', $template);
    }

    public function getOrder()
    {
        return 2;
    }
}
