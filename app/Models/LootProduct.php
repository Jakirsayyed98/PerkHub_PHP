<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LootProduct extends Model
{
    use HasFactory;

    // Optional: if your table name isn't the plural of the model name
    protected $table = 'loot_products';

    protected $fillable = [
        'miniapp_id',
        'product_name',
        'description',
        'image_url',
        'original_price',
        'discounted_price',
        'discount_percentage',
        'product_url',
        'coupon_code',
    ];

    /**
     * Get all loot products.
     */
    public static function getAllProducts()
    {
        return self::all();
    }


    public static function getProductById($id)
    {
        return self::where('id', $id)->first();  
    }

    /**
     * Get paginated loot products.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginated($perPage = 10)
    {
        return self::paginate($perPage);
    }

    /**
     * Get loot product by ID.
     *
     * @param int $id
     * @return self|null
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Add or update a loot product.
     *
     * @param array $data
     * @return self
     */
    public static function addOrUpdateProduct($data)
    {
        $product = self::updateOrCreate(
            ['id' => $data['id'] ?? null], // Use 'id' if it exists, otherwise create a new record
            [
                'miniapp_id' => $data['miniapp_id'],
                'product_name' => $data['product_name'],
                'description' => $data['description'],
                'image_url' => $data['image_url'],
                'original_price' => $data['original_price'],
                'discounted_price' => $data['discounted_price'],
                'discount_percentage' => $data['discount_percentage'],
                'product_url' => $data['product_url'],
                'coupon_code' => $data['coupon_code'],
            ]
        );

        return $product;
    }
}
