<?php
    class Cart extends ConnectionBuilder{

        public $itemInserted = null;

        public function insertItemIntoCart($productId,$userId){
            $sql = "
                insert into cart_items (
                    cart_id,
                    product_id,
                    product_name,
                    brand_id,
                    brand_name,
                    category_id,
                    category_name,
                    size,
                    purchase_price,
                    selling_price,
                    other_information,
                    image,
                    cart_item_status_id
                )
                select
                    (
                        select c.cart_id
                        from carts c
                        where c.user_id = {$userId}
                    ) cart_id,
                    p.product_id,
                    p.name product_name,
                    b.brand_id,
                    b.name brand_name,
                    c.category_id,
                    c.name category_name,
                    p.size,
                    p.purchase_price,
                    p.selling_price,
                    p.other_information,
                    p.image,
                    1 cart_item_status_id
                from products p
                inner join brands b on b.brand_id = p.brand_id
                inner join categories c on c.category_id = p.category_id
                where p.product_id = {$productId}
            ";
            $query = $this->conn->prepare($sql);
            $checkInsert = $query->execute();

            if($checkInsert){
                $this->itemInserted = true;
            }else{
                $this->itemInserted = false;
            }
        }

    }
?>