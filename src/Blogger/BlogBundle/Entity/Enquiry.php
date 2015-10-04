<?php
namespace Blogger\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Entita predstavujúca dotazník.
 * @package Blogger\BlogBundle\Entity
 */
class Enquiry
{
        /** @var string meno používateľa */
	protected $name;
        
        /** @var string email používateľa */
	protected $email;
        
        /** @var string predmet dotazníka */
	protected $subject;
        
        /** @var string text dotazníka */
	protected $body;

        /**
         * Získa meno používateľa.
         * @return string meno používateľa
         */
	public function getName()
	{
		return $this->name;
	}

        /**
         * Nastaví meno používateľa.
         * @param type $name meno používateľa
         */
	public function setName($name)
	{
		$this->name = $name;
	}

        /**
         * Získa meno používateľa.
         * @return string email používateľa
         */
	public function getEmail()
	{
		return $this->email;
	}

        /**
         * Nastaví email používateľa.
         * @param string $email email používateľa
         */
	public function setEmail($email)
	{
		$this->email = $email;
	}

        /**
         * Získa predmet dotazníka.
         * @return string predmet dotazníka
         */
	public function getSubject()
	{
		return $this->subject;
	}

        /**
         * Nastaví predmet dotazníka.
         * @param string $subject predmet dotazníka
         */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

        /**
         * Získa text dotazníka.
         * @return string text dotazníka
         */
	public function getBody()
	{
		return $this->body;
	}

        /**
         * Nastaví text dotazníka.
         * @param string $body text dotazníka
         */
	public function setBody($body)
	{
		$this->body = $body;
	}

        /**
         * Načíta metadáta povinných údajov dotazníka.
         * @param ClassMetadata $metadata metadáta povinných údajov dotazníka
         */
	public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addPropertyConstraint('name', new notBlank());
		$metadata->addPropertyConstraint('email', new Email());
		$metadata->addPropertyConstraint('subject', new NotBlank());
		$metadata->addPropertyConstraint('subject', new Length(array('max' => 50)));
		$metadata->addPropertyConstraint('body', new Length(array('min' => 50)));
		$metadata->addPropertyConstraint('email', new Email(array(
		    'message' => 'Quiet blog does not like invalid emails. Give me a real one!'
		)));
	}
}