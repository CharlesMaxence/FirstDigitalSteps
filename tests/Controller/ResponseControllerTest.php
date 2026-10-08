<?php

namespace App\Tests\Controller;

use App\Entity\Response;
use App\Repository\ResponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ResponseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    /** @var EntityRepository<Response> $responseRepository */
    private EntityRepository $responseRepository;
    private string $path = '/response/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->responseRepository = $this->manager->getRepository(Response::class);

        foreach ($this->responseRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Response index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'response[text]' => 'Testing',
            'response[isRight]' => 'Testing',
            'response[question]' => 'Testing',
        ]);

        self::assertResponseRedirects('/response');

        self::assertSame(1, $this->responseRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Response();
        $fixture->setText('My Title');
        $fixture->setIsRight('My Title');
        $fixture->setQuestion('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Response');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Response();
        $fixture->setText('Value');
        $fixture->setIsRight('Value');
        $fixture->setQuestion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'response[text]' => 'Something New',
            'response[isRight]' => 'Something New',
            'response[question]' => 'Something New',
        ]);

        self::assertResponseRedirects('/response');

        $fixture = $this->responseRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getText());
        self::assertSame('Something New', $fixture[0]->getIsRight());
        self::assertSame('Something New', $fixture[0]->getQuestion());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Response();
        $fixture->setText('Value');
        $fixture->setIsRight('Value');
        $fixture->setQuestion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/response');
        self::assertSame(0, $this->responseRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
