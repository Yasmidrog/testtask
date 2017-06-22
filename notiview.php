<?php
function view($notifications)
{


    foreach ($notifications as $n) {;
       element($n);
    }
}


function element($n){

    ?>
    <div>
        <?php if (isset($_SESSION['last'])&&$n->date>$_SESSION['last']) {?>
            <div> Новый</div>
            <?php
        } ?>
        <img src="<?php echo $n->photo ?>" height="60" width="60"/>
    </div>
    <?php
}