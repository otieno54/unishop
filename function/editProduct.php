<?php
    require_once("connection.php");
     
     $targetDir='../upload/';

if(isset($_POST["submit"])){ 

    $new_name=$_POST["new_product_name"];
    $new_product_status=$_POST["new_product_status"];
    $new_price=$_POST["new_product_price"];
    $new_description=$_POST["new_product_description"]; 
    $old_image_1=$_POST["old_image_1"];
    $old_image_2=$_POST["old_image_2"];
    $old_image_3=$_POST["old_image_3"];

    $vendorId=$_POST["vendor_id"];
    $productId=$_POST["product_id"];  
        
    //update product information only if all images are empty
    if(empty($_FILES["new_product_image1"]["name"]) && empty($_FILES["new_product_image2"]["name"]) && empty($_FILES["new_product_image3"]["name"])){
        $sql="UPDATE `product_table` SET `product_name` = '$new_name', `product_price` = '$new_price', `product_description` = '$new_description', `product_status` = '$new_product_status' WHERE `product_table`.`product_id` = $productId";
        $update=mysqli_query($conn,$sql);
        if($update){
            ?>
                <script>
                    window.alert("Product is updated successfully");
                    window.location.href="../vendor.php";
                </script>
            
            <?php
        }else{
            ?>
        
                <script>
                    window.alert("Error,Couldn't update");
                    window.location.href="../vendor.php";
                </script>
        
            <?php
        }
        
    }
     //if one of the image is empty
    if(empty($_FILES["new_product_image1"]["name"]) || empty($_FILES["new_product_image2"]["name"]) || empty($_FILES["new_product_image3"]["name"])){
            //if all images are changed
            if(!empty($_FILES["new_product_image1"]["name"]) && !empty($_FILES["new_product_image2"]["name"]) && !empty($_FILES["new_product_image3"]["name"])){
                 //rename image 1
                 $firstImage = $_FILES["new_product_image1"]["name"];
                 $fileExt1= explode('.',$firstImage);
                 $fileActualExt1=strtolower(end($fileExt1));
                 $firstNewName = uniqid('',true).".".$fileActualExt1;
                 $targetFilePath1 = $targetDir . $firstNewName; 
                 $fileType1 = pathinfo($targetFilePath1,PATHINFO_EXTENSION); 
                 //rename image 2
                $secondImage = $_FILES["new_product_image2"]["name"];
                $fileExt2= explode('.',$secondImage);
                $fileActualExt2=strtolower(end($fileExt2));
                $secondNewName = uniqid('',true).".".$fileActualExt2;
                $targetFilePath2 = $targetDir . $secondNewName; 
                $fileType2 = pathinfo($targetFilePath2,PATHINFO_EXTENSION); 
                 //rename image 3
                 $thirdImage = $_FILES["new_product_image3"]["name"];
                 $fileExt3= explode('.',$thirdImage);
                 $fileActualExt3=strtolower(end($fileExt3));
                 $thirdNewName = uniqid('',true).".".$fileActualExt3;
                 $targetFilePath3 = $targetDir . $thirdNewName; 
                 $fileType3 = pathinfo($targetFilePath3,PATHINFO_EXTENSION); 

                   // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType1, $allowTypes) && in_array($fileType2, $allowTypes) && in_array($fileType3, $allowTypes)){
                    //delete old image
                    $image1Delete=unlink($targetDir . $old_image_1);
                    $image2Delete=unlink($targetDir . $old_image_2);
                    $image3Delete=unlink($targetDir . $old_image_3);
                    //add new image
                    move_uploaded_file($_FILES["new_product_image1"]["tmp_name"], $targetFilePath1);
                    move_uploaded_file($_FILES["new_product_image2"]["tmp_name"], $targetFilePath2);
                    move_uploaded_file($_FILES["new_product_image3"]["tmp_name"], $targetFilePath3);
                    $sql="UPDATE `product_table` SET `product_name` = '$new_name', `product_price` = '$new_price', `product_description` = '$new_description', `product_status` = '$new_product_status', `first_image_name` = '$firstNewName', `second_image_name` = '$secondNewName', `third_image_name` = '$thirdNewName' WHERE `product_table`.`product_id` = $productId";
                    $update=mysqli_query($conn,$sql);
                    if($update){
                        ?>
                            <script>
                                window.alert("All images are updated successfully");
                                window.location.href="../vendor.php";
                            </script>
                        
                        <?php
                    }else{
                        ?>
                    
                            <script>
                                window.alert("Coudln't update all images ");
                                window.location.href="../vendor.php";
                            </script>
                    
                        <?php
                    }

                }else{
                    ?>
                        <script>
                            window.alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload the images.Try again");
                            window.location.href="../vendor.php";
                        </script>
                    <?php
                }
            }
            //if first image is changed
            if(!empty($_FILES["new_product_image1"]["name"])){
                //rename image
                $firstImage = $_FILES["new_product_image1"]["name"];
                $fileExt1= explode('.',$firstImage);
                $fileActualExt1=strtolower(end($fileExt1));
                $firstNewName = uniqid('',true).".".$fileActualExt1;
                $targetFilePath1 = $targetDir . $firstNewName; 
                $fileType1 = pathinfo($targetFilePath1,PATHINFO_EXTENSION); 

                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType1, $allowTypes)){
                    //delete old image
                    $image1Delete=unlink($targetDir . $old_image_1);
                    //add new image
                    move_uploaded_file($_FILES["new_product_image1"]["tmp_name"], $targetFilePath1);
                    $sql="UPDATE `product_table` SET `product_name` = '$new_name', `product_price` = '$new_price', `product_description` = '$new_description', `product_status` = '$new_product_status', `first_image_name` = '$firstNewName' WHERE `product_table`.`product_id` = $productId";
                    $update=mysqli_query($conn,$sql);
                    if($update){
                        ?>
                            <script>
                                window.alert("Image 1 is updated successfully");
                                window.location.href="../vendor.php";
                            </script>
                        
                        <?php
                    }else{
                        ?>
                    
                            <script>
                                window.alert("Error,Couldn't update Image 1");
                                window.location.href="../vendor.php";
                            </script>
                    
                        <?php
                    }

                }else{
                    ?>
                        <script>
                            window.alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload for image 1.Try again");
                            window.location.href="../vendor.php";
                        </script>
                    <?php
                }
            }
            //if second image is changed
            if(!empty($_FILES["new_product_image2"]["name"])){
                //rename image
                $secondImage = $_FILES["new_product_image2"]["name"];
                $fileExt2= explode('.',$secondImage);
                $fileActualExt2=strtolower(end($fileExt2));
                $secondNewName = uniqid('',true).".".$fileActualExt2;
                $targetFilePath2 = $targetDir . $secondNewName; 
                $fileType2 = pathinfo($targetFilePath2,PATHINFO_EXTENSION); 

                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType2, $allowTypes)){
                    //delete old image
                    $image2Delete=unlink($targetDir . $old_image_2);
                    //add new image
                    move_uploaded_file($_FILES["new_product_image2"]["tmp_name"], $targetFilePath2);
                    $sql="UPDATE `product_table` SET `product_name` = '$new_name', `product_price` = '$new_price', `product_description` = '$new_description', `product_status` = '$new_product_status', `second_image_name` = '$secondNewName' WHERE `product_table`.`product_id` = $productId";
                    $update=mysqli_query($conn,$sql);
                    if($update){
                        ?>
                            <script>
                                window.alert("Image 2 is updated successfully");
                                window.location.href="../vendor.php";
                            </script>
                        
                        <?php
                    }else{
                        ?>
                    
                            <script>
                                window.alert("Error,Couldn't update Image 2 ");
                                window.location.href="../vendor.php";
                            </script>
                    
                        <?php
                    }

                }else{
                    ?>
                        <script>
                            window.alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload for image 2.Try again");
                            window.location.href="../vendor.php";
                        </script>
                    <?php
                }
            }
            //if third image is changed
            if(!empty($_FILES["new_product_image3"]["name"])){
                //rename image
                $thirdImage = $_FILES["new_product_image3"]["name"];
                $fileExt3= explode('.',$thirdImage);
                $fileActualExt3=strtolower(end($fileExt3));
                $thirdNewName = uniqid('',true).".".$fileActualExt3;
                $targetFilePath3 = $targetDir . $thirdNewName; 
                $fileType3 = pathinfo($targetFilePath3,PATHINFO_EXTENSION); 

                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType3, $allowTypes)){
                    //delete old image
                    $image3Delete=unlink($targetDir . $old_image_3);
                    //add new image
                    move_uploaded_file($_FILES["new_product_image3"]["tmp_name"], $targetFilePath3);
                    $sql="UPDATE `product_table` SET `product_name` = '$new_name', `product_price` = '$new_price', `product_description` = '$new_description', `product_status` = '$new_product_status', `third_image_name` = '$thirdNewName' WHERE `product_table`.`product_id` = $productId";
                    $update=mysqli_query($conn,$sql);
                    if($update){
                        ?>
                            <script>
                                window.alert("Image 3 is updated successfully");
                                window.location.href="../vendor.php";
                            </script>
                        
                        <?php
                    }else{
                        ?>
                    
                            <script>
                                window.alert("Error,Couldn't update Image 3 ");
                                window.location.href="../vendor.php";
                            </script>
                    
                        <?php
                    }

                }else{
                    ?>
                        <script>
                            window.alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload for image 3.Try again");
                            window.location.href="../vendor.php";
                        </script>
                    <?php
                }
            }

     }

   
} 

echo "OKAY";

?>