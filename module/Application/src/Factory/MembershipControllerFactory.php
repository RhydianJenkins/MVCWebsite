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
        $siteKey = $container->get('config')['keystore']['api']['reCaptchaSite'];
        $secretKey = $container->get('config')['keystore']['api']['reCaptchaSecret'];
        $loginForm = $formManager->get(LoginForm::class, ['site_key' => $siteKey, 'secret_key' => $secretKey]);
        $registerForm = $formManager->get(RegisterForm::class, ['site_key' => $siteKey, 'secret_key' => $secretKey]);
        $resetForm = $formManager->get(ResetForm::class, ['site_key' => $siteKey, 'secret_key' => $secretKey]);
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
