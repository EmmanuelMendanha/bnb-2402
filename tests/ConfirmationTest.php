<?php

namespace App\Tests;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConfirmationTest extends WebTestCase
{
    public function testBookRoomWhenLoggedIn(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $traveler = $userRepository->findOneBy(['email'=>'user75@user.fr']);
        $client->loginUser($traveler);
        
        
        $client->request('POST', '/confirmation', [
            'room' => 1,
            'checkin' => '2024-04-01',
            'checkout' => '2024-04-02',
            'guests' => 1

        ]);

        $booking = static::getContainer()->get(BookingRepository::class)->findOneBy([],[ 'id' => 'DESC']);

        $this->assertEquals($traveler->getEmail(), $booking->getTraveler()->getEmail());
       
    }
}
