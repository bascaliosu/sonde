<?php

namespace SondeBundle\Command;

use Doctrine\ORM\Mapping\Entity;
use SondeBundle\Entity\Sonde;
use SondeBundle\Entity\SondeDetails;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class PopulateSondeDetailsCommand
 * @package SondeBundle\Command
 */
class PopulateSondeDetailsCommand extends ContainerAwareCommand
{
    /**
     * @var null | Entity
     */
    private $em = null;

    /**
     * The default name of the command
     */
    protected function configure()
    {
        $this->setName('sonde:add-details');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager('default');

        $sonde = $this
            ->em
            ->getRepository(Sonde::class)
            ->findAll();

        /** @var Sonde $sonda */
        foreach ($sonde as $sonda) {
            $idSonda = $sonda->getId();
            for ($i = 0; $i < 5;$i++) {
                $sondeDetails = new SondeDetails();
                $sondeDetails->setIdSonda($idSonda);
                $sondeDetails->setCurentMotor(rand(100, 400));
                $sondeDetails->setPutereMotor(rand(200, 300));
                $sondeDetails->setTensiuneMotor(rand(100, 300));
                $sondeDetails->setRaportReductor(rand(0, 100));
                $sondeDetails->setFulieMotor(rand(50, 100));
                $sondeDetails->setFulieReductor(rand(50, 100));
                $sondeDetails->setCreatedAt(new \DateTime());

                $this->em->persist($sondeDetails);
                $this->em->flush();

                $output->writeln("New details added for id " . $idSonda);
                sleep(3);
            }
        }
    }
}
