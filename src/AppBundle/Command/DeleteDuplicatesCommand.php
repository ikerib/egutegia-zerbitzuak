<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteDuplicatesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName( 'app:delete_duplicates' )
            ->setDescription( 'Jakinazpen bikoiztuak ezabatu' );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        /** @var EntityManager $em */
        $em   = $this->getContainer()->get( 'doctrine' )->getManager();
        $conn = $em->getConnection();

        $sql  = "DELETE t1 FROM notification t1
                INNER JOIN notification t2
                WHERE t1.id > t2.id
                and t1.description = t2.description
                and t1.eskaera_id = t2.eskaera_id
                and t1.firma_id=t2.firma_id
                and t1.name = t2.name
                and t1.user_id = t2.user_id;";
        $stmt = $conn->prepare( $sql );
        $stmt->execute();
        $output->writeln( 'Fin' );
    }
}
