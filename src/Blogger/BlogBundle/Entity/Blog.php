<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entita predstavujúca článok.
 * @package Blogger\BlogBundle\Entity
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\BlogRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
 */
class Blog
{
    /**
     * @var int ID článku
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string titulok článku
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string autor článku
     * @ORM\Column(type="string", length=100)
     */
    protected $author;

    /**
     * @var string text článku
     * @ORM\Column(type="text")
     */
    protected $blog;

    /**
     * @var string obrázok článku
     * @ORM\Column(type="string", length=20)
     */
    protected $image;

    /**
     * @var string tagy článku
     * @ORM\Column(type="text")
     */
    protected $tags;

    /**
     * @var string slug komponent pre lepšie SEO v URL článku
     * @ORM\Column(type="string")
     */
    protected $slug;
    
    /**
     * @var \Comment[] pole komentárov
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments = array();
    
    /**
     * @var \DateTime čas vytvorenia komentáru
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime čas úpravy
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * Konštruktor pre článok.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * Získa identifikátor.
     * @return integer identifikátor
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Nastaví titulok.
     * @param string $title nový titulok
     * @return Blog článok
     */
    public function setTitle($title)
    {
        $this->title = $title;

        $this->setSlug($this->title);        
    }

    /**
     * Získa titulok
     * @return string titulok
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Nastaví autora.
     * @param string $author nový autor
     * @return Blog článok
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Získa autora.
     * @return string autor
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Nastaví článok.
     * @param string $blog nový článok
     * @return Blog článok
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Získa článok.
     * @return string článok
     */
    public function getBlog($length = null)
    {
        if (false == is_null($length) && $length > 0)
        {
            return substr($this->blog, 0, $length);
        }
        else
        {
            return $this->blog;
        }
    }

    /**
     * Nastaví obrázok.
     * @param string $image nový obrázok
     * @return Blog článok
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Získa obrázok.
     * @return string obrázok
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Nastaví tagy.
     * @param string $tags nové tagy
     * @return Blog článok
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Získa tagy.
     * @return string tagy
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Nastaví čas vytvorenia článku.
     * @param \DateTime $created nový čas
     * @return Blog článok
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Získa čas vytvorenia článku.
     * @return \DateTime čas vytvorenia.
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Nastaví čas úpravy.
     * @param \DateTime $updated čas úpravy
     * @return Blog článok
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
     * Nastaví hodnotu času úpravy.
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * Odstráni komentáre.
     * @param \Blogger\BlogBundle\Entity\Comment $comments odstraňované komentáre
     */
    public function removeComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Vyžadovaná metóda, ktorá získa titulok článku.
     * @return string titulok článku
     */
    public function __toString()
    {
        return $this->getTitle();
    }
    
    /**
     * Odstráni nechcené znaky z textu.
     * @param string $text text pre úpravu
     * @return string upravený text vhodný do URL článku
     */
    public function slugify($text)
    {
        // nahradí čísla a písmena znakom '-'
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // ozdobí
        $text = trim($text, '-');

        // prepíše
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // zníži na malé znaky
        $text = strtolower($text);

        // odstráni nechcené znaky
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Pridá komentár medzi ostatné.
     * @param Comment $comment pridávaný komentár
     */
    public function addComment(Comment $comment)
    {
    	$this->commets[] = $comment;
    }

    /**
     * Získa komentáre.
     * @return \Comment[] pole komentárov
     */
    public function getComments()
    {
    	return $this->comments;
    }


    /**
     * Nastaví reťazec článku v URL adrese.
     * @param string $slug
     * @return Blog
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * Získa reťazec článku v URL adrese.
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
