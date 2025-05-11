<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\EstimateController;
use App\Entity\Estimate;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Тесты контроллера.
 *
 * @coversDefaultClass EstimateController
 * @group EstimateController
 */
class EstimateControllerTest extends WebTestCase
{
    /**
     * Тестовый пользователь.
     *
     * @var User
     */
    private User $user;

    /**
     * Клиент.
     *
     * @var KernelBrowser
     */
    private KernelBrowser $client;

    /**
     * EntityManager.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Инициализация.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $userRepository = $this->entityManager->getRepository(User::class);
        $this->user = $userRepository->findBy(['email' => 'test@example.com'])[0];
    }

    /**
     * Проверка загрузки полей формы оценки.
     */
    public function testEstimateFormFieldsAreVisible(): void
    {
        $this->client->loginUser($this->user);

        $response = $this->client->request('GET', '/dashboard');

        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan(0, $response->filter(
            'form[name=estimate]')->count(),
            'Форма не найдена'
        );
        $this->assertEquals(1, $response->filter(
            'input[name="estimate[email]"]')->count(),
            'Поле email отсутствует'
        );
        $this->assertEquals(1, $response->filter(
            'select[name="estimate[service]"]')->count(),
            'Поле service отсутствует'
        );
        $this->assertEquals(1, $response->filter(
            'input[name="estimate[price]"]')->count(),
            'Поле price отсутствует'
        );
        $this->assertEquals(1, $response->filter(
            'button[type=submit]')->count(),
            'Кнопка submit отсутствует'
        );
    }

    /**
     * Тест успешного сохранения оценки.
     *
     * @covers EstimateController::index
     */
    public function testEstimateCreateSuccess(): void
    {
        $this->client->loginUser($this->user);
        $serviceRepo = $this->entityManager->getRepository(Service::class);
        $services = $serviceRepo->findAll();
        /** @var Service $randomService */
        $randomService = $services[array_rand($services)];
        $randomEmail = uniqid('testuser_') . '@example.com';

        $this->client->request('GET', '/dashboard');
        $this->client->submitForm('Подтвердить', [
            'estimate[email]' => $randomEmail,
            'estimate[service]' => $randomService->getId(),
            'estimate[price]' => $randomService->getPrice()->getAmount(),
        ]);

        $this->assertResponseIsSuccessful();

        $estimateRepo = $this->entityManager->getRepository(Estimate::class);
        /** @var Estimate $estimate */
        $estimate = $estimateRepo->findOneBy(['email' => $randomEmail]);

        $this->assertNotNull($estimate);
        $this->assertEquals($randomService->getId(), $estimate->getService()->getId());
        $this->assertEquals(
            $randomService->getPrice()->getAmount(),
            $estimate->getService()
                ->getPrice()
                ->getAmount()
        );
    }

    /**
     * Тест ошибки, если услуга не выбрана.
     *
     * @covers EstimateController::index
     */
    public function testEstimateServiceNotSelectedException(): void
    {
        $this->client->loginUser($this->user);
        $randomEmail = uniqid('testuser_') . '@example.com';

        $this->client->request('GET', '/dashboard');
        $this->client->submitForm('Подтвердить', [
            'estimate[email]' => $randomEmail,
        ]);

        $this->assertSelectorTextContains('li', 'Выберите услугу');
    }

    /**
     * Тест ошибки, если email не введен.
     *
     * @covers EstimateController::index
     */
    public function testEstimateEmailNotSelectedException(): void
    {
        $this->client->loginUser($this->user);
        $serviceRepo = $this->entityManager->getRepository(Service::class);
        $services = $serviceRepo->findAll();
        /** @var Service $randomService */
        $randomService = $services[array_rand($services)];

        $this->client->request('GET', '/dashboard');
        $this->client->submitForm('Подтвердить', [
            'estimate[service]' => $randomService->getId(),
            'estimate[price]' => $randomService->getPrice()->getAmount(),
        ]);

        $this->assertSelectorTextContains('li', 'Введите корректный email');
    }

    /**
     * Тест ошибки, если введен невалидный email.
     *
     * @covers EstimateController::index
     */
    public function testEstimateEmailNotValidException(): void
    {
        $this->client->loginUser($this->user);
        $serviceRepo = $this->entityManager->getRepository(Service::class);
        $services = $serviceRepo->findAll();
        /** @var Service $randomService */
        $randomService = $services[array_rand($services)];

        $this->client->request('GET', '/dashboard');
        $this->client->submitForm('Подтвердить', [
            'estimate[email]' => 'Df^%33VHH990.;',
            'estimate[service]' => $randomService->getId(),
            'estimate[price]' => $randomService->getPrice()->getAmount(),
        ]);

        $this->assertSelectorTextContains('li', 'Введите корректный email');
    }

    /**
     * Проверка ошибки, если пользователь не авторизован.
     *
     * @covers EstimateController::index
     */
    public function testAccessDeniedForUnauthenticatedUser(): void
    {
        $this->client->request('GET', '/dashboard');

        $this->assertSelectorTextContains(
            '.example-wrapper',
            'У вас нет прав для просмотра этой страницы.'
        );
    }
}