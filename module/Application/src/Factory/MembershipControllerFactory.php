<?php
namespace Application\Factory;

use Application\Controller\MembershipController;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Form\ResetForm;
use Application\Form\ResetPasswordForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\LoginAuthenticator;
use Application\Model\Emailer;

class MembershipControllerFactory implements FactoryInterface {
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return MembershipController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $loginForm = $formManager->get(LoginForm::class);
        $registerForm = $formManager->get(RegisterForm::class);
        $resetForm = $formManager->get(ResetForm::class);
        $resetPasswordForm = $formManager->get(ResetPasswordForm::class);
        $authenticator = $container->get(LoginAuthenticator::class);
        $authStorage = $container->get(SessionStorageFactory::class);
        $emailer = $container->get(Emailer::class);
        return new MembershipController(
            $loginForm,
            $registerForm,
            $resetForm,
            $resetPasswordForm,
            $authenticator,
            $authStorage,
            $emailer
        );
    }
}
