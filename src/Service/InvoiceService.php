<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    private InvoiceRepository $invoiceRepository;
    private EntityManagerInterface $em;

    public function __construct(
        InvoiceRepository $invoiceRepository,
        EntityManagerInterface $em)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->em = $em;
    }

    public function getLastInvoiceNumber(): string
    {
        $lastInvoice = $this->invoiceRepository->findOneBy([], ['id' => 'DESC']);
        if (!$lastInvoice) {
            return '0001';
        }
        $lastNumber = $lastInvoice->getNumber();
        $number = intval($lastNumber) + 1;
        return str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function createInvoice(Booking $booking): Invoice
    {
        $invoice = new Invoice();
        $invoice->setNumber($this->getLastInvoiceNumber())
                ->setBooking($booking)
                ->setAddress($booking->getTraveler()->getFullAddress())
                ;
        $this->em->persist($invoice);
        $this->em->flush();

        return $invoice;
    }
}