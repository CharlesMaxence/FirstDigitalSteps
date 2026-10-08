<?php

namespace App\Tests\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class QuestionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    /** @var EntityRepository<Question> $questionRepository */
    private EntityRepository $questionRepository;
    private string $path = '/question/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->questionRepository = $this->manager->getRepository(Question::class);

        foreach ($this->questionRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Question index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'question[Text]' => 'Testing',
            'question[explication]' => 'Testing',
            'question[statistic]' => 'Testing',
        ]);

        self::assertResponseRedirects('/question');

        self::assertSame(1, $this->questionRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Question();
        $fixture->setText('My Title');
        $fixture->setExplication('My Title');
        $fixture->setStatistic('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Question');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Question();
        $fixture->setText('Value');
        $fixture->setExplication('Value');
        $fixture->setStatistic('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'question[Text]' => 'Something New',
            'question[explication]' => 'Something New',
            'question[statistic]' => 'Something New',
        ]);

        self::assertResponseRedirects('/question');

        $fixture = $this->questionRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getText());
        self::assertSame('Something New', $fixture[0]->getExplication());
        self::assertSame('Something New', $fixture[0]->getStatistic());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Question();
        $fixture->setText('Value');
        $fixture->setExplication('Value');
        $fixture->setStatistic('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/question');
        self::assertSame(0, $this->questionRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
