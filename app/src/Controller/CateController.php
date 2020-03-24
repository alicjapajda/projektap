<?php
/**
 * Cate controller.
 */

namespace App\Controller;

use App\Entity\Cate;
use App\Form\CateType;
use App\Repository\CateRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CateController.
 *
 * @Route("/cate")
 */
class CateController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\CateRepository $cateRepository Cate repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="cate_index",
     * )
     */
    public function index(Request $request, CateRepository $cateRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $cateRepository->queryAll(),
            $request->query->getInt('page', 1),
            CateRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'cate/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Cate $cate Cate entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="cate_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Cate $cate): Response
    {
        return $this->render(
            'cate/show.html.twig',
            ['cate' => $cate]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\CateRepository $cateRepository Cate repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="cate_create",
     * )
     */
    public function create(Request $request, CateRepository $cateRepository): Response
    {
        $cate = new Cate();
        $form = $this->createForm(CateType::class, $cate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cate->setCreatedAt(new \DateTime());
            $cate->setUpdatedAt(new \DateTime());
            $cateRepository->save($cate);

            $this->addFlash('success', 'message_created_successfully');


            return $this->redirectToRoute('cate_index');
        }

        return $this->render(
            'cate/create.html.twig',
            ['form' => $form->createView()]
        );
    }


    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Cate $cate Cate entity
     * @param \App\Repository\CateRepository $cateRepository Cate repository
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
     *     name="cate_edit",
     * )
     */
    public function edit(Request $request, Cate $cate, CateRepository $cateRepository): Response
    {
        $form = $this->createForm(CateType::class, $cate, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cate->setUpdatedAt(new \DateTime());
            $cateRepository->save($cate);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('cate_index');
        }

        return $this->render(
            'cate/edit.html.twig',
            [
                'form' => $form->createView(),
                'cate' => $cate,
            ]
        );
    }


    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Cate                    $cate           Cate entity
     * @param \App\Repository\CateRepository        $cateRepository Cate repository
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
     *     name="cate_delete",
     * )
     */
    public function delete(Request $request, Cate $cate, CateRepository $cateRepository): Response
    {
        $form = $this->createForm(CateType::class, $cate, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $cateRepository->delete($cate);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('cate_index');
        }

        return $this->render(
            'cate/delete.html.twig',
            [
                'form' => $form->createView(),
                'cate' => $cate,
            ]
        );
    }

}