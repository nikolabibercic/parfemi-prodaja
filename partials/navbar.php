
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: darkblue;">
        <a class="navbar-brand" href="/shop/index.php">parfem.in.rs</a>
          
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a href="/shop/views/cart.view.php" class="nav-link" id="navLink1" style="color:white;">
                        <?php
                            if(!isset($_SESSION['user'])){
                                echo 'Korpa';
                            }else{
                                $userId = $_SESSION['user']->user_id;
                                $cartItemsCount = $cart->cartItemsCount($userId);
                                echo '<b>'.$cartItemsCount[0]->CountItems.'</b> Korpa';
                            }
                        ?>
                    </a>
                </li>

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
