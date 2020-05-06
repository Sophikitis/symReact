<?php

namespace App\DataFixtures;

use App\Entity\Customers;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');


        for ($u = 0; $u < 10; $u++) {

            $user = new User();
            $hash = $this->encoder->encodePassword($user, 'password');


            $user->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setLastName($faker->lastName)
                ->setPassword($hash);
            $manager->persist($user);


            for ($c = 0; $c < mt_rand(2, 20); $c++) {
                $chrono = 1;

                $customer = new Customers();
                $customer->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName)
                    ->setCompany($faker->company)
                    ->setEmail($faker->companyEmail)
                    ->setUser($user);

                $manager->persist($customer);

                for ($i = 0; $i < mt_rand(3, 20); $i++) {
                    $invoice = new Invoice();
                    $invoice->setAmout($faker->randomFloat(2, 250, 5000))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                        ->setChrono($chrono)
                        ->setCustomer($customer);

                    $chrono++;
                    $manager->persist($invoice);

                }
            }

            $manager->flush();
        }
    }
}
