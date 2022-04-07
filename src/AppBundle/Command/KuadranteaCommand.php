<?php

namespace AppBundle\Command;

use AppBundle\Entity\Event;
use AppBundle\Entity\Kuadrantea;
use AppBundle\Entity\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KuadranteaCommand extends ContainerAwareCommand
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:kuadrantea')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        // TRUNCATE
        $classMetaData = $this->em->getClassMetadata('AppBundle:Kuadrantea');
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        }



        $year = date('Y');
        // urteko lehen astea bada, aurreko urtea aukeratu
        $date_now = new DateTime();
        //        $date2    = new DateTime("06/01/".$year);
        $date2    = new DateTime($year.'-01-06');

        if ($date_now <= $date2) {
            --$year;
        }

        /** @var $users  User **/
        $users = $this->em->getRepository('AppBundle:User')->findAll();
        /** @var User $user */
        foreach ($users as $user) {
            $months = ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $i = 0;
            $len = count($months);
            foreach ($months as $month) {
                $k = new Kuadrantea();
                $k->setUser($user);
                $k->setUrtea($year);
                $k->setHilabetea($month);
                $this->em->persist($k);
                if ($i == $len - 1) {
                    $k = new Kuadrantea();
                    $k->setUser($user);
                    $k->setUrtea($year+1);
                    $k->setHilabetea('january');
                    $this->em->persist($k);
                }
                $i++;
                $this->em->persist($k);
            }

            $this->em->flush();


            // get current user all events
            /** @var Event $events */
            $events = $this->em->getRepository('AppBundle:Event')->getUserYearEvents($user->getId(), $year);
            $hilabetea = "";
            $kua = null;
            /** @var Event $event */
            foreach ($events as $event) {

                $kuadranteak = $this->em->getRepository('AppBundle:Kuadrantea')->findByUserYearMonth(
                    $user->getId(),
                    $event->getStartDate()->format('Y'),
                    $event->getStartDate()->format('F')
                );

                if (count($kuadranteak) === 0) {
                    continue;
                }

                $kua = $kuadranteak[0];

                if ($event->getStartDate() == $event->getEndDate()) {
                    $field = "setDay".$event->getStartDate()->format('d');
                    $kua->{$field}($event->getType()->getLabur());

                } else {
                    $begin = new \DateTime($event->getStartDate()->format('Y-m-d'));

                    if ($event->getEndDate() === null) {
                        $end = new \DateTime($event->getStartDate()->format('Y-m-d'));
                    } else {
                        $end = new \DateTime($event->getEndDate()->format('Y-m-d'));
                    }

                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt) {

                        $field = "setDay".$dt->format('d');
                        $kua->{$field}($event->getType()->getLabur());
                    }
                }
                $this->em->persist($kua);
            }
        }
        $this->em->flush();
        $output->writeln('Command result.');
    }
}
