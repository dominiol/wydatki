<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller
{
    /**
     * @Route("/authenticate", name="authenticate")
     */
    public function authenticate(Request $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->get('pin') == '1234') {
                $token = new UsernamePasswordToken('user', null, 'main', ['ROLE_USER']);

                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $event = new InteractiveLoginEvent($request, $token);
                $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

                return $this->redirectToRoute('index');
            }
            else {
                return $this->render('security/authenticate.html.twig', [
                    'error' => true
                ]);
            }
        }

        return $this->render('security/authenticate.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->redirectToRoute('index');
    }
}
