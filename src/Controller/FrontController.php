<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EFNCRepository;

use App\Service\MailerService;
use App\Service\EntityDeletionService;

#[Route('/', name: 'app_')]
class FrontController extends AbstractController
{
    private $eFNCRepository;
    private $mailerService;
    private $entityDeletionService;

    public function __construct(
        EFNCRepository $eFNCRepository,
        MailerService $mailerService,

        EntityDeletionService $entityDeletionService
    ) {
        $this->eFNCRepository = $eFNCRepository;
        $this->mailerService = $mailerService;

        $this->entityDeletionService = $entityDeletionService;
    }

    #[Route('/', name: 'base')]
    public function base(): Response
    {
        if (count($this->eFNCRepository->getMonthOldLowLevelRiskEfnc()) > 0) {
            $this->mailerService->sendReminderEmailToAdmin();
        }
        return $this->render('base.html.twig', []);
    }

    #[Route('/form_list', name: 'form_list')]
    public function formList(): Response
    {
        return $this->render('/services/efnc/display/efnc_list.html.twig', []);
    }
    #[Route('/admin/archived_form_list', name: 'archived_form_list')]
    public function archivedFormList(): Response
    {
        return $this->render('/services/efnc/display/archived_efnc_list.html.twig', []);
    }
    #[Route('/admin/closed_form_list', name: 'closed_form_list')]
    public function closedFormList(): Response
    {
        return $this->render('/services/efnc/display/closed_efnc_list.html.twig', []);
    }

}
