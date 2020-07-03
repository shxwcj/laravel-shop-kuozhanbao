<?php

use Illuminate\Database\Seeder;

class CartItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cart_items')->delete();
        
        \DB::table('cart_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 101,
                'product_sku_id' => 5,
                'amount' => 1,
            ),
        ));
        
        
    }
}