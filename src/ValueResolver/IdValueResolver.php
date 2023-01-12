<?php

namespace App\ValueResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class IdValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        //return $argument->getType() === 'string';
        return true;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        return [$request->attributes->get($argument->getName())];
    }
}
