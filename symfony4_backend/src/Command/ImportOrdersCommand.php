<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// #[AsCommand(
//     name: 'ImportOrdersCommand',
//     description: 'Import orders from orders.json using Doctrine.',
// )]
class ImportOrdersCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {        
        $this
            ->setName('app:import-orders')
            ->setDescription('Import orders from orders.json using Doctrine.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // Loads the contents of the orders.json file
        $ordersJson = file_get_contents($this->getApplication()->getKernel()->getContainer()->getParameter('kernel.project_dir') . '/var/data/orders.json');
        $ordersData = json_decode($ordersJson, true);

        // Import data using Doctrine
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

        $io->success('Orders imported successfully.');

        return Command::SUCCESS;
    }
}
