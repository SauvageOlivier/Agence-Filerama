<?php
	
	namespace App\DataFixtures;
	
	use Doctrine\Bundle\FixturesBundle\Fixture;
	use Doctrine\Common\Persistence\ObjectManager;
	use App\Entity\Property;
	use Faker\Factory;
	
	class PropertyFixtures extends Fixture
	{
		public function load( ObjectManager $manager )
		{
			$faker = Factory::create('fr_FR');
			for ( $i = 0; $i < 100; $i++ ) {
				$property = new Property();
				$property
					->setTitle($faker->words(3, true))
					->setDescription($faker->sentence(3, true))
					->setSurface($faker->numberBetween(15, 400))
					->setRooms($faker->numberBetween(3, 20))
					->setBedrooms($faker->numberBetween(1, 12))
					->setFloor($faker->numberBetween(0, 5))
					->setPrice($faker->numberBetween(15000, 2000000))
					->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
					->setCity($faker->city)
					->setAddress($faker->address)
					->setPostalCode($faker->postcode)
					->setSold(false);
				$manager->persist($property);
			}
			$manager->flush();
		}
	}
