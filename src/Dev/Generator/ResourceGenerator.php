<?php
/*
 * This file is part of the KleijnWeb\SwaggerBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KleijnWeb\SwaggerBundle\Dev\Generator;

use KleijnWeb\SwaggerBundle\Document\SwaggerDocument;
use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class ResourceGenerator extends Generator
{
    /**
     * @param BundleInterface $bundle
     * @param SwaggerDocument $document
     */
    public function generate(BundleInterface $bundle, SwaggerDocument $document)
    {
        $dir = $bundle->getPath();

        $parameters = [
            'namespace'          => $bundle->getNamespace(),
            'bundle'             => $bundle->getName(),
            'resource_namespace' => 'Model\Resources'
        ];

        foreach ($document->getResourceSchemas() as $typeName => $spec) {
            $resourceFile = "$dir/Model/Resources/$typeName.php";
            $this->renderFile(
                'resource.php.twig',
                $resourceFile,
                array_merge($parameters, $spec, ['resource' => $typeName, 'resource_class' => $typeName])
            );
        }
    }
}
