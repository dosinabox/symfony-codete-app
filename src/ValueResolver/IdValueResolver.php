<?php

namespace App\ValueResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

class IdValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $types = explode('|', $argument->getType());
        foreach ($types as $type) {
            if($request->attributes->has('id')) {
                return $type === Uuid::class || $type === 'int';
            }
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $id = $request->attributes->get('id');
        if(Uuid::isValid($id)) {
            yield Uuid::fromString($request->attributes->get('id'));
        } elseif(is_numeric($id)) {
            yield (int)$id;
        } else {
            throw new BadRequestHttpException('Argument type is invalid!');
        }
    }
}
