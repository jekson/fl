<?php
namespace AdminBundle\Controller;

use KPC\SecurityBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logInAsAction($id)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');
        $session = $this->get('session');
        $user = $em->getRepository('AppBundle:User')->find($id);

        //if ($user->getIsActive() && $user->getIsEnabled()) {
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            $this->get("security.token_storage")->setToken($token);

        //}
        return $this->redirect($this->generateUrl('homepage'));
    }
}