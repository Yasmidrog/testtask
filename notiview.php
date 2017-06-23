<?php
function view($notifications)
{
    $arr = [
        'Декабря',
        'Января',
        'Февраля',
        'Марта',
        'Апреля',
        'Мая',
        'Июня',
        'Июля',
        'Августа',
        'Сентября',
        'Октября',
        'Ноября'
    ];

    $groups = array();
    foreach ($notifications as $n) {
        $key = (date("d", $n->date) * 1) . ' ' . $arr[date("n", $n->date)];
        if (!isset($groups[$key])) {
            $groups[$key] = [$n];
        } else {
            $groups[$key][] = $n;
        }
    }
    foreach ($groups as $date => $narr) {
        ?>
        <div class="date_block">
            <h3 class="date_title"> <?php echo $date; ?></h3>
            <?php
            foreach ($narr as $n) {
                element($n);
            } ?>
        </div>
        <?php
    }
}


function element($n)
{
    ?>
    <div xmlns="http://www.w3.org/1999/html">
        <?php if (isset($_SESSION['last']) && $n->date > $_SESSION['last']) { ?>
            <div> Новый</div>
            <?php
        } ?>
        <div style="width:25%; display: flex; flex-flow: row nowrap">
            <img src="<?php echo $n->photo ?>" width="50px" height="50px">
            <p style="padding: 0; margin: 0"><?php echo date('Y-m-d G:i:s', ($n)->date); ?><br><?php echo $n->name ?>
            </p>
        </div>


        <?php
        ?>
    </div>
    <?php
}