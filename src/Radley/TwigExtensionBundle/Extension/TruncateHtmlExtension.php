<?php

/**
  Truncate Html string without stripping tags
  register in Resources/config/services.yml with:
  services:
  truncatehtml.twig.extension:
  class: Radley\TwigExtensionBundle\Extension\TruncateHtmlExtension
  tags:
  - { name: twig.extension }

  Usage:
  {{ htmlstring|truncatehtml(500)|raw }}
 */

namespace Radley\TwigExtensionBundle\Extension;

class TruncateHtmlString {

    function __construct($string, $limit) {
// create dom element using the html string
        $this->tempDiv = new \DomDocument();
        $this->tempDiv->loadXML('<div>' . $string . '</div>');
// keep the characters count till now
        $this->charCount = 0;
        $this->encoding = 'UTF-8';
// character limit need to check
        $this->limit = $limit;
    }

    function cut() {
// create empty document to store new html
        $this->newDiv = new \DomDocument();
// cut the string by parsing through each element
        $this->searchEnd($this->tempDiv->documentElement, $this->newDiv);
        $newhtml = $this->newDiv->saveHTML();
        return $newhtml;
    }

    function deleteChildren($node) {
        while (isset($node->firstChild)) {
            $this->deleteChildren($node->firstChild);
            $node->removeChild($node->firstChild);
        }
    }

    function searchEnd($parseDiv, $newParent) {
        foreach ($parseDiv->childNodes as $ele) {
// not text node
            if ($ele->nodeType != 3) {
                $newEle = $this->newDiv->importNode($ele, true);
                if (count($ele->childNodes) === 0) {
                    $newParent->appendChild($newEle);
                    continue;
                }
                $this->deleteChildren($newEle);
                $newParent->appendChild($newEle);
                $res = $this->searchEnd($ele, $newEle);
                if ($res)
                    return $res;
                else
                    continue;
            }

// the limit of the char count reached
            if (mb_strlen($ele->nodeValue, $this->encoding) + $this->charCount >= $this->limit) {
                $newEle = $this->newDiv->importNode($ele);
                $newEle->nodeValue = substr($newEle->nodeValue, 0, $this->limit - $this->charCount);
                $newParent->appendChild($newEle);
                return true;
            }
            $newEle = $this->newDiv->importNode($ele);
            $newParent->appendChild($newEle);
            $this->charCount += mb_strlen($newEle->nodeValue, $this->encoding);
        }
        return false;
    }

}

class TruncateHtmlExtension extends \Twig_Extension {

    public function getName() {
        return 'truncatehtml';
    }

    public function getFilters() {
        return array('truncatehtml' => new \Twig_Filter_Method($this, 'truncatehtml'));
    }

    public function truncatehtml($html, $limit, $endchar = '&hellip;') {
        $output = new TruncateHtmlString($html, $limit);
        return $output->cut() . $endchar;
    }

}