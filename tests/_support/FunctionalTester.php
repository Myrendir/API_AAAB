<?php
namespace App\Tests;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */

    /**
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        try {
            $user = $this->grabEntityFromRepository(Users::class, ['summonerName' => $username]);
            $jwtManager = $this->grabService('test.lexik_jwt_authentication.jwt_manager');
            $token = $jwtManager->create($user);
            $this->amBearerAuthenticated($token);
        } catch (\Exception $exception) {
            return new JsonResponse(sprintf('Unable to login as "%s" using password "%s"', $username, $password));
        }
    }

    public function sendPostJson(string $url, array $jsonContent, array $files = [])
    {
        $this->sendPost($url, json_encode($jsonContent), $files);
    }
}
