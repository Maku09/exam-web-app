<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class MyPaginator extends LengthAwarePaginator
{
  /**
   * Get the instance as an array.
   *
   * @return array
   */
  public function toArray()
  {
    return [
      'items' => $this->items->toArray(),
      'meta' => [
        'current_page' => $this->currentPage(),
        'from'         => $this->firstItem(),
        'last_page'    => $this->lastPage(),
        'per_page'     => $this->perPage(),
        'to'           => $this->lastItem(),
        'total'        => $this->total(),
      ]
    ];
  }
}