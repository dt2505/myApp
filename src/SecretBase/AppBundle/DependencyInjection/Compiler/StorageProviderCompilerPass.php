<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class StorageProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('storage.manager')) {
            return;
        }

        $definition = $container->getDefinition('storage.manager');
        $taggedServices = $container->findTaggedServiceIds('storage');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addStorage',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
}
 