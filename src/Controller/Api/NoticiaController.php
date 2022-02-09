<?php

namespace App\Controller\Api;

use App\Repository\NoticiaRepository;
use App\Form\Type\TaskType;
use App\Entity\Noticia;
use App\Form\Type\NoticiaFormType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class NoticiaController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/api/noticias")
     * @Rest\View(serializerGroups={"noticia"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(NoticiaRepository $noticiaRepository){
      return $noticiaRepository-> findAll();
   }

   /**
     * @Rest\Post(path="/api/noticias")
     * @Rest\View(serializerGroups={"noticia"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(EntityManagerInterface $en, Request $request){
      $noticia = new Noticia();
      $form = $this->createForm(NoticiaFormType::class, $noticia);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
         $en->persist($noticia);
         $en->flush();
         return $noticia;
      }
      return $form;
   }

   /**
     * @Rest\Delete(path="/api/noticias/{id}")
     * @Rest\View(serializerGroups={"noticia"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteActions($id,EntityManagerInterface $en, NoticiaRepository $noticiaRepository){
      $exists = 'no';
      if($cours = $noticiaRepository->find($id)) {
         $existe = 'yes';
         $en->remove($cours);
         $en->flush();
       }
      return $cours;
   }

}