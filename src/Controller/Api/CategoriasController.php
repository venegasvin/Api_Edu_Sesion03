<?php

namespace App\Controller\Api;

use App\Entity\Categorias;
use App\Repository\CategoriasRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class CategoriasController extends AbstractFOSRestController
{
    private $catRepository;
    private $em;

    public function __construct(CategoriasRepository $categoriasRepository, EntityManagerInterface $em){
        $this->catRepository = $categoriasRepository;
        $this->em = $em;
    }

    /**
     * @Rest\Get(path="/categorias")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks=true)
     * @return void
     */
    public function getListCategorias(){
        $categorias = $this->catRepository->findAll();
        return $categorias;
    }

    /**
     * @Rest\Post("/add_categoria")
     * @Rest\View(serializerGroups={"categoria"}, serializerEnableMaxDepthChecks=true)
     * @return Categorias
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createCategoria(Request $request ){
        $categoria = new Categorias();
        $categoria->setCategoria($request->get('categoria'));
        $this->em->persist($categoria);
        $this->em->flush();
        return $categoria;
    }
}