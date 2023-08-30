<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Register;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ConfirmAccountControllerTest extends AbstractWebTestCase
{
    public function testConfirmAccount(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register/confirmAccountToken/confirm-account');

        $this->assertResponseStatusCodeSame(302);
        $crawler = $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('app_login');
        $this->assertSame('Votre compte a bien été vérifié, vous pouvez maintenant vous connecter.', $crawler->filter('div.alert--success')->text());
    }

    public function testExpiredToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register/expiredConfirmAccountToken/confirm-account');

        $this->assertResponseStatusCodeSame(400);
    }

    public function testNotFoundToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register/notFoundToken/confirm-account');

        $this->assertResponseStatusCodeSame(404);
    }
}
