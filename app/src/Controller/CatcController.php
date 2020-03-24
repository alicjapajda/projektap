<?php
/**
 * Catc controller.
 */

namespace App\Controller;

use App\Entity\Catc;
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
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CatcRepository        $cateRepository Cate repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator          Paginator
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
}