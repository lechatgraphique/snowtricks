<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    /** @var array*/
    private array $items;

    /** @var int */
    private int $limit;

    /** @var int */
    private int $page;

    public function __construct(Request $request, array $items, int $limit)
    {
        $this->items = $items;
        $this->limit = $limit;

        $this->validate($request);
    }

    public function getPagedItems(): array
    {
        return array_slice($this->items, ($this->page-1) * $this->limit, $this->limit);
    }

    public function getPagination(): array
    {
        return [
            'Première' => $this->page > 1 ? 1 : null,
            '&laquo; Précédent' => $this->page > 1 ? $this->page - 1 : null,
            'Suivant &raquo;' => $this->page < $this->getMaxPage() ? $this->page + 1 : null,
            'Dernier' => $this->page < $this->getMaxPage() ? $this->getMaxPage() : null,
        ];
    }

    protected function validate(Request $request): void
    {
        $this->page = $request->query->getInt('page', 1);

        if ($this->page < 1 ) {
            $this->page = 1;
        } elseif ($this->page > $this->getMaxPage()) {
            $this->page = $this->getMaxPage();
        }
    }

    protected function getMaxPage(): int
    {
        return ceil(count($this->items) / $this->limit);
    }
}