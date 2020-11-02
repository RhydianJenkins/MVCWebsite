<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Controller\JoinUsController;
use Application\Model\Emailer;
use Application\Model\MembershipApplicationManager;
use Application\Form\MembershipForm;
use Application\Form\GroupMembershipForm;

class JoinUsControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $siteKey = $container->get('config')['keystore']['api']['reCaptchaSite'];
        $secretKey = $container->get('config')['keystore']['api']['reCaptchaSecret'];
        $emailer = $container->get(Emailer::class);
        $manager = $container->get(MembershipApplicationManager::class);
        $membershipForm = $formManager->get(MembershipForm::class, ['site_key' => $siteKey, 'secret_key' => $secretKey]);
        $groupMembershipForm = $formManager->get(GroupMembershipForm::class, ['site_key' => $siteKey, 'secret_key' => $secretKey]);
        return new JoinUsController($emailer, $manager, $membershipForm, $groupMembershipForm);
    }
}