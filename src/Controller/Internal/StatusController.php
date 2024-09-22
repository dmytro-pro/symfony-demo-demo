<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Internal;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/internal/status', name: 'app_status')]
    public function index(): Response
    {
        try {
            // Perform a simple SQL query to check the DB connection
            $this->entityManager->getConnection()->executeQuery('SELECT 1');
            $dbStatus = 'ok';
        } catch (\Exception $e) {
            $dbStatus = 'error: ' . $e->getMessage();
        }

        // You can add more checks here as needed
        return new JsonResponse([
            'database' => $dbStatus,
            'status' => 'ok',
        ]);
    }
}
