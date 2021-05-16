<?php

namespace App\Controller;

use App\Entity\ApiUsers;
use App\Services\XmlGenerator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="list", methods={"GET"})
     */
    public function index(XmlGenerator $xmlGenerator): Response
    {
        $userList = $this->getDoctrine()->getRepository(ApiUsers::class)->findAll();

        if(!$userList) {
            throw $this->createNotFoundException('No apiUsers found in db');
        }

        return $xmlGenerator->generateXml($userList);
    }

    /**
     * Returns only items with that were imported
     * 
     * @Route("/api/create", name="create", methods={"POST"})
     */
    public function create(Request $request, XmlGenerator $xmlGenerator): Response
    {
        $decodedXml = simplexml_load_string($request->getContent());
        
        $importedItems = [];
        foreach($decodedXml as $content) {
            if(empty($content->email)){
                continue;
            }

            $emailAlreadyExists = $this->getDoctrine()->getRepository(ApiUsers::class)
                    ->findOneBy(['email' => $content->email]);
            if($emailAlreadyExists) {
                continue;
            }

            $importedItems[] = $content;

            $newApiUser = new ApiUsers();
            $newApiUser->setName($content->name)
                ->setPassword($content->password)
                ->setEmail($content->email)
                ->setCity($content->city)
            ;

            $this->getDoctrine()->getManager()->persist($newApiUser);
        }

        $this->getDoctrine()->getManager()->flush();

        return $xmlGenerator->generateXml($importedItems);
    }

    /**
     * Returns only items with that were updated
     * 
     * @Route("/api/update", name="update", methods={"PUT"})
     */
    public function update(Request $request, XmlGenerator $xmlGenerator): Response
    {
        $decodedXml = simplexml_load_string($request->getContent());
        
        $importedItems = [];
        foreach($decodedXml as $content) {
            if(empty($content->email)){
                continue;
            }

            // Could maybe add and check for ['email' => $content->email]
            $entryFound = $this->getDoctrine()->getRepository(ApiUsers::class)
                    ->findOneBy(['email' => $content->email]);
            if(!$entryFound) {
                continue;
            }

            $importedItems[] = $content;

            $entryFound->setName($content->name)
                ->setPassword($content->password)
                ->setEmail($content->email)
                ->setCity($content->city)
            ;
        }

        $this->getDoctrine()->getManager()->flush();

        return $xmlGenerator->generateXml($importedItems);
    }

    /**
     * Returns only items with that were removed
     * 
     * @Route("/api/delete", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, XmlGenerator $xmlGenerator): Response
    {
        $decodedXml = simplexml_load_string($request->getContent());
        
        $deletedItems = [];
        foreach($decodedXml as $content) {
            if(empty($content->email)){
                continue;
            }

            $entryFound = $this->getDoctrine()->getRepository(ApiUsers::class)
                    ->findOneBy(['email' => $content->email]);
            if(!$entryFound) {
                continue;
            }

            $deletedItems[] = $content;

            $this->getDoctrine()->getManager()->remove($entryFound);
        }

        $this->getDoctrine()->getManager()->flush();

        return $xmlGenerator->generateXml($deletedItems);
    }
}
