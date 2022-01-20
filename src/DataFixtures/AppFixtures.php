<?php

namespace App\DataFixtures;

use App\DataFixtures\Data;
use App\Entity\Categorie;
use App\Entity\Delivery;
use App\Entity\Image;
use App\Entity\Mark;
use App\Entity\Product;
use App\Entity\Stock;
use App\Entity\Store;
use App\Entity\SubCategorie;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public $AllCategories;
    public $AllSubCategories;
    public $AllBrands;
    public $AllProducts;
    public $AllStores;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->AllCategories = [];
        $this->AllSubCategories = [];
        $this->AllBrands = [];
        $this->AllProducts = [];
        $this->AllStores = [];
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $data = new Data();
        $faker = Factory::create('fr_FR');
        $brands = $data->brands;
        $categories = $data->categories;
        $subCategories = $data->subCategories;
        $stores = $data->stores;
        $products = $data->products;
        $stocks = $data->stocks;
        $deliveries = $data->deliveries;
        $user = new User();

        $user->setEmail("raul3wa@gmail.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setCivility('M.');
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setAddress('7 Avenue Jacques Cartier');
        $user->setCity('Bussy-Saint-Georges');
        $user->setZipCode('77600');
        $user->setCountry('FR');
        $user->setPhone('0634567891');
        $date = new DateTime("1994/11/17");
        $user->setBirth($date);
        $user->setIsVerified(true);

        $manager->persist($user);

        # Brands
        foreach ($brands as $key => $value) {
            $mark = new Mark();

            $mark->setName($value['name']);
            $mark->setLogo($value['logo']);
            
            array_push($this->AllBrands, $mark);
            $manager->persist($mark);
        }

        # Categories
        foreach ($categories as $key => $value) {
            $category = new Categorie();

            $category->setName($value['name']);
            
            array_push($this->AllCategories, $category);
            $manager->persist($category);
        }

        # SubCategories
        foreach ($subCategories as $key => $value) {
            $id = 0+$value['categorie_id'];
            $subCategory = new SubCategorie();
    
            $subCategory->setName($value['name']);
            $subCategory->setCategorieId($this->AllCategories[$id]);
            
            array_push($this->AllSubCategories, $subCategory);
            $manager->persist($subCategory);
        }

        # Stores
        foreach ($stores as $key => $value) {
            $store = new Store();
    
            $store->setName($value['name']);
            $store->setAddress($value['address']);
            $store->setZipCode($value['zip_code']);
            $store->setCity($value['city']);
            $store->setCountry($value['country']);
            $store->setPhone($value['phone']);
            
            array_push($this->AllStores, $store);
            $manager->persist($store);
        }

        # Products
        foreach ($products as $key => $value) {
            $markId = 0+$value['mark_id'];
            $categorieId = 0+$value['categorie_id'];
            $subcategorieId = 0+$value['sub_categorie_id'];
            $product = new Product();
    
            $product->setRef($value['ref']);
            $product->setModel($value['model']);
            $product->setTag($value['tag']);
            $product->setRay($value['ray']);
            $product->setDescription($value['description']);
            $product->setMarkId($this->AllBrands[$markId]);
            $product->setSubCategorieId($this->AllSubCategories[$subcategorieId]);
            $product->setCategorieId($this->AllCategories[$categorieId]);
    
            array_push($this->AllProducts, $product);
            $manager->persist($product);
        }

        # Stocks
        foreach ($stocks as $key => $value) {
            $productId = 0+$value['product_id'];
            $storeId = 0+$value['store_id'];
            $stock = new Stock();
    
            $stock->setAmount($value['amount']);
            $stock->setSize($value['size']);
            $stock->setColor($value['color']);
            $stock->setMatter($value['matter']);
            $stock->setPrice($value['price']);
            $stock->setProductId($this->AllProducts[$productId]);
            $stock->setStoreId($this->AllStores[$storeId]);
    
            $manager->persist($stock);
        }

        # Images
        foreach ($this->AllProducts as $key => $value) {
            
            if ($value->getRef() == "7762101" || $value->getRef() == "3985101" || $value->getRef() == "7600102") {
                for ($i=1; $i < 3; $i++) {
                    $image = new Image();
                    $image->setPath($value->getRef().'_'.$i.'.jpg');
                    $image->setProductId($value);
                    
                    $manager->persist($image);
                }
            } elseif ($value->getRef() == "6704021") {
                for ($i=1; $i < 5; $i++) {
                    $image = new Image();
                    $image->setPath($value->getRef().'_'.$i.'.jpg');
                    $image->setProductId($value);
                    
                    $manager->persist($image);
                }
            } elseif ($value->getRef() == "7600702") {
                $image = new Image();
                $image->setPath($value->getRef().'_1.jpg');
                $image->setProductId($value);
                
                $manager->persist($image);
            } else {
                for ($i=1; $i < 7; $i++) {
                    $image = new Image();
                    $image->setPath($value->getRef().'_'.$i.'.jpg');
                    $image->setProductId($value);

                    $manager->persist($image);
                }
            }
        }

        # Stocks
        foreach ($deliveries as $key => $value) {
            $deliverie = new Delivery();
    
            $deliverie->setName($value['name']);
            $deliverie->setThreshold($value['threshold']);
            $deliverie->setPriceBefore($value['price_before']);
            $deliverie->setPriceAfter($value['price_after']);
            $deliverie->setDescription($value['description']);
    
            $manager->persist($deliverie);
        }
        
        $manager->flush();
    }
}
