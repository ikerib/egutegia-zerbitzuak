<?php

namespace AppBundle\Command;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Firma;
use AppBundle\Entity\Firmadet;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Sinatzaileakdet;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EskaeraCompletedCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:eskaera_completed')
            ->setDescription('begiratu firma denak dituen, baldin baditu, markatu eskaera amaitua bezala');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $jakinarazpenak = $em->getRepository('AppBundle:Notification')->findBy(
            array(
                'completed'=>0,
            )
        );

        /** @var Notification $jakinarazpena */
        foreach ($jakinarazpenak as $jakinarazpena) {
            // Firma ez badu zehaztua, bideratu gabe dago, beraz salto
            if (!$jakinarazpena->getFirma()) {
                continue;
            }
            $output->writeln($jakinarazpena->getId());
            /** @var Firma $firma */
            $firma = $jakinarazpena->getFirma();
            $erab = $jakinarazpena->getUser();
            if ($firma->getCompleted()) {
                $jakinarazpena->setCompleted(1);
                $em->persist($jakinarazpena);
            }

            $sinatzailea_dago = false;
            /** @var Firmadet $fd */
            foreach ($firma->getFirmadet() as $fd) {
                if ($fd->getFirmatzailea() && $fd->getFirmatzailea()->getId() === $erab->getId()) {
                    $sinatzailea_dago = true;
                    break;
                }
            }
            $jakinarazpena->setCompleted($sinatzailea_dago);
            $em->persist($jakinarazpena);
        }
        $em->flush();

        $output->writeln('Fin');
    }
}
