<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/25/20
 * Time: 3:48 PM
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 * @package App\Services
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ValidatorService
{
    protected $validator;
    
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($object)
    {
        $violation = $this->validator->validate($object);

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        return null;
    }
}