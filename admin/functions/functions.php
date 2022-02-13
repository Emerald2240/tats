<?php
echo "<script>
function nairaFormat(number) {
    console.log('inside nairaFormat function');
    document.write('₦')
    document.write(number.toLocaleString(undefined , {maximumFractionDigits: 0 }));
    //return ''.formater.format(number);
}

function nairaFormatR(number) {
    console.log('inside nairaFormatR function');
    //window.alert('this should be working');
    amount = number.toLocaleString(undefined, {maximumFractionDigits: 0 });
    return(amount);
}
//window.alert('This naira format function is working');
</script>";

//This starts a session for the entire project
session_start();

//This takes me to any page i want
function gotoPage($location)
{
    header('location:' . $location);
    exit();
}

//This cleans any data i'm accepting. Removing security vulnerabilities and bugs
function Sanitize($data, $case = null)
{
    //This function cleanses and arranges the data about to be stored. like freeing it from any impurities like sql injection
    $result = htmlentities($data, ENT_QUOTES);
    if ($case == 'lower') {
        $result = strtoupper($result);
    } elseif ($case == 'none') {
        //leave it as it is
    } else {
        $result = strtoupper($result);
    }
    return $result;
}

//CREATE start

//this collects and prepares all the data entered for a new post for storage
function processNewProduct($formstream, $editId = null)
{
    //This function processes what user data is being stored and checks if they are accurate or entered at all.
    //It also helps in confirming if what the user entered is Okay, like someone entering two different things in the password and confirm password box
    extract($formstream);
    $noImages = false;

    if (isset($submit)) {

        $datamissing = [];

        if (empty($title)) {
            $datamissing['pt'] = "Missing product title";
        } else {
            $title = trim(Sanitize($title));
        }

        if (empty($price)) {
            $datamissing['p'] = "Missing product price";
        } else {
            $price = htmlentities($price, ENT_QUOTES);
        }

        if (empty($stock)) {
            //$datamissing['st'] = "Missing product stock";
            $stock = 0;
        } else {
            $stock = htmlentities($stock, ENT_QUOTES);
        }


        if (empty($discount)) {
            //$datamissing['d'] = "Missing product discount";
            $discount = 0;
        } else {
            $discount = trim(Sanitize($discount));
        }

        if (empty($tax)) {
            $tax = 0;
            //$datamissing['t'] = "Missing product tax";
        } else {
            $tax = trim(Sanitize($tax));
        }

        if (empty($specsummary)) {
            $datamissing['ss'] = "Missing product spec summary";
        } else {
            $specsummary = trim(Sanitize($specsummary));
        }

        if (empty($specsjson)) {
            $datamissing['fs'] = "Missing product full specs";
        } else {
            $specsjson = htmlentities($specsjson, ENT_QUOTES);
        }

        if (empty($colorsjson)) {
            $datamissing['c'] = "Missing product colors";
        } else {
            $colorsjson = htmlentities($colorsjson, ENT_QUOTES);
        }

        if (empty($categoriesjson)) {
            $datamissing['pc'] = "Missing product categories";
        } else {
            $categoriesjson = htmlentities($categoriesjson, ENT_QUOTES);
        }

        if (empty($features)) {
            $datamissing['pf'] = "Missing product features";
        } else {
            $features = htmlentities($features, ENT_QUOTES);
        }



        //image adding section

        //main image
        if (empty($_FILES['mi']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['mainimage'] = "Missing Main Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['mi']['tmp_name'];

            $tmpfilename = basename($_FILES['mi']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {
                    $imagename = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload';
                    $datamissing['image'] = "Missing Main Product Image";
                }
            } else {
                $datamissing['mainimage'] = "Invalid File Type";
            }
        }

        //side image 1
        if (empty($_FILES['si1']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage1'] = "Missing First Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si1']['tmp_name'];

            $tmpfilename = basename($_FILES['si1']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {



                    $imagename1 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload1';
                    $datamissing['sideimage1'] = "Missing First Side Product Image";
                }
            } else {
                $datamissing['sideimage1'] = "Invalid File Type";
            }
        }

        //side image 2
        if (empty($_FILES['si2']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage2'] = "Missing Second Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si2']['tmp_name'];

            $tmpfilename = basename($_FILES['si2']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {



                    $imagename2 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload2';
                    $datamissing['sideimage2'] = "Missing Second Side Product Image";
                }
            } else {
                $datamissing['sideimage2'] = "Invalid File Type";
            }
        }

        //side image 3
        if (empty($_FILES['si3']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage3'] = "Missing Third Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si3']['tmp_name'];

            $tmpfilename = basename($_FILES['si3']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {

                    $imagename3 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload3';
                    $datamissing['sideimage3'] = "Missing Third Side Product Image";
                }
            } else {
                $datamissing['sideimage3'] = "Invalid File Type";
            }
        }




        if (empty($datamissing)) {

            if (isset($editId)) {
                //if none of the images are touched, use the editProductWithoutImages function, else use the edit all function
                if ($noImages) {
                    editProductWithoutImages($editId, $title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features);
                    // die;
                } else {
                    unlink("../product_images/" . $_SESSION['editImage1']);
                    unlink("../product_images/" . $_SESSION['editImage2']);
                    unlink("../product_images/" . $_SESSION['editImage3']);
                    unlink("../product_images/" . $_SESSION['editImage4']);

                    EditProduct($editId, $title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
                }

                $_SESSION['editproduct'] = null;
            } else {

                AddProduct($title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
                // die;
            }
        } else {
            return $datamissing;
        }
    }
}

//adds the prepared data into the database
function AddProduct($title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $admin = $_SESSION['admin_id'];

    $sql = "INSERT INTO item(title, 	price, stock, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by) VALUES ('$title', '$price', '$stock', '$discount', '$tax', '$specsummary', '$fullspecs', '$colors', '$categories', '$features', '$mi', '$si1', '$si2', '$si3', '$admin')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['ProductJustAdded'] = 1;
        gotoPage("products.php");
    } else {

        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
        die;
    }
    //mysqli_close($db);
}

//CREATE end

//READ start

//admin
function loadProducts()
{
    global $db;
    // $user = $_SESSION['username'];
    // if (!empty($user)) {
    $query = "SELECT id, title, price, stock, sold, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by  FROM item ORDER BY `id` DESC ";
    $response = @mysqli_query($db, $query);
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            adminProductView($row);
            $checker = $row['id'];
        }
        if (empty($checker)) {
            echo '<p class="text-center">No Products Added Yet</p>';
        }
    }
    //}
}

function adminProductView($productsArray)
{
    //id===========================
    echo '<tr><td>';
    echo $productsArray['id'];
    echo '</td>';

    //title============================
    echo  '<td>';
    if ($productsArray['stock'] <= 0) {
        echo '<span class="text-danger">';
    }
    $string = substr($productsArray['title'], 0, 25);
    echo ucwords(strtolower($string));
    if ($productsArray['stock'] == 0) {
        echo '</span>';
    }
    echo '</td>';

    //specification summary
    echo '<td>';
    $string = substr($productsArray['spec_summary'], 0, 25);
    echo $string;
    echo '</td>';

    //price
    echo '<td>';
    echo $productsArray['price'];
    echo '</td>';

    //discount
    echo '<td>';
    echo $productsArray['discount'];
    echo '</td>';

    //tax
    echo '<td>';
    echo $productsArray['tax'];
    echo '</td>';

    //stock
    echo '<td>';
    if ($productsArray['stock'] <= 0) {
        echo '<span class="text-danger">';
    }
    echo $productsArray['stock'];
    if ($productsArray['stock'] == 0) {
        echo '</span>';
    }
    echo '</td>';

    //How many sold
    echo '<td>';
    echo $productsArray['sold'];
    echo '</td>';

    //created by
    echo '<td>';
    echo $productsArray['created_by'];
    echo '</td>';

    //edit
    echo '<td>';
    echo '<a href="newproduct.php?id=';
    echo $productsArray['id'];

    echo '&title=';
    echo ucwords(strtolower($productsArray['title']));

    echo '&specsummary=';
    echo ucwords(strtolower($productsArray['spec_summary']));

    echo '&features=';
    echo ucwords(strtoupper($productsArray['features']));

    echo '&price=';
    echo ucwords(strtoupper($productsArray['price']));

    echo '&discount=';
    echo ucwords(strtoupper($productsArray['discount']));

    echo '&tax=';
    echo ucwords(strtoupper($productsArray['tax']));

    echo '&stock=';
    echo ucwords(strtoupper($productsArray['stock']));

    echo '&image1=';
    echo ucwords(strtoupper($productsArray['main_img']));

    echo '&image2=';
    echo ucwords(strtoupper($productsArray['side_img1']));

    echo '&image3=';
    echo ucwords(strtoupper($productsArray['side_img2']));

    echo '&image4=';
    echo ucwords(strtoupper($productsArray['side_img3']));

    //json class
    echo '&fullspec=';
    echo ($productsArray['full_spec']);

    echo '&colors=';
    echo ($productsArray['colors']);

    echo '&categories=';
    echo ($productsArray['categories']);
    //json class


    echo '&edit=1';

    echo '">';
    echo '<i class="fa fa-edit"></i></a></td>';


    //delete
    echo '<td><a href="deleteproduct.php?id=';
    echo $productsArray['id'];

    echo '&image1=';
    echo ucwords(strtoupper($productsArray['main_img']));

    echo '&image2=';
    echo ucwords(strtoupper($productsArray['side_img1']));

    echo '&image3=';
    echo ucwords(strtoupper($productsArray['side_img2']));

    echo '&image4=';
    echo ucwords(strtoupper($productsArray['side_img3']));

    echo '"';
    echo '><i class="fa fa-trash"></i></a></td>';

    echo '</tr>';

    return true;
}

//shows all the entries in the datamissing array or just a success message if everything went well
function showDataMissing($datamissing, $showSuccess = null)
{
    //this function checks if the datamissing array passed in is empty. if it isnt it prints out all of its contents. if it is empty nothing happens
    if (isset($datamissing)) {
        foreach ($datamissing as $miss) {

            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Holy guacamole!</strong> Your username or password are incorrect.
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //       <span aria-hidden="true">&times;</span>
            //     </button>
            //   </div>';


            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Holy guacamole! </strong>' . $miss . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';

            // echo '<p class="text-danger">';
            // echo $miss;
            // echo '</p>';
        }
    } elseif (isset($showSuccess)) {
        // echo '<p class="text-success">';
        // echo "Successful";
        // echo '</p>';

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Holy guacamole! </strong> Successful
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}

//READ end


// UPDATE start

function EditProduct($id, $title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `title` = '$title', `price` = '$price',  `stock` = '$stock', `discount` = '$discount', `tax` = '$tax', `spec_summary` = '$specsummary', `full_spec` = '$fullspecs', `colors` = '$colors', `categories` = '$categories', `features` = '$features', `main_img` = '$mi', `side_img1` = '$si1', `side_img2` = '$si2', `side_img3` = '$si3' WHERE `item`.`id` = $id ";
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editproduct'] = null;
        gotoPage("products.php");
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function editProductWithoutImages($id, $title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features)
{

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `title` = '$title', `price` = '$price',  `stock` = '$stock', `discount` = '$discount', `tax` = '$tax', `spec_summary` = '$specsummary', `full_spec` = '$fullspecs', `colors` = '$colors', `categories` = '$categories', `features` = '$features' WHERE `item`.`id` = $id ";
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editproduct'] = null;
        gotoPage("products.php");
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

//UPDATE end

//DELETE start

function deleteProduct($id, $imagename, $imagename1, $imagename2, $imagename3)
{
    global $db;

    //This sql statement deletes the course with the mentioned id
    $sql = "DELETE FROM `item`  WHERE item.id = '$id' ";
    if (mysqli_query($db, $sql)) {

        unlink("../product_images/" . $imagename);
        unlink("../product_images/" . $imagename1);
        unlink("../product_images/" . $imagename2);
        unlink("../product_images/" . $imagename3);

        //echo "Course Saved";
        //echo '<p class="text-success">';
        //echo "Course deleted";
        //echo '</p>';
        gotoPage('products.php');
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}


//DELETE end

//checks if the input mail exists in the admins database. if it exists return false, if not return true
function validateMailAddress($email)
{
    global $db;
    $sql = "SELECT * FROM `admins` WHERE `email`='$email'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($email == isset($result['email'])) {
            //echo 'email exists';
            return false;
        } else {
            //echo 'email doesnt exist';
            return true;
        }
    } else {
        //echo 'email definitely doesnt exist';
        return true;
    }
}

function processNewAdmin($formstream, $editId = null)
{
    //This function processes what user data is being stored and checks if they are accurate or entered at all.
    //It also helps in confirming if what the user entered is Okay, like someone entering two different things in the password and confirm password box
    extract($formstream);

    if (isset($submit)) {

        $datamissing = [];

        //firstname
        if (empty($firstname)) {
            $datamissing['firstname'] = "Missing First Name";
        } else {
            $firstname = trim(Sanitize($firstname));
        }

        //lastname
        if (empty($lastname)) {
            $datamissing['lastname'] = "Missing Last Name";
        } else {
            $lastname = trim(Sanitize($lastname));
        }

        // //facebook
        // if (empty($facebook)) {
        //     $datamissing['facebook'] = "Missing facebook profile page";
        // } else {
        //     $facebook = trim(Sanitize($facebook));
        // }

        // //twitter
        // if (empty($twitter)) {
        //     $datamissing['twitter'] = "Missing twitter page";
        // } else {
        //     $twitter = trim(Sanitize($twitter));
        // }

        // //instagram
        // if (empty($instagram)) {
        //     $datamissing['instagram'] = "Missing instagram page";
        // } else {
        //     $instagram = trim(Sanitize($instagram));
        // }

        // //linkedin
        // if (empty($linkedin)) {
        //     $datamissing['linkedin'] = "Missing Linkedin page";
        // } else {
        //     $linkedin = trim(Sanitize($linkedin));
        // }

        //email address
        if (empty($email)) {
            $datamissing['email'] = "Missing email Address";
        } else {
            $email = trim(Sanitize($email));
            if (!validateMailAddress($email)) {
                $datamissing['email'] = "Email already exists";
            }
        }
        //phone number
        // if (empty($phone)) {
        //     $datamissing['phone'] = "Phone Number";
        // } else {
        //     $phone = trim(Sanitize($phone));
        // }


        if (empty($password)) {
            $datamissing['password'] = "Missing Password";
        } else {
            $password = trim(Sanitize($password));
        }

        if (empty($password1)) {
            $datamissing['confpass'] = "Missing Confirm Password";
        } else {
            $password1 = trim(Sanitize($password1));
            if ($password != $password1) {
                $datamissing['confpass'] = "Password Mismatch";
            } else {
                // $password1 = trim(Sanitize($password1));
                $password = sha1($password);
            }
        }

        if (empty($datamissing)) {

            //addRegistered($firstname, $lastname, $email, $password, $facebook, $twitter, $linkedin, $instagram);
            addRegistered($firstname, $lastname, $email, $password);
        } else {
            return $datamissing;
        }
    }
}

function addRegistered($fname, $lname, $em, $pass)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $sql = "INSERT INTO admins(  	firstname, 	lastname,	email, 	password) VALUES ('$fname', '$lname', '$em', '$pass')";

    if (mysqli_query($db, $sql)) {
        $_SESSION['registered'] = "true";
        gotoPage("login.php");
        //echo "New record created successfully";
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function processLogin($formstream)
{
    //This simply queries the database to see if the users data is really available then sets the users data to a session to show theyve logged in
    extract($formstream);
    global $db;


    if (isset($submit)) {
        // username and password sent from form 

        $myusername = Sanitize($email);
        $mypassword = trim(Sanitize($password));
        $mypassword = sha1($mypassword);

        $result = mysqli_query($db, "SELECT * FROM admins WHERE email ='$myusername' AND password = '$mypassword'      ");

        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();

            $_SESSION['username'] = ucwords(strtolower($result['firstname'])) . " " . ucwords(strtolower($result['lastname']));
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['lastname'] = $result['lastname'];
            $_SESSION['admin_id'] = $result['id'];

            //$_SESSION['datejoined'] = $result['datejoined'];
            $_SESSION['email'] = $result['email'];
            //$_SESSION['phone'] = $result['phone'];
            // $_SESSION['profilepic'] = $result['profilepic'];

            $_SESSION['log'] = "true";


            //print_r($formstream);
            //die;

            //This is the line of code for saving cookies AKA remember me

            // if (isset($remember)) {
            if ($remember == true) {
                //die;
                setcookie("mem_mail",  $_SESSION['email'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_pass", $password, time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_sele",  $_SESSION['admin_id'], time() + (10 * 365 * 24 * 60 * 60));
            } else {
                if (isset($_COOKIE['mem_log'])) {
                    setcookie('mem_log', '');
                }
                setcookie("mem_mail",  $_SESSION['email'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_pass", '', time() + (10 * 365 * 24 * 60 * 60));
            }



            // echo "<pre>";
            // print_r($_COOKIE);
            // die;

            // echo "<br>";
            // echo 'Logged In';
            // echo "<pre>";
            // print_r($result);
            gotoPage('index.php');
        } else {

            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Holy guacamole!</strong> Your username or password are incorrect.
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //       <span aria-hidden="true">&times;</span>
            //     </button>
            //   </div>';
            $datamissing['login_error'] = 'Your email or password are incorrect.';
            return $datamissing;
        }
    }
}

function validateResetCode($code)
{
    global $db;
    $sql = "SELECT * FROM `resetpassword` WHERE `code`='$code'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($code == isset($result['code'])) {
            //echo 'code exists';
            $_SESSION['resetMail'] = $result['email'];
            return true;
        } else {
            //echo 'code doesnt exist';
            return false;
        }
    } else {
        //echo 'code definitely doesnt exist';
        return false;
    }
}

function addNewResetData($code, $email)
{

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "INSERT INTO resetpassword(  	email, 	code 	) VALUES ('$email', '$code')";
    $_SESSION['resetMail'] = strtoupper($email);
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //gotoPage("login.php");
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function ResetPassword($formstream)
{
    extract($formstream);

    if (isset($submit)) {

        $datamissing = [];

        if (empty($pass1)) {
            $datamissing['password'] = "Missing Password";
        } else {
            $password = trim(Sanitize($pass1));
        }

        if (empty($pass2)) {
            $datamissing['password2'] = "Missing Confirm Password";
        } else {
            $password1 = trim(Sanitize($pass2));
            if ($password != $password1) {
                $datamissing['confpass'] = "Password Mismatch";
            } else {
                // $password1 = trim(Sanitize($password1));
                $password = sha1($password);
            }
        }

        if (empty($datamissing)) {
            if (isset($_SESSION['resetMail'])) {
                setNewPassword($_SESSION['resetMail'], $password);
                deleteResetPassword($_SESSION['resetMail']);
            } else {
                $datamissing['Reset Email'] = "Email not found";
                return $datamissing;
            }
            //addRegistered($firstname, $lastname, $email, $password, $facebook, $twitter, $linkedin, $instagram);
        } else {
            return $datamissing;
        }
    }
}

function setNewPassword($email, $password)
{
    $email = strtoupper($email);
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `admins` SET `password` = '$password' WHERE `admins`.`email` = '$email'";

    if (mysqli_query($db, $sql)) {
        echo 'password updated';
        //gotoPage("login.php");
    } else {
        echo 'admins password not updated';
        echo  "<br>" . "Error: " . mysqli_error($db);
    }
    //mysqli_close($db);
}

function deleteResetPassword($email)
{
    global $db;
    $email = strtoupper($email);
    $sql2 = "DELETE FROM `resetpassword` WHERE `resetpassword`.`email` = '$email'";

    if (mysqli_query($db, $sql2)) {
        gotoPage("login.php");
    } else {
        echo '<br>';
        echo 'reset password not deleted';
        echo  "<br>" . "Error: " . mysqli_error($db);
    }
    //mysqli_close($db);
}


function getAdminName()
{
    $id = $_SESSION['admin_id'];
    global $db;

    $query = "SELECT lastname, firstname FROM admins WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                echo ucwords(strtolower($row['lastname']));
                echo " ";
                echo ucwords(strtolower($row['firstname']));
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
}

function loadAdmins()
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT id, firstname, lastname, email, joined FROM admins ORDER BY `id` DESC ";
    $response = @mysqli_query($db, $query);

    if ($response) {

        while ($row = mysqli_fetch_array($response)) {

            //$query2 = "SELECT profilepic FROM users WHERE emailaddress = '$master' ";

            echo '<tr><td>';
            echo $row['id'];
            echo '</td>';

            echo  '<td>';
            //echo '<a href="admin_details.php?id=';
            //echo $row['id'];
            //echo '"> ';
            echo ucwords(strtolower($row['firstname']));
            //echo '</a>';
            echo '</td>';

            echo '<td>';
            echo ucwords(strtolower($row['lastname']));
            echo '</td>';


            echo '<td>';
            echo ucwords(strtolower($row['email']));
            echo '</td>';

            echo '<td>';
            echo $row['joined'];
            echo '</td>';




            // echo '<td><a href="new_exam.php?id=';
            // echo $row['id'];
            // echo '&coursename=';
            // echo ucwords(strtolower($row['title']));
            // echo '"><i class="fa fa-plus"></i></a></td>';

            // echo '<td><a href="edit_admin.php?id=';
            // echo $row['id'];
            // echo '"';
            // echo '>';
            // echo '<i class="fa fa-edit"></i></a></td>';


            if ($row['id'] == 1 || $row['id'] == 6) {
                echo '<td></td>';
            } else {
                echo '<td><a href="delete_admin.php?id=';
                echo $row['id'];
                echo '"';
                // echo 'data-toggle="modal" data-target="#deleteModal"';
                echo '><i class="fa fa-trash"></i></a></td>';
            }

            echo '</tr>';
        }
    } else {
        echo '<tr>Though Impossible, there are no admins yet</tr>';
    }
}

function deleteAdmin($id)
{
    global $db;
    if ($id == 1) {
        header("location:admins.php");
    } else {
        //This sql statement deletes the course with the mentioned id
        $sql = "DELETE FROM `admins`  WHERE admins.id = '$id' ";
        if (mysqli_query($db, $sql)) {
            header("location:admins.php");
        } else {
            //header("location:course_detail.php?exam_id=$id&coursename=$course");
            header("location:courses.php");
        }
    }
    //mysqli_close($db);
}

function findActivePage($pages)
{
    for ($i = 0; $i < count($pages); $i++) {

        if (strpos($_SERVER["PHP_SELF"], $pages[$i])) {
            echo 'active';
        }
    }
}

//this is the paystack javascript code containing all the functions it needs, including the API keys. For security reasons, it has to be echoed from here.
function loadPaystackCode()
{
    $paystackCode = "<script>
    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener('submit', payWithPaystack, false);

    function payWithPaystack(e) {

        e.preventDefault();

        let handler = PaystackPop.setup({
            //email: document.getElementById('email-address').value,
            email: 'nomail@mail.com',

            //amount: document.getElementById('amount').value * 100,
            amount: getGrossTotalPrice() * 100,

            // ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you

            // label: 'Customer'

            onClose: function() {

                //alert('Window closed.');

            },

            callback: function(response) {

                let message = 'Payment complete! Reference: ' + response.reference;
                //clearProductTable();
                //deleteAllCartItems();
                window.location = 'admin/verify_transaction.php?reference=' + response.reference + '&cart=' + getJsonFromObject(getProductsInLocalStorage());
                //alert(message);

            }

        });

        handler.openIframe();

        }</script>";

    return $paystackCode;
}

//after a user finishes paying, another page opens('verify_transaction.php') that makes sure we received the payment. if yes it takes us to the payment confirmed page('payment_confirmed.php').
function verifyPayment()
{
    if (isset($_GET['reference'])) {
        $reference = $_GET['reference'];
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(

        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_ENCODING => "",

        CURLOPT_MAXREDIRS => 10,

        CURLOPT_TIMEOUT => 30,

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        CURLOPT_CUSTOMREQUEST => "GET",

        CURLOPT_HTTPHEADER => array(

            

            "Cache-Control: no-cache",

        ),

    ));



    $response = curl_exec($curl);

    $err = curl_error($curl);

    curl_close($curl);



    if ($err) {

        echo "cURL Error #:" . $err;
    } else {

        $number = rand(100, 100000);
        $t = time();
        $random = $number . '' . $t;



        // $response = '{
        //     "status": true,
        //     "message": "Verification successful",
        //     "data": {
        //       "id": ' . $random . '6,
        //       "domain": "test",
        //       "status": "success",
        //       "reference": "nms6uvr1pl",
        //       "amount": 15600,
        //       "message": null,
        //       "gateway_response": "Successful",
        //       "paid_at": "2022-01-19T12:30:56.000Z",
        //       "created_at": "2022-01-19T12:26:44.000Z",
        //       "channel": "card",
        //       "currency": "NGN",
        //       "ip_address": "154.118.28.239",
        //       "metadata": "",
        //       "log": {
        //         "start_time": 1589891451,
        //         "time_spent": 6,
        //         "attempts": 1,
        //         "errors": 0,
        //         "success": true,
        //         "mobile": false,
        //         "input": [],
        //         "history": [
        //           {
        //             "type": "action",
        //             "message": "Attempted to pay with card",
        //             "time": 5
        //           },
        //           {
        //             "type": "success",
        //             "message": "Successfully paid with card",
        //             "time": 6
        //           }
        //         ]
        //       },
        //       "fees": 300,
        //       "fees_split": {
        //         "paystack": 300,
        //         "integration": 40,
        //         "subaccount": 19660,
        //         "params": {
        //           "bearer": "account",
        //           "transaction_charge": "",
        //           "percentage_charge": "0.2"
        //         }
        //       },
        //       "authorization": {
        //         "authorization_code": "AUTH_xxxxxxxxxx",
        //         "bin": "408408",
        //         "last4": "4081",
        //         "exp_month": "12",
        //         "exp_year": "2020",
        //         "channel": "card",
        //         "card_type": "visa DEBIT",
        //         "bank": "Test Bank",
        //         "country_code": "NG",
        //         "brand": "visa",
        //         "reusable": true,
        //         "signature": "SIG_xxxxxxxxxxxxxxx",
        //         "account_name": null
        //       },
        //       "customer": {
        //         "id": 24259516,
        //         "first_name": null,
        //         "last_name": null,
        //         "email": "customer@email.com",
        //         "customer_code": "CUS_xxxxxxxxxxx",
        //         "phone": null,
        //         "metadata": null,
        //         "risk_action": "default"
        //       },
        //       "plan": null,
        //       "order_id": null,
        //       "paidAt": "2020-05-19T12:30:56.000Z",
        //       "createdAt": "2020-05-19T12:26:44.000Z",
        //       "requested_amount": 20000,
        //       "transaction_date": "2020-05-19T12:26:44.000Z",
        //       "plan_object": {},
        //       "subaccount": {
        //         "id": 37614,
        //         "subaccount_code": "ACCT_xxxxxxxxxx",
        //         "business_name": "Cheese Sticks",
        //         "description": "Cheese Sticks",
        //         "primary_contact_name": null,
        //         "primary_contact_email": null,
        //         "primary_contact_phone": null,
        //         "metadata": null,
        //         "percentage_charge": 0.2,
        //         "settlement_bank": "Guaranty Trust Bank",
        //         "account_number": "0123456789"
        //       }
        //     }
        //   }';
        //echo '<pre>';
        //echo $response;
        if (isset($_GET['cart'])) {
            $cart = $_GET['cart'];
        } else {
            $cart = null;
        }

        processVerifyTransactionResult($response, $cart);
    }
}

//This is the real function that confirms if the payment went through by reading through a paystack API response
function processVerifyTransactionResult($response, $cart)
{
    $phpclassresponse = json_decode($response, true);

    $status = $phpclassresponse['data']['status'];
    $redeem_code = $phpclassresponse['data']['id'];
    $amount = $phpclassresponse['data']['amount'];
    $channel = $phpclassresponse['data']['channel'];
    $ip = $phpclassresponse['data']['ip_address'];
    $paid_at = $phpclassresponse['data']['paid_at'];
    $created_at = $phpclassresponse['data']['created_at'];
    $fees = $phpclassresponse['data']['fees'];
    $full_transaction_info_json = json_encode($phpclassresponse);

    // echo '<pre>';
    // print_r($phpclassresponse);
    // gotoPage('payment_confirmed.php?redeem_code=' . $phpclassresponse['message']);

    //$phpclassresponse['status'] === 'false' 
    if ($phpclassresponse['data']['status'] === 'success') {
        addTransactionDetail($status, $redeem_code, $cart, $amount, $channel, $ip, $paid_at, $created_at, $fees, $full_transaction_info_json);
    } else {
        gotoPage('../index.php');
    }
}

//This function stores the paystack API response(including the redeem code(message)) into the database for future reference.
function addTransactionDetail($status, $redeem_code, $cart_items, $amount, $channel, $ip, $paid_at, $created_at, $fees, $full_transaction_info_json)
{
    $cart_items_decoded = json_decode($cart_items, true);

    for ($i = 0; $i < sizeof($cart_items_decoded); $i++) {
        $id = $cart_items_decoded[$i]['id'];
        $quantity = $cart_items_decoded[$i]['quantity'];
        updateStockAndSold($id, $quantity);
    }

    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $sql = "INSERT INTO transactions(status, redeem_code, cart_items, 	amount, 	channel, 	ip, 	paid_at, 	created_at, 	fees, full_transaction_info_json) VALUES ('$status', '$redeem_code', '$cart_items', '$amount', '$channel', '$ip', '$paid_at', '$created_at', '$fees', '$full_transaction_info_json')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['ProductJustAdded'] = 1;
        //gotoPage("products.php");
        gotoPage('payment_confirmed.php?redeem_code=' . $redeem_code);
    } else {
        // echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
        // die;
    }
    //mysqli_close($db);
}

function updateStockAndSold($id, $quantity)
{
    //this gets the previous stock of the item and subtracts the current quantity being bought
    $oldStock = getCurrentStock($id);
    $newStock = $oldStock - $quantity;
    if ($newStock < 0) {
        $newStock = 0;
    }

    //this gets the previous sold amount of the item and adds the current quantity being bought
    $oldSold = getCurrentSold($id);
    $newSold = $oldSold + $quantity;


    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `stock` = '$newStock', `sold` = '$newSold' WHERE `item`.`id` = '$id' ";

    if (mysqli_query($db, $sql)) {
        return true;
        //gotoPage('../product_summary.php?fin=true');
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function getCurrentStock($id)
{
    global $db;

    //get current stock
    $oldStock = 0;

    $query = "SELECT stock FROM item WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $oldStock = $row['stock'];
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
    return $oldStock;
}

function getCurrentSold($id)
{
    global $db;

    //get current sold items
    $oldSold = 0;

    $query = "SELECT sold FROM item WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $oldSold = $row['sold'];
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
    return $oldSold;
}

//This function adds some extra details to the transaction table. these details are name and phone number which are not compulsory
function UpdateTransactionDetail($redeem_code, $name, $phone)
{
    $name = trim(Sanitize($name));
    $phone = trim(Sanitize($phone));

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `transactions` SET `customer_name` = '$name', `customer_phone` = '$phone' WHERE `transactions`.`redeem_code` = '$redeem_code' ";

    if (mysqli_query($db, $sql)) {
        gotoPage('../product_summary.php?fin=true');
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function processRedeemCode($formstream)
{
    //This simply queries the database to see if the users data is really available then sets the users data to a session to show theyve logged in
    extract($formstream);
    global $db;


    if (isset($submit)) {

        $result = mysqli_query($db, "SELECT * FROM transactions WHERE redeem_code ='$redeem_code' AND status = 'success' ORDER BY `id` DESC      ");

        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();

            $_SESSION['username'] = $result['id'];

            if ($result['redeemed'] == 0) {
                gotoPage('showcart.php?redeem_id=' . $result['id'] . '&' . 'redeem_code=' . $result['redeem_code'] . '&' . 'customer_name=' . $result['customer_name'] . '&' . 'customer_phone=' . $result['customer_phone'] . '&' . 'cart=' . $result['cart_items']);
            } else {
                $datamissing['redeem_error'] = 'Items have already been redeemed by the customer';
                return $datamissing;
            }
        } else {

            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Holy guacamole!</strong> Your username or password are incorrect.
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //       <span aria-hidden="true">&times;</span>
            //     </button>
            //   </div>';
            $datamissing['redeem_error'] = 'Redeem code is Invalid';
            return $datamissing;
        }
    }
}

function layoutCart($jsonCart)
{
    $phpClassCart = json_decode($jsonCart, true);
    $itemsCount = count($phpClassCart);
    $confirmed = true;
    $total = 0;

    for ($i = 0; $i < $itemsCount; $i++) {
        $id = $phpClassCart[$i]['id'];
        $price = $phpClassCart[$i]['price'];
        $discount = $phpClassCart[$i]['discount'];
        $title = $phpClassCart[$i]['title'];
        $quantity = $phpClassCart[$i]['quantity'];
        $tax = $phpClassCart[$i]['tax'];
        $temptotal = ($price - $discount + $tax) * $quantity;
        $total += $temptotal;

        if (confirmItemData($id, $price, $discount, $tax) == true) {
            echo ' <tr>
            <td>' . $quantity . '</td>
            <td>' . $title . '</td>
            <td class="text-success">' . $temptotal . '</td>
            <td>' . getRealItemPrice($id, $quantity) . '</td>
        </tr>';
        } else {
            echo ' <tr>
           
            <td>' . $quantity . '</td>
            <td>' . $title . '</td>
            <td class="text-danger">' . $temptotal . '</td>
            <td>' . getRealItemPrice($id, $quantity) . '</td>
        </tr>';
        }
    }
}

function getCartBasicInfo($jsonCart)
{
    $phpClassCart = json_decode($jsonCart, true);
    $itemsCount = count($phpClassCart);
    $confirmed = true;
    $total = 0;

    echo ' <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="h4 mb-0 text-gray-800">Number of Items:  ' . $itemsCount . '</h3></div>';

    for ($i = 0; $i < $itemsCount; $i++) {
        $id = $phpClassCart[$i]['id'];
        $price = $phpClassCart[$i]['price'];
        $discount = $phpClassCart[$i]['discount'];
        $title = $phpClassCart[$i]['title'];
        $quantity = $phpClassCart[$i]['quantity'];
        $tax = $phpClassCart[$i]['tax'];
        $temptotal = ($price - $discount + $tax) * $quantity;
        $total += $temptotal;

        if (confirmItemData($id, $price, $discount, $tax) == true) {
        } else {
            $confirmed = false;
        }
    }

    if ($confirmed == true) {
        echo '<div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h3 class="h4 mb-0 text-success">Total paid: ' . $total . '</h3>
         </div>';
    } else {
        echo '<div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h3 class="h4 mb-0 text-danger">Total paid: ' . $total . '</h3>
         </div>';
    }
}

function confirmItemData($id, $price, $discount, $tax)
{
    global $db;
    $sql = "SELECT * FROM `item` WHERE `id`='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($price == $result['price'] && $tax == $result['tax'] && $discount == $result['discount']) {
            //nothing has been tampered with
            return true;
        } else {
            //something is wrong somewhere
            //return $result['price'] + $result['tax'] - $result['discount'];
            return false;
        }
    } else {
        //something is definitely wrong somewhere;
        return false;
    }
}

function getRealItemPrice($id, $quantity)
{
    global $db;
    $sql = "SELECT * FROM `item` WHERE `id`='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        return ($result['price'] - $result['discount'] + $result['tax']) * $quantity;
    } else {
        //something is definitely wrong somewhere;
        return 0;
    }
}

function finish_redeem($redeem_id)
{
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `transactions` SET `redeemed` = 1 WHERE `transactions`.`id` = '$redeem_id' ";

    if (mysqli_query($db, $sql)) {
        gotoPage('redeem.php');
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

function loadProductTitle($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT title FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['title'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getProductTitle($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT title FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['title'];
        }
    } else {
        echo $id;
        echo 'Error! Meta title Not found.';
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);

        //die;
    }
}

function getProductPrice($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT price FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['price'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getProductSpec_summary($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT spec_summary FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['spec_summary'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getProductMainImage($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT main_img FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['main_img'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadSpecSummary($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT spec_summary FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['spec_summary'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductImage1($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT main_img FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['main_img'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductImage2($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT side_img1 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img1'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductImage3($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT side_img2 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img2'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductImage4($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT side_img3 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img3'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadFullSpecs($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT full_spec FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $fullspecs = json_decode(html_entity_decode($row['full_spec']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);
            for ($i = 0; $i < count($fullspecs); $i++) {
                echo '<tr class="techSpecRow">';
                echo '<td class= "techSpecTD1">' . $fullspecs[$i]["title"] . '</td>';
                echo '<td class = "techSpecTD2">' . $fullspecs[$i]["value"] . '</td>';
                echo '</tr>';
            }

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductColors($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT colors FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $colors = json_decode(html_entity_decode($row['colors']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);
            for ($i = 0; $i < count($colors); $i++) {
                echo '<tr class="techSpecRow">';
                echo '<td class= "techSpecTD1">' . $colors[$i]["title"] . '</td>';
                // echo '<td class = "techSpecTD2">' . $colors[$i]["value"] . '</td>';
                echo '</tr>';
            }

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductFeatures($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT features FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['features'];

            //echo html_entity_decode( ucwords(strtolower($row['features'])));
            echo html_entity_decode(ucwords($row['features']));
            //echo ucwords(strtolower($string));
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductsWithCategories($category)
{
    //this loads up all the latest products in the database
    global $db;

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['side_img3'];
            if (!validateProductCategory($category, html_entity_decode($row['categories']))) {
            } else {
                echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
        </li>';
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductsWithCategoriesBlock($category)
{


    //this loads up all the latest products in the database
    global $db;

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['side_img3'];
            // if($category != 'ALL'){

            if (!validateProductCategory($category, html_entity_decode($row['categories']))) {
            } else {
                echo '
    <div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			
		</form>
	</div>
    </div><hr class="soft" />';
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadProductCartInfo($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT * FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            echo "getProductData('";

            echo $row['main_img'];
            echo "', ";

            echo $row['discount'];
            echo ", '";

            echo $row['title'];
            echo "', ";

            echo $row['price'];
            echo ", ";

            echo  $row['id'];
            echo ", ";

            echo 1;
            echo ", ";

            echo $row['tax'];

            echo ");";

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function returnProductCartInfo($id)
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    $query = "SELECT * FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $jsCartFunction = "getProductData('" . $row['main_img'] . "', " . $row['discount'] . ", '" . $row['title'] . "', " . $row['price'] . ", " .  $row['id'] . ", " . 1 . ", " . $row['tax'] . ');"';

            return $jsCartFunction;
            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

//frontend
function loadLatestProducts($id = null)
{
    //this loads up all the latest products in the database
    global $db;
    if ($_SERVER["PHP_SELF"] == '/tats/index.php') {
        $itemLimit = 10;
    } else {
        $itemLimit = 10000;
    }


    $query = "SELECT * FROM item ORDER BY created desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if ($row['stock'] > 0) {
                    if ($row['id'] == $id) {
                    } else {
                        echo ' <li class="span3">
            <div class="thumbnail">
                <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                <div class="caption">
                    <h5>' . $row['title'] . '</h5>
                    <p>' . $row['spec_summary'] . '
                    </p>

                    <h4 style="text-align:center">
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
                </div>
            </div>
        </li>';
                    }
                } //end of stock checker
            }
        } else {
            $count = 0;

            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if ($count != $itemLimit) {
                        //echo $row['side_img3'];

                        echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
    </li>';
                        $count++;
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

//frontend
function loadLatestProductsBlock($id = null)
{

    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    if ($_SERVER["PHP_SELF"] == '/tats/index.php') {
        $itemLimit = 10;
    } else {
        $itemLimit = 10000;
    }

    $query = "SELECT * FROM item ORDER BY created desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {

        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if ($row['stock'] > 0) {

                    if ($row['id'] == $id) {
                    } else {
                        echo '
                    <hr class="soft" /><div class="row">
                    <div class="span2">
                    <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>	</div>
                    <div class="span4">
                    <h3>' . $row['title'] . '</h3>
                        <hr class="soft" />
                        <p>' . $row['spec_summary'] . '
                                </p>
                        <a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
                        <br class="clr" />
                    </div>
                    <div class="span3 alignR">
                            <h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
                    </div>
                    </div>';
                    }
                } //end of stock checker
            }
        } else {
            $count = 0;
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if ($count != $itemLimit) {
                        echo '
    <hr class="soft" /><div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			<div class="btn-group">
                
               
			</div>
		</form>
	</div>
    </div>';
                        $count++;
                    }

                    // echo '<a class="btn btn-large btn-primary" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a> <a href="product_summary.php?id=' . $row['id'] . '" class="btn btn-large"> Go to <i class=" icon-shopping-cart"></i></a>';
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadRelatedProducts($id)
{
    global $db;
    $productsArray = getIdsOfProductsUnderCategories(getParticularProductCategories($id), $id);

    $query = "SELECT * FROM item ORDER BY updated desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if (in_array($row['id'], $productsArray)) {
                        //echo $row['side_img3'];

                        echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
    </li>';
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadRelatedProductsBlock($id)
{
    global $db;
    $productsArray = getIdsOfProductsUnderCategories(getParticularProductCategories($id), $id);

    $query = "SELECT * FROM item ORDER BY updated desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if (in_array($row['id'], $productsArray)) {
                        //echo $row['side_img3'];

                        echo '
    <hr class="soft" /><div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			<div class="btn-group">
                
               
			</div>
		</form>
	</div>
    </div>';
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getAllProductCategories()
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;
    $allCategories = [];
    $query = "SELECT categories FROM item";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $categories = json_decode(html_entity_decode($row['categories']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);

            array_push($allCategories, $categories);

            //echo html_entity_decode($row['full_spec']);
        }
        //    echo '<pre>';
        //    print_r($allCategories);
        return $allCategories;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getParticularProductCategories($id)
{
    global $db;
    $allCategories = [];
    $query = "SELECT categories FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $categories = json_decode(html_entity_decode($row['categories']), true);
        }
        return $categories;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function getIdsOfProductsUnderCategories($categories, $parentId)
{

    //this loads up all the latest products in the database
    global $db;
    $idsOfProductsUnderCategory = [];

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    for ($i = 0; $i < count($categories); $i++) {
        if ($response) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if (validateProductCategory($categories[$i]['title'], html_entity_decode($row['categories']))) {
                    if (!in_array($row['id'], $idsOfProductsUnderCategory) && $row['id'] != $parentId) {
                        array_push($idsOfProductsUnderCategory, $row['id']);
                    }
                }
            }
        } else {
            echo 'Error! Not found.';
            die;
        }
    }
    return $idsOfProductsUnderCategory;
}

function formatAllProductCategories($allCategories)
{
    $allCategoriesFormatted = [];
    for ($i = 0; $i < count($allCategories); $i++) {
        for ($j = 0; $j < count($allCategories[$i]); $j++) {

            if (in_array($allCategories[$i][$j]['title'], $allCategoriesFormatted) == false) {
                array_push($allCategoriesFormatted, $allCategories[$i][$j]['title']);
            }
        }
    }
    // echo '<pre>';
    //print_r($allCategoriesFormatted);
    sort($allCategoriesFormatted, SORT_DESC);

    return $allCategoriesFormatted;
}

function loadCategories()
{
    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }

        echo '<li><a class="' . $active . '" href="products.php?category=' . $allCategories[$i] . '"><i class="icon-chevron-right"></i>' . $allCategories[$i] . ' [' . numberOfProductsUnderCategory($allCategories[$i]) . ']</a></li>';
    }
}

function numberOfProductsUnderCategory($category)
{
    $allCategories = getAllProductCategories();
    $count = 0;
    for ($i = 0; $i < count($allCategories); $i++) {
        for ($j = 0; $j < count($allCategories[$i]); $j++) {
            //array_push($allCategoriesFormatted, $allCategories[$i][$j]['title']);
            if ($category == $allCategories[$i][$j]['title']) {
                $count++;
            }
        }
    }
    //echo '<pre>';
    //print_r($allCategoriesFormatted);
    return $count;
}

function validateProductCategory($category, $categoryjson)
{
    $productCategories = json_decode($categoryjson, true);
    $result = false;
    for ($i = 0; $i < count($productCategories); $i++) {
        //array_push($allCategoriesFormatted, $allCategories[$i][$j]['title']);
        //if (in_array($category, $productCategories[$i])) {
        if ($category == $productCategories[$i]['title']) {
            $result = true;
        }
    }
    //echo $result;
    return $result;
}

function getTotalNumberOfProducts()
{
    global $db;
    $allProducts = 0;
    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $allProducts++;
        }
        return $allProducts;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

function loadTopBarCategories()
{

    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }

        echo '<li><a class="" href="products.php?category=' . $allCategories[$i] . '">' . $allCategories[$i] . ' [' . numberOfProductsUnderCategory($allCategories[$i]) . ']</a></li>';
    }
}

function loadSearchBarCategories()
{

    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }
        echo '<option value="' . $allCategories[$i] . '">' . $allCategories[$i] . '</option>';
    }
}

//frontend
function loadProductSearchResults($formstream)
{
    global $db;
    extract($formstream);
    $category = '0';

    if (!empty($name)) {

        //if (!empty($category)) {

        $wordsAry = explode(" ", $name);
        $wordsCount = count($wordsAry);
        for ($i = 0; $i < $wordsCount; $i++) {

            $queryCondition = "WHERE title LIKE '%" . $wordsAry[$i] . "%' OR spec_summary LIKE '%" . $wordsAry[$i] . "%' ";

            if ($i != $wordsCount - 1) {
                $queryCondition .= " OR ";
            }
        }
        //  }
    } else {
        $name = "";
        $wordsAry = explode(" ", $name);
        $wordsCount = count($wordsAry);
        for ($i = 0; $i < $wordsCount; $i++) {

            $queryCondition = "WHERE title LIKE '%" . $wordsAry[$i] . "%' OR spec_summary LIKE '%" . $wordsAry[$i] . "%' ";

            if ($i != $wordsCount - 1) {
                $queryCondition .= " OR ";
            }
        }
    }



    $orderby = " ORDER BY id desc";
    //echo $queryCondition;
    $sql = "SELECT * FROM item " . $queryCondition . $orderby;

    $checker = null;
    $response = @mysqli_query($db, $sql);
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            if ($row['stock'] > 0) {
                //     if (validateProductCategory($category, html_entity_decode($row['categories'])) && 2 < 1) {
                //         $checker = $row['id'];
                //         echo ' <li class="span3">
                //     <div class="thumbnail">
                //         <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                //         <div class="caption">
                //             <h5>' . $row['title'] . '</h5>
                //             <p>' . $row['spec_summary'] . '
                //             </p>

                //             <h4 style="text-align:center">

                //                 <a class="btn " href="product_summary.php">&#8358;' . $row['price'] . '</a>
                //             </h4>
                //         </div>
                //     </div>
                // </li>';
                //  } elseif ($category == '0') {
                $checker = $row['id'];
                echo ' <li class="span3">
               <div class="thumbnail">
                   <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                   <div class="caption">
                       <h5>' . $row['title'] . '</h5>
                       <p>' . $row['spec_summary'] . '
                       </p>
           
                       <h4 style="text-align:center">
                       
                       <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                           <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                       </h4>
                   </div>
               </div>
           </li>';
                // }
            } //end of stock checker
        }
        if ($checker == null) {
            echo '<li>Not found</li>';
        }
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
}

// incomplete function
function loadPagination($pag = null)
{

    if (isset($pag)) {
        if ($pag == 'prev') {
        }
    } else {
        for ($i = 0; $i < ceil(getTotalNumberOfProducts() / 10); $i++) {
            echo '<li><a href="#">2</a></li>';
        }
    }
}

function getTotalMonthlyIncome()
{
    global $db;
    $allProducts = 0;
    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $total = 0;

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $currentmonth = date("Y-m");
            $paidmonth = date("Y-m", strtotime($row['created']));
            // 

            if ($paidmonth == $currentmonth) {
                $total += $row['amount'];
            }
        }
    }
    return $total;
}

function getTotalYearlyIncome()
{
    global $db;

    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $total = 0;

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $currentyear = date("Y");
            $paidyear = date("Y", strtotime($row['paid_at']));
            // 

            if ($paidyear == $currentyear) {
                $total += $row['amount'];
            }
        }
    }
    return $total;
}

function getAllTwelveMonthsIncome()
{

    global $db;
    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $amountArray = [];
    $dateArray = [];
    $allMonthsReport = '';

    //echo '------outside-loop<br>';
    if ($response) {

        while ($row = mysqli_fetch_array($response)) {
            array_push($amountArray, $row['amount']);
            array_push($dateArray, $row['created']);
        }

        //loop through january to february and get their total amounts
        for ($j = 1; $j <= 12; $j++) {
            $totalMonthly = 0;
            //echo '------looping through month' . $j . '<br>';
            //echo '<pre>';
            //print_r($amountArray);

            //loop through all transactions and get total amount for a single month
            for ($i = 0; $i < sizeof($amountArray); $i++) {
                //echo '------inside main loop, count ' . $i . '<br>';
                //$currentmonth = date("Y-m");

                if ($j < 10) {
                    $currentmonth = '2022-0' . $j;
                } else {
                    $currentmonth = '2022-' . $j;
                }


                //echo '------the year is ' . $currentmonth . '<br>';
                $paidmonth = date("Y-m", strtotime($dateArray[$i]));

                if ($paidmonth == $currentmonth) {
                    $totalMonthly += $amountArray[$i];
                }
            }

            //check if total monthly amount is valid, if yes add it to all report
            $allMonthsReport .= $totalMonthly . ', ';
            //echo $totalMonthly;
            //echo $allMonthsReport;
            // echo '<br><br><br>';
        } //end of for loop
    }
    return $allMonthsReport;
}

function generateTrulyRandomNumber()
{
    $number = rand(100, 100000);
    $t = time();
    $random = $number . '' . $t;
    return $random;
}

function deleteDuplicateImages()
{
    global $db;
    $validImages = [];

    $query = "SELECT main_img, side_img1, side_img2, side_img3  FROM item";
    $response = @mysqli_query($db, $query);
    if ($response) {
        //this loops through the whole product images and stores all their images in a single array. This array will then be used to validate the false images
        while ($row = mysqli_fetch_array($response)) {
            array_push($validImages, $row['main_img'], $row['side_img1'], $row['side_img2'], $row['side_img3']);
        }

        //the next three lines gets all the files in the product_images folder
        $path = 'product_images/';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));

        //this takes a single image from all the ones in the folder, and checks if they are contained in the valid images array, if not they are deleted.
        foreach ($files as $file) {
            //echo "<a href='product_images/$file'>$file</a><br>";
            if (!in_array($file, $validImages, true)) {
                echo "$file deleted<br>";
                unlink("product_images/" . $file);
            }
        }
    }
}

function loadPageMetaData($page, $uniqueId = null)
{

    echo loadPageMetaTitle($page, $uniqueId = null);
    echo loadPageMetaDescription($page, $uniqueId = null);
    echo loadPageMetaUrl($page, $uniqueId = null);
    echo loadPageMetaImage($page, $uniqueId = null);
    echo loadPageMetaKeywords($page, $uniqueId = null);
    echo loadPageMetaType($page, $uniqueId = null);
}

function loadPageMetaTitle($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<title>I-Plan Store</title>';
            break;

        case 'contact':
            //code here
            return '<title>I-Plan Store Contact Page</title>';
            break;

        case 'faq':
            //code here
            return '<title>I-Plan Store Frequently Asked Questions</title>';
            break;

        case 'legal':
            //code here
            return '<title>I-Plan Store Legal Notice Page</title>';
            break;

        case 'product_details':
            if (isset($uniqueId)) {
                return '<title>Buy ' . ucwords(strtolower(getProductTitle($uniqueId)))  . ' on I-Plan Store at ' . getProductPrice($uniqueId) . ' Naira</title>';
            }
            //code here
            break;

        case 'cart':
            //code here
            return '<title>I-Plan Store Shopping Cart</title>';
            break;

        case 'products':
            //code here
            if (isset($uniqueId)) {
                return '<title>[' . numberOfProductsUnderCategory($uniqueId) . '] Products Under ' . ucwords(strtolower($uniqueId))  . ' at I-Plan Store</title>';
            } else {
                return '<title>All [' . getTotalNumberOfProducts() . '] products at I-Plan Store</title>';
            }
            break;

        case 'tac':
            return '<title>I-Plan Store Terms and Conditions</title>';
            //code here
            break;

        case 'register':
            return '<title>Register as an I-Plan Store Admin</title>';
            //code here
            break;

        case 'test':
            return '<title>Developer Test Page</title>';
            //code here
            break;

        case 'search':
            return '<title>Search Results</title>';
            //code here
            break;


            //////////////////////////////////////////////// ADMIN SECTION /////////////////////////////////////////////
        case 'admins':
            return '<title>I-Plan Store Admins Page</title>';
            //code here
            break;

        case 'dashboard':
            //code here
            return '<title>I-Plan Store Dashboard</title>';
            break;

        case 'login':
            //code here
            return '<title>I-Plan Store Login Page</title>';
            break;

        case 'new_product':
            //code here
            return '<title>Create New Product on I-Plan Store</title>';
            break;

        case 'payment_confirmed':
            //code here
            return '<title>Payment Confirmed on I-Plan Store</title>';
            break;

        case 'payment_error':
            //code here
            return '<title>Payment Error on I-Plan Store</title>';
            break;

        case 'admin_products':
            //code here
            return '<title>All Products on I-Plan Store</title>';
            break;

        case 'redeem':
            //code here
            return '<title>I-Plan Store Redeem Page</title>';
            break;

        case 'newpass':
            //code here
            return '<title>Set New I-Plan Store Password</title>';
            break;

        case 'forgotpass':
            //code here
            return '<title>Forgot I-Plan Store Password</title>';
            break;

        case 'showcart':
            //code here
            return '<title>Customer Items Redeem and Final Validations Page</title>';
            break;


        default:
            //incase all else fails. don't forget to end code with semicolon
            return '<title>I-Plan Store</title>';
    }
}

function loadPageMetaType($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here

            break;

        case 'contact':
            //code here
            break;

        case 'faq':
            //code here
            break;

        case 'legal':
            //code here
            break;

        case 'product_details':
            //code here
            break;

        case 'cart':
            //code here
            break;

        case 'products':
            //code here
            break;

        case 'tac':
            //code here
            break;

        case 'test':
            //code here
            break;

            ////////////////////////////////////// ADMIN SECTION //////////////////////////////////////////////////////////
        case 'admins':
            //code here
            break;

        case 'dashboard':
            //code here
            break;

        case 'login':
            //code here
            break;

        case 'new_product':
            //code here
            break;

        case 'payment_confirmed':
            //code here
            break;

        case 'payment_error':
            //code here
            break;

        case 'admin_products':
            //code here
            break;

        case 'redeem':
            //code here
            break;

        case 'newpass':
            //code here
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    return '<meta property="og:type" content="website">';
}

function loadPageMetaDescription($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<meta property="og:description" content="Welcome! This is an online store for electronics, computer gadgets and computers. We are located opposite Nnamdi Azikiwe Stadium Enugu, Nigeria." >';
            break;

        case 'contact':
            //code here
            return '<meta property="og:description" content="
            For complaints relating to unprocessed transactions or errors, feedback on how to better serve you, including suggestions and ideas on where you think we should improve, design and functionality feedback, strictly for people with coding experience or technical know how..." >';
            break;

        case 'faq':
            //code here
            return '<meta property="og:description" content="Home for questions frequently asked by our customers." >';
            break;

        case 'legal':
            //code here
            return '<meta property="og:description" content="For any legal doubts, please do well to read it." >';
            break;

        case 'product_details':
            //code here
            if (isset($uniqueId)) {
                return '<meta property="og:description" content="' . ucwords(strtolower(getProductSpec_summary($uniqueId))) . '" >';
            }
            break;

        case 'cart':
            //code here
            return '<meta property="og:description" content="Exactly as it sounds, its your shopping cart." >';
            break;

        case 'products':
            //code here
            return '<meta property="og:description" content="This page contains all the products I-Plan Store has to offer." >';
            break;

        case 'tac':
            //code here
            return '<meta property="og:description" content="We have little to no terms and conditions, but you can check out the few we do have." >';
            break;

        case 'register':
            //code here
            return '<meta property="og:description" content="As an admin, you will be able to create new products, edit or delete old ones. You will also be able to redeem customer products." >';
            break;

        case 'test':
            //code here
            return '<meta property="og:description" content="product testing is a really important part of software development." >';
            break;


            ///////////////////////////////////////////////////////// ADMIN SECTION ////////////////////////////////////////////////
        case 'admins':
            //code here
            return '<meta property="og:description" content="This page contains a list of all the admins who control how the site works." >';
            break;

        case 'dashboard':
            //code here
            return '<meta property="og:description" content="This page contains all the info you need on sales and the general overview of the site." >';
            break;

        case 'login':
            //code here
            return '<meta property="og:description" content="Input your email and password to access admin privileges" >';
            break;

        case 'new_product':
            //code here
            return '<meta property="og:description" content="Create a new product and add details like name, price, stock, discount etc." >';
            break;

        case 'payment_confirmed':
            //code here
            return '<meta property="og:description" content="Congratulations!!! Your payment has been confirmed and you can redeem your product at any of our stores or ask for a delivery. Thanks for your patronage." >';
            break;

        case 'payment_error':
            //code here
            return '<meta property="og:description" content="Oops!!! Seems your payment didnt go through... If you were debited, your funds will be refunded shortly" >';
            break;

        case 'admin_products':
            //code here
            return '<meta property="og:description" content="This is where all products can be created, updated or destroyed." >';
            break;

        case 'redeem':
            //code here
            return '<meta property="og:description" content="Enter the customers redeem code to view and validate their goods before delivery." >';
            break;

        case 'newpass':
            //code here
            return '<meta property="og:description" content="Input your new password. Do make sure not to forget it this time..." >';
            break;

        case 'forgotpass':
            //code here
            return '<meta property="og:description" content="Things happen, we get it, Just input your email and request for a new password." >';
            break;

        case 'showcart':
            //code here
            return '<meta property="og:description" content="Full summary of everything purchased by client" >';
            break;

        default:
            return '<meta property="og:description" content="I-Plan store page" >';

            //incase all else fails. don't forget to end code with semicolon
    } //end of switch statement
}

function loadPageMetaUrl($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here

            break;

        case 'contact':
            //code here
            break;

        case 'faq':
            //code here
            break;

        case 'legal':
            //code here
            break;

        case 'product_details':
            //code here
            break;

        case 'cart':
            //code here
            break;

        case 'products':
            //code here
            break;

        case 'tac':
            //code here
            break;

        case 'test':
            //code here
            break;

        case 'admins':
            //code here
            break;

        case 'dashboard':
            //code here
            break;

        case 'login':
            //code here
            break;

        case 'new_product':
            //code here
            break;

        case 'payment_confirmed':
            //code here
            break;

        case 'payment_error':
            //code here
            break;

        case 'admin_products':
            //code here
            break;

        case 'redeem':
            //code here
            break;

        case 'newpass':
            //code here
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    return '<meta property="og:url" content="http://store.techac.net">';
}

function loadPageMetaImage($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'contact':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'faq':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'legal':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'product_details':
            //code here
            if (isset($uniqueId)) {
                return '<meta property="og:image" content="https://techac.net/tats/product_images/' . getProductMainImage($uniqueId) . '">';
            }
            break;

        case 'cart':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'products':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'tac':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'test':
            //code here

            break;



            ////////////////////////////////////////////////////////////ADMIN SECTION/////////////////////////////////////////////////////

        case 'admins':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'dashboard':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'login':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'new_product':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'payment_confirmed':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'payment_error':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'admin_products':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'redeem':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'newpass':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'forgotpass':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'showcart':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    // return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
}

function loadPageMetaKeywords($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'contact':
            //code 
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, contact us,  contact, phone number, address">';
            break;

        case 'faq':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, faq, frequently asked questions">';
            break;

        case 'legal':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, legal notice">';
            break;

        case 'product_details':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, ' . ucwords(strtolower(getProductTitle($uniqueId))) . '">';
            break;

        case 'cart':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, cart, shopping cart">';
            break;

        case 'products':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, products">';
            break;

        case 'tac':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, terms and conditions">';
            break;

        case 'test':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'admins':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, admins">';
            break;

        case 'dashboard':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'login':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, login">';
            break;

        case 'new_product':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, products, create products">';
            break;

        case 'payment_confirmed':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, payment confirmed, confirmed, payed">';
            break;

        case 'payment_error':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, error">';
            break;

        case 'admin_products':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, admin products, cms, admin">';
            break;

        case 'redeem':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, redeem">';
            break;

        case 'newpass':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, set new password, new, password, new password">';
            break;

        default:
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';

            //incase all else fails. don't forget to end code with semicolon
    } //end of switch statement

}


// switch ($page) {

//     case 'home':
//         //code here

//         break;

//     case 'contact':
//         //code here
//         break;

//     case 'faq':
//         //code here
//         break;

//     case 'legal':
//         //code here
//         break;

//     case 'product_details':
//         //code here
//         break;

//     case 'cart':
//         //code here
//         break;

//     case 'products':
//         //code here
//         break;

//     case 'tac':
//         //code here
//         break;

//     case 'test':
//         //code here
//         break;

//     default:
//         //incase all else fails. don't forget to end code with semicolon
// } //end of switch statement


// <title>TA TECH BLOG ADMIN HOME PAGE</title>
//     <meta name="description" content= 'Tech Acoustic Tech Blog ADMIN HOME' ">
//     <!-- <meta property='og:title' content="tats HOME"> -->
//     <meta property='og:url' content="https://techac.net/tats">
//     <!-- <meta property='og:image' itemprop="image" content="https://techac.net/tats/assets/images/mike.jpg"> -->
//     <meta property='keywords' content="Admin, home, Tech Acoustic, TA, tats, Tech Blog, Tech, Science, Computers">
//     <!-- <meta property='og:locale' content="">
// 	<meta property='og:type' content=""> -->



// $path = './';
// $files = scandir($path);
// $files = array_diff(scandir($path), array('.', '..'));
// foreach($files as $file){
// echo "<a href='$file'>$file</a>";
// }


         
// if (!is_dir("../product_images/".$row['main_img'])) {
//     //mkdir("../product_images", 0755);
//     unlink("../product_images/" . $_SESSION['editImage1']);
//     unlink("../product_images/" . $_SESSION['editImage2']);
//     unlink("../product_images/" . $_SESSION['editImage3']);
//     unlink("../product_images/" . $_SESSION['editImage4']);
// } else {
   
// }


//     }

//https://localhost/tats/admin/showcart.php?redeem_id=11&redeem_code=690075529&customer_name=Orji Michael&customer_phone=08148863871&cart=[{"image":"4.jpg","discount":700,"title":"Camera","price":15000,"quantity":1,"id":7,"tax":200},{"image":"7.jpg","discount":500,"title":"32 Gig USB","price":4500,"quantity":1,"id":8,"tax":100}]