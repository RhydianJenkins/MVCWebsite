<?php
namespace Application\Factory;

use Application\Controller\MembershipController;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\LoginAuthenticator;

class MembershipControllerFactory implements FactoryInterface {
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return MembershipController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $authStorage = $container->get(SessionStorageFactory::class);
        $loginForm = $formManager->get(LoginForm::class);
        $registerForm = $formManager->get(RegisterForm::class);
        return new MembershipController(
            $loginForm,
            $registerForm,
            $container->get(LoginAuthenticator::class),
            $authStorage
        );
    }
}
