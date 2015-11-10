<?php

namespace Spb\SymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * News controller.
 * see https://github.com/alexdebril/rss-atom-bundle for details
 */
class NewsController extends Controller {

    /**
     * Показать новости с blog.symfony.spb.ru.
     * Источник: http://blog.symfony.spb.ru/feeds/posts/default
     */
    public function newsAction() {

        // fetch the FeedReader
        $reader = $this->container->get('debril.reader');

        // this date is used to fetch only the latest items
        $date = \DateTime::createFromFormat('d-M-Y', '15-Feb-2012');


        // the feed you want to read
        $url = 'http://blog.symfony.spb.ru/feeds/posts/default?max-results=4';

        // now fetch its (fresh) content
        $feed = $reader->getFeedContent($url, $date);

        // the $content object contains as many Item instances as you have fresh articles in the feed
        $items = $feed->getItems();


        $response = $this->render('SpbSymfonyBundle:News:blog.html.twig', array('items' => $items));

        // пометить ответ как public или private
        $response->setPublic();
        //$response->setPrivate();
        // установить max age для private и shared ответов
        $response->setMaxAge(86400);
        $response->setSharedMaxAge(86400);

        // установить специальную директиву Cache-Control
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

}
