<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use APP\Entity\User;

class UserFixtures extends baseFixture
{
    private  $encoder;

    /**
     * Dans une class (autre que un controller),
     * on peut récupérer des services par autowiring uniquement dans
     * un constructeur
     */
    public function  __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}


    protected function loadData()
    {
        //administrateurs
        $this->createMany(5,'user_admin', function (int $num){
           $admin = new User();
           $password = $this->encoder->encodePassword($admin,'admin' . $num);

           return $admin
               ->setEmail('admin'. $num . '@kritik.fr' )
               ->setRoles(['ROLE_ADMIN'])
               ->setPassword($password)
               ->setPseudo('admin_' . $num)
               ->confirmAccount()
               ->renewToken()
               ;
        });

        //utilisateurs
        $this->createMany(20,'user_user',function (int $num){
           $user = new User();
           $password = $this->encoder->encodePassword($user,'admin' . $num);

           return $user
               ->setEmail('user' . $num . '@kritik.fr')
               ->setPassword($password)
               ->setPseudo('user_' . $num)
               ->confirmAccount()
               ->renewToken()
               ;
        });

    }
}