<?php

namespace Mvenghaus\OrderPrevent\Api\Data;

interface RuleInterface
{

    const KEY_ID = 'id';
    const KEY_COMPANY = 'company';
    const KEY_FIRSTNAME = 'firstname';
    const KEY_LASTNAME = 'lastname';
    const KEY_POSTCODE = 'postcode';
    const KEY_CITY = 'city';
    const KEY_EMAIL = 'email';
    const KEY_ERROR_MESSAGE = 'error_message';

    /** @return $this */
    public function setId($id);

    public function getId();

    /** @return $this */
    public function setCompany($company);

    public function getCompany();

    /** @return $this */
    public function setFirstname($firstname);

    public function getFirstname();

    /** @return $this */
    public function setLastname($lastname);

    public function getLastname();

    /** @return $this */
    public function setPostcode($postcode);

    public function getPostcode();

    /** @return $this */
    public function setCity($city);

    public function getCity();

    /** @return $this */
    public function setEmail($email);

    public function getEmail();

    /** @return $this */
    public function setErrorMessage($errorMessage);

    public function getErrorMessage();
}
