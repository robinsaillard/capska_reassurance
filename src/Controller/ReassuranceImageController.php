<?php

namespace FOP\Doctrine\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use FOP\Doctrine\Form\DemoFormType;

final class FormController extends FrameworkBundleAdminController
{
    /**
     * @Route("/reassurance-image", methods={"GET", "POST"}, name="reassurance_image_form", defaults={
     *     "_legacy_controller": "AdminReassuranceImage",
     *     "_legacy_link": "AdminReassuranceImage"
     *     })
     */
    public function renderForm(Request $request)
    {
        $demoForm = $this->createForm(ReassuranceImageType::class);

        if ($request->isMethod('POST')) {
            $demoForm->handleRequest($request);

            if ($demoForm->isSubmitted() && $demoForm->isValid()) {
                /** @var EntityManagerInterface $manager */
                $manager = $this->getDoctrine()->getManager();

                $manager->persist($demoForm->getData());
                $manager->flush();

                return $this->redirectToRoute('reassurance_image_form');
            }
        }

        return $this->render('@Modules/capska_reassurance/src/View/upload_image.html.twig', [
            'layoutTitle' => 'Controller exemple (Form)',
            'demoForm' => $demoForm->createView(),
        ]);
    }
}