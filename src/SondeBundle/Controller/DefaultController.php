<?php

namespace SondeBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use SondeBundle\Entity\Sonde;
use SondeBundle\Entity\SondeDetails;
use SondeBundle\Entity\SondeRpmHistory;
use SondeBundle\Form\SondeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /** @var ContainerInterface $container */
    protected $container;

    /** @var Request $request */
    protected $request;

    /**
     * MetaController constructor.
     *
     * @param ContainerInterface $container
     * @param RequestStack $requestStack
     */
    public function __construct(
        ContainerInterface $container,
        RequestStack $requestStack
    ) {
        $this->container = $container;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->get('doctrine')->getManager('default');
        $sonde = $em->getRepository(Sonde::class)->getSonde();

        return $this->render('@Sonde/Default/index.html.twig', [
            'company_name' => $this->getParameter('company_name'),
            'sonde' => $sonde
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getSondeBySectorAction()
    {
        $sector = $this->request->get('sector');

        $em = $this->get('doctrine')->getManager('default');
        $sonde = $em->getRepository(Sonde::class)->getSondeBySector($sector);

        return new JsonResponse(['sonde' => $sonde]);
    }

    /**
     * @param $sondaId
     *
     * @return Response
     */
    public function sondeDetailsAction($sondaId)
    {
        $em = $this->get('doctrine')->getManager('default');
        $sondaRepository = $em->getRepository(Sonde::class);
        $sondaDetailsRepository = $em->getRepository(SondeDetails::class);

        /** @var Sonde $sonda */
        $sonda = $sondaRepository->find($sondaId);

        $details = $sondaDetailsRepository->getDetailsBySondaId($sonda->getId());

        $sector = $sonda->getSector();
        $sonde = $sondaRepository->getSondeBySector($sector);

        $form = $this->createForm(SondeType::class, $sonda);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedSonda = $form->getData();
            $newRpm = (int)$submittedSonda->getRpm();
            $sonda->setRpm($newRpm);

            $em->persist($sonda);
            $em->flush();

            $sondeRpmHistory = new SondeRpmHistory();
            $sondeRpmHistory->setIdSonda($sondaId);
            $sondeRpmHistory->setRpm($submittedSonda->getRpm());
            $sondeRpmHistory->setCreatedAt(new \DateTime());

            $em->persist($sondeRpmHistory);
            $em->flush();

            $this->request->getSession()->getFlashBag()->add('success', "RPM salvat corect");
        }

        return $this->render('@Sonde/Default/details.html.twig', [
            'company_name' => $this->getParameter('company_name'),
            'sonda' => $sonda,
            'sonde' => $sonde,
            'form' => $form->createView(),
            'details' => $details
        ]);
    }

    /**
     * @param $sondaId
     *
     * @return Response
     */
    public function sondeChartsAction($sondaId)
    {
        $newChartData = [];
        $yAxis = [];
        $minYaxis = 0;
        $maxYaxis = 0;
        
        $dataType = $this->request->get('type');

        if (is_null($dataType)) {
            $dataType = SondeDetails::SONDA_RPM;
        }

        if (!in_array($dataType, SondeDetails::$sondaDetails)) {
            $dataType = SondeDetails::SONDA_RPM;
        }

        list(
            $title,
            $chartData
            ) = $this->getChartDataByType($dataType, $sondaId);

        foreach ($chartData as $data) {
            $newChartData[] = [$data[0], $data[1]];
        }

        return $this->render('@Sonde/Default/charts.html.twig', [
            'chart_data' => json_encode($newChartData),
            'company_name' => $this->getParameter('company_name'),
            'sondaId' => $sondaId,
            'data_type' => $dataType,
            'title' => $title
        ]);
    }

    /**
     * @param $type
     * @param $sondaId
     *
     * @return null
     */
    protected function getChartDataByType($type, $sondaId)
    {
        switch($type) {
            case SondeDetails::SONDA_RPM:
                $title = "RPM";
                $data = $this->getRpmDetails($sondaId);
                break;
            case SondeDetails::SONDA_CURENT_MOTOR:
                $title = "Curent motor";
                $data = $this->getSondaDetails($sondaId, "getCurentMotor");
                break;
            case SondeDetails::SONDA_PUTERE_MOTOR:
                $title = "Putere motor";
                $data = $this->getSondaDetails($sondaId, "getPutereMotor");
                break;
            case SondeDetails::SONDA_TENSIUNE_MOTOR:
                $title = "Tensiune motor";
                $data = $this->getSondaDetails($sondaId, "getTensiuneMotor");
                break;
            case SondeDetails::SONDA_RAPORT_REDUCTOR:
                $title = "Raport reductor";
                $data = $this->getSondaDetails($sondaId, "getRaportReductor");
                break;
            case SondeDetails::SONDA_FULIE_MOTOR:
                $title = "Fulie motor";
                $data = $this->getSondaDetails($sondaId, "getFulieMotor");
                break;
            case SondeDetails::SONDA_FULIE_REDUCTOR:
                $title = "Fulie reductor";
                $data = $this->getSondaDetails($sondaId, "getFulieReductor");
                break;
            case SondeDetails::SONDA_DEBIT:
                $title = "Debit";
                $data = [[0,0]];
                break;
            default:
                $title = "";
                $data = [[0,0]];
                break;
        }

        return [$title, $data];
    }

    /**
     * @param $sondaId
     *
     * @return array
     */
    private function getRpmDetails($sondaId)
    {
        $chartData = [];
        $em = $this->get('doctrine')->getManager('default');
        $sondaRepository = $em->getRepository(SondeRpmHistory::class);
        $sondaDetails = $sondaRepository->findBy(
            ['idSonda' => $sondaId],
            ['createdAt' => 'ASC']
        );

        if (is_array($sondaDetails)) {
            /** @var SondeRpmHistory $sondaDetail */
            foreach ($sondaDetails as $sondaDetail) {
                $chartData[] = [
                    $sondaDetail->getCreatedAt()->format("Y-m-d H:i"),
                    $sondaDetail->getRpm(),
                ];
            }
        }

        return $chartData;

    }

    /**
     * @param $sondaId
     * @param $method
     *
     * @return array
     */
    private function getSondaDetails($sondaId, $method)
    {
        $chartData = [];
        $em = $this->get('doctrine')->getManager('default');
        $sondaRepository = $em->getRepository(SondeDetails::class);
        $sondaDetails = $sondaRepository->findBy(
            ['idSonda' => $sondaId],
            ['createdAt' => 'ASC']
        );

        if (is_array($sondaDetails)) {
            /** @var SondeDetails $sondaDetail */
            foreach ($sondaDetails as $sondaDetail) {
                $chartData[] = [
                    $sondaDetail->getCreatedAt()->format("Y-m-d H:i"),
                    call_user_func_array([$sondaDetail, $method], []),
                ];
            }
        }

        return $chartData;
    }

    public function sondeDebitAction($sondaId)
    {

    }
}
