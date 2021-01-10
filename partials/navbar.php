
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: darkblue;">
        <a class="navbar-brand" href="/shop/index.php">parfem.in.rs</a>
          
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto">

                <?php
                    //Ako je user ulogovan kupi njegov user id
                    if(isset($_SESSION['user'])){
                        $userId = $_SESSION['user']->user_id;
                    }
                ?>  

                <?php if(!isset($_SESSION['user'])): //ako nije ulogovan ne ispisuje nista ?>        
                    <?php echo ''; ?>
                <?php elseif($user->checkUserAdmin($userId) or $user->checkUserBloger($userId)): //ako je admin ili bloger ispisuje opciju Porudzbine ?>
                    <li class="nav-item">
                        <a href="/shop/views/admin.orders.view.php" class="nav-link" id="navLink1" style="color:white;">Porudzbine</a>
                    </li>
                <?php elseif(isset($_SESSION['user']) and !$user->checkUserAdmin($userId) and !$user->checkUserBloger($userId)): //ako je ulogovan a nije admin i bloger ispisuje opciju Korpa ?>
                    <li class="nav-item">
                        <a href="/shop/views/cart.view.php" class="nav-link" id="navLink1" style="color:white;">
                            <?php
                                $cartItemsCount = $cart->cartItemsCount($userId);
                                echo '<b>'.$cartItemsCount[0]->CountItems.'</b> Korpa';
                            ?>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(isset($_SESSION['user'])): ?>        
                    <li class="nav-item">
                        <a href="/shop/views/admin.view.php" class="nav-link" id="navLink2" style="color:white;">
                            <?php
                                echo $_SESSION['user']->name;
                            ?>
                        </a>
                    </li>
                    <li class="nav-item"><a href="/shop/files/logout.php" class="nav-link" id="navLink3" style="color:white;">Odjava</a></li>
                <?php else: ?>
                    <li class="nav-item" ><a href="/shop/views/login.view.php" class="nav-link" id="navLink4" style="color:white;">Prijava</a></li>    
                <?php endif; ?>

            </ul>
        </div>           
</nav>
