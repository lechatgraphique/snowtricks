<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');

        $users = [];
        $categories = [];
        $genders = ['male', 'female'];
        $categoriesDemoName = ['Grabs', 'Rotations', 'Flips', 'Rotations désaxées', 'Slides', 'One foot', 'Old school'];
        $tricksDemoName = ['Mute', 'Indy', '360', '720', 'Backflip', 'Misty', 'Tail slide', 'Method air', 'Backside air'];

        for ($i = 0 ; $i < 20 ; $i++)
        {
            $user = new User();

            $gender = $faker->randomElement($genders);

            $user->setUsername($faker->userName)
                ->setEmail($faker->safeEmail)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setActivated(true)
                ->setPicturePath('https://randomuser.me')
                ->setPictureName('api/portraits/' . ($gender == 'male' ? 'men/' : 'women/') . $faker->numberBetween(1,99) . '.jpg')
                ->setToken(md5(random_bytes(10)));
            $manager->persist($user);
            $users[] = $user;
        }

        foreach ($categoriesDemoName as $categoryName)
        {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categories[] = $category;
        }

        foreach ($tricksDemoName as $trickName)
        {
            $trick = new Trick();
            $trick->setName($trickName)
                ->setDescription($faker->paragraph(5))
                ->setCreatedAt(new \Datetime)
                ->setUpdatedAt(new \Datetime)
                ->setUser($faker->randomElement($users))
                ->setCategory($faker->randomElement($categories))
                ->setMovie('https://youtube.com');

            for ($k = 1 ; $k < 4 ; $k++)
            {
                $picture = new Picture();
                $picture->setPath('img/tricks')
                    ->setName($trick->getName() . ' ' . $k . '.jpg')
                    ->setTrick($trick);

                $manager->persist($picture);

                if($k === 3)
                {
                    $trick->setMainPicture($picture);
                    $manager->persist($trick);
                }

            }

            for ($m = 0 ; $m < mt_rand(0, 30) ; $m++)
            {
                $comment = new Comment();
                $comment->setContent($faker->sentence(mt_rand(1, 5)))
                    ->setCreatedAt(new \Datetime)
                    ->setUser($faker->randomElement($users))
                    ->setTrick($trick);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}