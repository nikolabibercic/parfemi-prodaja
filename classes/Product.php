<?php
    class Product extends ConnectionBuilder{

        public $categoryInserted = null;
        public $categoryDeleted = null;
        public $brandInserted = null;
        public $brandDeleted = null;
        public $categoryUpdated = null;
        public $brandUpdated = null;
        public $productInserted = null;

        public function insertCategory($categoryName){
            $sql = "insert into categories values(null,'{$categoryName}')";
            $query = $this->conn->prepare($sql);
            $checkInsert = $query->execute();

            if($checkInsert){
                $this->categoryInserted = true;
            }else{
                $this->categoryInserted = false;
            }
        }

        public function insertBrand($brandName){
            $sql = "insert into brands values(null,'{$brandName}' )";
            $query = $this->conn->prepare($sql);
            $checkInsert = $query->execute();

            if($checkInsert){
                $this->brandInserted = true;
            }else{
                $this->brandInserted = false;
            }
        }

        public function deleteCategory($categoryId){
            $sql = "
                    delete from products where category_id = {$categoryId};

                    delete from categories where category_id = {$categoryId};
                    ";
            $query = $this->conn->prepare($sql);
            $checkDelete = $query->execute();

            if($checkDelete){
                $this->categoryDeleted = true;
            }else{
                $this->categoryDeleted = false;
            }
        }

        public function deleteBrand($brandId){
            $sql = "
                    delete from products where brand_id = {$brandId};
        
                    delete from brands where brand_id = {$brandId};
                    ";
            $query = $this->conn->prepare($sql);
            $checkDelete = $query->execute();

            if($checkDelete){
                $this->brandDeleted = true;
            }else{
                $this->brandDeleted = false;
            }
        }

        public function selectAllCategories(){
            $sql = "select * 
                    from categories c
                    ";

            $query = $this->conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        public function selectAllBrands(){
            $sql = "select * 
                    from brands b
                    ";

            $query = $this->conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        public function selectAllProducts($search,$categoryId,$brandId){
            $sql = "select  p.product_id
                            ,p.name as perfume_name
                            ,p.size
                            ,p.quantity
                            ,p.purchase_price
                            ,p.selling_price
                            ,p.image
                            ,c.name as category_name
                            ,b.name as brand_name
                    from products p
                    inner join categories c on c.category_id = p.category_id
                    inner join brands b on b.brand_id = p.brand_id
                    where   (p.category_id = {$categoryId} or $categoryId = 0)
                            and (p.brand_id = {$brandId} or $brandId = 0)
                            and (p.name like '%$search%' or c.name like '%$search%' or b.name like '%$search%');
                    ";

            $query = $this->conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        public function selectTop10Products(){
            $sql = "select  p.product_id
                            ,p.name as perfume_name
                            ,p.size
                            ,p.quantity
                            ,p.purchase_price
                            ,p.selling_price
                            ,p.image
                            ,c.name as category_name
                            ,b.name as brand_name
                    from products p
                    inner join categories c on c.category_id = p.category_id
                    inner join brands b on b.brand_id = p.brand_id
                    limit 10;
                    ";

            $query = $this->conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        public function updateCategory($categoryId,$categoryNameNew){
            $sql = "
                    update categories set name='{$categoryNameNew}' where category_id = {$categoryId};
                    ";
            $query = $this->conn->prepare($sql);
            $checkUpdate = $query->execute();

            if($checkUpdate){
                $this->categoryUpdated = true;
            }else{
                $this->categoryUpdated = false;
            }
        }

        public function updateBrand($brandId,$brandNameNew){
            $sql = "
                    update brands set name='{$brandNameNew}' where brand_id = {$brandId};
                    ";
            $query = $this->conn->prepare($sql);
            $checkUpdate = $query->execute();

            if($checkUpdate){
                $this->brandUpdated = true;
            }else{
                $this->brandUpdated = false;
            }
        }

        public function uploadPicture($picture){
            $target_dir = "../images/";
            $target_file = $target_dir . basename($picture["name"]) ;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if file already exists
                if (file_exists($target_file)) {
                    //echo "Sorry, file already exists.";
                $uploadOk = 0;
                }
            
                // Check file size
                if ($picture["size"] > 10000000) {
                    //echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
            
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                    //echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
                $uploadOk = 0;
                }
            
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                if (move_uploaded_file($picture["tmp_name"], $target_file)) {
                    echo "The file " . basename( $picture["name"] ) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            
            //return $target_file;
            return '/parfem/images/'.$picture["name"];
            }         

            public function insertProduct($brandId,$categoryId,$name,$size,$quantity,$purchasePrice,$sellingPrice,$otherInformation,$image1Path){
                $sql = "insert into products values(null,{$brandId},{$categoryId},'{$name}',{$size},{$quantity},{$purchasePrice},{$sellingPrice},'{$otherInformation}','{$image1Path}',1 )";
                $query = $this->conn->prepare($sql);
                $checkInsert = $query->execute();
    
                if($checkInsert){
                    $this->productInserted = true;
                }else{
                    $this->productInserted = false;
                }
            }

    }
?>