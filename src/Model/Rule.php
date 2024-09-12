<?php

namespace Mvenghaus\OrderPrevent\Model;

use Mvenghaus\OrderPrevent\Api\Data\RuleInterface;

class Rule extends \Magento\Framework\Model\AbstractModel implements RuleInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Rule::class);
    }

    public function setCompany($company)
    {
        $this->setData(self::KEY_COMPANY, $company);
        return $this;
    }

    public function getCompany()
    {
        return $this->getData(self::KEY_COMPANY);
    }

    public function setFirstname($firstname)
    {
        $this->setData(self::KEY_FIRSTNAME, $firstname);
        return $this;
    }

    public function getFirstname()
    {
        return $this->getData(self::KEY_FIRSTNAME);
    }

    public function setLastname($lastname)
    {
        $this->setData(self::KEY_LASTNAME, $lastname);
        return $this;
    }

    public function getLastname()
    {
        return $this->getData(self::KEY_LASTNAME);
    }

    public function setPostcode($postcode)
    {
        $this->setData(self::KEY_POSTCODE, $postcode);
        return $this;
    }

    public function getPostcode()
    {
        return $this->getData(self::KEY_POSTCODE);
    }

    public function setCity($city)
    {
        $this->setData(self::KEY_CITY, $city);
        return $this;
    }

    public function getCity()
    {
        return $this->getData(self::KEY_CITY);
    }

    public function setEmail($email)
    {
        $this->setData(self::KEY_EMAIL, $email);
        return $this;
    }

    public function getEmail()
    {
        return $this->getData(self::KEY_EMAIL);
    }

    public function setErrorMessage($errorMessage)
    {
        $this->setData(self::KEY_ERROR_MESSAGE, $errorMessage);
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->getData(self::KEY_ERROR_MESSAGE);
    }
}
