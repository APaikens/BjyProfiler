<?php
/**
 * Created by Inditel Meedia OÜ
 * User: Oliver Leisalu
 */

namespace BjyProfiler\Db\Adapter;


use BjyProfiler\Db\Profiler\Profiler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Interop\Container\ContainerInterface;

class ProfilingAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return $this->__invoke($serviceLocator,null);
    }
    
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('config');
        $dbParams = $config['db'];
        $adapter = new ProfilingAdapter($dbParams);

        $adapter->setProfiler(new Profiler);
        if (isset($dbParams['options']) && is_array($dbParams['options'])) {
            $options = $dbParams['options'];
        } else {
            $options = array();
        }
        $adapter->injectProfilingStatementPrototype($options);
        return $adapter;
    }
  
}
