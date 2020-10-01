<?php

namespace App\Infrastructure\Http;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestDtoInterface::class);
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return Generator|iterable<mixed>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $class = $argument->getType();
        $dto = new $class($request);
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsStr = '';
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $errorsStr .= $error->getPropertyPath() . " - " . $error->getMessage() . "\n";
            }
            throw new BadRequestHttpException($errorsStr);
        }
        yield $dto;
    }
}
