<?php

namespace SondeBundle\Controller;

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
        }

        return $this->render('@Sonde/Default/details.html.twig', [
            'company_name' => $this->getParameter('company_name'),
            'sonda' => $sonda,
            'sonde' => $sonde,
            'form' => $form->createView(),
            'details' => $details
        ]);
    }
}
