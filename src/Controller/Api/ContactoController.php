<?php

namespace App\Controller\Api; 

use App\Repository\ContactoRepository;
use App\Form\Type\TaskType;
use App\Entity\Contacto;
use App\Form\Type\ContactoFormType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request; 
use Doctrine\ORM\EntityManagerInterface;

class ContactoController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/api/contactos")
     * @Rest\View(serializerGroups={"contacto"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(ContactoRepository $contactoRepository){
      return $contactoRepository-> findAll();
   }

   /**
     * @Rest\Post(path="/api/contactos")
     * @Rest\View(serializerGroups={"contacto"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(EntityManagerInterface $en, Request $request){
      $contacto = new Contacto();
      $form = $this->createForm(ContactoFormType::class, $contacto);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
         $en->persist($contacto);
         $en->flush();
         return $contacto;
      }
      return $form;
   }

   /**
     * @Rest\Delete(path="/api/contactos/{id}")
     * @Rest\View(serializerGroups={"noticia"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteActions($id,EntityManagerInterface $en, ContactoRepository $contactoRepository){
      $exists = 'no';
      if($contact = $contactoRepository->find($id)) {
         $existe = 'yes';
         $en->remove($contact);
         $en->flush();
       }
      return $contact;
   }
}