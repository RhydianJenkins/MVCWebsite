<?php
namespace Application\Factory;

use Application\Controller\MembershipController;
use Application\Form\LoginForm;
use Application\Model\MemberTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\LoginAuthAdapter;

class MembershipControllerFactory implements FactoryInterface {
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return MembershipController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new MembershipController(
            $container->get(MemberTable::class),
            $formManager->get(LoginForm::class),
            $container->get(LoginAuthAdapter::class)
        );
    }
}
