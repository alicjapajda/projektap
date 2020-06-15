<?php
/**
 * Catc controller.
 */

namespace App\Controller;

use App\Entity\Catc;
use App\Form\CatcType;
use App\Repository\CatcRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CatcController.
 *
 * @Route("/catc")
 */
class CatcController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\CatcRepository            $catcRepository Catc repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="catc_index",
     * )
     */
    public function index(Request $request, CatcRepository $catcRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $catcRepository->queryAll(),
            $request->query->getInt('page', 1),
            CatcRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'catc/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Catc $catc Catc entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="catc_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Catc $catc): Response
    {
        return $this->render(
            'catc/show.html.twig',
            ['catc' => $catc]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\CatcRepository            $catcRepository Catc repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="catc_create",
     * )
     */
    public function create(Request $request, CatcRepository $catcRepository): Response
    {
        $catc = new Catc();
        $form = $this->createForm(CatcType::class, $catc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catc->setCreatedAt(new \DateTime());
            $catc->setUpdatedAt(new \DateTime());
            $catcRepository->save($catc);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('catc_index');
        }

        return $this->render(
            'catc/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Entity\Catc                          $catc           Catc entity
     * @param \App\Repository\CatcRepository            $catcRepository Catc repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="catc_edit",
     * )
     */
    public function edit(Request $request, Catc $catc, CatcRepository $catcRepository): Response
    {
        $form = $this->createForm(CatcType::class, $catc, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catc->setUpdatedAt(new \DateTime());
            $catcRepository->save($catc);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('catc_index');
        }

        return $this->render(
            'catc/edit.html.twig',
            [
                'form' => $form->createView(),
                'catc' => $catc,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Entity\Catc                          $catc           Catc entity
     * @param \App\Repository\CatcRepository            $catcRepository Catc repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="catc_delete",
     * )
     */
    public function delete(Request $request, Catc $catc, CatcRepository $catcRepository): Response
    {
        $form = $this->createForm(CatcType::class, $catc, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $catcRepository->delete($catc);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('catc_index');
        }

        return $this->render(
            'catc/delete.html.twig',
            [
                'form' => $form->createView(),
                'catc' => $catc,
            ]
        );
    }
}
