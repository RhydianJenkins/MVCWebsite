<?php
namespace Application\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Model\MembershipApplicationManager;

class MembershipApplicationManagerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new MembershipApplicationManager();
    }
}