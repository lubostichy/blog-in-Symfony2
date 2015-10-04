<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Entita predstavujúca komentár.
 * @package Blogger\BlogBundle\Entity
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    /**
     * @var int identifikátor komentáru
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string meno používateľa
     * @ORM\Column(type="string")
     */
    protected $user;

    /**
     * @var string text komentáru
     * @ORM\Column(type="text")
     */
    protected $comment;

    /**
     * @var bool schvalený/neschválený komentár
     * @ORM\Column(type="boolean")
     */
    protected $approved;

    /**
     * @var \Blog odpovedajúci článok
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    protected $blog;

    /**
     * @var \DateTime čas vytvorenia komentára
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime čas úpravy komentára
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * Konštruktor komentára.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());

        $this->setApproved(true);
    }

    /**
     * Získa identifikátor komentára.
     * @return int identifikátor komentára
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Nastaví meno používateľa.
     * @param string $user nové meno používateľa
     * @return Comment komentár
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Získa meno používateľa.
     * @return string meno používateľa
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Nastaví text komentára.
     * @param string $comment nový text komentára
     * @return Comment komentár
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     *Získa text komentára.
     * @return string text komentára
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Nastaví schválenie komentára.
     * @param boolean $approved true pre schválané a false pre neschválané
     * @return Comment komentár
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Získa hodnotu schválania komentára.
     * @return boolean hodnota schválenia
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Nastaví čas vytvorenia.
     * @param \DateTime $created čas vytvorenia
     * @return Comment komentár
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Získa čas vytvorenia.
     * @return \DateTime čas vytvorenia
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Nastaví čas úpravy.
     * @param \DateTime $updated čas úpravy
     * @return Comment komentár
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Získa čas úpravy.
     * @return \DateTime čas úpravy
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Nastaví hodnotu úpravy.
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }
    
    /**
     * Priradí komentár k článku.
     * @param \Blogger\BlogBundle\Entity\Blog|null $blog článok
     * @return Comment komentár
     */
    public function setBlog(\Blogger\BlogBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Získa článok, ku ktorému patrí komentár.
     * @return \Blogger\BlogBundle\Entity\Blog článok
     */
    public function getBlog()
    {
        return $this->blog;
    }
    
    /**
     * Načíta metadáta o povinných údajoch pri komentári.
     * @param ClassMetadata $metadata metadáta povinných údajov
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('user', new NotBlank(array(
            'message' => 'You must enter your name'
        )));
        $metadata->addPropertyConstraint('comment', new NotBlank(array(
            'message' => 'You must enter a comment'
        )));
    }
}
