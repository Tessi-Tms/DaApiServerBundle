<?php

/**
 * This file is part of the Da Project.
 *
 * (c) Thomas Prelot <tprelot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Da\ApiServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Da\ApiServerBundle\DependencyInjection\Security\Factory\ApiFactory;
use Da\ApiServerBundle\DependencyInjection\Security\Factory\OAuthFactory;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Da\ApiServerBundle\DependencyInjection\Compiler\InjectSecurityFirewallParametersCompilerPass;

class DaApiServerBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new InjectSecurityFirewallParametersCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);

        if (version_compare(Kernel::VERSION, '2.1', '>=')) {
            $extension = $container->getExtension('security');
            $extension->addSecurityListenerFactory(new ApiFactory());
            $extension->addSecurityListenerFactory(new OAuthFactory());
        }
    }
}
