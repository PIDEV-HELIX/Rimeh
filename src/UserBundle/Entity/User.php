<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
	/**
•	 * @ORM\Entity
•	 * @ORM\Table(name="fos_user")
•	 */
	class User extends BaseUser
    {
        /**
         * •         * @ORM\Id
         * •         * @ORM\Column(type="integer")
         * •         * @ORM\GeneratedValue(strategy="AUTO")
         * •         */
        protected $id;

        public function __construct()
        {
            parent::__construct();

        }
    }



