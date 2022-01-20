<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Marque;
use App\Entity\Stock;
use App\Entity\SubCategory;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var Marque[]
     */
    public $marques = [];

    /**
     * @var SubCategory[]
     */
    public $subCategories = [];

    /**
     * @var Stock[]
     */
    public $sizes = [];

    /**
     * @var integer
     */
    public $promo = false;
}