<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    # Controller to import orders from a local file /var/data/orders.json
    public function importOrders(): Response
    {
        $ordersJson = file_get_contents($this->getParameter('kernel.project_dir') . '/var/data/orders.json');
        $ordersData = json_decode($ordersJson, true);
    
        foreach ($ordersData as $orderData) {
            $order = new Order();
            $order->setDate(new \DateTime($orderData['date']));
            $order->setCustomer($orderData['customer']);
            $order->setAddress1($orderData['address1']);
            $order->setCity($orderData['city']);
            $order->setPostcode($orderData['postcode']);
            $order->setCountry($orderData['country']);
            $order->setAmount($orderData['amount']);
            $order->setStatus($orderData['status']);
            $order->setDeleted($orderData['deleted']);
            $order->setLastModified(new \DateTime($orderData['last_modified']));
    
            $this->entityManager->persist($order);
        }
    
        $this->entityManager->flush();
    
        return $this->redirectToRoute('list_orders');
    }

    # Controller to upload orders
    public function uploadOrders(Request $request): JsonResponse
    {
        $file = $request->files->get('file');

        try {
            // Checks that the file content is not empty
            if ($file->getSize() === 0) {
                throw new \InvalidArgumentException('The uploaded file is empty.');
            }

            // Gets the contents of the file as a string
            $fileContent = file_get_contents($file->getPathname());

            // Decodes JSON content
            $ordersData = json_decode($fileContent, true);

            // Checks whether decoding was successful
            if ($ordersData === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('Failed to decode JSON: ' . json_last_error_msg());
            }

            foreach ($ordersData as $orderData) {
                $order = new Order();
                $order->setDate(new \DateTime($orderData['date']));
                $order->setCustomer($orderData['customer']);
                $order->setAddress1($orderData['address1']);
                $order->setCity($orderData['city']);
                $order->setPostcode($orderData['postcode']);
                $order->setCountry($orderData['country']);
                $order->setAmount($orderData['amount']);
                $order->setStatus($orderData['status']);
                $order->setDeleted($orderData['deleted']);
                $order->setLastModified(new \DateTime($orderData['last_modified']));

                $this->entityManager->persist($order);
            }

            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Orders uploaded successfully']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    
    # Controller to list orders
    public function listOrders(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        // Transforms data into an associative array
        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'date' => $order->getDate()->format('Y-m-d H:i:s'),
                'customer' => $order->getCustomer(),
                'address1' => $order->getAddress1(),
                'city' => $order->getCity(),
                'postcode' => $order->getPostcode(),
                'country' => $order->getCountry(),
                'amount' => $order->getAmount(),
                'status' => $order->getStatus(),
                'deleted' => $order->getDeleted(),
                'last_modified' => $order->getLastModified()->format('Y-m-d H:i:s'),
            ];
        }
        // Returns a JSON response
        return $this->json($data);

        // return $this->render('order/list.html.twig', [
        //     'orders' => $orders,
        // ]);
    }

    # Controller to cancel order
    public function cancelOrder(Order $order): Response
    {        
        // Checks if the order status is other than 'cancelled' before canceling
        if ($order->getStatus() !== 'cancelled') {
            $order->setStatus('cancelled');

            $this->entityManager->persist($order);
            $this->entityManager->flush();
        }

        // return $this->redirectToRoute('list_orders');
        return new RedirectResponse($this->generateUrl('list_orders'), RedirectResponse::HTTP_SEE_OTHER);
    }
    
    # Controller to search order
    public function searchOrders(Request $request, OrderRepository $orderRepository): Response
    {
        $customer = $request->query->get('customer');
        $status = $request->query->get('status');

        $orders = $orderRepository->findByCustomerAndStatus($customer, $status);

        // Transforms data into an associative array
        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'date' => $order->getDate()->format('Y-m-d H:i:s'),
                'customer' => $order->getCustomer(),
                'address1' => $order->getAddress1(),
                'city' => $order->getCity(),
                'postcode' => $order->getPostcode(),
                'country' => $order->getCountry(),
                'amount' => $order->getAmount(),
                'status' => $order->getStatus(),
                'deleted' => $order->getDeleted(),
                'last_modified' => $order->getLastModified()->format('Y-m-d H:i:s'),
            ];
        }
        // Returns a JSON response
        return $this->json($data);

        // return $this->render('order/search.html.twig', [
        //     'orders' => $orders,
        // ]);
    }
}
