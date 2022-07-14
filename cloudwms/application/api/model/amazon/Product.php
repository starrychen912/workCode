<?

namespace app\api\model\amazon;


class Product {

    public $merchantIdentifier;

    public $operation;

    public $skuId;

    public $standardType;

    public $standardValue;

    public $productTaxCode;


    public $title;

    public $brand;


    public $description;


    public $bulletPoint1;

    public $bulletPoint2;

    public $currency;

    public $price;

    public $manufacturer;

    public $itemType;

    public $ingredients;

    public $directions;

    public function checkvalid(){

        if(!isset($this->merchantIdentifier)){
            return false;
        }
        return true;

    }





}

