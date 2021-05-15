<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\ApiUsers;
use SimpleXMLElement;

class XmlGenerator
{
    public function generateXml(array $userList): Response
    {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<api>';

        /** @var ApiUsers $user */
        foreach($userList as $user) {
            if($user instanceof SimpleXMLElement) {
                $xml .= '<content>';
                $xml .= '<id>' . $user->id . '</id>';
                $xml .= '<name>' . $user->name . '</name>';
                $xml .= '<email>' . $user->email . '</email>';
                $xml .= '<password>' . $user->password . '</password>';
                $xml .= '<city>' . $user->city . '</city>';
                $xml .= '</content>';
                continue;
            }
            $xml .= '<content>';
            $xml .= '<id>' . $user->getId() . '</id>';
            $xml .= '<name>' . $user->getName() . '</name>';
            $xml .= '<email>' . $user->getEmail() . '</email>';
            $xml .= '<password>' . $user->getPassword() . '</password>';
            $xml .= '<city>' . $user->getCity() . '</city>';
            $xml .= '</content>';
        }

        $xml .= '</api>';
        
        $response = new Response($xml);
        $response->headers->set('Content-Type', 'xml');

        return $response;
    }
}
