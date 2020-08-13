<?php


namespace App\Service;


use Symfony\Component\Routing\RouterInterface;

class Pagination
{

    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }
    /**
     * @param $page
     * @param $pages
     * @return array
     */
    public function getUrl ($page, $pages)
    {
        $paginationLinks = array(
            'page' => $page,
            'pages' => $pages,
            'firstPage' => $this->router->generate('home.index', ['page' => '1']),
            'lastPage' => $this->router->generate('home.index', ['page' => $pages]),
            'nextPage' => $this->router->generate('home.index', ['page' => ($page + 1)]),
            'previousPage' => $this->router->generate('home.index', ['page' => ($page - 1)])
        );
        return $paginationLinks;
    }

    /**
     * @param $page
     * @param $pages
     * @param $trickSlug
     * @return array
     */
    public function getCommentUrl ($page, $pages, $trickSlug)
    {
        $paginationLinks = array(
            'page' => $page,
            'pages' => $pages,
            'firstPage' => $this->router->generate('trick.show', ['slug' => $trickSlug, 'page' => '1']),
            'lastPage' => $this->router->generate('trick.show', ['slug' => $trickSlug, 'page' => $pages]),
            'nextPage' => $this->router->generate('trick.show', ['slug' => $trickSlug, 'page' => ($page + 1)]),
            'previousPage' => $this->router->generate('trick.show', ['slug' => $trickSlug, 'page' => ($page - 1)])
        );
        return $paginationLinks;
    }
}