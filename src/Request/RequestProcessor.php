<?php
/*
 * This file is part of the KleijnWeb\SwaggerBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KleijnWeb\SwaggerBundle\Request;

use Symfony\Component\HttpFoundation\Request;
use KleijnWeb\SwaggerBundle\Exception\InvalidParametersException;
use KleijnWeb\SwaggerBundle\Exception\MalformedContentException;
use KleijnWeb\SwaggerBundle\Exception\UnsupportedContentTypeException;

/**
 * @author John Kleijn <john@kleijnweb.nl>
 */
class RequestProcessor
{
    /**
     * @var RequestValidator
     */
    private $validator;

    /**
     * @var RequestCoercer
     */
    private $coercer;

    /**
     * @param RequestValidator $validator
     * @param RequestCoercer   $coercer
     */
    public function __construct(RequestValidator $validator, RequestCoercer $coercer)
    {
        $this->validator = $validator;
        $this->coercer = $coercer;
    }

    /**
     * @param Request $request
     * @param array   $operationDefinition
     *
     * @throws InvalidParametersException
     * @throws MalformedContentException
     * @throws UnsupportedContentTypeException
     */
    public function process(Request $request, array $operationDefinition)
    {
        $this->coercer->coerceRequest($request, $operationDefinition);
        $this->validator->setOperationDefinition($operationDefinition);
        $this->validator->validateRequest($request);
    }
}
