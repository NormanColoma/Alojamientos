<?php


namespace App\Models\DTO;


class Owner extends AbstractUser
{

    private $customers;

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param mixed $customers
     */
    public function setCustomers(Owner $customers)
    {
        $this->customers = $customers;
    }

    function __construct() {
        $this->setAdmin(false);
        $this->setOwner(true);
    }

}