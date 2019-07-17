<?php

namespace SondeBundle\Command;

use Doctrine\ORM\Mapping\Entity;
use SondeBundle\Entity\Sonde;
use SondeBundle\Entity\SondeDetails;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this->setName('sonde:add-details')
            ->addOption(
                'repeat',
                'repeat',
                InputOption::VALUE_OPTIONAL,
                "Number of iterations"
            )
            ->addOption(
                'id_sonda',
                'id_sonda',
                InputOption::VALUE_OPTIONAL,
                "Only for this Id will insert details"
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sonde = [];
        $iterations = $input->getOption("repeat");
        $idSonda = $input->getOption("id_sonda");

        if (is_null($iterations)) {
            $iterations = 5;
        }

        $output->writeln("Will execute " . $iterations . " iterations");

        $this->em = $this->getContainer()->get('doctrine')->getManager('default');

        if (is_null($idSonda)) {
            $sonde = $this
                ->em
                ->getRepository(Sonde::class)
                ->findAll();
        } else {
            $oneSonda = $this
                ->em
                ->getRepository(Sonde::class)
                ->find($idSonda);

            if (!is_null($oneSonda)) {
                $sonde[] = $oneSonda;
            }
        }

        /** @var Sonde $sonda */
        foreach ($sonde as $sonda) {
            $idSonda = $sonda->getId();
            for ($i = 0; $i < $iterations;$i++) {
                $sondeDetails = new SondeDetails();
                $sondeDetails->setIdSonda($idSonda);
                $sondeDetails->setCurentMotor(rand(100, 400));
                $sondeDetails->setPutereMotor(rand(200, 300));
                $sondeDetails->setTensiuneMotor(rand(100, 300));
                $sondeDetails->setRaportReductor(rand(0, 100));
                $sondeDetails->setFulieMotor(rand(50, 100));
                $sondeDetails->setFulieReductor(rand(50, 100));

                $hoursSub = rand(60, 14400);
                $date = new \DateTime();
                $date->sub(new \DateInterval('PT' . $hoursSub . 'M'));

                $sondeDetails->setCreatedAt($date);

                $this->em->persist($sondeDetails);
                $this->em->flush();

                $output->writeln("New details added for id " . $idSonda);
            }
        }
    }
}
