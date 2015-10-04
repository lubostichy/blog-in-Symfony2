<?php

namespace Blogger\BlogBundle\Twig\Extensions;

/**
 * Rozšírenie pre Twig šablóny.
 * @package Blogger\BlogBundle\Twig\Extensions
 */
class BloggerBlogExtension extends \Twig_Extension
{
    /**
     * Získa rozšírenie.
     * @return \Twig_Filter_Method[] rozšírenie
     */
    public function getFilters()
    {
        return array(
            'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
        );
    }

    /**
     * Vytvorí z času vytvorenia text, ktorý opisuje pred akou dobou bol príspevok vytvorený.
     * @param \DateTime $dateTime čas vytvorenia
     * @return string text, ktorý opisuje, že pred akou dobou bol príspevok vytvorený
     * @throws \InvalidArgumentException nesprávny parameter metódy
     */
    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // sekundy
            $time = $delta;
            $duration = $time . " second" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 3600)
        {
            // minúty
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 86400)
        {
            // hodiny
            $time = floor($delta / 3600);
            $duration = $time . " hour" . (($time > 1) ? "s" : "") . " ago";
        }
        else
        {
            // dni
            $time = floor($delta / 86400);
            $duration = $time . " day" . (($time > 1) ? "s" : "") . " ago";
        }

        return $duration;
    }

    /**
     * Získa názov rozšírenia.
     * @return string názov rozšírenia
     */
    public function getName()
    {
        return 'blogger_blog_extension';
    }
}