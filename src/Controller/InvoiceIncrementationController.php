<?php


namespace App\Controller;


use App\Entity\Invoice;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceIncrementationController
{
    /**
     * @var ObjectManager
     */
    private $manager;


    /**
     * InvoiceIncrementationController constructor.
     * @param ObjectManager $manager
     */
    public function __construct( EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(Invoice $data)
    {
        $data->setChrono($data->getChrono()+1);
        $this->manager->flush($data);

        return $data;
    }
}